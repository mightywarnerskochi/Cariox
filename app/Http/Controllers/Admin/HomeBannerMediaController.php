<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeBannerMedia;
use App\Models\HomeBannerContent;
use Illuminate\Support\Facades\Storage;

class HomeBannerMediaController extends Controller
{
    public function store(Request $request)
    {
        $banner = HomeBannerContent::first();
        if (!$banner) {
            return back()->withErrors(['message' => 'Please save the banner section first.']);
        }

        // Limit check
        $activeCount = HomeBannerMedia::where('home_banner_content_id', $banner->id)->where('status', 1)->count();
        if ($activeCount >= 3) {
            return back()->withErrors(['message' => 'Maximum 3 active media items allowed.']);
        }

        $request->validate([
            'file' => 'required_without:pre_uploaded_path|file|mimes:jpeg,png,jpg,gif,svg,mp4,webm|max:20480',
            'thumbnail' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
            'pre_uploaded_path' => 'nullable|string',
            'position' => 'nullable|integer|min:1',
            'alt_text' => 'nullable|string|max:255',
        ]);

        $maxPosition = HomeBannerMedia::where('home_banner_content_id', $banner->id)->max('position') ?? 0;
        $position = $request->position ?? ($maxPosition + 1);

        if ($request->position && $request->position <= $maxPosition) {
            HomeBannerMedia::where('home_banner_content_id', $banner->id)
                ->where('position', '>=', $position)
                ->increment('position');
        }

        $thumbnail_path = null;
        if ($request->pre_uploaded_path) {
            $path = $request->pre_uploaded_path;
            $type = 'video';
            if ($request->hasFile('thumbnail')) {
                $thumbnail_path = $request->file('thumbnail')->store('banner_media_thumbnails', 'public');
            }
        } else {
            $file = $request->file('file');
            $type = str_contains($file->getMimeType(), 'image') ? 'image' : 'video';
            $path = $file->store('banner_media', 'public');
            if ($type === 'video' && $request->hasFile('thumbnail')) {
                $thumbnail_path = $request->file('thumbnail')->store('banner_media_thumbnails', 'public');
            }
        }

        HomeBannerMedia::create([
            'home_banner_content_id' => $banner->id,
            'type' => $type,
            'file_path' => $path,
            'thumbnail_path' => $thumbnail_path,
            'alt_text' => $request->alt_text,
            'position' => $position,
            'status' => 1
        ]);

        return back()->with('success', 'Media added successfully.');
    }

    public function update(Request $request, $id)
    {
        $media = HomeBannerMedia::findOrFail($id);

        $request->validate([
            'position' => 'nullable|integer|min:1',
            'alt_text' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('file') || $request->pre_uploaded_path || $request->hasFile('thumbnail')) {
            if ($request->hasFile('file')) {
                $request->validate(['file' => 'file|mimes:jpeg,png,jpg,gif,svg,mp4,webm|max:20480']);
            }
            if ($request->hasFile('thumbnail')) {
                $request->validate(['thumbnail' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:5120']);
            }
            
            if ($request->hasFile('file') || $request->pre_uploaded_path) {
                if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
                
                if ($request->pre_uploaded_path) {
                    $media->type = 'video';
                    $media->file_path = $request->pre_uploaded_path;
                } else {
                    $file = $request->file('file');
                    $media->type = str_contains($file->getMimeType(), 'image') ? 'image' : 'video';
                    $media->file_path = $file->store('banner_media', 'public');
                }
            }

            if ($request->hasFile('thumbnail')) {
                if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
                    Storage::disk('public')->delete($media->thumbnail_path);
                }
                $media->thumbnail_path = $request->file('thumbnail')->store('banner_media_thumbnails', 'public');
            }
        }

        if ($request->has('alt_text')) {
            $media->alt_text = $request->alt_text;
        }

        if ($request->has('position') && $request->position != $media->position) {
            $newPosition = $request->position;
            $currentPosition = $media->position;

            if ($newPosition < $currentPosition) {
                HomeBannerMedia::where('home_banner_content_id', $media->home_banner_content_id)
                    ->where('position', '>=', $newPosition)
                    ->where('position', '<', $currentPosition)
                    ->increment('position');
            }
            elseif ($newPosition > $currentPosition) {
                HomeBannerMedia::where('home_banner_content_id', $media->home_banner_content_id)
                    ->where('position', '<=', $newPosition)
                    ->where('position', '>', $currentPosition)
                    ->decrement('position');
            }
            $media->position = $newPosition;
        }

        $media->save();

        return back()->with('success', 'Media updated successfully.');
    }

    public function destroy($id)
    {
        $media = HomeBannerMedia::findOrFail($id);
        $bannerId = $media->home_banner_content_id;
        $deletedPosition = $media->position;

        if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }
        if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }
        $media->delete();

        HomeBannerMedia::where('home_banner_content_id', $bannerId)
            ->where('position', '>', $deletedPosition)
            ->decrement('position');

        return back()->with('success', 'Media deleted successfully.');
    }

