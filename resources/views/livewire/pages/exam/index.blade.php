<?php

use function Livewire\Volt\{layout, state, title};
use App\Models\Question;
use App\Models\Answer;

layout('layouts.app');

title('Exams - SLSPI Entrance Exam');

state(['questions' => Question::with('category')->latest()->get()]);


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
                @foreach ($questions as $question)
                    @livewire('questions.show-edit-state-manage', ['question' => $question])
                @endforeach
                
            </div>
            <div class="col-span-1">
                Search
            </div>
        </div>
    </div>
</div>