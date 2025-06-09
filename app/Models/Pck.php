<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pck extends Model
{
    use HasFactory;
    protected $table = 'kinerja';
    protected $fillable = [
        'username',
        'satker_id',
        'bulan',
        'tahun',
        'nilai',
        'file',
    ];
}
