<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LaporanPerkembanganSiswa extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_perkembangan', function (Blueprint $table) {
            $table->id("id_perkembangan");
            $table->string('judul_buku')->nullable();
            $table->string('isi_buku',4000)->nullable();
            $table->string('nis_siswas')->nullable();
            $table->string('id_pengguna')->nullable();
            $table->enum("level_kategori", ['Umum','Confidensial','Tidak Ada Kategori'])->nullable();
            $table->string('tanggal')->nullable();
            
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
        //
    }
}