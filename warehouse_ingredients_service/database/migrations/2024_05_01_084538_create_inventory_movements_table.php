<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->unsignedBigInteger('ingredient_id');
            $table->unsignedBigInteger('movement_reason_id');
            $table->unsignedBigInteger('movement_type_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->foreign('movement_reason_id')->references('id')->on('reason_of_movements');
            $table->foreign('movement_type_id')->references('id')->on('type_of_movements');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_movements');
    }
}
