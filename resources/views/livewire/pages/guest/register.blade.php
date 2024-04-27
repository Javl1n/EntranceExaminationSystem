<?php

use function Livewire\Volt\{state, layout, rules};

use App\Models\Examinee;

layout('layouts.examinee');

state([
    'name',
    'email',
    // 'contact',
    'grade' => 7,
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
    // 'contact' => ['required', 'numeric', 'starts_with:09', 'max_digits:11', 'min_digits:11']
]);

$grade7 = fn () => $this->grade = 7;
$grade11 = fn () => $this->grade = 11;


$register = function () {
    $this->validate();
    $examinee = Examinee::firstOrCreate([
        'name' => $this->name,
        // 'contact' => $this->contact,
        'email' => $this->email,
        'grade_level' => $this->grade, 
    ]);

    return $this->redirectRoute('examinees.startExam',['examinee' => $examinee->id],  navigate: true, );
};


?>
<div class="min-h-screen flex sm:justify-center items-center">
    <div class="lg:max-w-none sm:max-w-md mt-6  bg-blue-400 shadow-md overflow-hidden sm:rounded-lg">
        <div class="grid grid-cols-2 p-4">
            <div class="col-span-1 px-6 py-4 text-white">
                <h1 class="font-bold text-lg">EXAM GUIDLINES</h1>
                <ol class="list-decimal w-80">
                    <li>Avoid Changing tab during examination period; it will reset your progress.</li>
                    <li class="mt-2">Be mindful of the time limit. Scores will be calculated automatically if you run out of time.</li>
                    <li class="mt-2">Average must be 75% and above.</li>
                    <li class="mt-2">Examination result will determine your section/strand.</li>
                    <li class="mt-2">Do not cheat.</li>
                </ol>
    
            </div>
            <div class="col-span-1 rounded-lg bg-white px-6 py-4">
                <h1 class="text-xl font-bold">Enter Your Information</h1>
                <div class="mt-4">
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
            
                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input wire:model="email" id="email" class="block mt-1 w-full" type="email" name="email" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
            
                    {{-- <!-- Contact Number -->
                    <div class="mt-4">
                        <x-input-label for="contact" :value="__('Contact Number')" />
            
                        <x-text-input wire:model="contact" id="contact" class="block mt-1 w-full"
                                        type="text"
                                        name="contact"
                                         />
            
                        <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                    </div> --}}
    
                    <!-- Grade Level -->
                    <div class="mt-4">
                        <x-input-label for="grade" :value="__('Grade Level')" />
                        <div class="grid grid-cols-2 gap-2">
                            <div class="text-center">
                                <button class="{{ $grade === 7 ? 'bg-green-500 text-white' : ''  }} font-bold text-gray-600 text-sm w-full py-3 transition linear rounded shadow-sm border border-gray-300" wire:click.prevent="grade7">Grade 7</button>
                            </div>
                            <div class="text-center">
                                <button class="{{ $grade === 11 ? 'bg-blue-500 text-white' : ''  }} font-bold text-gray-600 text-sm w-full py-3 transition linear rounded shadow-sm border border-gray-300" x-on:click="$wire.grade11">Grade 11</button>
                            </div>
                        </div>
                        {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                    </div>
    
                    <div class="mt-6">
                        <button class="bg-blue-500 text-white px-6 py-2 rounded w-full hover:bg-blue-800 uppercase font-bold" x-on:click="$wire.register">
                            Get Started
                        </button>
                    </div>
    
                    {{-- <div class="flex justify-center mt-4">
                        <x-primary-button wire:click="register" class="ms-4 w-full text-center">
                            {{ __('Get Started') }}
                        </x-primary-button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

