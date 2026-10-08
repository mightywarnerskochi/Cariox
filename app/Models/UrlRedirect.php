<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class UrlRedirect extends Model
{
    public const CACHE_KEY = 'url_redirects.active';

    protected $fillable = ['from_path', 'to_url', 'status_code', 'hits', 'last_hit_at', 'status'];

    protected $casts = [
        'last_hit_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        // The redirect middleware reads a cached map, so drop it whenever a rule changes
        static::saved(fn () => Cache::forget(self::CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::CACHE_KEY));
    }

    /**
     * Normalise a URL or path to the "/path?query" form used for matching.
     */
    public static function normalizePath(string $value): string
    {
        $parts = parse_url(trim($value));
        $path = '/' . trim($parts['path'] ?? '', '/');

        return isset($parts['query']) && $parts['query'] !== '' ? $path . '?' . $parts['query'] : $path;
    }

    /**
     * Active rules keyed by from_path.
     */
    public static function activeMap(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return static::where('status', 1)->get(['id', 'from_path', 'to_url', 'status_code'])
                ->keyBy('from_path')
                ->map(fn ($r) => ['id' => $r->id, 'to' => $r->to_url, 'code' => $r->status_code])
                ->all();
        });
    }
}
