<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotFoundLog;
use App\Models\UrlRedirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UrlRedirectController extends Controller
{
    public function index(Request $request): View
    {
        $redirects = UrlRedirect::latest()->get();
        // Prefill the add form when coming from the 404 log
        $prefillFrom = $request->query('from');

        return view('admin.sitemap.redirects.index', compact('redirects', 'prefillFrom'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        UrlRedirect::create($data);

        // The broken URL is handled now, so it no longer belongs in the 404 log
        NotFoundLog::where('path', strtok($data['from_path'], '?'))->delete();

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect added successfully.');
    }

    public function edit(int $id): View
    {
        $redirect = UrlRedirect::findOrFail($id);

        return view('admin.sitemap.redirects.edit', compact('redirect'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $redirect = UrlRedirect::findOrFail($id);
        $redirect->update($this->validated($request, $redirect->id));

        return redirect()->route('admin.redirects.index')->with('success', 'Redirect updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        UrlRedirect::findOrFail($id)->delete();

        return back()->with('success', 'Redirect deleted.');
    }

    public function toggleStatus(int $id): RedirectResponse
    {
        $redirect = UrlRedirect::findOrFail($id);
        $redirect->update(['status' => !$redirect->status]);

        return back()->with('success', 'Redirect status updated.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'from_path' => $request->filled('from_path') ? UrlRedirect::normalizePath($request->input('from_path')) : null,
        ]);

        $data = $request->validate([
            'from_path' => [
                'required', 'string', 'max:255', 'not_in:/',
                Rule::unique('url_redirects', 'from_path')->ignore($ignoreId),
            ],
            'to_url' => ['required', 'string', 'max:1000', 'regex:/^(https?:\/\/|\/)/i'],
            'status_code' => ['required', Rule::in([301, 302])],
        ], [
            'from_path.not_in' => 'The homepage cannot be redirected.',
            'from_path.unique' => 'A redirect for this URL already exists.',
            'to_url.regex' => 'The target must be a full URL (https://...) or a path starting with "/".',
        ]);

        if (rtrim(UrlRedirect::normalizePath($data['to_url']), '/') === rtrim($data['from_path'], '/')
            && !preg_match('/^https?:\/\//i', $data['to_url'])) {
            throw \Illuminate\Validation\ValidationException::withMessages(['to_url' => 'The target cannot be the same as the old URL.']);
        }

        return $data;
    }
}
