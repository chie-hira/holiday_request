<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_categories', function (Blueprint $table) {
            $table->id()->index()->comment('届出種類ID');
            $table->string('report_name')->unique();
            $table->integer('max_days')->nullable();
            $table->integer('max_times')->nullable();
            $table->foreignId('acquisition_id')
                ->constrained('acquisition_forms')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('report_categories');
    }
}
