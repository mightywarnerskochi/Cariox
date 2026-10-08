<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SitemapGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SitemapController extends Controller
{
    public function index(): View
    {
        $path = SitemapGenerator::path();
        $exists = File::exists($path);
        $urlCount = 0;
        $lastModified = null;

        if ($exists) {
            $urlCount = substr_count(File::get($path), '<loc>');
            $lastModified = \Illuminate\Support\Carbon::createFromTimestamp(File::lastModified($path));
        }

        $redirectCount = \App\Models\UrlRedirect::count();
        $notFoundCount = \App\Models\NotFoundLog::count();

        return view('admin.sitemap.index', compact('exists', 'urlCount', 'lastModified', 'redirectCount', 'notFoundCount'));
    }

    public function generate(SitemapGenerator $generator): RedirectResponse
    {
        $count = $generator->generate();

        return redirect()->route('admin.sitemap.index')->with('success', "Sitemap generated successfully with {$count} URLs.");
    }

    public function edit(): View|RedirectResponse
    {
        $path = SitemapGenerator::path();
        if (!File::exists($path)) {
            return redirect()->route('admin.sitemap.index')->with('error', 'Generate the sitemap before editing it.');
        }

        $content = File::get($path);

        return view('admin.sitemap.edit', compact('content'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(['content' => 'required|string']);

        $content = $request->input('content');

        // Reject malformed XML so a bad edit cannot break the live sitemap
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $valid = $doc->loadXML($content, LIBXML_NONET);
        $errors = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        if (!$valid || $doc->documentElement?->localName !== 'urlset') {
            $message = $errors ? trim($errors[0]->message) . ' (line ' . $errors[0]->line . ')' : 'Root element must be <urlset>.';

            return back()->withInput()->withErrors(['content' => 'Invalid sitemap XML: ' . $message]);
        }

        File::put(SitemapGenerator::path(), $content);

        return redirect()->route('admin.sitemap.index')->with('success', 'Sitemap saved successfully.');
    }
}
