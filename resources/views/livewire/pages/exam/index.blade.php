<?php

use function Livewire\Volt\{layout, state, title, mount};
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Contracts\Database\Eloquent\Builder;

layout('layouts.app');

title('Exams - SLSPI Entrance Exam');

state([
    'category' => [0,0],
    'questionQuery',
    'questions'
]);

mount(function () {
    $this->questionQuery = Question::with(['category', 'answers' => function (Builder $query) {
        $query->orderBy('letter');
    }])->orderBy('updated_at', 'DESC')->get();
    $this->questions = $this->questionQuery;
});

$setCategories = function ($array) {
    $this->category = $array;
    if($this->category[0] === 0 && $this->category[1] === 0) {
        return $this->questions = $this->questionQuery->all();
    }
    if($this->category[0] !== 0 && $this->category[1] === 0) {
        return $this->questions = $this->questionQuery->where('grade_level', $this->category[0])->all();
    }
    if($this->category[0] === 0 && $this->category[1] !== 0) {
        return $this->questions = $this->questionQuery->where('category_id', $this->category[1])->all();
    }
    return $this->questions = $this->questionQuery->where('grade_level', $this->category[0])->where('category_id', $this->category[1])->all();
};

$overview = fn($grade) => $this->redirect(route('exams.overview', [$grade]));


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
                @livewire('auth.questions.create')
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
                        <livewire:auth.questions.index :$question :answers="$question->answers" :key="$question->id" /> 
                @endforeach
            </div>
            <div class="col-span-1">
                <div>
                    <div class="bg-white rounded-lg shadow-sm p-4 text-center grid gap-2">
                        <x-primary-button wire:click='overview(7)' class="w-full bg-green-500 hover:bg-green-800 flex justify-center text-2xl">
                            <div>
                                G7 Examinee Overview
                            </div>
                        </x-primary-button>
                        <x-primary-button wire:click='overview(11)' class="w-full flex justify-center text-2xl">
                            <div>
                                G11 Examinee Overview
                            </div>
                        </x-primary-button>
                    </div>
                </div>
                @livewire('auth.timers.index')
                <div class="p-4 bg-white rounded-lg shadow-sm mt-4">
                    <h1 class="text-lg font-bold">Subjects</h1>
                    <div class="mt-2">
                        <h2 class="text-md font-semibold">All Grade</h2>
                        <div class="flex-1 flex justify-between gap-1 mt-1 h-10">
                            <div wire:click.prevent='setCategories([0, 0])' @class([
                                'bg-gradient-to-br from-30% from-gray-400 to-gray-200 text-white' => $this->category === [0, 0],
                                'border-2 border-gray-400 text-gray-700 hover:bg-gray-100' => $this->category !== [0, 0],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">All:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->count() }}
                                </h1>
                            </div>
                            <div wire:click.prevent='setCategories([0, 3])' @class([
                                'bg-gradient-to-br from-30% from-yellow-400 text-white to-yellow-200' => $this->category === [0, 3],
                                'border-2 border-yellow-500 text-yellow-700 hover:bg-yellow-50' => $this->category !== [0, 3],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">English:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 3)->count() }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex-1 flex justify-between gap-1 mt-1 h-10">
                            <div wire:click.prevent='setCategories([0, 2])' @class([
                                'bg-gradient-to-br from-10% text-white from-purple-500 to-violet-300' => $this->category === [0, 2],
                                'border-2 border-violet-400 text-violet-500 hover:bg-violet-50' => $this->category !== [0, 2],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">Science:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 2)->count() }}
                                </h1>
                            </div>
                            <div wire:click.prevent='setCategories([0, 1])' @class([
                                'bg-gradient-to-br from-30% text-white from-red-500 to-red-300' => $this->category === [0, 1],
                                'border-2 border-red-400 text-red-500 hover:bg-red-50' => $this->category !== [0, 1],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">Math:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 1)->count() }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <h2 class="text-md font-semibold">Grade 7</h2>
                        <div class="flex-1 flex justify-between gap-1 mt-1 h-10">
                            <div wire:click.prevent='setCategories([7, 0])' @class([
                                'bg-gradient-to-br from-30% from-green-400 to-green-200 text-white' => $this->category === [7, 0],
                                'border-2 border-green-500 text-green-700 hover:bg-green-50' => $this->category !== [7, 0],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">All:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('grade_level', 7)->count() }}
                                </h1>
                            </div>
                            <div wire:click.prevent='setCategories([7, 3])' @class([
                                'bg-gradient-to-br from-30% from-yellow-400 text-white to-yellow-200' => $this->category === [7, 3],
                                'border-2 border-yellow-500 text-yellow-700 hover:bg-yellow-50' => $this->category !== [7, 3],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">English:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 3)->where('grade_level', 7)->count() }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex-1 flex justify-between gap-1 mt-1 h-10">
                            <div wire:click.prevent='setCategories([7, 2])' @class([
                                'bg-gradient-to-br from-10% text-white from-purple-500 to-violet-300' => $this->category === [7, 2],
                                'border-2 border-violet-400 text-violet-500 hover:bg-violet-50' => $this->category !== [7, 2],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">Science:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 2)->where('grade_level', 7)->count() }}
                                </h1>
                            </div>
                            <div wire:click.prevent='setCategories([7, 1])' @class([
                                'bg-gradient-to-br from-30% text-white from-red-500 to-red-300' => $this->category === [7, 1],
                                'border-2 border-red-400 text-red-500 hover:bg-red-50' => $this->category !== [7, 1],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">Math:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 1)->where('grade_level', 7)->count() }}
                                </h1>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2">
                        <h2 class="text-md font-semibold">Grade 11</h2>
                        <div class="flex-1 flex justify-between gap-2 mt-1 h-10">
                            <div wire:click.prevent='setCategories([11, 0])' @class([
                                'bg-gradient-to-br from-10% from-blue-500 to-indigo-200 text-white' => $this->category === [11, 0],
                                'border-2 border-blue-700 text-blue-700 hover:bg-blue-50' => $this->category !== [11, 0],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">All:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('grade_level', 11)->count() }}
                                </h1>
                            </div>
                            <div wire:click.prevent='setCategories([11, 3])' @class([
                                'bg-gradient-to-br from-30% from-yellow-400 text-white to-yellow-200' => $this->category === [11, 3],
                                'border-2 border-yellow-500 text-yellow-700 hover:bg-yellow-50' => $this->category !== [11, 3],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">English:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 3)->where('grade_level', 11)->count() }}
                                </h1>
                            </div>
                        </div>
                        <div class="flex-1 flex justify-between gap-2 mt-1 h-10">
                            <div wire:click.prevent='setCategories([11, 2])' @class([
                                'bg-gradient-to-br from-10% text-white from-purple-500 to-violet-300' => $this->category === [11, 2],
                                'border-2 border-violet-400 text-violet-500 hover:bg-violet-50' => $this->category !== [11, 2],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">Science:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 2)->where('grade_level', 11)->count() }}
                                </h1>
                            </div>
                            <div wire:click.prevent='setCategories([11, 1])' @class([
                                'bg-gradient-to-br from-30% text-white from-red-500 to-red-300' => $this->category === [11, 1],
                                'border-2 border-red-400 text-red-500 hover:bg-red-50' => $this->category !== [11, 1],
                                'w-full text-center flex gap-2 justify-center rounded-xl transition duration-150 linear cursor-pointer'
                                ])>
                                <h1 class="text-center text-lg my-auto">Math:</h1>
                                <h1 class="text-lg font-bold my-auto">
                                    {{ $this->questionQuery->where('category_id', 1)->where('grade_level', 11)->count() }}
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>