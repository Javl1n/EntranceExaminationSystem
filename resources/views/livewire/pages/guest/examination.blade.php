<?php

use function Livewire\Volt\{state, layout, computed, mount, on};

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Examinee;
use App\Models\Timer;
use App\Models\Question;
use App\Models\Answer;

layout('layouts.examinee');

state([
    'examinee',
    'questions',
    'timer',
    'selectedAnswers'
]);

mount(function () {
    $this->examinee = Examinee::findOrFail($this->examinee);
    $this->questions = Question::with(['category', 'answers' => function (Builder $query) {
        $query->orderBy('letter');
    }])->where('grade_level', $this->examinee->grade_level)->get();
    $this->timer = Timer::where('grade', $this->examinee->grade_level)->first();
});

$questionOrder = computed(function () {
    $array = [];
    foreach($this->questions as $question) {
        $array[] = $question->id;
    }
    shuffle($array);
    return $array;
});

$categoryColor = computed(function ($subject) {
    switch ($subject) {
        case 1:
            return 'bg-red-400';
            break;
        case 2:
            return 'bg-yellow-400';
            break;
        case 3:
            return 'bg-purple-400';
            break;
        default:
            return '';
            break;
    }
});

$selectAnswers = function ($question, $letter) {
    $this->selectedAnswers[$question] = $letter;
    // ddd($this->selectedAnswers);
};


$submit = function ()  {
    return ()
};

?>

<div class="min-h-screen flex justify-center bg-gray-100">
    <div class="pt-24 w-2/4  overflow-scroll"  x-data="{
        n: 0,
        order: [
            @foreach ($this->questionOrder as $question)
                {{ $question }},
            @endforeach], 
        selectedAnswers: {
            @foreach ($this->questionOrder as $question)
               question{{ $question }}: '',
            @endforeach
        }
    }">
        <h1 class="font-bold text-3xl text-center">Grade {{ $examinee->grade_level }} Entrance Examination</h1>
        <div class="flex justify-between mt-10">
            <div>
                Question <span x-text="n + 1"></span> out of {{ $questions->count() }}
            </div>
            <div x-data="timer(
                new Date().setHours(new Date().getHours() + {{ $timer->hours }},
                new Date().getMinutes() + {{ $timer->minutes }}, 
                new Date().getSeconds() + {{ $timer->seconds }}))" x-init="init();">
            {{-- <div x-data="" x-init="init();"> --}}
                Time Left: <span x-text="time().hours"></span> : <span x-text="time().minutes"></span> : <span x-text="time().seconds"></span>
            </div>
            <script>
                function timer(expiry) {
                    return {
                        expiry: expiry,
                        remaining:null,
                        init() {
                            this.setRemaining()
                            setInterval(() => {
                                this.setRemaining();
                            }, 1000);
                        },
                        setRemaining() {
                            const diff = this.expiry - new Date().getTime();
                            this.remaining =  parseInt(diff / 1000);
                        },
                        days() {
                            return {
                                value:this.remaining / 86400,
                                remaining:this.remaining % 86400
                            };
                        },
                        hours() {
                            return {
                                value:this.days().remaining / 3600,
                                remaining:this.days().remaining % 3600
                            };
                        },
                        minutes() {
                            return {
                                value:this.hours().remaining / 60,
                                remaining:this.hours().remaining % 60
                            };
                        },
                        seconds() {
                            return {
                                value:this.minutes().remaining,
                            };
                        },
                        format(value) {
                            return ("0" + parseInt(value)).slice(-2)
                        },
                        time(){
                            return {
                                days:this.format(this.days().value),
                                hours:this.format(this.hours().value),
                                minutes:this.format(this.minutes().value),
                                seconds:this.format(this.seconds().value),
                            }
                        },
                    }
                }

            </script>
        </div>
        
            @foreach ($questions as $question)  
                <div x-show="{{ $question->id }} === order[n]">
                    @php
                        $categoryColor = '';

                        switch ($question->category->id) {
                            case 1:
                                $categoryColor = 'bg-red-400';
                                break;
                            case 2:
                                $categoryColor = 'bg-yellow-400';
                                break;
                            case 3:
                                $categoryColor = 'bg-purple-400';
                                break;
                            default:
                                $categoryColor = '';
                                break;
                        }
                    @endphp
                    <div class="">
                        <div class="absolute rounded-lg {{ $categoryColor }}  mt-4 ms-3  px-5 text-sm text-white font-bold">
                            {{ $question->category->title }}
                        </div>
                        <div class="w-full bg-white rounded-lg py-10 px-12 shadow-md mt-4">
                            <h1 class="text-center text-2xl mt-4">
                                {{ $question->description }}
                            </h1>
                            <div class="mt-10 grid grid-cols-2 grid-rows-2 gap-5" x-data="{
                                selectAnswer (letter) {
                                    selectedAnswers.question{{ $question->id }} = letter;
                                    console.log(selectedAnswers.question{{ $question->id }});
                                }
                            }">
                                @foreach ($question->answers as $answer)
                                    <div class="flex">
                                        <div class="flex flex-col">
                                            <div 
                                            x-on:click="selectAnswer('{{ $answer->letter }}')" 
                                            class="w-14 rounded-l text-center py-4 font-bold transition ease-in-out"
                                            :class = "selectedAnswers.question{{ $question->id }} == '{{ $answer->letter }}' ? 'bg-green-400' : 'bg-gray-100'"
                                            >{{ $answer->letter }}</div>
                                        </div>
                                        <div 
                                        class="py-2 px-2 flex-1 rounded-r transition ease-in-out"
                                        :class = "selectedAnswers.question{{ $question->id }} == '{{ $answer->letter }}' ? 'bg-green-400' : 'bg-gray-100'"
                                        >
                                            <div class="px-2 py-2 rounded text-center bg-white break-all h-full">{{ $answer->description }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="mt-12 flex justify-center">
                <div x-show = "n >= {{ $questions->count() }} -1">
                    <button
                        x-data = "{
                            submit () {
                                @foreach ($this->questionOrder as $question)
                                    $wire.selectAnswers({{ $question }}, selectedAnswers.question{{ $question }}) 
                                @endforeach 
                                $wire.submit()
                            },
                        }"
                        x-on:click="submit()"
                        class="bg-blue-500 text-white text-xl font-bold uppercase px-12 py-2 rounded-lg">
                        Finish
                    </button>
                </div>
                <div x-show = "n < {{ $questions->count() }} -1">
                    <a
                        x-on:click="n++"
                        class="bg-blue-500 text-white text-xl font-bold uppercase px-12 py-2 rounded-lg">
                        Next
                    </a>
                </div>
            </div>
            
    </div>
</div>