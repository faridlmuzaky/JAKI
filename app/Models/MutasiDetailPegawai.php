<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiDetailPegawai extends Model
{
    use HasFactory;
    protected $table = 'mutasi_detail_pegawai';
    protected $fillable = [
        'id_mutasi_detail',
        'nip',
        'nama',
        'tempat_lahir',
        'tgl_lahir',
        'golongan',
        'tmt_golongan',
        'jabatan_lama',
        'tmt_jabatan_lama',
        'satker_asal',
        'jabatan_baru',
        'satker_tujuan',
        'catatan',
        'file_pendukung',
        'tgl_usulan',
        'status_usulan',
        'catatan_baperjakat',
        'syarat_jabatan',
        'tanggal_pensiun',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted'
    ];
}
