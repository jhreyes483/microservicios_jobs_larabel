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
            $table->timestamps();
        });

        DB::table('ingredients')->insert([
            ['id'=>1, 'name'=>'tomato', 'quantity'=>5,'status_id'=>1 , 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>2, 'name'=>'lemon', 'quantity'=>5,'status_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>3, 'name'=>'potato', 'quantity'=>5,'status_id'=>1,'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>4, 'name'=>'rice', 'quantity'=>5,'status_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>5, 'name'=>'ketchup', 'quantity'=>5,'status_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>6, 'name'=>'lettuce', 'quantity'=>5,'status_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()],
            ['id'=>7, 'name'=>'onion', 'quantity'=>5,'status_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>8, 'name'=>'cheese', 'quantity'=>5,'status_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>9, 'name'=>'meat', 'quantity'=>5,'status_id'=>1,'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString() ],
            ['id'=>10, 'name'=>'chicken', 'quantity'=>5,'status_id'=>1, 'created_at'=> Carbon::now()->toDateTimeString(), 'updated_at' =>  Carbon::now()->toDateTimeString()]
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
