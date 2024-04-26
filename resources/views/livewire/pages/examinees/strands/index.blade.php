<?php

use function Livewire\Volt\{state, layout, title, boot};
use Illuminate\Database\Eloquent\Builder;
use App\Models\Examinee;
use App\Models\Strand;

layout('layouts.app');

title('Strands - SLSPI Entrance Exam');

state([
    'examinees',
    'strands' => Strand::get(),
    'strand' => 1
])->url();

// state([
//     'strand'
// ])->url();

boot(function () {
    $this->examinees = Examinee::whereHas('strandRecommendations', function (Builder $query) {
        $query->where('strand_id', $this->strand);
        $query->where('ranking', 1);
    })->latest()->get();
});

$selectStrand = function ($strand) {
    $this->strand = $strand;
    $this->examinees = Examinee::whereHas('strandRecommendations', function (Builder $query) {
        $query->where('strand_id', $this->strand);
        $query->where('ranking', 1);
    })->latest()->get();
};

?>

<div class="max-w-7xl min-h-max mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Strand Recommendations') }}
        </h2>
    </x-slot>
    <div class="mt-4">
        <div class="flex">
            @foreach ($this->strands as $strand)
                <div 
                wire:click='selectStrand({{ $strand->id }})'
                @class([
                    "rounded-t-lg px-6 text-xl font-semibold cursor-pointer transition duration-100",
                    "bg-white" => $this->strand === $strand->id,
                    "bg-gray-50 border-t border-x hover:bg-gray-100" => $this->strand !== $strand->id
                ])>
                    {{ $strand->title }}
                </div>
            @endforeach
        </div>
        <div @class([
                "bg-white  rounded-b-xl rounded-tr-lg sm:rounded-b-lg sm:rounded-tr-lg shadow-sm p-4  transition ease-linear",
                "rounded-tl-xl sm:rounded-tl-lg" => $this->strand !== 1,
            ])>
            <div class="grid grid-cols-12 w-full border-b-2 pb-4 px-2">
                <div class="col-span-3">Name</div>
                <div class="col-span-3 text-center">Score</div>
                <div class="col-span-2 text-center">Average</div>
                <div class="col-span-2 text-center">Date</div>
                <div class="col-span-2 text-center">Time</div>
            </div>
            @foreach ($this->examinees as $examinee)
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
                ])>
                    <div class="col-span-3">{{ $examinee->name }}</div>
                    <div class="col-span-3 text-center">{{ $sumScore }} out of {{ $sumTotal; }}</div>
                    <div class="col-span-2 text-center">{{ round($sumScore / $sumTotal * 100, 2) }}%</div>
                    <div class="col-span-2 text-center">{{ $examinee->created_at->format('F j, Y') }}</div>
                    <div class="col-span-2 text-center">{{ $examinee->created_at->format('H:i a') }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
