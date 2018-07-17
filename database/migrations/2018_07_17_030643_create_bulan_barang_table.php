<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulanBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulan_barang', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('bulan_id')->unsigned()->index();
            $table->integer('barang_id')->unsigned()->index();
            
            $table->foreign('bulan_id')->references('id')->on('bulans')->onDelete('cascade');
            $table->foreign('barang_id')->references('id')->on('barangs')->onDelete('cascade');

            $table->integer('stok_awal');
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
        Schema::dropIfExists('bulan_barang');
    }
}
