<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FileController extends Controller
{       
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Files/Index', [
            'files' => auth()->user()->files()->get(),
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
            'name' => 'required|string',
            'extension' => 'required|string',
            'duration' => 'integer|required',
        ]);

        $user = auth()->user();
        $file = $user->files()->create($validated);

        $response = FileService::createS3Object($file);

        return response()->json([
            'upload_url' => $response['upload_url']
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        return Inertia::render('Files/Show', [
            'file' => $file->load('transcriptions'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        //
    }
}
