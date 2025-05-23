<?php

use function Livewire\Volt\{state, layout, computed, mount, on};

use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Examinee;
use App\Models\ExamineeAnswer;
use App\Models\Timer;
use App\Models\Question;
use App\Models\Answer;

layout('layouts.examinee');

state([
    'examinee',
    'questions',
    'timer',
    'selectedAnswers',
    'devMode' => false
]);

mount(function () {
    $this->examinee = Examinee::findOrFail($this->examinee);
    if($this->examinee->answered) {
        return $this->redirectRoute('examinees.result', ['examinee' => $this->examinee->id], navigate: true);
    }
    $this->questions = Question::with(['category', 'answers' => function (Builder $query) {
        $query->orderBy('letter');
    }])->where('grade_level', $this->examinee->grade_level)->get();
    $this->timer = Timer::where('grade', $this->examinee->grade_level)->first();
});

$questionOrder = computed(function () {
    $math = [];
    foreach($this->questions->where('category_id', 1)->all() as $question) {
        $math[] = $question;
    }
    shuffle($math);

    $science = [];
    foreach($this->questions->where('category_id', 2)->all() as $question) {
        $science[] = $question;
    }
    shuffle($science);

    $english = [];
    foreach($this->questions->where('category_id', 3)->all() as $question) {
        $english[] = $question;
    }
    shuffle($english);

    return array_merge($math, $science, $english);
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
};


$submit = function ()  {
    if($this->examinee->answered) {
        return $this->redirectRoute('examinees.result', ['examinee' => $this->examinee->id], navigate: true);
    }

    $this->answers = collect($this->selectedAnswers);

    $answers = $this->answers->filter(function ($value, $key) {
        return $value !== '';
    })->map(function ($value, $key) {
        return $this->examinee->answers()->firstOrCreate([
            'question_id' => $key,
            'answer_id' => $value
        ]);
    });

    $scores = $this->examinee->scores()->createMany([
        [
            'score' => $answers->where('question.category_id', 1)->where('answer.is_correct')->count(),
            'total' => $this->questions->where('category_id', 1)->count(),
            'category_id' => 1
        ],
        [
            'score' => $answers->where('question.category_id', 2)->where('answer.is_correct')->count(),
            'total' => $this->questions->where('category_id', 2)->count(),
            'category_id' => 2
        ],
        [
            'score' => $answers->where('question.category_id', 3)->where('answer.is_correct')->count(),
            'total' => $this->questions->where('category_id', 3)->count(),
            'category_id' => 3
        ],
    ])->sortByDesc('score')->values();
    

    $scorePercent = round($scores->pluck('score')->sum() / $this->questions->count() * 100, 2);

    if($this->examinee->grade_level === 7) {
        $this->examinee->sectionPivot()->firstOrCreate([
            'section_id' => match(true) {
                $scorePercent < 75 => 5,
                $scorePercent < 80 => 4,
                $scorePercent < 85 => 3,
                $scorePercent < 90 => 2,
                $scorePercent <=100 => 1,
            }
        ]);
    } else if ($this->examinee->grade_level === 11) {
        // ddd($scores[2]->category->title);
        if($scorePercent < 75) {
            $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 1,
                'strand_id' => 4,
            ]);
        
            $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 2,
                'strand_id' => match ($scores[1]->category->title) {
                    'Mathematics' => 
                        match ($scores[2]->category->title) {
                            'Science' => 1,
                            'English' => 2
                        },
                    'Science' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 1,
                            'English' => 3,
                        },
                    'English' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 2,
                            'Science' => 3,
                        },
                },
            ]);

            $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 3,
                'strand_id' => match ($scores[1]->category->title) {
                    'Mathematics' => 
                        match ($scores[2]->category->title) {
                            'Science' => 1,
                            'English' => 2
                        },
                    'Science' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 1,
                            'English' => 3,
                        },
                    'English' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 2,
                            'Science' => 3,
                        },
                },
            ]);

            $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 4,
                'strand_id' => match ($scores[1]->category->title) {
                    'Mathematics' => 
                        match ($scores[2]->category->title) {
                            'Science' => 1,
                            'English' => 2
                        },
                    'Science' => 
                        match ($scores[2]->category->title) {
                                'Mathematics' => 1,
                                'English' => 3,
                        },
                    'English' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 2,
                            'Science' => 3,
                        },
                },
            ]);
        } else {
            $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 1,
                'strand_id' => match ($scores[0]->category->title) {
                    'Mathematics' => 
                        match ($scores[1]->category->title) {
                            'Science' => 1,
                            'English' => 2
                        },
                    'Science' => 
                        match ($scores[1]->category->title) {
                            'Mathematics' => 1,
                            'English' => 3,
                        },
                    'English' => 
                        match ($scores[1]->category->title) {
                            'Mathematics' => 2,
                            'Science' => 3,
                        },
                },
            ]);

            $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 2,
                'strand_id' => match ($scores[0]->category->title) {
                    'Mathematics' => 
                        match ($scores[2]->category->title) {
                            'Science' => 1,
                            'English' => 2
                        },
                    'Science' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 1,
                            'English' => 3,
                        },
                    'English' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 2,
                            'Science' => 3,
                        },
                },
            ]);

            $this->examinee->strandRecommendations()->firstOrCreate([
                'ranking' => 3,
                'strand_id' => match ($scores[1]->category->title) {
                    'Mathematics' => 
                        match ($scores[2]->category->title) {
                            'Science' => 1,
                            'English' => 2
                        },
                    'Science' => 
                        match ($scores[2]->category->title) {
                                'Mathematics' => 1,
                                'English' => 3,
                        },
                    'English' => 
                        match ($scores[2]->category->title) {
                            'Mathematics' => 2,
                            'Science' => 3,
                        },
                },
            ]);
        }
    }

    $this->examinee->update([
        'answered' => 1
    ]);

    return $this->redirectRoute('examinees.result', ['examinee' => $this->examinee->id], navigate: true);
};

