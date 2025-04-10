<?php

namespace App\Http\Controllers;

use App\Models\Chikhis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChikhisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // whant bring with the vedio the subject to
        $chikhis = Chikhis::with(['videos' => function ($query) {
            $query->with('subject');
        }])->get();

        return response()->json($chikhis);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $chikhis = new Chikhis();
        $chikhis->name = $request->input('name');
        $chikhis->description = $request->input('description');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('chikhis', $imageName, 'public');
            $chikhis->image = $path;
        }
        
        $chikhis->save();

        return response()->json($chikhis, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Chikhis $chikhis)
    {
        // whant bring with the vedio the subject to
        $chikhis = Chikhis::with(['videos' => function ($query) {
            $query->with('subject');
        }])->find($chikhis->id);

        return response()->json($chikhis);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $chikhis = Chikhis::find($id);
        $chikhis->name = $request->input('name');
        $chikhis->description = $request->input('description');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($chikhis->image) {
                Storage::disk('public')->delete($chikhis->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('chikhis', $imageName, 'public');
            $chikhis->image = $path;
        }
        
        $chikhis->save();

        return response()->json($chikhis);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $chikhis = Chikhis::find($id);  
        // Delete image file if exists
        if ($chikhis->image) {
            Storage::disk('public')->delete($chikhis->image);
        }
        
        $chikhis->delete();

        return response()->json($chikhis, 204);
    }
}
