<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTglkunci extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('izbels', function (Blueprint $table) {
            $table->dateTime('tgl_kunci')
                ->after('keterangan')
                ->nullable();
            $table->text('status_kunci')
                ->after('tgl_kunci')
                ->nullable();
            $table->text('no_surat_balasan')
                ->after('status_kunci')
                ->nullable();
            $table->text('tgl_surat_balasan')
                ->after('no_surat_balasan')
                ->nullable();
            $table->text('tujuan_surat')
                ->after('tgl_surat_balasan')
                ->nullable();
            $table->text('produk')
                ->after('tujuan_surat')
                ->nullable();
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
