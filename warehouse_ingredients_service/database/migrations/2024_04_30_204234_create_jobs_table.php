<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('model_id');
            $table->integer('retry');
            $table->unsignedBigInteger('model_quantity');
            $table->unsignedBigInteger('status_id');
            $table->unsignedBigInteger('job_type_id');
            $table->unsignedBigInteger('external_order_id')->nullable();
            $table->foreign('job_type_id')->references('id')->on('job_types');
            $table->foreign('status_id')->references('id')->on('statuses');
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
        Schema::dropIfExists('jobs');
    }
}
