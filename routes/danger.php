<?php

use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::delete('/questions', function () {
    DB::table('questions')->delete();

    return back();
});