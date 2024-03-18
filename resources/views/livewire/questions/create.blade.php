<?php

use App\Models\Answer;
use function Livewire\Volt\{state, rules};

rules([
    'question' => 'required',
    'answerA' => 'required',
    'answerB' => 'required',
    'answerC' => 'required',
    'answerD' => 'required',
]);

state([
    'correctAnswer' => 'A',
    'answerClasses' => [
        'A' => 'bg-green-200',
        'B' => 'bg-gray-100',
        'C' => 'bg-gray-100',
        'D' => 'bg-gray-100'
    ],
    'categories' => App\Models\Category::all(),
    'categoryChoice' => 1,
    'grade' => 7,
    'question' => '',
    'answerA' => '',
    'answerB' => '',
    'answerC' => '',
    'answerD' => '',
]);

$setCorrectAnswer = function ($number) {
    $this->correctAnswer = $number;
    $letters = ['A', 'B', 'C', 'D'];
    foreach ($letters as $letter) {
        $this->answerClasses[$letter] = $this->correctAnswer === $letter ? 'bg-green-200' : 'bg-gray-100';
    }
};

$submitForm = function () {


    $this->validate();

    $question = App\Models\Question::create([
        'description' => $this->question,
        'grade_level' => $this->grade,
        'category_id' => $this->categoryChoice
    ]);
    

    $answersDescription =[
        [
            'letter' => 'A',
            'description' => $this->answerA,
            'is_correct' => 'A' === $this->correctAnswer
        ],
        [
            'letter' => 'B',
            'description' => $this->answerB,
            'is_correct' => 'B' === $this->correctAnswer
        ],
        [
            'letter' => 'C',
            'description' => $this->answerC,
            'is_correct' => 'C' === $this->correctAnswer
        ],
        [
            'letter' => 'D',
            'description' => $this->answerD,
            'is_correct' => 'D' === $this->correctAnswer
        ],
    ];

    foreach($answersDescription as $description) {
        $question->answers()->create($description);
    }


    session()->flash('question-add', 'Question Added Successfully');

    return $this->redirectRoute('exams', navigate: true);
}

?>

<div x-data="{ open: false }" class="bg-white shadow-sm sm:rounded-lg p-4 rounded-xl">
    <form wire:submit.prevent='submitForm'>
        <div class="flex justify-between">
            <h3 class="text-lg font-bold">Add Question</h3>
            <span x-on:click="open = ! open " class="my-auto">
                <x-bootstrap-icons icon="plus" x-bind:class="open ? 'rotate-45' : ''" class="h-6 w-6 linear transition cursor-pointer" />
            </span>
        </div>
        <div class="mt-2" x-show="open" x-collapse>
            <div class="lg:flex gap-3">
                <div class="flex gap-2">
                    <span class="text-sm my-auto">Grade Level:</span>
                    <select class="text-sm my-auto py-0 h-8 rounded-lg" wire:model='grade'>
                        <option value="7">Grade 7</option>
                        <option value="11">Grade 11</option>
                    </select>
                </div>
                <div class="mt-2 lg:mt-0 flex gap-2">
                    <span class="text-sm my-auto">Category:</span>
                    <select class="text-sm my-auto py-0 h-8 rounded-lg" wire:model="categoryChoice">
                        @foreach ($categories as $category)
                            <option class="" value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            {{-- Question --}}
            <div class="mt-4">
                <div class="flex">
                    <div class="flex flex-col">
                        <h1 class="bg-blue-100 px-3 py-2 rounded-l-lg font-bold select-none" title="Question Field">Q</h1>
                    </div>
                    <div class="bg-blue-100 p-2 flex-1 rounded-b-lg rounded-tr-lg">
                        <textarea class="w-full border-none resize-none rounded" rows="4" wire:model='question' required>{{ $question }}</textarea>
                        @error("question")
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Answers --}}
            <div class="mt-4">
                <h1 class="font-bold">Answers:
                    <span class="font-light text-xs italic text-gray-600">select the letter for the option that you want to be the <span class="text-green-600 font-bold">correct answer</span>.
                    </span>
                </h1>
                {{-- Answer A --}}
                <div class="flex mt-2">
                    <div class="flex flex-col">
                        <h1 class="{{ $answerClasses['A'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" wire:click="setCorrectAnswer('A')">A</h1>
                    </div>
                    <div class="{{ $answerClasses['A'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                        <textarea class="w-full border-none resize-none rounded" rows="2" wire:model.live="answerA" required>{{ $answerA }}</textarea>
                        @error("answerA")
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- Answer B --}}
                <div class="flex mt-2">
                    <div class="flex flex-col">
                        <h1 class="{{ $answerClasses['B'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" wire:click="setCorrectAnswer('B')">B</h1>
                    </div>
                    <div class="{{ $answerClasses['B'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                        <textarea class="w-full border-none resize-none rounded " rows="2" wire:model="answerB" required>{{ $answerB }}</textarea>
                        @error("answerB")
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- Answer C --}}
                <div class="flex mt-2">
                    <div class="flex flex-col">
                        <h1 class="{{ $answerClasses['C'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" wire:click="setCorrectAnswer('C')">C</h1>
                    </div>
                    <div class="{{ $answerClasses['C'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                        <textarea class="w-full border-none resize-none rounded" rows="2" wire:model="answerC" required>{{ $answerC }}</textarea>
                        @error("answerC")
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{-- Answer D --}}
                <div class="flex mt-2">
                    <div class="flex flex-col">
                        <h1 class="{{ $answerClasses['D'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" wire:click="setCorrectAnswer('D')">D</h1>
                    </div>
                    <div class="{{ $answerClasses['D'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                        <textarea class="w-full border-none resize-none rounded" rows="2" wire:model="answerD" required>{{ $answerD }}</textarea>
                        @error("answerD")
                            <span class="text-red-500 text-xs italic">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- Submit Button --}}
            <div class="mt-6 flex justify-end">
                <button class="bg-blue-500 hover:bg-blue-900 px-4 py-2 rounded-lg text-white text-sm font-bold transition ease-linear">Submit</button>
            </div>
        </div>
    </form>
</div>
