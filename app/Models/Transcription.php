<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transcription extends Model
{
    use HasFactory;

    protected $fillable = [
        'deepgram_response',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
        'deepgram_response' => 'array',
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
