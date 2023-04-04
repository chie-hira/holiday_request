<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('employee')->nullable()->unique();
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
            $table->foreignId('approval_id')
                ->nullable()
                ->constrained('approval_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
