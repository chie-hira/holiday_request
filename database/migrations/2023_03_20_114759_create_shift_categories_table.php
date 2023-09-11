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
            $table->float('work_time1')->comment('前半労働時間');
            $table->float('work_time2')->comment('後半労働時間');
            $table->time('am_pm_switch');
            $table->time('start_time')->comment('始業時刻');
            $table->time('end_time')->comment('終業時刻');
            $table->time('rest1_start_time')->nullable();
            $table->time('rest1_end_time')->nullable();
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
