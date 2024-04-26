<?php

use function Livewire\Volt\{state, computed, mount};
use Carbon\Carbon;

state([
    'examinees',
    'strands'
]);

mount(function () {
    $this->examinees = $this->examinees->where('grade_level', 11);
});

$examineesToday = computed(function () {
    return $this->examinees->where('created_at', '>=', Carbon::today())->count();
});

$examineesThisYear = computed(function () {
    return $this->examinees->filter(function ($value) {
        return $value->created_at->year === (int)date('Y');
    })->count();
});

$strandExaminees = computed(function ($id) {
    return $this->strands->where('id', $id)->first()->list->count();
});

?>

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-4">
    <div class="p-6 text-gray-900">
        <h1 class="text-xl font-bold">{{ __("Senior High School Examinees") }}</h1>
        <div class="flex justify-between gap-2 mt-4 font-bold">
            <div class='border-2 border-blue-500 h-52 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                <h1 class="text-6xl font-bold">
                    {{ $this->examineesToday }}
                </h1>
                <h1 class="text-center text-sm">Today</h1>

                {{-- <h1 class="text-center text-sm">
                    <span class="text-transparent">0</span>
                </h1> --}}
            </div>
            <div class='border-2 border-blue-500 h-52 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                <h1 class="text-6xl font-bold">
                    {{ $this->examineesThisYear }}
                </h1>
                <h1 class="text-center text-sm">This Year</h1>
            </div>
            <div class='border-2 border-blue-500 h-52 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                <h1 class="text-6xl font-bold">
                    {{ $this->examinees->count() }}
                </h1>
                <h1 class="text-center text-sm">All Time</h1>
            </div>
        </div>
        <div class="mt-4">
            <h1 class="text-lg font-bold">{{ __("Strands") }}</h1>
            <div class="flex justify-between gap-2 font-bold h-40">
                @foreach ($this->strands as $section)
                    <div class='border-2 border-blue-500 w-full text-center flex flex-col gap-2 text-black justify-center rounded-xl'>
                        <h1 class="text-6xl font-bold">
                            {{ $this->strandExaminees($section->id) }}
                        </h1>
                        <h1 class="text-center text-sm">{{ $section->description }}</h1>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
