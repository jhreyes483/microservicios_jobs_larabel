<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHttpLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('http_logs', function (Blueprint $table) {
            $table->id();
            $table->json('body')->nullable();
            $table->json('response')->nullable();
            $table->unsignedBigInteger('type')->nullable(); // 1 => se recive, 2=> se envia
            $table->string('status')->nullable();
            $table->string('url')->nullable();
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
        Schema::dropIfExists('http_logs');
    }
}
