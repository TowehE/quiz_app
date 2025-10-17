<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuizRequest;
use App\Models\QuizResult;
use App\Services\CsvExportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Handle quiz submission
     */
    public function store(QuizRequest $request): JsonResponse
    {
        try {
            // Get validated data from QuizRequest
            $data = $request->validated();

            // Use database transaction for data integrity
            DB::beginTransaction();

            // Save to database
            $quiz = QuizResult::create($data);

            // Save to CSV automatically
            CsvExportService::appendToCsv($quiz);

            DB::commit();

            // Log successful submission
            Log::info('Quiz submitted successfully', [
                'email' => $quiz->email,
                'result_type' => $quiz->result_type,
                'id' => $quiz->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Quiz submitted successfully! Check your email for results.',
                'data' => [
                    'id' => $quiz->id,
                    'result_type' => $quiz->result_type,
                    'email' => $quiz->email
                ]
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Quiz submission failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to save quiz. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : 'An error occurred'
            ], 500);
        }
    }

    /**
     * Check if email has already submitted
     */
    public function checkEmail(string $email): JsonResponse
    {
        $exists = QuizResult::where('email', $email)->exists();
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists 
                ? 'This email has already completed the quiz.' 
                : 'Email is available.'
        ]);
    }
}