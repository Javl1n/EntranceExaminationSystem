<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/posts', '/');

Route::view('/', 'welcome')->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/exams', 'pages.exam.index')->name('exams.index');
    Volt::route('/examinees', 'pages.examinees.index')->name('examinees.index');
});

Route::middleware(['guest'])->group(function () {
    Volt::route('/exam', 'pages.guest.register')->name('examinees.create');
    Volt::route('/exam/{examinee:id}', 'pages.guest.examination')->name('examinees.startExam');
    Volt::route('/exam/{examinee}/result', 'pages.guest.result')->name('examinees.result');
});


require __DIR__.'/auth.php';
