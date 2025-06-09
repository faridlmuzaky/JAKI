<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratTugas extends Model
{
    use HasFactory;
    protected $table = 'surat_tugas';
    protected $fillable = [
        'no_surat_tugas',
        'tgl_surat_tugas',
        'menimbang',
        'maksud',
        'instansi_tujuan',
        'kota_tujuan',
        'alamat_tujuan',
        'tgl_awal',
        'tgl_akhir',
        'pejabat',
        'dipa'
    ];
}
