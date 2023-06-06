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
            $table->foreignId('factory_id') # メインの所属工場
                ->constrained('factory_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('department_id') # メインの所属課、同列複数の場合(工場長)は無所属
                ->constrained('department_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('group_id') # メインのグループ、同列複数の場合は無所属
                ->constrained('group_categories')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->date('adoption_date')->nullable();
            $table->string('birthday')->nullable();
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
