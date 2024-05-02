<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        $output['status'] = true;
        $output['code'] = 200;
        $output['msg'] = 'ok';

        try {
            $output['recipes'] = Recipe::with('Ingredients')
                ->orderBy('id', 'desc')
                ->when($request->ingredient_id, function ($query) use ($request) {
                    $query->whereHas('Ingredients', function ($subQuery) use ($request) {
                        $subQuery->where('recipe_ingredient.ingredient_id', $request->ingredient_id);
                    });
                });

            if (!$output['recipes']->exists()) {
                $output['msg'] = 'No hay recetas';
            } else {
                $output['recipes'] = $output['recipes']->get();
            }
        } catch (\Throwable $th) {
            $output['msg'] = ' error->' . $th->getMessage() . ' line->' . $th->getLine() . ' file->' . $th->getFile();
            $output['code'] = 500;
        }

        return $output;
    }

    /**
     * @return array
     */
    public function getComplements(): array
    {
        $ingredient = Ingredient::select('id', 'name')->get();
        return ['status' => true, 'data' => ['ingredient' => $ingredient], 'code' => 200];
    }
}
