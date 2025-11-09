<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\QuizResult;
use App\Mail\QuizResultMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class QuizController extends Controller
{
    public function store(QuizRequest $request): JsonResponse
    {
        try {
            $email = $request->input('email');
            
            Log::info('Attempting to save email', ['email' => $email]);
            
            // Save only email
            $quiz = QuizResult::create(['email' => $email]);
            
            Log::info('Email saved successfully', ['quiz_id' => $quiz->id]);
            
            // Send confirmation email
            Mail::to($email)->send(new QuizResultMail($email));
            
            Log::info('Email sent successfully', ['email' => $email]);
            
            return response()->json([
                'success' => true,
                'message' => 'Quiz completed! Check your email for confirmation.'
            ], 201);
                     
        } catch (\Exception $e) {
            Log::error('Quiz submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
                     
            return response()->json([
                'success' => false,
                'message' => 'Failed to save email. Please try again.',
                'error' => $e->getMessage() // Temporarily expose error for debugging
            ], 500);
        }
    }
}