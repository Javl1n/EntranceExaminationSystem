<?php

use function Livewire\Volt\{state, layout, title, computed};
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Examinee;
use App\Models\Question;
use App\Models\Strand;
use App\Models\Section;

state([
    'examinees' => Examinee::get(),
    'questions' => Question::get(),
    'strands' => Strand::with(['list' => function (Builder $query) {
        $query->where('ranking', 1);
    }])->get(),
    'sections' => Section::with('examinees')->get()
]);

layout('layouts.app');

title('Dashboard - SLSPI Entrance Exam');

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('dashboard.examinees', ['examinees' => $this->examinees])
            @livewire('dashboard.junior-highschool-examinees', ['examinees' => $this->examinees, 'sections' => $this->sections])
            @livewire('dashboard.senior-highschool-examinees', ['examinees' => $this->examinees, 'strands' => $this->strands])
        </div>
    </div>
</div>

