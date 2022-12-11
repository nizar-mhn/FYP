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
        Schema::create('order_printing_infos', function (Blueprint $table) {
            $table->increments('orderPrintingInfoID');
            $table->unsignedInteger('fileID');
            $table->string('bindingType');
            $table->string('color');
            $table->string('pageFormat');
            $table->integer('numCopies');
            $table->string('location');
            $table->foreign('fileID')->references('fileID')->on('files');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_printing_infos');
    }
};
