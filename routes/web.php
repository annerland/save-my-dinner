<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;

Route::resource('recipes',RecipeController::class);
Route::get('/api/recipes', [RecipeController::class, 'index']);