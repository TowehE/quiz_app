<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizQuestion;

class QuizQuestionsSeeder extends Seeder
{
    public function run()
    {
        $questions = [
            [
                'question' => 'How do you handle savings?',
                'options' => ['Save regularly','Spend freely','Invest','Plan carefully'],
            ],
            [
                'question' => 'Do you plan a monthly budget?',
                'options' => ['Yes','No','Sometimes','Rarely'],
            ],
            [
                'question' => 'How often do you invest?',
                'options' => ['Regularly','Occasionally','Rarely','Never'],
            ],
            [
                'question' => 'How do you react to financial risks?',
                'options' => ['Careful','Balanced','Risk-taker','Avoid entirely'],
            ],
            [
                'question' => 'Do you track your expenses?',
                'options' => ['Always','Sometimes','Rarely','Never'],
            ],
            [
                'question' => 'Do you set financial goals?',
                'options' => ['Yes, clearly','Somewhat','Not really','No'],
            ],
            [
                'question' => 'Do you prioritize saving or spending?',
                'options' => ['Saving','Spending','Both equally','Depends'],
            ],
            [
                'question' => 'How comfortable are you with investing?',
                'options' => ['Very','Somewhat','Not comfortable','Avoid completely'],
            ],
            [
                'question' => 'Do you have an emergency fund?',
                'options' => ['Yes, fully funded','Partially','Planning','No'],
            ],
            [
                'question' => 'How often do you review your finances?',
                'options' => ['Weekly','Monthly','Occasionally','Never'],
            ],
        ];

        foreach ($questions as $q) {
            QuizQuestion::create([
                'question' => $q['question'],
                'options' => $q['options'],    
            ]);
        }
    }
}
