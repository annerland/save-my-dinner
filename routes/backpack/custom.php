<?php

use Illuminate\Support\Facades\Route;

// Custom Backpack Routes
Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', backpack_middleware()],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () {
    // custom admin routes
    Route::crud('recipe', 'RecipeCrudController');
});
