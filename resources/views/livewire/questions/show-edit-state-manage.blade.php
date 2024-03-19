<?php

use function Livewire\Volt\{state};

state([
    'question',
    'answers' => fn($question) => $question->answers()->orderBy('letter')->get(),
    'gradeColor' => fn($question) => $question->grade_level === 7 ? 'bg-green-50' : 'bg-blue-50',
    'categoryColor' => function($question) {
        switch ($question->category->id) {
            case 1:
                return 'bg-red-200';
                break;
            case 2:
                return 'bg-yellow-100';
                break;
            case 3:
                return 'bg-orange-100';
                break;
            case 4:
                return 'bg-purple-100';
                break;
            case 5:
                return 'bg-pink-200';
                break;
            default:
                return '';
                break;
        }
    },
    'viewState' => 'edit'
]);

$setViewStateToEdit = fn () => $this->viewState = 'edit';
$setViewStateToShow = fn () => $this->viewState = 'show';

$updateQuestion;



?>

<div class="bg-white shadow-sm sm:rounded-lg mt-4 p-4 rounded-xl transition ease-linear">
    @if($viewState === 'show')
        <div>
            <div class="flex justify-between">
                <div class="flex gap-2">
                    <div class="py-1 px-2 {{ $gradeColor }}  rounded text-xs">Grade {{ $question->grade_level }}</div>
                    <div class="py-1 px-2 {{ $categoryColor }} rounded text-xs">{{ $question->category->title }}</div>
                </div>
                <div class="flex gap-2">
                    <button class="px-4 text-gray-500 text-sm font-bold rounded uppercase hover:text-blue-500 transition ease-linear" wire:click='setViewStateToEdit'>Edit</button>
                </div>
            </div>
            @livewire('questions.show', ['question' => $question])
        </div>
    @elseif ($viewState === 'edit')
        <div>
            <div class="flex justify-between">
                <div class="flex gap-2">
                    <div class="py-1 px-2 {{ $gradeColor }}  rounded text-xs">Grade {{ $question->grade_level }}</div>
                    <div class="py-1 px-2 {{ $categoryColor }} rounded text-xs">{{ $question->category->title }}</div>
                </div>
                <span class="font-bold text-blue-400">Edit Mode</span>
                <div class="flex gap-4">
                    <button class=" text-gray-500 text-sm font-bold rounded uppercase hover:text-green-500 transition ease-linear" wire:click='updateQuestion'>Save</button>
                    <button class=" text-gray-500 text-sm font-bold rounded uppercase hover:text-blue-500 transition ease-linear" wire:click='setViewStateToShow'>Cancel</button>
                </div>
            </div>
            <div class="mt-4 px-0">
                <textarea
                    class="resize-none p-0 w-full text-lg border-transparent focus:border-transparent focus:ring-0 rounded overflow-hidden"
                    x-data="{
                        resize: () => { $el.style.height = '5px'; $el.style.height = $el.scrollHeight + 'px' }
                    }"
                    x-init="resize()"
                    x-on:input="resize()"
                >{{ $question->description }}</textarea>
            </div>
            <div class="grid grid-cols-2 grid-rows-2 gap-3 mt-4">
                @foreach ($answers as $answer)
                    @php
                        $letterColor = $answer->is_correct ? 'bg-green-200' : 'bg-gray-100';
                        $answerColor = $answer->is_correct ? 'border-green-200' : 'border-gray-100';
            
                    @endphp
                    <div class="flex">
                        <div class="flex flex-col">
                            <div class="w-14 rounded-l text-center py-4 px-0 font-bold {{ $letterColor }}">{{ $answer->letter }}</div>
                        </div>
                        <div class="py-2 px-2 flex-1 rounded-r {{ $letterColor }}">
                            {{-- <input class="px-2 rounded bg-white break-all h-full" value="{{ $answer->description }}"> --}}
                            <div class="bg-white h-full rounded">
                                <textarea
                                    class="resize-none p-0 w-full px-2 pt-2 text-base border-transparent h-full focus:border-transparent focus:ring-0 rounded overflow-hidden"
                                    x-data="{
                                        resize: () => { $el.style.height = '38px'; $el.style.height = $el.scrollHeight + 'px' }
                                    }"
                                    x-init="resize()"
                                    x-on:input="resize()"
                                >{{ $answer->description }}</textarea>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

