<?php

use function Livewire\Volt\{state, action};

state([
    'question',
    'answers',
    'categoryColor' => function($question) {
        switch ($question->category->id) {
            case 1:
                return 'bg-red-400';
                break;
            case 2:
                return 'bg-yellow-400';
                break;
            case 3:
                return 'bg-purple-400';
                break;
            default:
                return '';
                break;
        }
    },
    'selectedAnswer',
]);

// $selectAnswer = action(
//     fn ($letter) => $this->dispatch('selectAnswer', question: $this->question->id, answer: $letter)
// )->renderless();

?>

<div>
    <div class="">
        <div class="absolute rounded-lg {{ $categoryColor }}  mt-4 ms-3  px-5 text-sm text-white font-bold">
            {{ $question->category->title }}
        </div>
        <div class="w-full bg-white rounded-lg py-10 px-12 shadow-md mt-4">
            <h1 class="text-center text-2xl mt-4">
                {{ $question->description }}
            </h1>
            <div class="mt-10 grid grid-cols-2 grid-rows-2 gap-5">
                @foreach ($answers as $answer)
                    <div class="flex">
                        <div class="flex flex-col">
                            <input type="radio" name="{{ $question->id }}" value="{{ $answer->letter }}" wire:model='selectedAnswer'>
                            <div 
                            {{-- wire:click.live="$parent.selectAnswer({{ $question->id }} ,'{{ $answer->letter }}')"  --}}
                            class="w-14 rounded-l text-center py-4 font-bold bg-gray-100">{{ $answer->letter }}</div>
                        </div>
                        <div class="py-2 px-2 flex-1 rounded-r bg-gray-100">
                            <div class="px-2 py-2 rounded text-center bg-white break-all h-full">{{ $answer->description }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
