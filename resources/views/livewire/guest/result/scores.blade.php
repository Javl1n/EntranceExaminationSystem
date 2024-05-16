<?php

use function Livewire\Volt\{state, computed};

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Mail\ResultSent;


state([
    'examinee',
    'questions',
    'password',
]);


// question counts
$englishQuestionCount = computed(function () {
    return $this->examinee->scores()->where('category_id', 2)->first()->total;
});

$mathematicsQuestionCount = computed(function () {
    return $this->examinee->scores()->where('category_id', 1)->first()->total;
});

$scienceQuestionCount = computed(function () {
    return $this->examinee->scores()->where('category_id', 3)->first()->total;
});

// scores
$englishScore = computed(function () {
    $count = $this->examinee->scores()->where('category_id', 2)->first()->score;
    $percent = 0;
    if ($this->englishQuestionCount > 0) {
        $percent = round(($count / $this->englishQuestionCount) * 100, 1);
    }
    return ['total' => $this->englishQuestionCount, 'percent' => $percent, 'sum' => $count];
});

$scienceScore = computed(function () {
    $count = $this->examinee->scores()->where('category_id', 3)->first()->score;
    $percent = 0;
    if ($this->scienceQuestionCount > 0) {
        $percent = round(($count / $this->scienceQuestionCount) * 100, 1);
    }
    return ['total' => $this->scienceQuestionCount, 'percent' => $percent, 'sum' => $count];
});

$mathematicsScore = computed(function () {
    $count = $this->examinee->scores()->where('category_id', 1)->first()->score;
    $percent = 0;
    if ($this->mathematicsQuestionCount > 0) {
        $percent = round(($count / $this->mathematicsQuestionCount) * 100, 1);
    }
    return ['total' => $this->mathematicsQuestionCount, 'percent' => $percent, 'sum' => $count];
});

// average score
$average = computed(function () {
    $percent = round($this->examinee->scores->pluck('score')->sum() / $this->examinee->scores->pluck('total')->sum() * 100, 2);

    return ['total' => $this->questions->count(), 'percent' => $percent, 'sum' => $this->examinee->scores->pluck('score')->sum()];
});

$assignment = computed(function () {
    if($this->examinee->grade_level === 7) {
        return ['grade' => "Section", 'place' => $this->examinee->sectionPivot->section->letter . ' - ' . $this->examinee->sectionPivot->section->description];
    } else if ($this->examinee->grade_level === 11) {
        return ['grade' => "Strand", "place" => $this->examinee->strandRecommendations->where('ranking', 1)->first()->strand->title];
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
};

$sendEmail = function () {
    // return $this->redirectRoute('mail.test', ['examinee' => $this->examinee], navigate: true);
    Mail::to($this->examinee)->send(new ResultSent($this->examinee));
}

?>

<div>
    <div id="photo" class="max-w-3xl py-5 mx-auto shadow bg-white rounded-lg" >
        <div class="px-10 text-sm">
            <div class="flex justify-between">
                <div>Name: <span class="font-bold">{{ $examinee->name }}</span></div>
                <div>Email: <span class="font-bold">{{ $examinee->email }}</span></div>
            </div>
            <div class="flex justify-between">
                <div>Grade Level: <span class="font-bold">Grade {{ $examinee->grade_level }}</span></div>
                <div>Examination Date: <span class="font-bold">{{ $examinee->created_at->format('F j, Y') }}</span></div>
            </div>
        </div>
        <div class="flex gap-10 px-10 justify-center">
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
    @if($examinee->grade_level === 11 && $this->average['percent'] >= 75)
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
    @if (request()->routeIs('examinees.result'))
        <div class="flex justify-center mt-10">
            <x-primary-button x-on:click="$wire.sendEmail" class="mx-auto">
                Send to Email
            </x-primary-button>
        </div> 
    @endif
    {{-- <x-modal name="confirm-examinee-retake" :show="$errors->isNotEmpty()" maxWidth='md' focusable>
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
    </x-modal> --}}
</div>

