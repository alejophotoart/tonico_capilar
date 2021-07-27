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
            $table->bigIncrements('id');
            $table->string('identification')->unique();
            $table->string('name', 100)->nullable();
            $table->string('phone',100)->nullable();
            $table->string('email')->unique();
            $table->binary('img')->nullable();
            $table->string('link', 255)->nullable();
            $table->string('password');

            $table->integer('type_identification_id')->unsigned()->nullable();
            $table->foreign('type_identification_id')->references('id')->on('type_identifications');

            $table->integer('role_id')->unsigned()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');

            $table->integer('city_id')->unsigned()->nullable();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->bigInteger('employee_state_id')->unsigned()->default(1);
            $table->foreign('employee_state_id')->references('id')->on('state_employees');

            $table->boolean('active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
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
