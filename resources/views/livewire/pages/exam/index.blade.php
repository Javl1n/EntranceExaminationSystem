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
                    <div class="bg-white shadow-sm sm:rounded-lg mt-4 p-4 rounded-xl">
                        <div class="flex gap-2">
                            <div class="py-1 px-2 @if ($question->grade_level === 7) bg-green-50 @else bg-blue-50 @endif  rounded text-xs">Grade {{ $question->grade_level }}</div>
                            @php
                                switch ($question->category->id) {
                                    case 1:
                                        $background = 'bg-red-200';
                                        break;
                                    case 2:
                                        $background = 'bg-yellow-100';
                                        break;
                                    case 3:
                                        $background = 'bg-orange-100';
                                        break;
                                    case 4:
                                        $background = 'bg-purple-100';
                                        break;
                                    case 5:
                                        $background = 'bg-pink-200';
                                        break;
                                    default:
                                        break;
                                }
                            @endphp
                            <div class="py-1 px-2 {{ $background }} rounded text-xs">{{ $question->category->title }}</div>
                        </div>
                        <div class="mt-4">{{ $question->description }}</div>
                        <div class="grid grid-cols-2 grid-rows-2">
                            @php
                                $answers = $question->answers()->orderBy('letter')->get();
                            @endphp

                            @foreach ($answers as $answer)
                                <div>
                                    {{ $answer->letter }}-{{ $answer->description }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
            </div>
            <div class="col-span-1">
                Search
            </div>
        </div>
    </div>
</div>