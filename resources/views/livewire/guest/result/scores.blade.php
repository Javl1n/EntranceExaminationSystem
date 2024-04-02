<?php

use function Livewire\Volt\{state, computed, mount};

state([
    'examinee',
    'questions'
]);


// question counts
$englishQuestionCount = computed(function () {
    $count = 0;
    foreach($this->questions as $question) {
        if ($question->category->id === 2) {
            $count++;
        }
    }
    return $count;
});

$mathematicsQuestionCount = computed(function () {
    $count = 0;
    foreach($this->questions as $question) {
        if ($question->category->id === 1) {
            $count++;
        }
    }
    return $count;
});

$scienceQuestionCount = computed(function () {
    $count = 0;
    foreach($this->questions as $question) {
        if ($question->category->id === 3) {
            $count++;
        }
    }
    return $count;
});


// scores
$englishScore = computed(function () {
    $count = 0;
    foreach($this->examinee->answers as $input) {
        if ($input->question->category->id === 2){
            if($input->answer->is_correct) {
                $count++;
            }
        }
    }
    $percent = round(($count / $this->englishQuestionCount) * 100, 1);
    return ['total' => $this->englishQuestionCount, 'percent' => $percent, 'sum' => $count];
});

$scienceScore = computed(function () {
    $count = 0;
    foreach($this->examinee->answers as $input) {
        if ($input->question->category->id === 3){
            if($input->answer->is_correct) {
                $count++;
            }
        }
    }
    $percent = round(($count / $this->scienceQuestionCount) * 100, 1);
    return ['total' => $this->scienceQuestionCount, 'percent' => $percent, 'sum' => $count];
});

$mathematicsScore = computed(function () {
    $count = 0;
    foreach($this->examinee->answers as $input) {
        if ($input->question->category->id === 1){
            if($input->answer->is_correct) {
                $count++;
            }
        }
    }
    $percent = round(($count / $this->mathematicsQuestionCount) * 100, 1);
    return ['total' => $this->mathematicsQuestionCount, 'percent' => $percent, 'sum' => $count];
});

// average score
$average = computed(function () {
    $sumAverage = $this->mathematicsScore['percent'] 
            + $this->scienceScore['percent'] 
            + $this->englishScore['percent'];
    $percent = round($sumAverage / 3, 1);
    $sum = $this->mathematicsScore['sum'] 
            + $this->scienceScore['sum'] 
            + $this->englishScore['sum'];
    return ['total' => $this->questions->count(), 'percent' => $percent, 'sum' => $sum];
});


// sectioning and strand recommendation 
$section = computed(function () {
    $average = $this->average['percent'];
    // $average = 99;
    return match (true) {
        $average < 70 => 'D - Deutoronomy',
        $average < 80 => 'C - Leviticus',
        $average < 90 => 'B - Exodus',
        $average <=100 => 'A - Genesis',
    };
});

$strand = computed(function() {

    $score['science'] = $this->scienceScore['percent'];
    $score['english'] = $this->englishScore['percent'];
    $score['mathematics'] = $this->mathematicsScore['percent'];

    // $score['science'] = 14;
    // $score['english'] = 3;
    // $score['mathematics'] = 20;

    arsort($score);

    $subjects = array_keys($score);
    $value = match ($subjects[0]) {
        'mathematics' => 
            match ($subjects[1]) {
                'science' => 'STEM',
                'english' => 'ABM'
            },
        'science' => 
            match ($subjects[1]) {
                    'mathematics' => 'STEM',
                    'english' => 'HUMSS',
            },
        'english' => 
            match ($subjects[1]) {
                'mathematics' => 'ABM',
                'science' => 'HUMSS',
            },
    };
    
    return $value;
});

?>

<div class="pt-24 w-2/4  overflow-scroll">
    <h1 class="font-bold text-3xl text-center">Your Result</h1>
    <div class="mt-10 flex gap-10 bg-white justify-center py-8 px-10 rounded-lg shadow-lg">
        <div class="bg-blue-300 h-52 w-52 aspect-square rounded-full text-center flex flex-col gap-2 justify-center my-auto">
            <div class="text-white font-bold">Average</div>
            <h1 class="text-white font-extrabold text-6xl">{{ $this->average['percent'] }}%</h1>
            <div class="text-white font-bold"><span class="font-bold">{{ $this->average['sum'] }}</span> out of {{ $this->average['total'] }}</div>
        </div>
        <div class="flex-1 flex flex-col">
            <div class="flex gap-4">
                <h4 class="mt-auto">{{ match ($examinee->grade_level) {
                    11 => 'Strand',
                    7 => 'Section',
                } }} :</h4>
                <h1 class="text-4xl mt-2 font-extrabold">{{ 
                    match($this->examinee->grade_level) {
                        11 => $this->strand,
                        7 => $this->section
                    } 
                }}</h1>
            </div>
            <div class="flex-1 flex justify-between gap-2 mt-4">
                <div class="bg-yellow-400 h-36 w-36 text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                    <h1 class="text-center text-sm">English</h1>
                    <h1 class="text-4xl font-bold">
                        {{ $this->englishScore['percent'] }}%
                    </h1>
                    <h1 class="text-center text-sm"><span class="font-bold">{{ $this->englishScore['sum'] }}</span> out of {{ $this->englishScore['total'] }}</h1>
                </div>
                <div class="bg-purple-500 h-36 w-36 text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                    <h1 class="text-center text-sm">Science</h1>
                    <h1 class="text-4xl font-bold">
                        {{ $this->scienceScore['percent'] }}%
                    </h1>
                    <h1 class="text-center text-sm"><span class="font-bold">{{ $this->scienceScore['sum'] }}</span> out of {{ $this->scienceScore['total'] }}</h1>
                </div>
                <div class="bg-red-500 h-36 w-36 text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                    <h1 class="text-center text-sm">Mathematics</h1>
                    <h1 class="text-4xl font-bold">
                        {{ $this->mathematicsScore['percent'] }}%
                    </h1>
                    <h1 class="text-center text-sm"><span class="font-bold">{{ $this->mathematicsScore['sum'] }}</span> out of {{ $this->mathematicsScore['total'] }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