?>

<div class="min-h-screen flex justify-center bg-gray-100" x-data="timer(
    new Date().setHours(new Date().getHours() + {{ $timer->hours }},
    new Date().getMinutes() + {{ $timer->minutes }}, 
    new Date().getSeconds() + {{ $timer->seconds }}))" x-init="init();">
    <div 
    class="pt-24 w-2/4 no-scrollbar"  
    x-data="{
        n: 0,
        order: [
            @foreach ($this->questionOrder as $question)
                [{{ $question->id }}, {{ $question->category->id }}],
            @endforeach], 
        selectedAnswers: {
            @foreach ($this->questionOrder as $question)
               question{{ $question->id }}: '',
            @endforeach
        },
        tabReset: '',
        sortArray (array) {
            math = array.filter(item => item[1] == 1);

            for (let i = math.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1));
                [math[i], math[j]] = [math[j], math[i]];
            }

            science = array.filter(item => item[1] == 2);

            for (let i = science.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1));
                [science[i], science[j]] = [science[j], science[i]];
            }

            english = array.filter(item => item[1] == 3);

            for (let i = english.length - 1; i > 0; i--) {
                let j = Math.floor(Math.random() * (i + 1));
                [english[i], english[j]] = [english[j], english[i]];
            }

            array = [...math, ...science, ...english]
        }
    }"
    x-init="document.addEventListener('visibilitychange', (event) => {
        if (document.visibilityState != 'visible') {
            n = 0;
            tabReset = 'Tab has been reset';
            sortArray(order);
            selectedAnswers= {
                @foreach ($this->questionOrder as $question)
                   question{{ $question->id }}: '',
                @endforeach
            }
        }
    })"
    >
        <h1 class="font-bold text-3xl text-center">Grade {{ $examinee->grade_level }} Entrance Examination</h1>
        <div class="flex justify-between mt-10">
            <div>
                Question <span x-text="n + 1"></span> out of {{ $questions->count() }}
            </div>
            <div x-text="tabReset" class="text-red-500">
            </div>
            <div>
            {{-- <div x-data="" x-init="init();"> --}}
                Time Left: 
                    <span class="font-bold" x-show="hours().value >= 0 || minutes().value >= 0 || seconds().value >= 0">
                        <span x-text="time().hours"></span> : 
                        <span x-text="time().minutes"></span> : 
                        <span x-text="time().seconds"></span>
                    </span>
                    <span class="font-bold" x-show="hours().value < 0 || minutes().value < 0 || seconds().value < 0">
                        00 : 00 : 00
                    </span>
            </div>
            <script>
                history.pushState(null, document.title, location.href);
                window.addEventListener('popstate', function (event)
                {
                    const leavePage = confirm("Leaving page will reset your exam");
                    if (leavePage) {
                        history.back();
                    } else {
                        history.pushState(null, document.title, location.href);
                    }
                });
                function timer(expiry) {
                    return {
                        expiry: expiry,
                        remaining:null,
                        interval:null,
                        init() {
                            this.setRemaining()
                            this.interval = setInterval(() => {
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
            <div x-show="hours().value >= 0 || minutes().value >= 0 || seconds().value >= 0">
                @foreach ($questions as $question)
                    <div x-show="{{ $question->id }} === order[n][0]"
                        x-transition:enter="transition ease-in-out duration-400"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        {{-- x-transition:leave="duration-0"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" --}}
                        >
                        @php
                            $categoryColor = '';
                            switch ($question->category->id) {
                                case 1:
                                    $categoryColor = 'bg-red-400';
                                    break;
                                case 3:
                                    $categoryColor = 'bg-yellow-400';
                                    break;
                                case 2:
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
                                                x-on:click="selectAnswer({{ $answer->id }})"
                                                class="w-14 rounded-l text-center py-4 font-bold transition ease-in-out"
                                                :class = "selectedAnswers.question{{ $question->id }} == {{ $answer->id }} ? 'bg-blue-400 text-white' : 'bg-gray-100'"
                                                >{{ $answer->letter }}</div>
                                            </div>
                                            <div
                                            class="py-2 px-2 flex-1 rounded-r transition ease-in-out"
                                            :class = "selectedAnswers.question{{ $question->id }} == {{ $answer->id }} ? 'bg-blue-400' : 'bg-gray-100'"
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
            </div>
            <div 
            x-show="hours().value < 0 || minutes().value < 0 || seconds().value < 0" 
            class="w-full bg-white rounded-lg h-80 shadow-md mt-4 flex flex-col justify-center">
                <h1 class="text-center text-4xl font-bold">
                    Time's Up!
                </h1>
            </div>
            <div class="mt-12 flex justify-center">
                <div x-show = "$wire.devMode || n >= {{ $questions->count() }} -1 || hours().value < 0 || minutes().value < 0 || seconds().value < 0">
                    <div x-show="eval('selectedAnswers.question' + order[n][0]) !== ''">
                        <button
                            x-data = "{
                                submit () {
                                    @foreach ($this->questionOrder as $question)
                                        $wire.selectAnswers({{ $question->id }}, selectedAnswers.question{{ $question->id }})
                                    @endforeach
                                    $wire.submit()
                                },
                            }"
                            x-on:click="submit()"
                            class="bg-blue-500 text-white text-xl font-bold uppercase px-12 py-2 rounded-lg">
                            Finish
                        </button>
                    </div>
                </div>
                {{-- <div x-show = "$wire.devMode || n >= {{ $questions->count() }} -1 || hours().value < 0 || minutes().value < 0 || seconds().value < 0">
                    <button
                        x-data = "{
                            submit () {
                                @foreach ($this->questionOrder as $question)
                                    $wire.selectAnswers({{ $question->id }}, selectedAnswers.question{{ $question->id }})
                                @endforeach
                                $wire.submit()
                            },
                        }"
                        x-on:click="submit()"
                        class="bg-blue-500 text-white text-xl font-bold uppercase px-12 py-2 rounded-lg">
                        Finish
                    </button>
                </div> --}}
                <div x-show="hours().value > 0 || minutes().value > 0 || seconds().value > 0" >
                    <div x-show = "n < {{ $questions->count() }} -1 && eval('selectedAnswers.question' + order[n][0]) !== ''" class="transition delay-200">
                        <a
                            x-on:click="n++; tabReset=''"
                            class="bg-blue-500 text-white text-xl font-bold uppercase px-12 py-2 rounded-lg cursor-pointer select-none">
                            Next
                        </a>
                    </div>
                </div>
            </div>
    </div>
</div>
