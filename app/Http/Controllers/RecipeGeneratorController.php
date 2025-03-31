<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Http\Requests\RecipeRequest;
use App\Services\OpenAIService;
use App\Http\Controllers\Controller;

class RecipeGeneratorController extends Controller
{
    protected $openAIService;

    public function __construct(OpenAIService $openAIService)
    {
        $this->openAIService = $openAIService;
    }

    public function generate(Request $request)
    {
        $ingredients = $request->input('ingredients', []);

        try {
            $recipeText = $this->openAIService->generateRecipe($ingredients);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to generate recipe'], 500);
        }

        return response()->json([
            'recipe' => $recipeText,
        ]);
    }

    public function saveGeneratedRecipe(RecipeRequest $request)
    {
        $recipe = Recipe::create($request->validated());
        return response()->json([
            'message' => 'Generated recipe saved successfully',
            'recipe' => $recipe,
        ]);
    }
}
