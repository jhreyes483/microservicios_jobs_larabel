<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateReasonOfMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reason_of_movements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });


        DB::table('reason_of_movements')->insert([
            ['id'=>1, 'name'=>'compra por espera','description'=>'Compra por que el producto estaba agotado en la plaza (job)', 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>2, 'name'=>'compra de producto inmediata','description'=>'Compra inmediata en la plaza' , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>3, 'name'=>'entrega de producto', 'description'=>'Se entrega producto de un pedido solicitado' , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reason_of_movements');
    }
}
