<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::all();
        return response()->json($recipes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->json([
            'message' => 'This is the create endpoint. Implement form handling on the client side.'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'ingredients'=> 'required|array',
            'ingredients.*.name'=> 'required|string',
            'ingredients.*.quantity'=> 'required|string',
            'prep_time' => 'required|string',
        ]);

        Recipe::create($data);

        return response()->json([
            'message' => 'Recipe created successfully!',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        return response()->json($recipe);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        return response()->json([
            'message' => 'This is the edit endpoint. Implement form handling on the client side.',
            'recipe' => $recipe
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'name'=> 'required|string|max:255',
            'description'=> 'required|string',
            'ingredients'=> 'required|array',
            'ingredients.*.name' => 'required|string',
            'ingredients.*.quantity'=> 'required|string',
            'prep_time'=> 'required|string',
        ]);

        $recipe->update($data);

        return response()->json([
            'message' => 'Recipe created successfully!',
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return response()->json([
            'message' => 'Recipe deleted successfully!'
        ]);
    }
}
