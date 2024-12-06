<?php

use function Livewire\Volt\{state};

use App\Models\Question;



state([
    'examinee',
    'questions',
    'heading'
]);

?>

<div class="mx-auto w-2/4 my-10">
    <h1 class="text-center font-bold text-2xl">
        {{ $this->heading }}
    </h1>

    @foreach ($questions as $question)

        <div class="mt-4" 
        @if ($loop->iteration <= 3)
            x-intersect="scrolled = false"
        @else
            x-intersect="scrolled = true"
        @endif
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
                
                $myAnswer = "";
                foreach($this->examinee->answers as $input) {
                    if ($input->question->id === $question->id){
                        $myAnswer = $input->answer;
                    }
                }
                if($myAnswer === "") {
                    $myAnswer = new stdClass;
                    $myAnswer->is_correct = false;
                    $myAnswer->letter = "";
                }
            @endphp
            <div class="">
                <div class="absolute rounded-lg {{ $categoryColor }}  mt-4 ms-3  px-5 text-sm text-white font-bold">
                    {{ $question->category->title }}
                </div>
                <div @class([
                    "w-full bg-white rounded-lg py-10 px-12 shadow-md mt-4 border-2",
                    'border-red-500' => !$myAnswer->is_correct,
                    'border-green-500' => $myAnswer->is_correct
                ])
                >
                    <h1 class="text-center text-2xl mt-4">
                        {{ $question->description }}
                    </h1>
                    <div class="mt-10 grid grid-cols-2 grid-rows-2 gap-5">
                        @foreach ($question->answers as $answer)
                            <div @class([
                                'flex rounded',
                                "bg-green-300" =>  $answer->is_correct,
                                'bg-gray-100' => $myAnswer->letter !== $answer->letter,
                                'bg-red-300' => $myAnswer->letter === $answer->letter && !$answer->is_correct,
                            ])>
                                <div class="flex flex-col">
                                    <div class="w-14 rounded-l text-center py-4 font-bold transition ease-in-out">{{ $answer->letter }}</div>
                                </div>
                                <div class='py-2 pe-2 flex-1 rounded-r transition ease-in-out'>
                                    <div
                                    @class([
                                        "px-2 py-2 rounded text-center break-all h-full bg-white",
                                    ])>{{ $answer->description }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if ($myAnswer->letter === "")
                        <div class="mt-8 text-center text-red-500">
                            No Answer
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
    {{-- {{ $questions->links() }} --}}
</div>
