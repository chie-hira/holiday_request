<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->date('report_date');
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('report_id')
                ->constrained('report_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('reason_id')
                ->constrained('reason_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('reason_detail')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('get_days', 8, 2);
            $table->boolean('am_pm')->default(0);
            $table->boolean('approval1')->default(0);
            $table->boolean('approval2')->default(0);
            $table->boolean('approval3')->default(0);
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
        Schema::dropIfExists('reports');
    }
}
