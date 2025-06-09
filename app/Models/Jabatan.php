<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';

    protected $fillable = [
        'nip',
        'tmt',
        'jabatan',
        'status',
        'unit_kerja',
        'satker',
        'tanggal_pelantikan',
        'nomor_sk',
        'pejabat_sk',
        'file_sk',
        'nomor_spp',
        'tanggal_spp',
        'file_spp',
        'nomor_spmt',
        'pejabat_spmt',
        'tmt_spmt',
        'tanggal_spmt',
        'file_spmt',
        'nomor_spmj',
        'pejabat_spmj',
        'tanggal_spmj',
        'file_spmj',
    ];
}
