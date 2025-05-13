<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutoringController;

Route::get('/dashboard', [TutoringController::class, 'index']);