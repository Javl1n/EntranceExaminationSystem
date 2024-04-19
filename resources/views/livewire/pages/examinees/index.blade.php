<?php

use function Livewire\Volt\{state, layout, title};

use App\Models\Examinee;

layout('layouts.app');

title('Examinees - SLSPI Entrance Exam');

state([
    'examinees' => Examinee::get()
]);

?>

<div class="max-w-7xl min-h-max mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Examinees') }}
        </h2>
    </x-slot>
    <div class="bg-white shadow-sm sm:rounded-lg mt-4 p-4 rounded-xl transition ease-linear">
        <div class="grid grid-cols-12 w-full border-b-2 pb-4 px-2">
            <div class="col-span-3">Name</div>
            <div class="col-span-2 text-center">Grade</div>
            <div class="col-span-3 text-center">Section/Strand</div>
            <div class="col-span-2 text-center">Score</div>
            <div class="col-span-2 text-end">Date Attempted</div>
        </div>
        @foreach ($examinees as $examinee)
            @php
                $sumScore = 0;
                $sumTotal = 0;
                foreach($examinee->scores as $score) {
                    $sumScore += $score->score;
                    $sumTotal += $score->total;
                }
            @endphp
            <div @class([
                "grid grid-cols-12 w-full py-2 px-2",
                'bg-blue-50' => $examinee->grade_level === 11,
                'bg-green-100' => $examinee->grade_level === 7
                ])>
                <div class="col-span-3">{{ $examinee->name }}</div>
                <div class="col-span-2 text-center">Grade {{ $examinee->grade_level }}</div>
                <div class="col-span-3 text-center">Section/Strand</div>
                <div class="col-span-2 text-center">{{ $sumScore }} out of {{ $sumTotal; }}</div>
                <div class="col-span-2 text-end">{{ $examinee->created_at->diffForHumans() }}</div>
            </div>
        @endforeach
    </div>
</div>
