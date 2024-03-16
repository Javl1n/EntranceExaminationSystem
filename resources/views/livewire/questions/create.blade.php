<?php

use function Livewire\Volt\{state};

state([
    'collapseClass' => 'open', 
    'isCollapsed' => true, 
    'correctAnswer', 
    'answers' => [
        'A' => 'bg-gray-100', 
        'B' => 'bg-gray-100', 
        'C' => 'bg-gray-100',
        'D' => 'bg-gray-100'
        ],
]);

$toggleCollapse = function () {
    $this->collapseClass = $this->isCollapsed ? "" : "rotate-45";
    $this->isCollapsed = !$this->isCollapsed;
};

$setCorrectAnswer = function ($number) {
    $this->correctAnswer = $number;
    $letters = ['A', 'B', 'C', 'D'];
    foreach ($letters as $letter) {
        $this->answers[$letter] = $this->correctAnswer === $letter ? 'bg-green-200' : 'bg-gray-100';
    }
};

?>

<div x-data="{ open: true }">
    <div class="flex justify-between">
        <h3 class="text-lg font-bold">Add Question</h3>
        <button x-on:click="open = ! open " wire:click='toggleCollapse' wire:transition>
            <x-bootstrap-icons icon="plus" class="h-6 w-6 {{ $collapseClass }} linear transition" />
        </button>
    </div>
    <div class="mt-2" x-show="open" x-collapse>
        <div class="flex gap-3">
            <div class="flex gap-2">
                <span class="text-sm my-auto">Grade Level:</span>
                <select class="text-sm my-auto py-0 h-8 rounded-lg" name="grade" id="">
                    <option value="">Grade 7</option>
                    <option value="">Grade 11</option>
                </select>
            </div>
            <div class="flex gap-2">
                <span class="text-sm my-auto">Category:</span>
                <select class="text-sm my-auto py-0 h-8 rounded-lg" name="grade" id="">
                    <option class="" value="">Mathematics</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4">
            <div class="flex">
                <div class="flex flex-col">
                    <h1 class="bg-gray-100 px-3 py-2 rounded-l-lg font-bold select-none" title="Question Field">Q</h1>
                </div>
                <div class="bg-gray-100 p-2 flex-1 rounded-b-lg rounded-tr-lg">
                    <textarea class="w-full border-none resize-none rounded" name="" id="" rows="4"></textarea>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h1 class="font-bold">Answers: 
                <span class="font-light text-xs italic text-gray-600">select the letter for the option that you want to be the <span class="text-green-600 font-bold">correct answer</span>.
                </span>
            </h1>
            <div class="flex mt-2">
                <div class="flex flex-col">
                    <h1 class="{{ $answers['A'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" title="Question Field" wire:click="setCorrectAnswer('A')">A</h1>
                </div>
                <div class="{{ $answers['A'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                    <textarea class="w-full border-none resize-none rounded" name="" id="" rows="4"></textarea>
                </div>
            </div>
            <div class="flex mt-2">
                <div class="flex flex-col">
                    <h1 class="{{ $answers['B'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" title="Question Field" wire:click="setCorrectAnswer('B')">B</h1>
                </div>
                <div class="{{ $answers['B'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                    <textarea class="w-full border-none resize-none rounded" name="" id="" rows="4"></textarea>
                </div>
            </div>
            <div class="flex mt-2">
                <div class="flex flex-col">
                    <h1 class="{{ $answers['C'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" title="Question Field" wire:click="setCorrectAnswer('C')">C</h1>
                </div>
                <div class="{{ $answers['C'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                    <textarea class="w-full border-none resize-none rounded" name="" id="" rows="4"></textarea>
                </div>
            </div>
            <div class="flex mt-2">
                <div class="flex flex-col">
                    <h1 class="{{ $answers['D'] }} transition ease-in-out px-3 py-2 rounded-l-lg font-bold select-none" title="Question Field" wire:click="setCorrectAnswer('D')">D</h1>
                </div>
                <div class="{{ $answers['D'] }} transition ease-in-out p-2 flex-1 rounded-b-lg rounded-tr-lg">
                    <textarea class="w-full border-none resize-none rounded" name="" id="" rows="4"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
