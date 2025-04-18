<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ScheduledPost;
use App\Models\Video;
use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ScheduledPostController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->scheduledPosts()
                ->with(['video', 'socialAccount'])
                ->orderBy('scheduled_at', 'asc')
                ->get();
                
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|exists:videos,id',
            'social_account_id' => 'required|exists:social_accounts,id',
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'hashtags' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Verify ownership
        $video = Video::where('id', $request->video_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
            
        $socialAccount = SocialAccount::where('id', $request->social_account_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $post = ScheduledPost::create([
            'video_id' => $request->video_id,
            'social_account_id' => $request->social_account_id,
            'user_id' => auth()->id(),
            'title' => $request->title ?? $video->title,
            'caption' => $request->caption ?? $video->caption,
            'hashtags' => $request->hashtags ?? $video->hashtags,
            'scheduled_at' => $request->scheduled_at,
            'status' => 'pending',
        ]);

        return response()->json($post->load(['video', 'socialAccount']), 201);
    }

    public function show($id)
    {
        $post = auth()->user()->scheduledPosts()
            ->with(['video', 'socialAccount'])
            ->findOrFail($id);
        
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'caption' => 'nullable|string',
            'hashtags' => 'nullable|string',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $post = auth()->user()->scheduledPosts()->findOrFail($id);
        
        // Only allow updates if not yet published
        if ($post->status !== 'pending') {
            return response()->json(['message' => 'Cannot update a post that has already been published or is being processed'], 422);
        }
        
        $post->update($request->only(['title', 'caption', 'hashtags', 'scheduled_at']));

        return response()->json($post->load(['video', 'socialAccount']));
    }

    public function destroy($id)
    {
        $post = auth()->user()->scheduledPosts()->findOrFail($id);
        
        // Only allow deletion if not yet published
        if ($post->status !== 'pending') {
            return response()->json(['message' => 'Cannot delete a post that has already been published or is being processed'], 422);
        }
        
        $post->delete();

        return response()->json(['message' => 'Scheduled post deleted successfully']);
    }
}
