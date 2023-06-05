<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_categories', function (Blueprint $table) {
            $table->id()->comment('シフト');
            $table->integer('shift_code')->unique();
            $table->time('start_time');
            $table->time('end_time');
            $table->time('rest1_start_time');
            $table->time('rest1_end_time');
            $table->time('rest2_start_time')->nullable();
            $table->time('rest2_end_time')->nullable();
            $table->time('rest3_start_time')->nullable();
            $table->time('rest3_end_time')->nullable();
            $table->time('lunch_start_time')->nullable();
            $table->time('lunch_end_time')->nullable();
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
        Schema::dropIfExists('shift_categories');
    }
}
