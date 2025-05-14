<?php

use function Livewire\Volt\{state, layout, title, mount};
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Models\Examinee;
use App\Models\Question;
use App\Models\Strand;
use App\Models\Section;
use Asantibanez\LivewireCharts\Facades\LivewireCharts;

state([
    'examinees' => Examinee::get(),
    'questions' => Question::get(),
    'strands' => Strand::with(['list' => function (Builder $query) {
        $query->where('ranking', 1);
    }])->get(),
    'sections' => Section::with('examinees')->get(),
]);

layout('layouts.app');

title('Dashboard - SLSPI Entrance Exam');

mount(function () {


    $this->pieChartModel7 = LivewireCharts::pieChartModel()
        ->setTitle("Grade 7 Overview")
        ->asPie()
        ->addSlice('Genesis', $this->sections->where('letter', 'A')->first()->examinees->count(), '#22c55e')
        ->addSlice('Exodus', $this->sections->where('letter', 'B')->first()->examinees->count(), '#10b981')
        ->addSlice('Leviticus', $this->sections->where('letter', 'C')->first()->examinees->count(), '#14b8a6')
        ->addSlice('Deutoronomy', $this->sections->where('letter', 'D')->first()->examinees->count(), '#06b6d4')
        ->addSlice('Remedial', $this->sections->where('letter', 'F')->first()->examinees->count(), '#71717a');


    $this->pieChartModel11 = LivewireCharts::pieChartModel()
        ->setTitle("Grade 11 Overview")
        ->asPie()
        ->addSlice('STEM', $this->strands->where('title', 'STEM')->first()->list->count(), '#3b82f6')
        ->addSlice('HUMSS', $this->strands->where('title', 'HUMSS')->first()->list->count(), '#10b981')
        ->addSlice('ABM', $this->strands->where('title', 'ABM')->first()->list->count(), '#ef4444')
        ->addSlice('Remedial', $this->strands->where('title', 'Remedial')->first()->list->count(), '#71717a');
})

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-4">
                <div class="h-96 bg-white rounded-xl p-4">
                
                    <livewire:livewire-pie-chart
                        class="h-full"
                        {{-- key="{{ $columnChartModel->reactiveKey() }}" --}}
                        :pie-chart-model="$this->pieChartModel7"
                    />
                </div>
                <div class="h-96 bg-white rounded-xl p-4">
                
                    <livewire:livewire-pie-chart
                        class="h-full"
                        {{-- key="{{ $columnChartModel->reactiveKey() }}" --}}
                        :pie-chart-model="$this->pieChartModel11"
                    />
                </div>
                
            </div>
            <div class="mt-4">
                @livewire('dashboard.examinees', ['examinees' => $this->examinees])
                @livewire('dashboard.junior-highschool-examinees', ['examinees' => $this->examinees, 'sections' => $this->sections])
                @livewire('dashboard.senior-highschool-examinees', ['examinees' => $this->examinees, 'strands' => $this->strands])
            </div>
        </div>
    </div>
</div>

