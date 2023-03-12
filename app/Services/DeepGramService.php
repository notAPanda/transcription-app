<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    public static function transcribe(File $file, array $options = [])
    {
        $token = env('DEEPGRAM_API_KEY');

        $defaults = [
            'url' => Storage::disk('s3')->url($file->s3_path),
            'language' => 'pl',
        ];

        $data = array_merge($defaults, $options);

        $response = Http::post('https://api.deepgram.com/v1/listen', $data)->headers([
            'Authorization' => "Token {$token}",
            'content-type' => 'application/json',
        ]);

        return $response;
    }
}
