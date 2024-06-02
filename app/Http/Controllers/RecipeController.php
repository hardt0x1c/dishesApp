<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Http\JsonResponse;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;

final class RecipeController extends Controller
{
    public function index(): Collection
    {
        return Recipe::all();
    }

    public function show(int $id): Recipe
    {
        return Recipe::findOrFail($id);
    }

    public function store(Request $request): JsonResponse
    {
        $recipeData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'instructions' => $request->input('instructions'),
        ];

        $result = Recipe::create($recipeData);

        if ($result) {
            return response()->json(['message' => 'Recipe created successfully'], 200);
        } else {
            return response()->json(['message' => 'Recipe not created'], 500);
        }
    }

    public function update(int $id, Request $request): JsonResponse
    {
        $recipeData = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'instructions' => $request->input('instructions'),
        ];

        $result = Recipe::where('id', $id)->update($recipeData);

        if ($result) {
            return response()->json(['message' => 'Recipe updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Recipe not found'], 404);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        $result = Recipe::destroy($id);

        if ($result) {
            return response()->json(['message' => 'Recipe deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Recipe not found'], 404);
        }
    }
}
