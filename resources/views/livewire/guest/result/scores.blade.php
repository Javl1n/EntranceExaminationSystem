<?php

use function Livewire\Volt\{state, computed};

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
    $this->examinee->scores()->firstOrCreate([
        'score' => $count,
        'total' => $this->englishQuestionCount,
        'category_id' => 2
    ]);

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
    $this->examinee->scores()->firstOrCreate([
        'score' => $count,
        'total' => $this->scienceQuestionCount,
        'category_id' => 3
    ]);
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
    $this->examinee->scores()->firstOrCreate([
        'score' => $count,
        'total' => $this->mathematicsQuestionCount,
        'category_id' => 1
    ]);
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

$assignment = computed(function () {
    if($this->examinee->grade_level === 7) {
        $average = $this->average['percent'];
        

        $section = $this->examinee->sectionPivot()->firstOrCreate([
            'section_id' => match(true) {
                $average < 70 => 4,
                $average < 80 => 3,
                $average < 90 => 2,
                $average <=100 => 1,
            }
        ])->section;


        $assignment = ['grade' => "Section", 'place' => $section->letter . ' - ' . $section->description];
    } else if ($this->examinee->grade_level === 11) {
        $score['science'] = $this->scienceScore['percent'];
        $score['english'] = $this->englishScore['percent'];
        $score['mathematics'] = $this->mathematicsScore['percent'];

        // $score['science'] = 14;
        // $score['english'] = 3;
        // $score['mathematics'] = 20;

        arsort($score);

        $subjects = array_keys($score);
        
        $strand = $this->examinee->strandRecommendations()->firstOrCreate([
            'ranking' => 1,
            'strand_id' => match ($subjects[0]) {
                'mathematics' => 
                    match ($subjects[1]) {
                        'science' => 1,
                        'english' => 2
                    },
                'science' => 
                    match ($subjects[1]) {
                            'mathematics' => 1,
                            'english' => 3,
                    },
                'english' => 
                    match ($subjects[1]) {
                        'mathematics' => 2,
                        'science' => 3,
                    },
            },
        ])->strand;

        $this->examinee->strandRecommendations()->firstOrCreate([
            'ranking' => 2,
            'strand_id' => match ($subjects[0]) {
                'mathematics' => 
                    match ($subjects[2]) {
                        'science' => 1,
                        'english' => 2
                    },
                'science' => 
                    match ($subjects[2]) {
                            'mathematics' => 1,
                            'english' => 3,
                    },
                'english' => 
                    match ($subjects[2]) {
                        'mathematics' => 2,
                        'science' => 3,
                    },
            },
        ]);

        $this->examinee->strandRecommendations()->firstOrCreate([
            'ranking' => 3,
            'strand_id' => match ($subjects[1]) {
                'mathematics' => 
                    match ($subjects[2]) {
                        'science' => 1,
                        'english' => 2
                    },
                'science' => 
                    match ($subjects[2]) {
                            'mathematics' => 1,
                            'english' => 3,
                    },
                'english' => 
                    match ($subjects[2]) {
                        'mathematics' => 2,
                        'science' => 3,
                    },
            },
        ]);
        
        $assignment = ['grade' => "Strand", "place" => $strand->title];
    }
    return $assignment;
});

?>

<div class="w-2/4 mx-auto shadow flex gap-10 bg-white justify-center py-8 px-10 rounded-lg">
    <div class="bg-gradient-to-bl from-30% from-blue-500 to-indigo-200 h-52 w-52 aspect-square rounded-full text-center flex flex-col gap-2 justify-center my-auto">
        <div class="text-white font-bold">Average</div>
        <h1 class="text-white font-extrabold text-6xl">{{ $this->average['percent'] }}%</h1>
        <div class="text-white font-bold"><span class="font-bold">{{ $this->average['sum'] }}</span> out of {{ $this->average['total'] }}</div>
    </div>
    <div class="flex-1 flex flex-col">
        <div class="flex gap-4">
            <h4 class="mt-auto">{{ $this->assignment['grade'] }} :</h4>
            <h1 class="text-4xl mt-2 font-extrabold">{{ 
                $this->assignment['place']
            }}</h1>
        </div>
        <div class="flex-1 flex justify-between gap-2 mt-4">
            <div class = 'bg-gradient-to-b from-30% from-yellow-400 to-yellow-200 h-36 w-36 text-center flex flex-col gap-2 text-white justify-center rounded-xl'>
                <h1 class="text-center text-sm">English</h1>
                <h1 class="text-4xl font-bold">
                    {{ $this->englishScore['percent'] }}%
                </h1>
                <h1 class="text-center text-sm"><span class="font-bold">{{ $this->englishScore['sum'] }}</span> out of {{ $this->englishScore['total'] }}</h1>
            </div>
            <div class="bg-gradient-to-br from-10% from-purple-500 to-violet-300 h-36 w-36 text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                <h1 class="text-center text-sm">Science</h1>
                <h1 class="text-4xl font-bold">
                    {{ $this->scienceScore['percent'] }}%
                </h1>
                <h1 class="text-center text-sm"><span class="font-bold">{{ $this->scienceScore['sum'] }}</span> out of {{ $this->scienceScore['total'] }}</h1>
            </div>
            <div class="bg-gradient-to-br from-30% from-red-500 to-red-300 h-36 w-36 text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                <h1 class="text-center text-sm">Mathematics</h1>
                <h1 class="text-4xl font-bold">
                    {{ $this->mathematicsScore['percent'] }}%
                </h1>
                <h1 class="text-center text-sm"><span class="font-bold">{{ $this->mathematicsScore['sum'] }}</span> out of {{ $this->mathematicsScore['total'] }}</h1>
            </div>
        </div>
    </div>
</div>

