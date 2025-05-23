<?php

use function Livewire\Volt\{state, on};
use App\Models\Answer;

state([
    'question',
    'answers',
    'gradeColor',
    'categoryColor',
    'successMessage'
]);

$editMode = fn () => $this->dispatch("editMode-" . $this->question->id);
$deleteQuestion = function() {
    $this->question->delete();
    session()->flash('deleted', 'Question Deleted Successfully');
    return $this->redirectRoute('exams.index', navigate: true);
};

$percentage = function (Answer $answer) {
    $examinees = $answer->examinees_answers->count();

    $total = $this->question->examinee_answers->count();

    if ($total == 0) {
        return 0;
    }

    return round($examinees / $total * 100);
    // return $percentage;
}

?>

<div>
    <div class="flex justify-between transition">
        <div class="flex gap-2">
            <div class="py-1 px-2 {{ $gradeColor }}  rounded text-xs">Grade {{ $question->grade_level }}</div>
            <div class="py-1 px-2 {{ $categoryColor }} rounded text-xs">{{ $question->category->title }}</div>
        </div>
        
        @session('edit-success-' . $question->id)
            <span class="font-bold text-green-400 transition">{{ $value }}</span>
        @endsession
        <div class="flex gap-2">
            <button class="px-4 text-gray-500 text-sm font-bold rounded uppercase hover:text-blue-500 transition ease-linear" wire:click='editMode'>Edit</button>
            <button class="px-4 text-red-400 text-sm font-bold rounded uppercase hover:text-red-700 transition ease-linear" wire:click='deleteQuestion' wire:confirm="Are you sure you want to delete this question?">Delete</button>
        </div>
    </div>
    <div class="mt-4 break-words text-lg">{{ $question->description }}</div>
    <div class="grid grid-cols-2 grid-rows-2 gap-3 mt-4">
        @foreach ($answers as $answer)
            <div class="flex" wire:key="showAnswer{{ $answer->id }}">
                @php
                    $letterColor = $answer->is_correct ? 'bg-green-200' : 'bg-gray-100';
                @endphp
                <div class="flex flex-col">
                    <div class="w-14 rounded-l text-center py-4 font-bold {{ $letterColor }}">{{ $answer->letter }}</div>
                </div>
                <div class="py-2 px-2 flex-1 rounded-r {{ $letterColor }}">
                    <div style="background-image: linear-gradient(to right, #dbeafe {{ $this->percentage($answer) - 1 }}%, white {{ $this->percentage($answer) }}%);" class="ring-[1px] ring-gray-200 px-2 py-2 rounded break-all h-full break-words">
                        <div class="flex">
                            <div class="flex-1">{{ $answer->description }}</div>
                            <div class="text-xs my-auto text-gray-700 font-bold">{{ $this->percentage($answer) }}%</div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-4 flex gap-5 text-xs text-gray-700 italic">
        <div>
            <span class="font-bold">created on: </span>{{ $question->created_at->toFormattedDayDateString()}} ({{ $question->created_at->diffForHumans() }})
        </div>
        <div>
            <span class="font-bold">last updated on: </span>{{ $question->updated_at->toFormattedDayDateString()}} ({{ $question->updated_at->diffForHumans() }})
        </div>
    </div>
</div>
