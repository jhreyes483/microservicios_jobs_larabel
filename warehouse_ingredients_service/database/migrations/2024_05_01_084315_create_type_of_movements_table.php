<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CreateTypeOfMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_of_movements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        DB::table('type_of_movements')->insert([
            ['id'=>1, 'name'=>'suma', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>2, 'name'=>'resta', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_of_movements');
    }
}
