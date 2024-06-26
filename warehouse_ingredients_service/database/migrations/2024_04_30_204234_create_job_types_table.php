<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateJobTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        DB::table('job_types')->insert([
            ['id'=>1, 'name'=>'comprar ingredinte', 'description'=>'El producto estaba agotado cuando se realizó el primer intento de compra por lo que se crea esta tarea','created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],           
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_types');
    }
}
