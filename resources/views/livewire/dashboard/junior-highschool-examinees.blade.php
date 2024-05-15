<?php

use function Livewire\Volt\{state, computed, mount};
use Carbon\Carbon;

state([
    'examinees',
    'sections'
]);

mount(function () {
    $this->examinees = $this->examinees->where('grade_level', 7);
});

$examineesToday = computed(function () {
    return $this->examinees->where('created_at', '>=', Carbon::today())->count();
});

$examineesThisYear = computed(function () {
    return $this->examinees->filter(function ($value) {
        return $value->created_at->year === (int)date('Y');
    })->count();
});

$sectionExaminees = computed(function ($id) {
    return $this->sections->where('id', $id)->first()->examinees->count();
});

?>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
    <div class="p-6 text-gray-900">
        <h1 class="text-xl font-bold">{{ __("Junior High School Examinees") }}</h1>
        <div class="flex justify-between gap-2 mt-4 font-bold h-52">
            <div class='border-2 border-blue-500 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                <h1 class="text-6xl font-bold">
                    {{ $this->examineesToday }}
                </h1>
                <h1 class="text-center text-sm">Today</h1>
            </div>
            <div class='border-2 border-blue-500 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                <h1 class="text-6xl font-bold">
                    {{ $this->examineesThisYear }}
                </h1>
                <h1 class="text-center text-sm">This Year</h1>
            </div>
            <div class='border-2 border-blue-500 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                <h1 class="text-6xl font-bold">
                    {{ $this->examinees->count() }}
                </h1>
                <h1 class="text-center text-sm">All Time</h1>
            </div>
        </div>
        <div class="mt-4">
            <h1 class="text-lg font-bold">{{ __("Sections") }}</h1>
            <div class="flex justify-between gap-2 font-bold h-40">
                @foreach ($this->sections as $section)
                    <div class='border-2 border-blue-500 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                        <a href="{{ route('sections.index', ['section' => $loop->iteration > 1 ? $loop->iteration : null]) }}">
                            <h1 class="text-6xl font-bold">
                                {{ $this->sectionExaminees($section->id) }}
                            </h1>
                            <h1 class="text-center text-sm">{{ $section->letter }} - {{ $section->description }}</h1>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
