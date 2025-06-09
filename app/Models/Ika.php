<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ika extends Model
{
    use HasFactory;
    protected $table = 'izin_keluar';
    protected $fillable = [
        'nama_ttd',
        'jabatan_ttd',
        'nip_ika',
        'nama_ika',
        'awal',
        'akhir',
        'keperluan',
    ];
}
