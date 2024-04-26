<?php

use function Livewire\Volt\{state, layout, title, mount};

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Examinee;
use App\Models\ExamineeAnswer;
use App\Models\Timer;
use App\Models\Question;
use App\Models\Answer;

layout('layouts.app');

title(fn() => $this->examinee->name . ' - SLSPI Entrance Exam');

state([
    'examinee',
    'questions',
    'answers'
]);

mount(function () {
    $this->examinee = Examinee::with([
        'answers' => [
            'question' 
            => [
                'category',
                // 'answers'
            ],
            'answer'
            //  => [
            //     'question'
            // ]
        ]
    ])->findOrFail($this->examinee);
    $this->questions = Question::
    with([
        'category', 
        'answers' => function (Builder $query) {
        $query->orderBy('letter');
    }
    ])->
    where('grade_level', $this->examinee->grade_level)->get();
});

?>

<div class="py-12 min-h-screen"  x-data="{scrolled: false}">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Examinee') }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mx-auto shadow bg-white  rounded-lg">
        <div class="py-8 px-10 text-xl">
            <div class="flex justify-between">
                <div>Name: <span class="font-bold">{{ $examinee->name }}</span></div>
                <div>Email: <span class="font-bold">{{ $examinee->email }}</span></div>
            </div>
            <div class="flex justify-between">
                <div>Grade Level: <span class="font-bold">Grade {{ $examinee->grade_level }}</span></div>
                <div>Examination Date: <span class="font-bold">{{ $examinee->created_at->format('F j, Y') }}</span></div>
            </div>
        </div>
    </div>
    <div class="mt-10">
        @livewire('guest.result.scores', ['examinee' => $this->examinee, 'questions' => $this->questions])
    </div>
    @livewire('guest.result.answers', ['examinee' => $this->examinee, 'questions' => $this->questions])
    <div class="sticky bottom-10" x-show="scrolled"  x-transition.duration.500ms >
        <div class="flex justify-center">
            <a href="#top" class="bg-blue-500 px-5 py-2 rounded-full shadow">
                <x-hero-icons icon="chevron-up" class="fill-white stroke-white stroke-1" />
            </a>
        </div>
    </div>
</div>
