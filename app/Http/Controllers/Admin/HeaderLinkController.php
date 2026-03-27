<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeaderLink;
use Illuminate\Http\Request;

class HeaderLinkController extends Controller
{
    public function index()
    {
        $links = HeaderLink::orderBy('order')->get();
        return view('admin.settings.header_links.index', compact('links'));
    }

    public function create()
    {
        return view('admin.settings.header_links.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'order' => 'integer'
        ]);

        HeaderLink::create($request->all());
        return redirect()->route('admin.settings.header_links.index')->with('success', 'Header link created successfully.');
    }

    public function edit($id)
    {
        $link = HeaderLink::findOrFail($id);
        return view('admin.settings.header_links.edit', compact('link'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'link' => 'required',
            'order' => 'integer'
        ]);

        $link = HeaderLink::findOrFail($id);
        $link->update($request->all());
        return redirect()->route('admin.settings.header_links.index')->with('success', 'Header link updated successfully.');
    }

    public function destroy($id)
    {
        HeaderLink::findOrFail($id)->delete();
        return back()->with('success', 'Header link deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $link = HeaderLink::findOrFail($request->id);
        $newStatus = $link->status ? 0 : 1;

        if ($newStatus == 1) {
            // Deactivate all others first
            HeaderLink::where('id', '!=', $link->id)->update(['status' => 0]);
        }

        $link->status = $newStatus;
        $link->save();

        return response()->json(['success' => true]);
    }
}
