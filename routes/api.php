<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeGeneratorController;
use App\Http\Controllers\RecipeController;

// Open AI Routes
Route::post('/generate-recipe', [RecipeGeneratorController::class, 'generate']);
Route::post('/save-generated-recipe', [RecipeGeneratorController::class, 'saveGeneratedRecipe']);

// CRUD Routes
Route::get('/recipes', [RecipeController::class,'index']);
Route::post('/recipes', [RecipeController::class, 'store']);
Route::put('/recipes/{recipe}', [RecipeController::class, 'update']);
Route::delete('/recipes/{recipe}', [RecipeController::class, 'destroy']);
Route::get('/recipes/{recipe}', [RecipeController::class, 'show']);