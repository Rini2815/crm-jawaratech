<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceJobController;

Route::get('/', function () {
    return redirect()->route('service-jobs.index');
});

Route::resource('service-jobs', ServiceJobController::class);