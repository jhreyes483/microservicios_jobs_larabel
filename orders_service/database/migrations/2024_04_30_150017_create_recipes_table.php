<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_id');
            $table->integer('retry')->default(0);
            $table->string('name');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();
        });

        DB::table('recipes')->insert([
            ['id'=>1, 'status_id'=>1, 'name'=>'Ensalada de tomate y lechuga con aderezo de queso', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>2, 'status_id'=>1, 'name'=>'Pollo al horno con papas y cebolla', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>3, 'status_id'=>1, 'name'=>'Arroz frito con vegetales', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>4, 'status_id'=>1, 'name'=>'Sándwich de queso', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>5, 'status_id'=>1, 'name'=>'Carne', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>6, 'status_id'=>1, 'name'=>'Carne queso', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
