<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecipeIngredient extends Model
{
    protected $table='recipe_ingredient';
    public $timestamps = true;
  	protected $primaryKey = 'id';
    use HasFactory;


    public function Ingedient(){
        return $this->belongsTo(Ingredient::class,  'ingredient_id');
    }

    public function Ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipe_ingredient', 'recipe_id', 'ingredient_id')->withPivot('recipe_quantity');
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_ingredient', 'ingredient_id', 'recipe_id');
    }


}
