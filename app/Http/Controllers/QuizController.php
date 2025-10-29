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
            $skipEmail = $request->input('skip_email', false);
            
            // If they skip email, just return success
            if ($skipEmail || empty($email)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Quiz completed successfully!'
                ], 200);
            }
            
            // Save email and send confirmation
            $quiz = QuizResult::create(['email' => $email]);
            
            Mail::to($email)->send(new QuizResultMail($email));
            
            Log::info('Quiz email saved', ['email' => $email]);
            
            return response()->json([
                'success' => true,
                'message' => 'Quiz completed! Check your email for confirmation.'
            ], 201);
                     
        } catch (\Exception $e) {
            Log::error('Quiz submission failed', ['error' => $e->getMessage()]);
                     
            return response()->json([
                'success' => false,
                'message' => 'Failed to save email. Please try again.'
            ], 500);
        }
    }
}