<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use Illuminate\Http\JsonResponse;

class QuizQuestionController extends Controller
{
    public function index(): JsonResponse
    {
        // Only return active questions, don't include correct answers!
        $questions = QuizQuestion::getActiveQuestions()
            ->map(function($q) {
                return [
                    'id' => $q->id,
                    'question' => $q->question,
                    'options' => $q->options
                ];
            });

        return response()->json($questions);
    }
}