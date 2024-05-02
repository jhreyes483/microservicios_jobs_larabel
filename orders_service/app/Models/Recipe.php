<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;


    public function Ingredients()
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient', 'recipe_id', 'ingredient_id')->withPivot('recipe_quantity');
    }
}
