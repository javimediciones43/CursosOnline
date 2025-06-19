<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Course::with('category', 'creator')->get();
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'creator_id' => 'required|exists:categories,id',
        ]);

        $course = Course::create([
            'title' => $request->title,
            'description'=> $request->description,
            'category_id' => $request->category_id,
            'created_by' => $request->creator_id,
        ]);
        return response()->json(['message' => 'Curso creado', 'course' => $course], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Course::with('category', 'creator')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'title'=> 'required|string|max:100',
            'description'=>'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course->update($request->all());
        return response()->json([
            'message' => 'Curso actualizado',
            'course' => $course
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::findOrFail($id)->delete();
        return response()->json(['message'=> 'Curso elminado']);
    }
}
