<?php

use function Livewire\Volt\{layout, state, mount, computed};

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Examinee;
use App\Models\ExamineeAnswer;
use App\Models\Timer;
use App\Models\Question;
use App\Models\Answer;

layout('layouts.examinee');

state([
    'examinee',
    'answer',
    'questions'
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
        ],
        'strandRecommendations',
        'sectionPivot'
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

$percent = computed(function () {
    $sumScore = 0;
    $sumTotal = 0;
    foreach($this->examinee->scores as $score) {
        $sumScore += $score->score;
        $sumTotal += $score->total;
    }
    return round($sumScore / $sumTotal * 100, 2);
});

?>
<div class=" bg-gray-100" id="top" x-data="{scrolled: false}">
    <div class="pt-24 mb-10">
        <h1 class="font-bold text-3xl text-center">Your Result</h1>
    </div>
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
    <div class="mt-10">@livewire('guest.result.scores', ['examinee' => $this->examinee, 'questions' => $this->questions])</div>
    @if ($this->percent < 75)
            <div class="flex justify-center mt-10">
                <x-danger-button 
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-examinee-retake')"> 
                    Retake Exam
                </x-danger-button>
            </div>
        @endif
    @if($this->percent >= 75)
        <div class="flex justify-center mt-10">
            <x-primary-button class="mx-auto">
                Send to Email
            </x-primary-button>
        </div>
        @livewire('guest.result.answers', ['examinee' => $this->examinee, 'questions' => $this->questions])
    @endif
    <div class="sticky bottom-10" x-show="scrolled"  x-transition.duration.500ms >
        <div class="flex justify-center">
            <a href="#top" class="bg-blue-500 px-5 py-2 rounded-full shadow">
                <x-hero-icons icon="chevron-up" class="fill-white stroke-white stroke-1" />
            </a>
        </div>
    </div>
</div>
