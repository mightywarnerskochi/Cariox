<?php

namespace App\Services;

/**
 * Rebuilds the generated SEO files (sitemap.xml, llms.txt) after content changes.
 */
class SeoFileSync
{
    private static bool $queued = false;

    /**
     * Regenerate once after the current request finishes, however many records changed in it.
     * Skipped in the console so seeders and imports don't write APP_URL-based links.
     */
    public static function queue(): void
    {
        if (self::$queued || app()->runningInConsole()) {
            return;
        }

        self::$queued = true;

        app()->terminating(function () {
            foreach ([SitemapGenerator::class, LlmsTxtGenerator::class] as $generator) {
                try {
                    app($generator)->generate();
                } catch (\Throwable $e) {
                    report($e);
                }
            }
        });
    }
}
