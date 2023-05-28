<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaporanPost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('laporan_post',function(Blueprint $table){
           $table->id('id_laporan');
           $table->string('id_pengguna')->nullable();
           $table->string('id_roles')->nullable();
           $table->string('gambar')->nullable();
           $table->string('deskripsi',10000)->nullable();
           $table->string('nama_siswass')->nullable(); 
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
    }
}