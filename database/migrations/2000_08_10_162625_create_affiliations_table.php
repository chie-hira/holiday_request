<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliations', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId('factory_id')
                ->constrained('factory_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('department_id')
                ->constrained('department_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table
                ->foreignId('group_id')
                ->constrained('group_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->timestamps();

            // 複合ユニーク制約
            $table->unique(['factory_id', 'department_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affiliations');
    }
}
