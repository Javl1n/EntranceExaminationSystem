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
    }
]);

rules([
    'questionInput' => 'required',
    'answerInputs.*' => 'required'
]);

$showMode = fn () => $this->dispatch("showMode-" . $this->question->id);

$updateQuestion = function() {
    $this->validate();
    // ddd($this->answerInputs);
    $this->question->update([
        'description' => $this->questionInput
    ]);
    
    foreach(['A', 'B', 'C', 'D'] as $letter) {
        // ddd($this->answerInputs[$letter]);
        $this->answers
            ->where('letter', $letter)
            ->first()
            ->update([
                'descrption' => $this->answerInputs[$letter]
            ]);
    }

    session()->flash('edit-success-' . $this->question->id, 'Question Added Successfully');
    $this->dispatch("showMode-" . $this->question->id);

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
            @php
                $letterColor = $answer->is_correct ? 'bg-green-200' : 'bg-gray-100';
                $answerColor = $answer->is_correct ? 'border-green-200' : 'border-gray-100';
            @endphp
            <div class="flex">
                <div class="flex flex-col">
                    <div class="w-14 rounded-l text-center py-4 px-0 font-bold {{ $letterColor }}">{{ $answer->letter }}</div>
                </div>
                <div class="py-2 px-2 flex-1 rounded-r {{ $letterColor }}">
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
                        @error("answersInput.{{ $answer->letter }}")
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
