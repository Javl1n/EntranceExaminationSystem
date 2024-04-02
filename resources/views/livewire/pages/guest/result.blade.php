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
            'question' => [
                'category',
                'answers'
            ],
            'answer'
            //  => [
            //     'question'
            // ]
        ]
    ])->findOrFail($this->examinee);
    $this->questions = Question::
    with(['category'
    // , 'answers' => function (Builder $query) {
    //     $query->orderBy('letter');
    // }
    ])->
    where('grade_level', $this->examinee->grade_level)->get();
});

?>
<div class="min-h-screen flex justify-center bg-gray-100">
    @livewire('guest.result.scores', ['examinee' => $this->examinee, 'questions' => $this->questions])
</div>
