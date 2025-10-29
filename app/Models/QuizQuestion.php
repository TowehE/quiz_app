<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = [
        'question', 
        'options', 
        'correct_answer',
        'order',
        'is_active'
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean'
    ];

    // Get only active questions, ordered
    public static function getActiveQuestions()
    {
        return self::where('is_active', true)
                   ->orderBy('order')
                   ->get();
    }
}