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
        Schema::create('jenis_produks', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nama');
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');         
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
        Schema::dropIfExists('jenis_produks');
    }
};
