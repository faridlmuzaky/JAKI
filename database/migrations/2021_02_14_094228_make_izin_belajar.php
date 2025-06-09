<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeIzinBelajar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('izbels', function (Blueprint $table) {
            $table->id();
            $table->string('nip');
            $table->string('nama_pegawai');
            $table->string('jabatan');
            $table->string('golongan');
            $table->string('izin_pendidikan');
            $table->string('nama_universitas');
            $table->string('alamat_universitas');
            $table->string('nomor_s_keterangan');
            $table->date('tgl_s_keterangan');
            $table->string('program_studi');
            $table->string('tahun_akademik');
            $table->string('file_surat_pengantar');
            $table->string('file_sk_pns');
            $table->string('file_sk_kp');
            $table->string('file_ijazah');
            $table->string('file_s_universitas');
            $table->string('file_akreditasi');
            $table->string('file_pernyataan');
            $table->string('file_rekomendasi');
            $table->string('user_id');
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
        Schema::dropIfExists('izbels');
    }
}
