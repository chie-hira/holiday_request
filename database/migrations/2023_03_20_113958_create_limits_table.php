<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        # limitsからremainingsに変更
        Schema::create('remainings', function (Blueprint $table) {
            $table->id()->comment('残日数ID');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('report_id')
                ->constrained('report_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->float('remaining', 8, 5)->nullable();
            $table->timestamps();

            // 複合ユニーク制約
            $table->unique(['user_id', 'report_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('remainings');
    }
}
