<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use Illuminate\Http\JsonResponse;

class QuizQuestionController extends Controller
{
    public function index(): JsonResponse
    {
        // Fetch all quiz questions
        $questions = QuizQuestion::all();
        return response()->json($questions);
    }
}
