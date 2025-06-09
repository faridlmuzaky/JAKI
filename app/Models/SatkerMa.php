<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatkerMa extends Model
{
    use HasFactory;
    protected $table = 'satker';
    protected $fillable = [
        'id',
        'kode_satker',
        'nama_satker',
        'level',
        'alamat_satker',
        'no_telp',
        'email',
        'penandatangan',
        'jabatan',
        'nip',
        'logo',
        'id_banding',
        'nama_banding',
        'latitude',
        'longitude',
        'website',
        'id_lingkungan',
        'lingkungan',
    ];
}
