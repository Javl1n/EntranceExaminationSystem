<?php

use function Livewire\Volt\{state, rules};

state([
    'timerG7',
    'timerG11',
    // 'inputG7' => fn ($timerG7) => [
    //     'hours' => $timerG7->hours, 
    //     'minutes' => $timerG7->minutes, 
    //     'seconds' => $timerG7->seconds
    // ],
    // 'inputG11' => fn ($timerG11) => [
    //     'hours' => $timerG11->hours, 
    //     'minutes' => $timerG11->minutes, 
    //     'seconds' => $timerG11->seconds
    // ],
    'input' => fn ($timerG7, $timerG11) => [
        'G7' => [
            'hours' => $timerG7->hours, 
            'minutes' => $timerG7->minutes, 
            'seconds' => $timerG7->seconds
        ],
        'G11' => [
            'hours' => $timerG11->hours, 
            'minutes' => $timerG11->minutes, 
            'seconds' => $timerG11->seconds
        ]
    ]
]);

rules([
    'input.*.*' => 'required|numeric'
]);

$showMode = fn () => $this->dispatch("timerShowMode");

$save = function () {
    $this->validate();
};

?>

<div>
    <div class="flex justify-between">
        <h1 class="text-lg font-bold">Manage Exam Timers</h1>
        <h1 class="text-blue-500 my-auto text-sm font-bold">Edit Mode</h1>
    </div>
    
    <div class="flex gap-1 bg-green-300 rounded p-2 mt-4">
        <div class="w-12 text-center my-auto text-lg">
            G7:
        </div>
        <div class="bg-white p-2 flex-1 flex justify-center gap-2 rounded font-bold">
            {{-- border-transparent focus:border-transparent focus:ring-0 --}}
            <input 
                value=""
                type="text" 
                class="h-5 w-5 p-0 my-auto text-center rounded"
                x-data="{
                    resize: () => { $el.style.width = '30px'; $el.style.width = $el.scrollWidth + 'px' }
                }"
                x-init="resize()"
                x-on:input="resize()"
                wire:model="input.G7.hours">
            <span class="">hr</span>
            <input 
                value=""
                type="text" 
                class="h-5 w-5 p-0 my-auto text-center rounded"
                x-data="{
                    resize: () => { $el.style.width = '30px'; $el.style.width = $el.scrollWidth + 'px' }
                }"
                x-init="resize()"
                x-on:input="resize()"
                wire:model="input.G7.minutes">
            <span class="">min</span>
            <input 
                value=""
                type="text" 
                class="h-5 w-5 p-0 my-auto text-center rounded"
                x-data="{
                    resize: () => { $el.style.width = '30px'; $el.style.width = $el.scrollWidth + 'px' }
                }"
                x-init="resize()"
                x-on:input="resize()"
                wire:model="input.G7.seconds">
            <span class="">sec</span>
        </div>
    </div>
    @foreach ($errors->get('input.G7.*') as $message)
        <div class="mt-0 text-center italic text-red-500 text-sm">
            {{ $message }}
        </div>
    @endforeach
    
    <div class="flex gap-1 bg-blue-300 rounded p-2 mt-4">
        <div class="w-12 text-center my-auto text-lg">
            G11:
        </div>
        <div class="bg-white p-2 flex-1 flex gap-2 rounded justify-center font-bold">
            {{-- border-transparent focus:border-transparent focus:ring-0 --}}
            <input
                value=""
                type="text"
                class="h-5 w-5 p-0 my-auto text-center rounded"
                x-data="{
                    resize: () => { $el.style.width = '30px'; $el.style.width = $el.scrollWidth + 'px' }
                }"
                x-init="resize()"
                x-on:input="resize()"
                wire:model="input.G11.hours">
            <span class="">hr</span>
            <input
                value=""
                type="text"
                class="h-5 w-5 p-0 px-2 my-auto text-center rounded"
                x-data="{
                    resize: () => { $el.style.width = '30px'; $el.style.width = $el.scrollWidth + 'px' }
                }"
                x-init="resize()"
                x-on:input="resize()"
                wire:model="input.G11.minutes">
            <span class="">min</span>
            <input
                value=""
                type="text"
                class="h-5 w-5 p-0 my-auto text-center rounded"
                x-data="{
                    resize: () => { $el.style.width = '30px'; $el.style.width = $el.scrollWidth + 'px' }
                }"
                x-init="resize()"
                x-on:input="resize()"
                wire:model="input.G11.seconds">
            <span class="">sec</span>
        </div>
    </div>
    <div class="mt-0 text-center italic text-red-500 text-sm">
        sad
    </div>
    
    
    <div class="flex justify-end gap-4 mt-4">
        <a class="text-base uppercase text-gray-600 font-bold my-auto hover:cursor-pointer hover:text-green-500 transition linear" x-on:click="$wire.save">Save</a>
        <a class="text-base uppercase text-gray-600 font-bold my-auto hover:cursor-pointer hover:text-blue-500 transition linear" x-on:click="$wire.showMode">Cancel</a>
    </div>
</div>
