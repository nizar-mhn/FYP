<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('studentID')->unique();
            $table->unsignedInteger('programID');
            $table->integer('year');
            $table->integer('semester');
            $table->integer('group');
            $table->string('studentName','40');
            $table->string('password');
            $table->string('email');
            $table->rememberToken();
            $table->foreign('programID')->references('programID')->on('programs');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
