<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Recipe;
use App\Models\User;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexReturnsAllRecipes()
    {
        $recipes = Recipe::factory()->count(2)->create();

        $response = $this->get('/api/recipe');

        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJson([
                ['name' => $recipes[0]->name],
                ['name' => $recipes[1]->name],
            ]);
    }

    public function testShowReturnsRecipeById()
    {
        $recipe = Recipe::factory()->create();
        $response = $this->get('/api/recipe/' . $recipe->id);
        $response->assertStatus(200)
            ->assertJson([
                'id' => $recipe->id,
                'name' => $recipe->name,
                'description' => $recipe->description,
                'instructions' => $recipe->instructions,
            ]);
    }

    public function testStoreReturnsSuccessResponseWhenRecipeCreated()
    {
        $recipeData = [
            'name' => 'Test Recipe',
            'description' => 'Test Description',
            'instructions' => 'Test Instructions',
        ];

        $response = $this->postJson('/api/recipe', $recipeData);

        $response->assertStatus(200)
            ->assertJson(['message' => 'Recipe created successfully']);
    }

    public function testDestroyReturnsSuccessResponseWhenRecipeDeleted()
    {
        $recipe = Recipe::factory()->create();
        $response = $this->delete('/api/recipe/' . $recipe->id);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Recipe deleted successfully']);
    }
}
