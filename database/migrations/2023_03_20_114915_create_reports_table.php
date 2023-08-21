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
            $table->foreignId('sub_report_id')
                ->nullable()
                ->constrained('sub_report_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('reason_id')
                ->constrained('reason_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('reason_detail')->nullable();
            $table->foreignId('shift_id')
                ->constrained('shift_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->float('get_days', 8, 5);
            $table->integer('am_pm')->nullable()->default(null);
            $table->boolean('approval1')->default(0);
            $table->boolean('approval2')->default(0);
            // $table->boolean('approval3')->default(0);
            $table->boolean('approved')->default(0);
            $table->boolean('cancel')->default(0);
            $table->timestamps();

            // 論理削除
            $table->softDeletes();
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
