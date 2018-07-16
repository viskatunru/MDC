<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpirePemakaianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expire_pemakaian', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('expire_id')->unsigned()->index();
            $table->integer('pemakaian_id')->unsigned()->index();
            
            $table->foreign('expire_id')->references('id')->on('expires')->onDelete('cascade');
            $table->foreign('pemakaian_id')->references('id')->on('pemakaians')->onDelete('cascade');

            $table->integer('jumlah');
            
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
        Schema::dropIfExists('expire_pemakaian');
    }
}
