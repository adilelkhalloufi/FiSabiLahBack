<?php

namespace App\Http\Controllers;

use App\Models\Subjects;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        // whant bring with the vedio the subject to
        $subjects = Subjects::with(['videos' => function ($query) {
            $query->with('chikhi');
        }])->get();

        return response()->json($subjects);
    }

 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $subjects = new Subjects();
        $subjects->name = $request->input('name');
        $subjects->description = $request->input('description');
        $subjects->save();

        return response()->json($subjects, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Subjects $subjects)
    {
        // whant bring with the vedio the subject to
        $subjects = Subjects::with(['videos' => function ($query) {
            $query->with('chikhi');
        }])->find($subjects->id);

        return response()->json($subjects);
    }

  

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subjects $subjects)
    {
        $subjects->name = $request->input('name');
        $subjects->description = $request->input('description');
        $subjects->save();

        return response()->json($subjects);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subjects $subjects)
    {
        $subjects->delete();

        return response()->json(null, 204);
    }
}
