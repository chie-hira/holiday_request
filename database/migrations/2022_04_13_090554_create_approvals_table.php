<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id()->index();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('factory_id')
                ->nullable()
                ->constrained('factory_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('department_id')
                ->nullable()
                ->constrained('department_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('group_id')
                ->nullable()
                ->constrained('group_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('approval_id')
                ->nullable()
                ->constrained('approval_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
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
        Schema::dropIfExists('approvals');
    }
}