    public function toggleStatus(Request $request)
    {
        $media = HomeBannerMedia::findOrFail($request->id);
        
        if (!$media->status) {
            $activeCount = HomeBannerMedia::where('home_banner_content_id', $media->home_banner_content_id)->where('status', 1)->count();
            if ($activeCount >= 3) {
                return back()->withErrors(['message' => 'Maximum 3 active media items allowed.']);
            }
        }

        $media->status = !$media->status;
        $media->save();
        return back()->with('success', 'Media status toggled successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $mediaItems = HomeBannerMedia::whereIn('id', $ids)->get();
            foreach ($mediaItems as $media) {
                $bannerId = $media->home_banner_content_id;
                $deletedPosition = $media->position;

                if ($media->file_path && Storage::disk('public')->exists($media->file_path)) {
                    Storage::disk('public')->delete($media->file_path);
                }
                if ($media->thumbnail_path && Storage::disk('public')->exists($media->thumbnail_path)) {
                    Storage::disk('public')->delete($media->thumbnail_path);
                }
                $media->delete();

                HomeBannerMedia::where('home_banner_content_id', $bannerId)
                    ->where('position', '>', $deletedPosition)
                    ->decrement('position');
            }
            return back()->with('success', 'Selected media deleted successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function bulkToggleStatus(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $mediaItems = HomeBannerMedia::whereIn('id', $ids)->get();
            $bannerId = HomeBannerContent::first()->id;
            
            foreach ($mediaItems as $media) {
                if(!$media->status) {
                    $activeCount = HomeBannerMedia::where('home_banner_content_id', $bannerId)->where('status', 1)->count();
                    if ($activeCount >= 3) {
                        return back()->withErrors(['message' => 'Limit of 3 active items reached. Partial update may have occurred.']);
                    }
                }
                $media->status = !$media->status;
                $media->save();
            }
            return back()->with('success', 'Selected media status toggled successfully.');
        }
        return back()->withErrors(['message' => 'No items selected.']);
    }

    public function chunkUpload(Request $request)
    {
        $receiver = \Illuminate\Http\UploadedFile::fake()->create('dummy'); // Not actually used but for type hinting if needed
        
        $file = $request->file('file');
        $chunkNumber = $request->input('resumableChunkNumber');
        $totalChunks = $request->input('resumableTotalChunks');
        $identifier = $request->input('resumableIdentifier');
        $fileName = $request->input('resumableFilename');

        $chunkPath = storage_path('app/chunks/' . $identifier);
        if (!file_exists($chunkPath)) {
            mkdir($chunkPath, 0777, true);
        }

        $file->move($chunkPath, $chunkNumber);

        if ($chunkNumber == $totalChunks) {
            // Merge chunks
            $finalPath = storage_path('app/public/banner_media/' . $fileName);
            if (!file_exists(storage_path('app/public/banner_media'))) {
                mkdir(storage_path('app/public/banner_media'), 0777, true);
            }

            $out = fopen($finalPath, "wb");
            for ($i = 1; $i <= $totalChunks; $i++) {
                $chunkFile = $chunkPath . '/' . $i;
                $in = fopen($chunkFile, "rb");
                while ($buff = fread($in, 4096)) {
                    fwrite($out, $buff);
                }
                fclose($in);
                unlink($chunkFile);
            }
            fclose($out);
            rmdir($chunkPath);

            return response()->json([
                'path' => 'banner_media/' . $fileName,
                'status' => 'complete'
            ]);
        }

        return response()->json(['status' => 'uploading']);
    }
}
