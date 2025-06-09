<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $table = 'master_cutis';
    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'tmt_cpns',
        'id_satker',
        'sisa_tahun_t2',
        'sisa_tahun_t1',
        'sisa_tahun_t0',
        'sisa_cs',
        'sisa_cm',
        'sisa_cap',
        'sisa_cbesar',
        'sisa_cltn',
        'tahun_anggaran',
        'aktif'
    ];
}
