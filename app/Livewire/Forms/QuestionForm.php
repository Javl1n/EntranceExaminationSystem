<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class QuestionForm extends Form
{
    #[Validate('required|min:20')]
    public $question = "";

    #[Validate('required|min:10')]
    public $answerA = "";

    #[Validate('required|min:10')]
    public $answerB = "";

    #[Validate('required|min:10')]
    public $answerC = "";

    #[Validate('required|min:10')]
    public $answerD = "";
}
