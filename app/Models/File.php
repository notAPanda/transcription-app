<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'extension',
        's3_path',
        'transcript',
        'raw_transcript',
        'duration',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transcriptions()
    {
        return $this->hasMany(Transcription::class);
    }
}
