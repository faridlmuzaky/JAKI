<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutiDetail extends Model
{
    use HasFactory;
    protected $table = 'master_cutis_detail';
    protected $fillable = [
        'master_cutis_id',
        'jenis_cuti',
        'alasan_cuti',
        'lama_cuti',
        'tgl_mulai',
        'tgl_akhir',
        'alamat_cuti',
        'telp',
        'setuju1',
        'perubahan1',
        'ditangguhkan1',
        'tidakdisetujui1',
        'keterangan',
        'atasan_langsung',
        'nama_atasan_langsung',
        'setuju2',
        'perubahan2',
        'ditangguhkan2',
        'tidakdisetujui2',
        'keterangan2',
        'pejabat_berwenang',
        'nama_pejabat_berwenang',
        'status',
        'posisi',
        'satker',
        'dok_cuti'
    ];
}
