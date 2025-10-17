<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('quiz_results', 'email')
            ],
            'answers' => 'required|array|min:1',
            'answers.*.question_id' => 'required|integer|exists:quiz_questions,id',
            'answers.*.answer' => 'required|string',
            'result_type' => 'required|string|max:100',
            'source' => 'required|string|max:50'
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Please provide your email address.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email has already been used to complete the quiz. Each email can only submit once.',
            'answers.required' => 'Please answer all quiz questions.',
            'answers.array' => 'Invalid answers format.',
            'answers.min' => 'Please answer at least one question.',
            'answers.*.question_id.required' => 'Question ID is required for each answer.',
            'answers.*.question_id.exists' => 'Invalid question ID provided.',
            'answers.*.answer.required' => 'Please provide an answer for each question.',
            'result_type.required' => 'Result type is required.',
            'source.required' => 'Source is required.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'email' => 'email address',
            'answers' => 'quiz answers',
            'result_type' => 'result type',
            'source' => 'submission source',
        ];
    }
}