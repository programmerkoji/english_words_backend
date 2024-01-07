<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_en',
        'word_ja',
        'part_of_speech',
        'memory',
        'memo',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
