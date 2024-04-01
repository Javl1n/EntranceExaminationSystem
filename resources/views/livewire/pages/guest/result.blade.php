<?php

use function Livewire\Volt\{layout, state};

layout('layouts.examinee');

state([
    'examinee',
]);

?>
<div class="min-h-screen flex justify-center bg-gray-100">
    <div 
    class="pt-24 w-2/4  overflow-scroll">
        <h1 class="font-bold text-3xl text-center">Your Result</h1>
        <div class="mt-10 flex gap-10 bg-white py-5 px-10 rounded-lg shadow-lg">
            <div class="bg-blue-200 h-48 w-48 rounded-full text-center flex flex-col justify-center">
                <h1 class="text-white font-extrabold text-7xl">50%</h1>
                <div class="text-white font-bold">Average</div>
            </div>
            <div class="flex-1 flex flex-col">
                <div class="flex gap-4">
                    <h4 class="mt-auto">Section :</h4>
                    <h1 class="text-4xl mt-2 font-extrabold">A - Genesis</h1>
                </div>
                <div class="grid grid-cols-3 flex-1 gap-5">
                    <div class="bg-blue-500 h-full p-2">
                        <h1 class="text-center">Science</h1>
                        <h1 class="text-center my-auto">
                            100
                        </h1>
                    </div>
                    <div class="bg-blue-500 h-full p-2">
                        <h1 class="text-center">Science</h1>
                        <h1 class="text-center my-auto">
                            100
                        </h1>
                    </div>
                    <div class="bg-blue-500 h-full p-2">
                        <h1 class="text-center">Science</h1>
                        <h1 class="text-center my-auto">
                            100
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
