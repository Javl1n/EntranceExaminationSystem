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
    'input.*.*' => 'required|numeric|integer'
])->messages([
    'input.*.*.required' => 'all fields must be required',
    'input.*.*.numeric' => 'all fields must be numeric',
    // 'input.*.*.integer' => 'all fields must be an ',
]);

$showMode = fn () => $this->dispatch("timerShowMode");

$save = function () {

    // validate inputs
    $this->validate();

    // process inputs G7
    $inputG7 = $this->input['G7'];
    $inputG7['minutes'] += intval($inputG7['seconds'] / 60);
    $inputG7['seconds']  = intval($inputG7['seconds'] % 60);
    $inputG7['hours']   += intval($inputG7['minutes'] / 60);
    $inputG7['minutes']  = intval($inputG7['minutes'] % 60);

    // store into database G7
    $this->timerG7->update([
        'hours' => $inputG7['hours'],
        'minutes' => $inputG7['minutes'],
        'seconds' => $inputG7['seconds'],
    ]);

    // process inputs G11
    $inputG11 = $this->input['G11'];
    $inputG11['minutes'] += intval($inputG11['seconds'] / 60);
    $inputG11['seconds']  = intval($inputG11['seconds'] % 60);
    $inputG11['hours']   += intval($inputG11['minutes'] / 60);
    $inputG11['minutes']  = intval($inputG11['minutes'] % 60);

    // store into database G11
    $this->timerG11->update([
        'hours' => $inputG11['hours'],
        'minutes' => $inputG11['minutes'],
        'seconds' => $inputG11['seconds'],
    ]);

    // refresh page
    return $this->redirectRoute('exams.index', navigate: true);
};

?>

<div>
    <div class="flex justify-between">
        <h1 class="text-lg font-bold">Manage Exam Timers</h1>
        <h1 class="text-blue-500 my-auto text-sm font-bold">Edit Mode</h1>
    </div>
    
    {{-- G7 --}}
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
    @foreach ($errors->get('input.G7.*') as $key)
        @error('input.G7.*')
            <div class="mt-0 text-center italic text-red-500 text-sm">
                {{ $message }}
            </div>
        @enderror
    @endforeach
    
    {{-- G11 --}}
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
    @foreach ($errors->get('input.G11.*') as $key)
        @error('input.G11.*')
            <div class="mt-0 text-center italic text-red-500 text-sm">
                {{ $message }}
            </div>
        @enderror
    @endforeach

    <div class="flex justify-end gap-4 mt-4">
        <a class="text-base uppercase text-gray-600 font-bold my-auto hover:cursor-pointer hover:text-green-500 transition linear" x-on:click="$wire.save">Save</a>
        <a class="text-base uppercase text-gray-600 font-bold my-auto hover:cursor-pointer hover:text-blue-500 transition linear" x-on:click="$wire.showMode">Cancel</a>
    </div>
</div>
