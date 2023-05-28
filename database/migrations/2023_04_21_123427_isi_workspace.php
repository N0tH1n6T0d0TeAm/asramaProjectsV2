<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsiWorkspace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('isi_workspace',function(Blueprint $table){
           $table->id('id_bagian');
           $table->integer('id_workspace');
           $table->string('isi_tugas');
           $table->string('status'); 
           $table->bigInteger('cek')->nullable();
           $table->string('deskripsi')->nullable(); 
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