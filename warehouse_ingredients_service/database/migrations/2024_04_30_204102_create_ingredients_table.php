<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('quantity');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('measure_id');
            $table->foreign('measure_id')->references('id')->on('measures');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->timestamps();
        });

        DB::table('ingredients')->insert([
            ['id'=>1, 'name'=>'Tomato', 'quantity'=>5,'status_id'=>1,'measure_id'=>1 , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>2, 'name'=>'Lemon', 'quantity'=>5,'status_id'=>1,'measure_id'=>1 , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>3, 'name'=>'Potato', 'quantity'=>5,'status_id'=>1,'measure_id'=>1 ,'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>4, 'name'=>'Rice', 'quantity'=>5,'status_id'=>1,'measure_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>5, 'name'=>'Ketchup', 'quantity'=>5,'status_id'=>1,'measure_id'=>1 , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>6, 'name'=>'Lettuce', 'quantity'=>5,'status_id'=>1,'measure_id'=>1 , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>7, 'name'=>'Onion', 'quantity'=>5,'status_id'=>1,'measure_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>8, 'name'=>'Cheese', 'quantity'=>5,'status_id'=>1,'measure_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>9, 'name'=>'Meat', 'quantity'=>5,'status_id'=>1,'measure_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>10, 'name'=>'Chicken', 'quantity'=>5,'status_id'=>1,'measure_id'=>1 , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingredients');
    }
}
