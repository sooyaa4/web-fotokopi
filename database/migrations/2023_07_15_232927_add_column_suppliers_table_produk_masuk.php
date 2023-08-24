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
        Schema::table('produk_masuks', function (Blueprint $table) {
            $table->unsignedInteger('suppliers_id')->after('nota');
            $table->foreign('suppliers_id')->references('id')->on('suppliers')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produk_masuks', function (Blueprint $table) {
            $table->dropColumn('suppliers_id');
        });
    }
};
