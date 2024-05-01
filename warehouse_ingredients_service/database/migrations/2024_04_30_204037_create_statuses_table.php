<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::table('statuses')->insert([
            ['id'=>1, 'name'=>'activo','created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>2,'name'=>'desactivado','created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>3,'name'=>'no hay existencia','created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>4,'name'=>'pendiente','created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()]
        ]);
    
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
