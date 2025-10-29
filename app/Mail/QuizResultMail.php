<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuizResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $score;

    public function __construct($email, $score)
    {
        $this->email = $email;
        $this->score = $score;
    }

    public function build()
    {
        return $this->subject('Your Quiz Results - Domtrade 2025')
                    ->markdown('emails.quiz-result');
    }
}