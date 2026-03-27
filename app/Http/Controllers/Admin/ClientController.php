<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\SectionContent;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index()
    {
        $sectionContent = SectionContent::firstOrCreate(['section' => 'client']);
        $clients = Client::positioned()->get();
        return view('admin.client.index', compact('clients', 'sectionContent'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'small_title' => 'required|string|max:255',
            'main_title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $sectionContent = SectionContent::firstOrCreate(['section' => 'client']);
        $sectionContent->update([
            'small_title' => $request->small_title,
            'main_title' => $request->main_title,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Section heading updated successfully.');
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        Client::increment('position');
        $position = 1;

        $path = $request->file('image')->store('clients', 'public');

        Client::create([
            'name' => $request->name,
            'image' => $path,
            'alt_text' => $request->alt_text,
            'position' => $position,
            'status' => 1
        ]);

        $this->normalizeClientOrder();

        return redirect()->route('admin.client.index')->with('success', 'Client added successfully.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.client.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $client = Client::findOrFail($id);

        $request->validate([
            'name' => $request->has('name') ? 'required|string|max:255' : 'nullable',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            $request->validate(['image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240']);
            if ($client->image && Storage::disk('public')->exists($client->image)) {
                Storage::disk('public')->delete($client->image);
            }
            $client->image = $request->file('image')->store('clients', 'public');
        }

        if ($request->has('name')) {
            $client->name = $request->name;
        }

        if ($request->has('alt_text')) {
            $client->alt_text = $request->alt_text;
        }

        if ($request->has('position')) {
            $client->position = $request->position;
        }

        $client->save();
        $this->normalizeClientOrder();
        return redirect()->route('admin.client.index')->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $client = Client::findOrFail($id);
        $deletedPosition = $client->position;

        if ($client->image && Storage::disk('public')->exists($client->image)) {
            Storage::disk('public')->delete($client->image);
        }
        $client->delete();
        $this->normalizeClientOrder();

        return back()->with('success', 'Client deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $client = Client::findOrFail($request->id);
        $client->status = !$client->status;
        if ($client->status == 0) {
            $client->position = Client::max('position') + 1;
        }
        $client->save();
        $this->normalizeClientOrder();
        return back()->with('success', 'Client status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $clients = Client::whereIn('id', $ids)->get();
            foreach ($clients as $client) {
                $client->delete();
            }
            $this->normalizeClientOrder();
            return back()->with('success', 'Selected clients deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $clients = Client::whereIn('id', $ids)->get();
            $maxPos = Client::max('position');
            foreach ($clients as $client) {
                $client->status = !$client->status;
                if ($client->status == 0) {
                    $client->position = ++$maxPos;
                }
                $client->save();
            }
            $this->normalizeClientOrder();
            return back()->with('success', 'Selected clients status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    private function normalizeClientOrder()
    {
        $items = Client::positioned()->get();
        foreach ($items as $index => $item) {
            $newPos = $index + 1;
            if ($item->position != $newPos) {
                $item->position = $newPos;
                $item->save();
            }
        }
    }
}
