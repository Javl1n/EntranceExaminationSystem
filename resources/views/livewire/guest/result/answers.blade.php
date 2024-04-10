<?php

use function Livewire\Volt\{state};

state([
    'examinee',
    'questions'
]);

?>

<div class="mx-auto w-2/4 my-10">
    <h1 class="text-center font-bold text-2xl">
        Your Answers
    </h1>

    @foreach ($questions as $question)
        <div class="m4-4">
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
                    <div class="mt-10 grid grid-cols-2 grid-rows-2 gap-5">
                        @foreach ($question->answers as $answer)
                            @php
                                $my_answer;
                                foreach($this->examinee->answers as $input) {
                                    if ($input->question->id === $question->id){
                                        $my_answer = $input->answer->letter;
                                    }
                                }
                            @endphp
                            <div class="flex">
                                <div class="flex flex-col">
                                    <div 
                                    @class([
                                        "w-14 rounded-l text-center py-4 font-bold transition ease-in-out",
                                        "bg-blue-300 text-white" => $my_answer === $answer->letter,
                                        'bg-gray-100' => $my_answer !== $answer->letter,
                                    ])>{{ $answer->letter }}</div>
                                </div>
                                <div 
                                @class([
                                    'py-2 px-2 flex-1 rounded-r transition ease-in-out',
                                    'bg-blue-300' => $my_answer === $answer->letter,
                                    'bg-gray-100' => $my_answer !== $answer->letter,
                                ])>
                                    <div
                                    @class([
                                        "px-2 py-2 rounded text-center break-all h-full",
                                        "bg-green-200 font-bold" => $answer->is_correct,
                                        "bg-white" => !$answer->is_correct
                                    ])>{{ $answer->description }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
