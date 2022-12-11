<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('fileID');
            $table->string('fileName');
            $table->string('fileType','40');
            $table->string('mime');
            $table->integer('noPage');
            $table->timestamp('dateUpload',0);
            $table->string('availability')->default('Available');
        });

        DB::statement("ALTER TABLE files ADD file MEDIUMBLOB");
        DB::statement("ALTER TABLE files ADD thumbnail MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
};
