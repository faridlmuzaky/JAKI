<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailCuti extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_cutis_detail', function (Blueprint $table) {
            $table->id();
            $table->string('master_cutis_id');
            $table->string('jenis_cuti');
            $table->string('alasan_cuti');
            $table->string('lama_cuti');
            $table->date('tgl_mulai');
            $table->date('tgl_akhir');
            $table->integer('sisa_cuti1');
            $table->integer('sisa_cuti0');
            $table->string('alamat_cuti');
            $table->string('telp');
            $table->string('setuju1');
            $table->string('perubahan1');
            $table->string('tangguhkan1');
            $table->string('atasan_langsung');
            $table->string('setuju2');
            $table->string('perubahan2');
            $table->string('tangguhkan2');
            $table->string('pejabat_berwenang');
            $table->string('status');
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
        Schema::dropIfExists('master_cutis_detail');
    }
}
