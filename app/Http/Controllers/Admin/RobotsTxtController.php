<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SitemapGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class RobotsTxtController extends Controller
{
    private const DEFAULT_CONTENT = "User-agent: *\nDisallow: /admin\n";

    private function path(): string
    {
        return public_path('robots.txt');
    }

    public function index(): View
    {
        $exists = File::exists($this->path());
        $content = $exists ? File::get($this->path()) : '';
        $lastModified = $exists ? \Illuminate\Support\Carbon::createFromTimestamp(File::lastModified($this->path())) : null;
        $hasSitemap = (bool) preg_match('/^\s*sitemap\s*:/im', $content);
        $sitemapExists = File::exists(SitemapGenerator::path());

        return view('admin.seo.robots', compact('exists', 'content', 'lastModified', 'hasSitemap', 'sitemapExists'));
    }

    public function edit(): View
    {
        $content = File::exists($this->path()) ? File::get($this->path()) : self::DEFAULT_CONTENT;

        return view('admin.seo.file_edit', [
            'title' => 'Edit Robots.txt',
            'fileName' => 'robots.txt',
            'content' => $content,
            'action' => route('admin.robots.update'),
            'backUrl' => route('admin.robots.index'),
            'note' => 'Changes apply immediately after saving. A wrong "Disallow: /" line can hide the whole site from search engines, so double-check before saving.',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(['content' => 'required|string|max:50000']);

        File::put($this->path(), $this->normalize($request->input('content')));

        return redirect()->route('admin.robots.index')->with('success', 'robots.txt saved successfully.');
    }

    /**
     * Append a "Sitemap:" directive pointing at the generated sitemap.
     */
    public function addSitemap(): RedirectResponse
    {
        $content = File::exists($this->path()) ? File::get($this->path()) : self::DEFAULT_CONTENT;

        if (preg_match('/^\s*sitemap\s*:/im', $content)) {
            return back()->with('success', 'robots.txt already references a sitemap.');
        }

        File::put($this->path(), $this->normalize(rtrim($content) . "\n\nSitemap: " . url('sitemap.xml')));

        return back()->with('success', 'Sitemap reference added to robots.txt.');
    }

    private function normalize(string $content): string
    {
        return rtrim(str_replace("\r\n", "\n", $content)) . "\n";
    }
}
