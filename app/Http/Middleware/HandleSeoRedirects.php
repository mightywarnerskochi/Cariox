<?php

namespace App\Http\Middleware;

use App\Models\NotFoundLog;
use App\Models\UrlRedirect;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Applies admin-managed URL redirects and records website 404s for the 404 log.
 */
class HandleSeoRedirects
{
    /**
     * Missing static files are not worth logging (old asset links, bot probes).
     */
    private const IGNORED_EXTENSIONS = [
        'css', 'js', 'map', 'png', 'jpg', 'jpeg', 'gif', 'webp', 'svg', 'ico', 'avif',
        'woff', 'woff2', 'ttf', 'eot', 'otf', 'mp4', 'webm', 'json', 'txt',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (!$this->isTrackable($request)) {
            return $next($request);
        }

        if ($redirect = $this->findRedirect($request)) {
            return $redirect;
        }

        $response = $next($request);

        if ($response->getStatusCode() === 404) {
            $this->logNotFound($request);
        }

        return $response;
    }

    private function isTrackable(Request $request): bool
    {
        if (!$request->isMethod('GET') && !$request->isMethod('HEAD')) {
            return false;
        }

        $path = $request->path();

        return !$request->is('admin', 'admin/*', 'storage/*', 'vendor/*', '_debugbar/*', 'up')
            && !in_array(strtolower(pathinfo($path, PATHINFO_EXTENSION)), self::IGNORED_EXTENSIONS, true);
    }

    private function findRedirect(Request $request): ?Response
    {
        try {
            $map = UrlRedirect::activeMap();
        } catch (\Throwable $e) {
            return null; // table missing during install
        }

        if (!$map) {
            return null;
        }

        $path = '/' . trim($request->path(), '/');
        $query = $request->getQueryString();

        // An exact "/path?query" rule wins over a plain "/path" rule
        $rule = ($query !== null ? ($map[$path . '?' . $query] ?? null) : null) ?? ($map[$path] ?? null);
        if (!$rule) {
            return null;
        }

        $target = Str::startsWith($rule['to'], ['http://', 'https://']) ? $rule['to'] : url($rule['to']);

        // Avoid a redirect loop when the target resolves to the current URL
        if (rtrim($target, '/') === rtrim($request->fullUrl(), '/')) {
            return null;
        }

        UrlRedirect::whereKey($rule['id'])->toBase()->update([
            'hits' => DB::raw('hits + 1'),
            'last_hit_at' => now(),
        ]);

        return redirect()->away($target, $rule['code']);
    }

    private function logNotFound(Request $request): void
    {
        try {
            $path = Str::limit('/' . trim($request->path(), '/'), 250, '');
            $referer = Str::limit((string) $request->headers->get('referer'), 1000, '') ?: null;
            $userAgent = Str::limit((string) $request->userAgent(), 500, '') ?: null;

            // Keep the last known referrer when a later hit arrives without one
            $updated = NotFoundLog::where('path', $path)->toBase()->update(array_filter([
                'hits' => DB::raw('hits + 1'),
                'referer' => $referer,
                'user_agent' => $userAgent,
                'last_seen_at' => now(),
                'updated_at' => now(),
            ]));

            if (!$updated) {
                NotFoundLog::create([
                    'path' => $path,
                    'referer' => $referer,
                    'user_agent' => $userAgent,
                    'last_seen_at' => now(),
                ]);
            }
        } catch (\Throwable $e) {
            // Logging must never break the 404 page itself
        }
    }
}
