<?php

namespace App\Services;

/** New uploads waiting for their record to be saved; see MediaStorage::stage(). */
class StagedMedia
{
    private bool $committed = false;

    /**
     * @param  array<string, string>  $paths  attribute => newly stored path
     * @param  array<string, string|null>  $replaced  attribute => path it replaces
     */
    public function __construct(
        private MediaStorage $media,
        private array $paths,
        private array $replaced,
    ) {}

    /** @return array<string, string> attribute => new path, only for fields that received a file */
    public function paths(): array
    {
        return $this->paths;
    }

    /** Call after the record is saved: removes the files the new uploads replaced. */
    public function commit(): void
    {
        if ($this->committed) {
            return;
        }
        $this->committed = true;
        $this->media->forget($this);

        $old = array_diff(array_filter($this->replaced), array_values($this->paths));
        $this->media->deleteUnused(array_values($old));
    }
}
