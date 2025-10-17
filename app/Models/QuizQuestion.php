<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    protected $fillable = ['question', 'options'];

    protected $casts = [
        'options' => 'array'
    ];
}
