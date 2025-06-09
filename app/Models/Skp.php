<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skp extends Model
{
    use HasFactory;
    protected $table = 'skp';
    protected $fillable = [
        'username', 'predikat_kinerja', 'periode_skp', 'tahun', 'file', 'file_ttd_kpta', 'created_by', 'updated_by'
    ];
}
