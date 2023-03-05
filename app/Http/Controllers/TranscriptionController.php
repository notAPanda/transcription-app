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
        return Inertia::render('Transcriptions/Index');
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
    public function show(Transcription $transcription)
    {
        //
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
