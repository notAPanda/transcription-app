<?php

namespace App\Http\Controllers;

use App\Models\Transcription;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TranscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Transcriptions/Index', [
            'transcriptions' => auth()->user()->transcriptions()->with('file')->get(),
        ]);
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
        $validated = $request->validate([
            'file_id' => 'required|integer',
            'language' => 'required|string',
        ]);

        $settings = array_filter($validated, function($key) {
            return !in_array($key, ['file_id']);
        }, ARRAY_FILTER_USE_KEY);

        Transcription::create([
            'user_id' => $request->user()->id,
            'file_id' => $validated['file_id'],
            'settings' => $settings,
            'status' => 0,
        ]);

        return to_route('transcriptions.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transcription $transcription)
    {
        return Inertia::render('Transcriptions/Show', [
            'transcription' => $transcription,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transcription $transcription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transcription $transcription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transcription $transcription)
    {
        //
    }
}
