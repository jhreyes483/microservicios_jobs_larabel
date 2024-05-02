<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRecipeIngredientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_ingredient', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipe_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('recipe_quantity');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('recipe_ingredient')->insert([
            ['recipe_id'=>1, 'ingredient_id'=>1, 'recipe_quantity'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['recipe_id'=>1, 'ingredient_id'=>6, 'recipe_quantity'=>2, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],

            ['recipe_id'=>1, 'ingredient_id'=>2, 'recipe_quantity'=>3, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            //
            ['recipe_id'=>2, 'ingredient_id'=>10,'recipe_quantity'=>2 , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['recipe_id'=>2, 'ingredient_id'=>3, 'recipe_quantity'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['recipe_id'=>2, 'ingredient_id'=>7, 'recipe_quantity'=>2, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            //
            ['recipe_id'=>3, 'ingredient_id'=>4, 'recipe_quantity'=>2, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['recipe_id'=>3, 'ingredient_id'=>7, 'recipe_quantity'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            //
            ['recipe_id'=>4, 'ingredient_id'=>8,'recipe_quantity'=>2, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['recipe_id'=>4, 'ingredient_id'=>5, 'recipe_quantity'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            //
            ['recipe_id'=>5, 'ingredient_id'=>9,'recipe_quantity'=>2, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            //
            ['recipe_id'=>6, 'ingredient_id'=>9,'recipe_quantity'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['recipe_id'=>6, 'ingredient_id'=>8,'recipe_quantity'=>2,'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_ingredient');
    }
}
