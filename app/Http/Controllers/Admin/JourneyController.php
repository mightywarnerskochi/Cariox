<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Journey;
use Illuminate\Support\Facades\Storage;

class JourneyController extends Controller
{
    public function index()
    {
        $journeys = Journey::orderBy('order')->get();
        return view('admin.about.journey_index', compact('journeys'));
    }

    public function create()
    {
        return view('admin.about.journey_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:255',
            'caption' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'image_alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
        ]);

        $maxOrder = Journey::max('order') ?? 0;
        $order = $request->order ?? ($maxOrder + 1);

        if ($request->order && $request->order <= $maxOrder) {
            Journey::where('order', '>=', $order)->increment('order');
        }

        $path = $request->hasFile('image') ? $request->file('image')->store('journeys', 'public') : null;

        Journey::create([
            'year' => $request->year,
            'caption' => $request->caption,
            'description' => $request->description,
            'image' => $path,
            'image_alt_text' => $request->image_alt_text,
            'order' => $order,
            'status' => 1
        ]);

        return redirect()->route('admin.journey.index')->with('success', 'Journey record added.');
    }

    public function edit($id)
    {
        $journey = Journey::findOrFail($id);
        return view('admin.about.journey_edit', compact('journey'));
    }

    public function update(Request $request, $id)
    {
        $journey = Journey::findOrFail($id);

        if ($request->has('order') && !$request->has('year')) {
            $request->validate(['order' => 'required|integer|min:1']);
            if ($request->order != $journey->order) {
                $newOrder = $request->order;
                $currentOrder = $journey->order;
                if ($newOrder < $currentOrder) {
                    Journey::where('order', '>=', $newOrder)->where('order', '<', $currentOrder)->increment('order');
                }
                elseif ($newOrder > $currentOrder) {
                    Journey::where('order', '<=', $newOrder)->where('order', '>', $currentOrder)->decrement('order');
                }
                $journey->order = $newOrder;
                $journey->save();
            }
            return back()->with('success', 'Journey order updated.');
        }

        $request->validate([
            'year' => 'required|string|max:255',
            'caption' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image_alt_text' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:1',
        ]);

        $data = $request->only(['year', 'caption', 'description', 'image_alt_text', 'status']);

        if ($request->hasFile('image')) {
            $request->validate(['image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240']);
            if ($journey->image && Storage::disk('public')->exists($journey->image)) {
                Storage::disk('public')->delete($journey->image);
            }
            $data['image'] = $request->file('image')->store('journeys', 'public');
        }

        if ($request->has('order') && $request->order != $journey->order) {
            $newOrder = $request->order;
            $currentOrder = $journey->order;
            if ($newOrder < $currentOrder) {
                Journey::where('order', '>=', $newOrder)->where('order', '<', $currentOrder)->increment('order');
            }
            elseif ($newOrder > $currentOrder) {
                Journey::where('order', '<=', $newOrder)->where('order', '>', $currentOrder)->decrement('order');
            }
            $journey->order = $newOrder;
        }

        $journey->update($data);
        $journey->save();

        return redirect()->route('admin.journey.index')->with('success', 'Journey updated successfully.');
    }

    public function destroy($id)
    {
        $journey = Journey::findOrFail($id);
        $deletedOrder = $journey->order;
        if ($journey->image && Storage::disk('public')->exists($journey->image)) {
            Storage::disk('public')->delete($journey->image);
        }
        $journey->delete();
        Journey::where('order', '>', $deletedOrder)->decrement('order');
        return back()->with('success', 'Journey deleted.');
    }

    public function toggleStatus($id)
    {
        $journey = Journey::findOrFail($id);
        $journey->status = !$journey->status;
        $journey->save();
        return back()->with('success', 'Status toggled.');
    }

    public function bulkDelete(Request $request)
    {
        if ($request->ids) {
            $items = Journey::whereIn('id', $request->ids)->get();
            foreach ($items as $item) {
                $deletedOrder = $item->order;
                if ($item->image && Storage::disk('public')->exists($item->image)) {
                    Storage::disk('public')->delete($item->image);
                }
                $item->delete();
                Journey::where('order', '>', $deletedOrder)->decrement('order');
            }
            return back()->with('success', 'Selected items deleted.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        if ($request->ids) {
            $items = Journey::whereIn('id', $request->ids)->get();
            foreach ($items as $item) {
                $item->status = !$item->status;
                $item->save();
            }
            return back()->with('success', 'Statuses toggled.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }
}
