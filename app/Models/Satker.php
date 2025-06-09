<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Satker extends Model
{
    use HasFactory;
    protected $table = 'satkers';
    protected $fillable = [
        'kode_satker',
        'nama_satker',
        'alamat_satker',
        'no_telp',
        'email',
        'penandatangan',
        'jabatan',
        'nip',
        'logo'
    ];
}
