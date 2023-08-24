<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calenders', function (Blueprint $table) {
            $table->id()->comment('カレンダー');
            $table->string('date');
            $table->foreignId('calender_id')
                ->constrained('calender_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('date_id')
                ->constrained('date_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['date', 'calender_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calenders');
    }
}
