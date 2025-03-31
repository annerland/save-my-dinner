<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
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
                'message' => 'Yummy! A new recipe was created successfully!',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create recipe. Please try again.',
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $recipe = Recipe::findOrFail($id);

            return response()->json([
                'recipe' => $recipe,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Recipe not found.',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        try {
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
                'message' => 'Yummy! Recipe updated successfully!',
                'data' => $data
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Uh oh! Recipe not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update recipe. Please try again.',
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $recipe = Recipe::findOrFail($id);
            $recipe->delete();

            return response()->json([
                'message' => 'Recipe deleted successfully!',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Recipe not found.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete recipe. Please try again.',
            ], 500);
        }
    }
}
