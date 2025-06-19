<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'enrollment_id' => 'required|exists:enrollments,id',
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $evaluation = Evaluation::create([
            'enrollment_id' => $request->enrollment_id,
            'score' => $request->score,
            'feedback' => $request->feedback,
            'evaluated_at' => now(),
        ]);
        return response()->json($evaluation, 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $evaluation = Evaluation::findOrFail($id);
        $request ->validate([
            'score' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);
        $evaluation->update($request->all());
        return response()->json($evaluation);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Evaluation::findOrFail( $id )->delete();
        return response()->json(['message' => 'Evaluación eliminada']);
    }

    public function byStudent(Request $request, string $id)
    {
        if ($request->user()->role !== 'admin' && $request->user()->id != $id) {
            return response()->json(['message'=> 'No tienes permiso para ver las evaluaciones de otros estudiantes'], 403);
        }
        return Evaluation::with('enrollment.course')
                            ->whereHas('enrollment', fn($q) => $q->where('user_id', $id))
                            ->get();
    }
}
