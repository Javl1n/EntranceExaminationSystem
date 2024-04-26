<?php

use function Livewire\Volt\{state, computed};

use Illuminate\Support\Facades\Validator;
use App\Models\User;

state([
    'examinee',
    'questions',
    'password'
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

    $percent = 0;
    if ($this->englishQuestionCount > 0) {
        $percent = round(($count / $this->englishQuestionCount) * 100, 1);
    }
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
    $percent = 0;
    if ($this->scienceQuestionCount > 0) {
        $percent = round(($count / $this->scienceQuestionCount) * 100, 1);
    }
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
    $percent = 0;
    if ($this->mathematicsQuestionCount > 0) {
        $percent = round(($count / $this->mathematicsQuestionCount) * 100, 1);
    }
    return ['total' => $this->mathematicsQuestionCount, 'percent' => $percent, 'sum' => $count];
});

// average score
$average = computed(function () {
    $sumAverage = $this->mathematicsScore['percent'] 
            + $this->scienceScore['percent'] 
            + $this->englishScore['percent'];
    $sum = $this->mathematicsScore['sum'] 
            + $this->scienceScore['sum'] 
            + $this->englishScore['sum'];
    $percent = round($sum / $this->questions->count() * 100, 1);

    return ['total' => $this->questions->count(), 'percent' => $percent, 'sum' => $sum];
});

$assignment = computed(function () {
    if($this->examinee->grade_level === 7) {
        $average = $this->average['percent'];

        $section = $this->examinee->sectionPivot()->firstOrCreate([
            'section_id' => match(true) {
                $average < 75 => 5,
                $average < 80 => 4,
                $average < 85 => 3,
                $average < 90 => 2,
                $average <=100 => 1,
            }
        ])->section;
        return ['grade' => "Section", 'place' => $section->letter . ' - ' . $section->description];
    } else if ($this->examinee->grade_level === 11) {
        if ($this->average['percent'] < 75) {
            $strand = $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 1,
                'strand_id' => 4,
            ])->strand;
            return ['grade' => 'Strand', 'place' => $strand->title];
        }
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
        
        return ['grade' => "Strand", "place" => $strand->title];
    }
});

$retake = function () {
    $this->validate([
        'password' => [
            'required', 
            'string',
            function (string $attribute, mixed $value, Closure $fail) {
                if(!Hash::check($value, User::where('email', 'farmodia@gmail.com')->first()->password)){
                    $fail("Invalid password.");
                }
            }
        ],
    ]);

    $this->examinee->answers()->delete();
    $this->examinee->scores()->delete();
    $this->examinee->sectionPivot()->delete();
    $this->examinee->strandRecommendations()->delete();
    $this->examinee->update([
        'answered' => false
    ]);

    $this->redirect(route('examinees.startExam', ['examinee' => $this->examinee]), navigate: true);
}

?>

<div>
    <div class="max-w-3xl mx-auto shadow bg-white  rounded-lg">
        {{-- <div class="px-10 pt-2 text-gray-500 flex justify-between">
            <span class="text-lg">Name: <span class="font-bold">{{ $examinee->name }}</span></span>
            <span class="text-lg">Grade Level: <span class="font-bold">{{ $examinee->grade_level }}</span></span>
        </div> --}}
        {{-- @if ($this->average['percent'] < 75)
            <div class="absolute max-w-3xl w-screen px-5 py-5">
                <div class="flex justify-end">
                    <h1 wire:click='$dispatch("open-modal", "confirm-examinee-retake")' class="text-xl font-extrabold text-red-600 cursor-pointer w-8 h-8 text-center hover:bg-gray-50 rounded-full"> ! </h1>
                </div>
            </div>
        @endif --}}
        <div class="flex gap-10 py-8 px-10 justify-center">
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
                @if($examinee->grade_level === 11)
                    <div class="flex gap-2">
                        <div>Description: </div>
                        <span class="font-bold">{{ $examinee->strandRecommendations->where('ranking', 1)->first()->strand->description }}</span>
                    </div>
                @endif
                <div class="flex-1 flex justify-between gap-2 mt-4">
                    <div class = 'bg-gradient-to-b from-30% from-yellow-400 to-yellow-200 h-36 w-full text-center flex flex-col gap-2 text-white justify-center rounded-xl'>
                        <h1 class="text-center text-sm">English</h1>
                        <h1 class="text-4xl font-bold">
                            {{ $this->englishScore['percent'] }}%
                        </h1>
                        <h1 class="text-center text-sm"><span class="font-bold">{{ $this->englishScore['sum'] }}</span> out of {{ $this->englishScore['total'] }}</h1>
                    </div>
                    <div class="bg-gradient-to-br from-10% from-purple-500 to-violet-300 h-36 w-full text-center flex flex-col gap-2 text-white justify-center rounded-xl">
                        <h1 class="text-center text-sm">Science</h1>
                        <h1 class="text-4xl font-bold">
                            {{ $this->scienceScore['percent'] }}%
                        </h1>
                        <h1 class="text-center text-sm"><span class="font-bold">{{ $this->scienceScore['sum'] }}</span> out of {{ $this->scienceScore['total'] }}</h1>
                    </div>
                    <div class="bg-gradient-to-br from-30% from-red-500 to-red-300 h-36 w-full text-center flex flex-col gap-2 text-white justify-center rounded-xl">
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
    @if($examinee->grade_level === 11)
        <div class="max-w-3xl mx-auto shadow bg-white px-10 py-6 mt-10 rounded-lg">
            {{-- <div class="px-10 pt-2 text-gray-500 flex justify-between">
                <span class="text-lg">Name: <span class="font-bold">{{ $examinee->name }}</span></span>
                <span class="text-lg">Grade Level: <span class="font-bold">{{ $examinee->grade_level }}</span></span>
            </div> --}}
            <h1 class="text-xl font-bold">{{ __("All Recommended Strands") }} <span class="text-sm font-bold italic text-gray-500">{{ __("(Most to Least Recommended)") }}</span></h1>
            
            <div class=" flex justify-between gap-2 mt-4 font-bold">
                <div class='bg-blue-600 h-52 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                    <h1 class="text-xl text-white font-bold">
                        {{ $examinee->strandRecommendations->where('ranking', 1)->first()->strand->description }}
                    </h1>
                </div>
                <div class='bg-blue-500 h-52 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                    <h1 class="text-xl text-white font-bold">
                        {{ $examinee->strandRecommendations->where('ranking', 2)->first()->strand->description }}
                    </h1>
                </div>
                <div class='bg-blue-400 h-52 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                    <h1 class="text-xl text-white font-bold">
                        {{ $examinee->strandRecommendations->where('ranking', 3)->first()->strand->description }}
                    </h1>
                </div>
            </div>
        </div>
    @endif
    <x-modal name="confirm-examinee-retake" :show="$errors->isNotEmpty()" maxWidth='md' focusable>
        <form wire:submit="retake" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 text-center">
                {{ __('Are you sure you want to retake the exam?') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 text-center">
                {{ __("Please call upon the proctor to enter admin's password.") }}
            </p>
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-5/6 mx-auto text-center"
                    placeholder=""
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-center" />
            </div>
            <div class="mt-6 flex justify-center">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-danger-button class="ms-3">
                    {{ __('Retake Exam') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>

