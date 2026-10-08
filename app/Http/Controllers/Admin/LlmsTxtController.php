<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\LlmsTxtGenerator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class LlmsTxtController extends Controller
{
    public function index(): View
    {
        $path = LlmsTxtGenerator::path();
        $exists = File::exists($path);
        $linkCount = 0;
        $lastModified = null;

        if ($exists) {
            $linkCount = preg_match_all('/^- \[/m', File::get($path));
            $lastModified = \Illuminate\Support\Carbon::createFromTimestamp(File::lastModified($path));
        }

        return view('admin.seo.llms', compact('exists', 'linkCount', 'lastModified'));
    }

    public function generate(LlmsTxtGenerator $generator): RedirectResponse
    {
        $count = $generator->generate();

        return redirect()->route('admin.llms.index')->with('success', "llms.txt generated successfully with {$count} links.");
    }

    public function edit(): View|RedirectResponse
    {
        $path = LlmsTxtGenerator::path();
        if (!File::exists($path)) {
            return redirect()->route('admin.llms.index')->with('error', 'Generate llms.txt before editing it.');
        }

        return view('admin.seo.file_edit', [
            'title' => 'Edit LLMs.txt',
            'fileName' => 'llms.txt',
            'content' => File::get($path),
            'action' => route('admin.llms.update'),
            'backUrl' => route('admin.llms.index'),
            'note' => 'Text outside the "llms:generated" markers is kept when the file is regenerated. Text between the markers is replaced on every regeneration.',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate(['content' => 'required|string|max:500000']);

        $content = rtrim(str_replace("\r\n", "\n", $request->input('content'))) . "\n";
        File::put(LlmsTxtGenerator::path(), $content);

        return redirect()->route('admin.llms.index')->with('success', 'llms.txt saved successfully.');
    }
}
