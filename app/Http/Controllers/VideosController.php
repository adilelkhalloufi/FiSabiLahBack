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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Videos $videos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Videos $videos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videos $videos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Videos $videos)
    {
        //
    }
}
