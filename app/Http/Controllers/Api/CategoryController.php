<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

// Este es un controlador con los métodos básicos para un CRUD tipo API.
// Implementación del modelo.

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:100',
            'descripcion'=>'nullable|string'
        ]);

        $category = Category::create($request->all());
        return response()->json([
            'messsage' => 'Categoria creada', 'category' => $category
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Category::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name'=> 'required|string|max:100',
            'description'=>'nullable|string'
        ]);

        $category->update($request->all());
        return response()->json([
            'message' => 'Categoria actualizada',
            'category' => $category
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::findOrFail($id)->delete();
        return response()->json(['message'=> 'Categoria elminada']);
    }
}
