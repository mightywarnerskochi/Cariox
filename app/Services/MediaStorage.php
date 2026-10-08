<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

use Throwable;

/**
 * Stores CMS uploads on the public disk and removes the files they replace.
 *
 * Replacement is two-step so an existing file is never lost:
 *   $staged = $media->stage($model, $request, ['image'], 'blogs');  // store new uploads (throws on failure)
 *   ...assign $staged->paths() and save the record...
 *   $staged->commit();                                               // delete the replaced files
 *
 * A replaced file is deleted only once no database row references it any more, so images shared
 * between records (or kept by soft-deleted rows) stay. Uploads whose record was never saved are
 * cleaned up when the request ends.
 */
class MediaStorage
{
    public const DISK = 'public';

    /** Tables that never hold CMS file paths. */
    private const SKIP_TABLES = ['migrations', 'sessions', 'cache', 'cache_locks', 'jobs', 'job_batches', 'failed_jobs', 'password_reset_tokens'];

    /** @var array<int, array{table: string, column: string, exact: bool}>|null */
    private ?array $pathColumns = null;

    /** @var array<int, StagedMedia> */
    private array $pending = [];

    private bool $cleanupRegistered = false;

    /** Store an upload and return its path on the public disk. */
    public function store(UploadedFile $file, string $directory): string
    {
        try {
            $path = $file->isValid() ? $file->store($directory, self::DISK) : false;
        } catch (Throwable $e) {
            report($e);
            $path = false;
        }
        if (! $path) {
            throw new MediaUploadFailed('The file "' . $file->getClientOriginalName() . '" could not be uploaded.');
        }

        return $path;
    }

    /**
     * Store every uploaded file among $fields for a record that already has values for them.
     *
     * @param  array<int|string, string>  $fields  request field names, or [request field => model attribute]
     */
    public function stage(Model $model, Request $request, array $fields, string $directory): StagedMedia
    {
        $paths = [];
        $replaced = [];

        try {
            foreach ($fields as $input => $attribute) {
                $input = is_int($input) ? $attribute : $input;
                if (! $request->hasFile($input)) {
                    continue;
                }
                $replaced[$attribute] = $model->getAttribute($attribute);
                $paths[$attribute] = $this->store($request->file($input), $directory);
            }
        } catch (Throwable $e) {
            // One upload failed: drop the ones that succeeded so the record keeps all its current files.
            $this->discard(array_values($paths));
            throw $e;
        }

        $staged = new StagedMedia($this, $paths, $replaced);
        if ($paths) {
            $this->track($staged);
        }

        return $staged;
    }

    /**
     * Delete files from the public disk unless a database row still references them.
     * Missing files and external URLs are ignored.
     *
     * @param  array<int, string|null>  $paths
     */
    public function deleteUnused(array $paths): void
    {
        foreach (array_unique(array_filter($paths, 'is_string')) as $path) {
            $path = $this->normalize($path);
            if ($path === null || $this->isReferenced($path)) {
                continue;
            }
            $this->deleteFile($path);
        }
    }

    /** @param array<int, string> $paths Freshly stored files that will not be used. */
    public function discard(array $paths): void
    {
        foreach ($paths as $path) {
            $this->deleteFile($path);
        }
    }

    /** True when any row in the database stores $path (exact value, or embedded in rich text). */
    public function isReferenced(string $path): bool
    {
        foreach ($this->pathColumns() as $col) {
            $query = DB::table($col['table']);
            $found = $col['exact']
                ? $query->where($col['column'], $path)->exists()
                : $query->where($col['column'], 'like', '%' . addcslashes($path, '%_\\') . '%')->exists();
            if ($found) {
                return true;
            }
        }

        return false;
    }

    /** @internal Called by StagedMedia::commit(). */
    public function forget(StagedMedia $staged): void
    {
        unset($this->pending[spl_object_id($staged)]);
    }

    private function track(StagedMedia $staged): void
    {
        $this->pending[spl_object_id($staged)] = $staged;

        if (! $this->cleanupRegistered) {
            $this->cleanupRegistered = true;
            // Record was never saved (validation or save failed after staging): remove the orphaned uploads.
            app()->terminating(function () {
                foreach ($this->pending as $staged) {
                    $this->deleteUnused(array_values($staged->paths()));
                }
                $this->pending = [];
            });
        }
    }

    /** Stored value to a disk path; null for empty values and external URLs. */
    private function normalize(string $path): ?string
    {
        $path = trim($path);
        if ($path === '' || preg_match('#^(https?:)?//#i', $path) || str_starts_with($path, 'data:')) {
            return null;
        }

        return preg_replace('#^/?storage/#', '', ltrim($path, '/'));
    }

    private function deleteFile(string $path): void
    {
        try {
            $disk = Storage::disk(self::DISK);
            if ($disk->exists($path)) {
                $disk->delete($path);
            }
        } catch (Throwable $e) {
            Log::warning('Could not delete replaced media file.', ['path' => $path, 'error' => $e->getMessage()]);
        }
    }

    /** Every string column in the database, discovered once per request. */
    private function pathColumns(): array
    {
        if ($this->pathColumns !== null) {
            return $this->pathColumns;
        }

        $this->pathColumns = [];
        foreach (Schema::getTableListing(schemaQualified: false) as $table) {
            if (in_array($table, self::SKIP_TABLES, true)) {
                continue;
            }
            foreach (Schema::getColumns($table) as $column) {
                $type = strtolower($column['type_name']);
                if (in_array($type, ['varchar', 'char', 'string', 'nvarchar'], true)) {
                    $this->pathColumns[] = ['table' => $table, 'column' => $column['name'], 'exact' => true];
                } elseif (str_contains($type, 'text') || $type === 'json') {
                    $this->pathColumns[] = ['table' => $table, 'column' => $column['name'], 'exact' => false];
                }
            }
        }

        return $this->pathColumns;
    }
}
