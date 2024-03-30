<?php

use function Livewire\Volt\{state, on };

state([
    'question',
    'answers',
    'gradeColor' => fn($question) => $question->grade_level === 7 ? 'bg-green-200' : 'bg-blue-200',
    'categoryColor' => function($question) {
        switch ($question->category->id) {
            case 1:
                return 'bg-red-200';
                break;
            case 2:
                return 'bg-yellow-100';
                break;
            case 3:
                return 'bg-purple-100';
                break;
            default:
                return '';
                break;
        }
    },
    'viewState' => 'show',
]);

on([
    "editMode-{question.id}" => function () { return $this->viewState = 'edit';},
    "showMode-{question.id}" => function () { return $this->viewState = 'show';},
]);



?>

<div class="bg-white shadow-sm sm:rounded-lg mt-4 p-4 rounded-xl transition ease-linear">
    @if($viewState === 'show')
        <livewire:auth.questions.show :$question :$answers :$gradeColor :$categoryColor />
    @elseif ($viewState === 'edit')
        <livewire:auth.questions.edit :$question :$answers :$gradeColor :$categoryColor />
    @endif
</div>

