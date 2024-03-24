<?php

use function Livewire\Volt\{state, on};

use App\Models\Timer;

state([
    'timerG7' => Timer::where('grade', 7)->first(),
    'timerG11' => Timer::where('grade', 11)->first(),
    'viewState' => 'edit',
]);

on([
    "timerEditMode" => function () { return $this->viewState = 'edit';},
    "timerShowMode" => function () { return $this->viewState = 'show';},
]);


?>

<div class="p-4 bg-white rounded-lg shadow-sm">
    @if ($viewState === 'show')
        @livewire('timers.show', ['timerG7' => $timerG7, 'timerG11' => $timerG11])
    @elseif ($viewState === 'edit')
        @livewire('timers.edit', ['timerG7' => $timerG7, 'timerG11' => $timerG11])
    @endif
</div>
