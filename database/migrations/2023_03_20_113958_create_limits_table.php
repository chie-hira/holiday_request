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
        # acquisition_daysに変更
        Schema::create('acquisition_days', function (Blueprint $table) {
            $table->id()->comment('残日数ID');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('report_id')
                ->constrained('report_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->float('remaining_days', 4, 1)->nullable();
            $table->integer('remaining_hours')->default(0);
            $table->integer('remaining_minutes')->default(0);
            $table->float('acquisition_days', 4, 1)->default(0);
            $table->integer('acquisition_hours')->default(0);
            $table->integer('acquisition_minutes')->default(0);
            // $table->float('remaining_days', 8, 5)->nullable();
            // $table->float('acquisition_days', 8, 5)->default(0);
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
        Schema::dropIfExists('acquisition_days');
    }
}
