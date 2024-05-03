<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CreateConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('desciption');
            $table->boolean('active');
            $table->timestamps();
        });

        DB::table('configs')->insert([
            ['id'=>1, 'desciption'=>'crear ordenes solo con ingredientes existentes (aleatoreo)', 'active'=>false, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>2, 'desciption'=>'crear ordenes con todos los ingredientes sin importar si hay existencias (aleatoreo)', 'active'=>true,'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configs');
    }
}
