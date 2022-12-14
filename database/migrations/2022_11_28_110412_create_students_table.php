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
            $table->string('studentName','40');
            $table->string('password');
            $table->string('email');
            $table->unsignedInteger('programDetailsID');
            $table->rememberToken();
            $table->foreign('programDetailsID')->references('programDetailsID')->on('program_details');

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
