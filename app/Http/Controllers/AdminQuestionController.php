<?php

namespace App\Http\Controllers;

use App\Models\QuizQuestion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminQuestionController extends Controller
{
    /**
     * Get all questions (including inactive and correct answers)
     */
    public function index(): JsonResponse
    {
        $questions = QuizQuestion::orderBy('order')->get();
        return response()->json($questions);
    }

    /**
     * Create a new question
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'correct_answer' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $question = QuizQuestion::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Question created successfully',
            'data' => $question
        ], 201);
    }

    /**
     * Update a question
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $question = QuizQuestion::find($id);

        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'question' => 'sometimes|string',
            'options' => 'sometimes|array|min:2',
            'correct_answer' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $question->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Question updated successfully',
            'data' => $question
        ]);
    }

    /**
     * Delete a question
     */
    public function destroy(int $id): JsonResponse
    {
        $question = QuizQuestion::find($id);

        if (!$question) {
            return response()->json([
                'success' => false,
                'message' => 'Question not found'
            ], 404);
        }

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => 'Question deleted successfully'
        ]);
    }
}