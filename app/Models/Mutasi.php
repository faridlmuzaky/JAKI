<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    use HasFactory;
    protected $table = 'mutasi';
    protected $fillable = [
        'periode',
        'tgl_mulai',
        'tgl_akhir',
        'doc_pengumuman',
        'jenis',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted'
    ];
}
