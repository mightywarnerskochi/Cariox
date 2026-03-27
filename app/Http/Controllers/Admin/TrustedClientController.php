<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrustedClient;
use App\Models\HomeBannerContent;
use Illuminate\Support\Facades\Storage;

class TrustedClientController extends Controller
{
    public function store(Request $request)
    {
        $banner = HomeBannerContent::first();
        if (!$banner) {
            return back()->withErrors(['message' => 'Please save the banner section first.']);
        }

        $request->validate([
            'client_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'client_name' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        $maxPosition = TrustedClient::where('home_banner_content_id', $banner->id)->max('position') ?? 0;
        $position = $request->position ?? ($maxPosition + 1);

        if ($request->position && $request->position <= $maxPosition) {
            TrustedClient::where('home_banner_content_id', $banner->id)
                ->where('position', '>=', $position)
                ->increment('position');
        }

        $path = $request->file('client_image')->store('trusted_clients', 'public');

        TrustedClient::create([
            'home_banner_content_id' => $banner->id,
            'client_image' => $path,
            'client_name' => $request->client_name,
            'alt_text' => $request->alt_text,
            'position' => $position,
            'status' => 1
        ]);

        return back()->with('success', 'Client added successfully.');
    }

    public function update(Request $request, $id)
    {
        $client = TrustedClient::findOrFail($id);

        $request->validate([
            'client_name' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'position' => 'nullable|integer|min:1',
        ]);

        if ($request->hasFile('client_image')) {
            $request->validate(['client_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:10240']);
            if ($client->client_image && Storage::disk('public')->exists($client->client_image)) {
                Storage::disk('public')->delete($client->client_image);
            }
            $client->client_image = $request->file('client_image')->store('trusted_clients', 'public');
        }

        if ($request->has('client_name')) {
            $client->client_name = $request->client_name;
        }

        if ($request->has('alt_text')) {
            $client->alt_text = $request->alt_text;
        }

        if ($request->has('position') && $request->position != $client->position) {
            $newPosition = $request->position;
            $currentPosition = $client->position;

            if ($newPosition < $currentPosition) {
                TrustedClient::where('home_banner_content_id', $client->home_banner_content_id)
                    ->where('position', '>=', $newPosition)
                    ->where('position', '<', $currentPosition)
                    ->increment('position');
            }
            elseif ($newPosition > $currentPosition) {
                TrustedClient::where('home_banner_content_id', $client->home_banner_content_id)
                    ->where('position', '<=', $newPosition)
                    ->where('position', '>', $currentPosition)
                    ->decrement('position');
            }
            $client->position = $newPosition;
        }

        $client->save();

        return back()->with('success', 'Client updated successfully.');
    }

    public function destroy($id)
    {
        $client = TrustedClient::findOrFail($id);
        $bannerId = $client->home_banner_content_id;
        $deletedPosition = $client->position;

        if ($client->client_image && Storage::disk('public')->exists($client->client_image)) {
            Storage::disk('public')->delete($client->client_image);
        }
        $client->delete();

        TrustedClient::where('home_banner_content_id', $bannerId)
            ->where('position', '>', $deletedPosition)
            ->decrement('position');

        return back()->with('success', 'Client deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $client = TrustedClient::findOrFail($request->id);
        $client->status = !$client->status;
        $client->save();
        return back()->with('success', 'Client status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $clients = TrustedClient::whereIn('id', $ids)->get();
            foreach ($clients as $client) {
                $bannerId = $client->home_banner_content_id;
                $deletedPosition = $client->position;

                if ($client->client_image && Storage::disk('public')->exists($client->client_image)) {
                    Storage::disk('public')->delete($client->client_image);
                }
                $client->delete();

                TrustedClient::where('home_banner_content_id', $bannerId)
                    ->where('position', '>', $deletedPosition)
                    ->decrement('position');
            }
            return back()->with('success', 'Selected clients deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $clients = TrustedClient::whereIn('id', $ids)->get();
            foreach ($clients as $client) {
                $client->status = !$client->status;
                $client->save();
            }
            return back()->with('success', 'Selected clients status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }
}
