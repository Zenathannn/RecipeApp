<?php

use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('recipes.index');
});

Route::resource('recipes', RecipeController::class);
