<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/detect', [VideoController::class, 'analyze'])->name('analyze.video');
