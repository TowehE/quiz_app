<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizQuestionController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// GET all quiz questions
Route::get('/quiz/questions', [QuizQuestionController::class, 'index']);

// POST quiz answers
Route::post('/quiz/submit', [QuizController::class, 'store']);

// Check if email exists (optional - for real-time validation)
Route::get('/quiz/check-email/{email}', [QuizController::class, 'checkEmail']);