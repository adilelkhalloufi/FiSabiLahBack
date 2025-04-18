<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function index()
    {
        $videos = auth()->user()->videos()->latest()->get();
        return response()->json($videos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video' => 'required|file|mimetypes:video/mp4,video/quicktime|max:100000', // 100MB max
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'hashtags' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $videoFile = $request->file('video');
        $path = $videoFile->store('videos', 'public');

        // In a real app, you'd want to process the video to get duration, resolution, etc.
        // This would typically be done in a job queue

        $video = auth()->user()->videos()->create([
            'title' => $request->title,
            'caption' => $request->caption,
            'hashtags' => $request->hashtags,
            'file_path' => $path,
            'status' => 'uploaded',
        ]);

        return response()->json($video, 201);
    }

    public function show($id)
    {
        $video = auth()->user()->videos()->with('scheduledPosts')->findOrFail($id);
        return response()->json($video);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'hashtags' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $video = auth()->user()->videos()->findOrFail($id);
        $video->update($request->only(['title', 'caption', 'hashtags']));

        return response()->json($video);
    }

    public function destroy($id)
    {
        $video = auth()->user()->videos()->findOrFail($id);
        
        // Delete file
        if (Storage::disk('public')->exists($video->file_path)) {
            Storage::disk('public')->delete($video->file_path);
        }
        
        $video->delete();

        return response()->json(['message' => 'Video deleted successfully']);
    }
}
