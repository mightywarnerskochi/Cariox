<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotFoundLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NotFoundLogController extends Controller
{
    public function index(): View
    {
        $logs = NotFoundLog::orderByDesc('last_seen_at')->paginate(50);

        return view('admin.sitemap.not_found', compact('logs'));
    }

    public function destroy(int $id): RedirectResponse
    {
        NotFoundLog::findOrFail($id)->delete();

        return back()->with('success', 'Log entry removed.');
    }

    public function clear(): RedirectResponse
    {
        NotFoundLog::truncate();

        return back()->with('success', '404 log cleared.');
    }
}
