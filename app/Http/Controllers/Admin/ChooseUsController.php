<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ChooseUs;
use App\Models\ChooseUsItem;
use Illuminate\Support\Facades\Storage;

class ChooseUsController extends Controller
{
    public function index()
    {
        $choose = ChooseUs::with(['items' => function ($q) {
            $q->orderBy('order');
        }])->firstOrCreate([], [
            'status' => 1
        ]);
        return view('admin.about.choose_us', compact('choose'));
    }

    public function updateMain(Request $request)
    {
        $choose = ChooseUs::first();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'image_alt_text' => 'nullable|string|max:255',
            'status' => 'required|integer',
        ]);

        $data = $request->only(['title', 'description', 'image_alt_text', 'status']);

        if ($request->hasFile('image')) {
            if ($choose->image && Storage::disk('public')->exists($choose->image)) {
                Storage::disk('public')->delete($choose->image);
            }
            $data['image'] = $request->file('image')->store('choose_us', 'public');
        }

        $choose->update($data);

        return back()->with('success', 'Main Choose Us updated successfully.');
    }

    public function storeItem(Request $request)
    {
        $choose = ChooseUs::first();
        $activeCount = ChooseUsItem::where('status', 1)->count();
        $status = $request->status ?? 1;

        if ($status == 1 && $activeCount >= 6) {
            return back()->withErrors(['message' => 'Maximum limit of 6 active features reached.']);
        }

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'icon' => 'nullable|string|max:255', // kept for backwards compatibility with existing items
            'text' => 'required|string|max:255',
            'order' => 'nullable|integer|min:1',
        ]);

        $maxOrder = ChooseUsItem::max('order') ?? 0;
        $order = $request->order ?? ($maxOrder + 1);

        if ($request->order && $request->order <= $maxOrder) {
            ChooseUsItem::where('order', '>=', $order)->increment('order');
        }

        $data = [
            'choose_id' => $choose->id,
            'icon' => $request->icon,
            'text' => $request->text,
            'order' => $order,
            'status' => $status,
        ];

        // Avoid passing `image` into SQL when the column doesn't exist yet
        // (e.g. migration not run) and no file was uploaded.
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('choose_us_items', 'public');
        }

        ChooseUsItem::create($data);

        return back()->with('success', 'Feature added successfully.');
    }

    public function updateItem(Request $request, $id)
    {
        $item = ChooseUsItem::findOrFail($id);

        if ($request->has('order') && !$request->has('text')) {
            $request->validate(['order' => 'required|integer|min:1']);
            if ($request->order != $item->order) {
                $newOrder = $request->order;
                $currentOrder = $item->order;
                if ($newOrder < $currentOrder) {
                    ChooseUsItem::where('order', '>=', $newOrder)->where('order', '<', $currentOrder)->increment('order');
                }
                elseif ($newOrder > $currentOrder) {
                    ChooseUsItem::where('order', '<=', $newOrder)->where('order', '>', $currentOrder)->decrement('order');
                }
                $item->order = $newOrder;
                $item->save();
            }
            return back()->with('success', 'Feature order updated.');
        }

        $request->validate([
            'text' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'icon' => 'nullable|string|max:255', // kept for backwards compatibility with existing items
            'status' => 'required|integer',
        ]);

        if ($request->status == 1 && !$item->status) {
            $activeCount = ChooseUsItem::where('status', 1)->count();
            if ($activeCount >= 6) {
                return back()->withErrors(['message' => 'Cannot activate. Maximum limit of 6 active features reached.']);
            }
        }

        $data = $request->only(['text', 'icon', 'status']);

        if ($request->hasFile('image')) {
            if ($item->image && Storage::disk('public')->exists($item->image)) {
                Storage::disk('public')->delete($item->image);
            }
            $data['image'] = $request->file('image')->store('choose_us_items', 'public');
        }

        $item->update($data);

        if ($request->has('order') && $request->order != $item->order) {
            $newOrder = $request->order;
            $currentOrder = $item->order;
            if ($newOrder < $currentOrder) {
                ChooseUsItem::where('order', '>=', $newOrder)->where('order', '<', $currentOrder)->increment('order');
            }
            elseif ($newOrder > $currentOrder) {
                ChooseUsItem::where('order', '<=', $newOrder)->where('order', '>', $currentOrder)->decrement('order');
            }
            $item->order = $newOrder;
            $item->save();
        }

        return back()->with('success', 'Feature updated.');
    }

    public function destroyItem($id)
    {
        $item = ChooseUsItem::findOrFail($id);
        $deletedOrder = $item->order;

        if ($item->image && Storage::disk('public')->exists($item->image)) {
            Storage::disk('public')->delete($item->image);
        }

        $item->delete();
        ChooseUsItem::where('order', '>', $deletedOrder)->decrement('order');
        return back()->with('success', 'Feature deleted.');
    }

    public function toggleItemStatus($id)
    {
        $item = ChooseUsItem::findOrFail($id);
        if (!$item->status) {
            $activeCount = ChooseUsItem::where('status', 1)->count();
            if ($activeCount >= 6) {
                return back()->withErrors(['message' => 'Limit reached. Only 6 items can be active.']);
            }
        }
        $item->status = !$item->status;
        $item->save();
        return back()->with('success', 'Status toggled.');
    }
}
