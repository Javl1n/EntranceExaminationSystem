<?php

use function Livewire\Volt\{state};

state([
    'question',
    'answers',
    'gradeColor',
    'categoryColor'
]);

$editMode = fn () => $this->dispatch("editMode-" . $this->question->id);

?>

<div>
    <div class="flex justify-between transition">
        <div class="flex gap-2">
            <div class="py-1 px-2 {{ $gradeColor }}  rounded text-xs">Grade {{ $question->grade_level }}</div>
            <div class="py-1 px-2 {{ $categoryColor }} rounded text-xs">{{ $question->category->title }}</div>
        </div>
        
        @session('edit-success' . $question->id)
            <span class="font-bold text-green-400 transition">{{ $message }}</span>
        @endsession
        <div class="flex gap-2">
            <button class="px-4 text-gray-500 text-sm font-bold rounded uppercase hover:text-blue-500 transition ease-linear" wire:click='editMode'>Edit</button>
        </div>
    </div>
    <div class="mt-4 break-words text-lg">{{ $question->description }}</div>
    <div class="grid grid-cols-2 grid-rows-2 gap-3 mt-4">
        @foreach ($answers as $answer)
            @php
                $letterColor = $answer->is_correct ? 'bg-green-200' : 'bg-gray-100';
                $answerColor = $answer->is_correct ? 'border-green-200' : 'border-gray-100';
            @endphp
            <div class="flex">
                <div class="flex flex-col">
                    <div class="w-14 rounded-l text-center py-4 font-bold {{ $letterColor }}">{{ $answer->letter }}</div>
                </div>
                <div class="py-2 px-2 flex-1 rounded-r {{ $letterColor }}">
                    <div class="px-2 py-2 rounded bg-white break-all h-full">{{ $answer->description }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
