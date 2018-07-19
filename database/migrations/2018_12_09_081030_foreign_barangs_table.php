<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForeignBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('barangs', function (Blueprint $table) 
        {
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->integer('penyimpanan_id')->unsigned();
            $table->foreign('penyimpanan_id')->references('id')->on('penyimpanans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('barangs', function (Blueprint $table) { 
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
}
