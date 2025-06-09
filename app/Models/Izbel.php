<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izbel extends Model
{
    use HasFactory;
    protected $table = 'izbels';
    protected $fillable = [
        'nip',
        'nama_pegawai',
        'jabatan',
        'golongan',
        'izin_pendidikan',
        'nama_universitas',
        'alamat_universitas',
        'nomor_s_keterangan',
        'tgl_s_keterangan',
        'program_studi',
        'tahun_akademik',
        'file_surat_pengantar',
        'file_sk_pns',
        'file_s_universitas',
        'file_akreditasi',
        'file_pernyataan',
        'file_rekomendasi',
        'user_id',
        'status',
        'keterangan',
        'status_kunci',
        'tgl_kunci',
        'no_surat_balasan',
        'tgl_surat_balasan',
        'tujuan_surat',
        'produk'
    ];
}
