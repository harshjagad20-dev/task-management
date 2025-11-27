<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Tasks
//----------------------------------
Route::apiResource('tasks', TaskController::class);