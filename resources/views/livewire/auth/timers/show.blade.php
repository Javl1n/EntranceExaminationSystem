<?php

use function Livewire\Volt\{state};

state([
    'timerG7',
    'timerG11'
]);

$editMode = fn () => $this->dispatch("timerEditMode");
// $showMode = fn () => $this->dispatch("showMode-" . $this->question->id);

?>

<div>
    <div class="flex justify-between">
        <h1 class="text-lg font-bold">Manage Exam Timers</h1>
        @session("timerUpdated")
            <h1 class="text-green-500 my-auto text-sm font-bold">{{ session('timerUpdated') }}</h1>
        @endsession
    </div>
    <div class="grid gap-4 mt-4">
        <div class="flex gap-1 bg-green-300 rounded p-2">
            <div class="w-12 text-center my-auto text-lg">
                G7:
            </div>
            <div class="bg-white p-2 flex-1 rounded text-center font-bold">
                {{ $timerG7->hours }} hr : {{ $timerG7->minutes }} min : {{ $timerG7->seconds }} sec
            </div>
        </div>
        <div class="flex gap-1 bg-blue-300 rounded p-2">
            <div class="w-12 text-center my-auto text-lg">
                G11:
            </div>
            <div class="bg-white p-2 flex-1 rounded text-center font-bold">
                {{ $timerG11->hours }} hr : {{ $timerG11->minutes }} min : {{ $timerG11->seconds }} sec
            </div>
        </div>
    </div>
    <div class="flex justify-end mt-4"><a class="text-base uppercase text-gray-600 font-bold my-auto hover:cursor-pointer hover:text-blue-500 transition linear" x-on:click="$wire.editMode">Edit</a></div>
</div>
