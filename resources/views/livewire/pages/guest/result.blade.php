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
    'answer'
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
<div class=" bg-gray-100" id="top" x-data="{scrolled: false}">
    <div class="pt-24 mb-10">
        <h1 class="font-bold text-3xl text-center">Your Result</h1>
    </div>
    @livewire('guest.result.scores', ['examinee' => $this->examinee, 'questions' => $this->questions])
    @livewire('guest.result.answers', ['examinee' => $this->examinee, 'questions' => $this->questions])
    <div class="sticky bottom-10" x-show="scrolled"  x-transition.duration.500ms >
        <div class="flex justify-center">
            <a href="#top" class="bg-blue-500 px-5 py-2 rounded-full shadow">
                <x-hero-icons icon="chevron-up" class="fill-white stroke-white stroke-1" />
            </a>
        </div>
    </div>
</div>
