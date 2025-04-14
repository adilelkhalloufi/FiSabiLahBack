<?php

namespace App\Http\Controllers;

use App\Models\Videos;
use Illuminate\Http\Request;

class VideosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // whant bring with the vedio the subject to
        $videos = Videos::with(['subjects' => function ($query) {
            $query->with('chikhi');
        }])->get();

        return response()->json($videos);
     }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
       

        $video = Videos::create($request->all());

        return response()->json($video, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $video = Videos::with(['subjects' => function ($query) {
            $query->with('chikhi');
        }])->find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        return response()->json($video);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Videos $videos)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        
     

        $video = Videos::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $video->update($request->all());

        return response()->json($video);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        
        $video = Videos::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        $video->delete();

        return response()->json(['message' => 'Video deleted successfully']);
    }
}
