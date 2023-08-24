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
        Schema::create('detail_produk_masuks', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->double('harga_satuan');
            $table->unsignedInteger('prod_masuk_id');
            $table->foreign('prod_masuk_id')->references('id')->on('produk_masuks')->onUpdate('cascade')->onDelete('restrict');
            $table->unsignedInteger('produk_id');
            $table->foreign('produk_id')->references('id')->on('produks')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_produk_masuks');
    }
};
