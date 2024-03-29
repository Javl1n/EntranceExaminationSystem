<?php

use function Livewire\Volt\{layout, state, title, on};
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Contracts\Database\Eloquent\Builder;

layout('layouts.app');

title('Exams - SLSPI Entrance Exam');

state(['questions' => Question::with(['category', 'answers' => function (Builder $query) {
    $query->orderBy('letter');
}])->orderBy('updated_at', 'DESC')->get()]);

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams Management') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl min-h-max mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="lg:grid lg:grid-cols-3 lg:gap-5">
            <div class="col-span-2">
                @livewire('questions.create')
                @session('question-add')
                    <div class="bg-green-400 text-white shadow-sm sm:rounded-lg mt-4 px-4 py-2 text-sm font-bold rounded-xl">
                        {{ session('question-add') }}
                    </div>
                @endsession
                @session('deleted')
                    <div class="bg-red-500 text-white shadow-sm sm:rounded-lg mt-4 px-4 py-2 text-sm font-bold rounded-xl">
                        {{ session('deleted') }}
                    </div>
                @endsession
                @foreach ($questions as $question)
                    @livewire('questions.index', ['question' => $question, 'answers' => $question->answers])
                @endforeach
            </div>
            <div class="col-span-1">
                @livewire('timers.index')
            </div>
        </div>
    </div>
</div>