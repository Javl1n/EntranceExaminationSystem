<?php

use function Livewire\Volt\{state, rules};

state([
    'question',
    'answers',
    'gradeColor',
    'categoryColor',
    'questionInput' => fn ($question) => $question->description,
    'answerInputs' => function ($answers) {
        $arr = [];
        foreach($answers as $answer) {
            $arr[$answer->letter] = $answer->description;
        }
        return $arr;
    },
    'correctAnswer' => function($answers) {
        foreach($answers as $answer) {
            if($answer->is_correct) {
                return $answer->letter;
            }
        }
    },
    'answerClasses' => function ($answers) {
        $arr = [];
        foreach($answers as $answer) {
            $arr[$answer->letter] = $answer->is_correct ? "bg-green-200" : "bg-gray-100";
        }
        return $arr;
    }
]);

rules([
    'questionInput' => 'required',
    'answerInputs.*' => 'required'
]);

$showMode = fn () => $this->dispatch("showMode-" . $this->question->id);

$setCorrectAnswer = function ($choice) {
    $this->correctAnswer = $choice;
    foreach ($this->answers as $answer) {
        $this->answerClasses[$answer->letter] = $this->correctAnswer === $answer->letter ? 'bg-green-200' : 'bg-gray-100';
    }
};

$updateQuestion = function() {
    $this->validate();
    $this->question->update([
        'description' => $this->questionInput
    ]);
    foreach(['A', 'B', 'C', 'D'] as $letter) {
        $answer = $this->answers
            ->where('letter', $letter)
            ->first()
            ->update([
                'description' => $this->answerInputs[$letter],
                'is_correct' => $this->correctAnswer === $letter ? true : false
        ]);
    }
    session()->flash('edit-success-' . $this->question->id,  'Changes Saved');
    return $this->redirectRoute('exams', navigate: true);
};

?>

<div>
    <div class="flex justify-between">
        <div class="flex gap-2">
            <div class="py-1 px-2 {{ $gradeColor }}  rounded text-xs">Grade {{ $question->grade_level }}</div>
            <div class="py-1 px-2 {{ $categoryColor }} rounded text-xs">{{ $question->category->title }}</div>
        </div>
        <span class="font-bold text-blue-400 transition">Edit Mode</span>
        <div class="flex gap-4">
            <button class=" text-gray-500 text-sm font-bold rounded uppercase hover:text-green-500 transition ease-linear" x-on:click="$wire.updateQuestion">Save</button>
            <button class=" text-gray-500 text-sm font-bold rounded uppercase hover:text-blue-500 transition ease-linear" x-on:click="$wire.showMode">Cancel</button>
        </div>
    </div>
    <div class="mt-4 px-0">
        <textarea
            class="resize-none p-0 w-full text-lg border-transparent focus:border-transparent focus:ring-0 rounded"
            x-data="{
                resize: () => { $el.style.height = '5px'; $el.style.height = $el.scrollHeight + 'px' }
            }"
            x-init="resize()"
            x-on:input="resize()"
            wire:model='questionInput'
            x-transition
        ></textarea>
        @error("questionInput")
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>
    <div class="grid grid-cols-2 grid-rows-2 gap-3 mt-4">
        @foreach ($this->answers as $answer)
            <div class="flex">
                <div class="flex flex-col"  x-on:click="$wire.setCorrectAnswer('{{ $answer->letter }}')">
                    <div class="w-14 rounded-l text-center py-4 px-0 font-bold {{ $answerClasses[$answer->letter] }}">{{ $answer->letter }}</div>
                </div>
                <div class="py-2 px-2 flex-1 rounded-r {{ $answerClasses[$answer->letter] }}">
                    <div class="bg-white h-full rounded">
                        <textarea
                            class="resize-none p-0 w-full px-2 pt-2 text-base border-transparent h-full focus:border-transparent focus:ring-0 rounded overflow-hidden"
                            x-data="{
                                resize: () => { $el.style.height = '38px'; $el.style.height = $el.scrollHeight + 'px' }
                            }"
                            x-init="resize()"
                            x-on:input="resize()"
                            wire:model="answerInputs.{{ $answer->letter }}"
                        ></textarea>
                        @error("answersInputs.{{ $answer->letter }}")
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
