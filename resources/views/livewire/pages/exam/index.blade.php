<?php

use function Livewire\Volt\{layout, state};

layout('layouts.app');

?>

<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Exams Management') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl min-h-max mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-3 gap-5">
            <div class="col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 rounded-xl">
                @livewire('questions.create')
            </div>
            <div class="col-span-1">
                Search
            </div>
        </div>
    </div>
</div>
