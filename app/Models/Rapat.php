<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    use HasFactory;
    protected $table = 'master_rapat';
    protected $fillable = [
        'id',
        'deskripsi',
        'tgl_rapat',
        'time_in',
        'time_out',
        'notulensi',
        'notulis',
        'pimpinan',
        'jenis_rapat',
        'status',
        'id_rapat',
        'tempat',
        'foto',
        'isPakaian',
        'Pakaian'
    ];
}
