<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('{page}', MainController::class)->where('page', '.*');

Auth::routes();
