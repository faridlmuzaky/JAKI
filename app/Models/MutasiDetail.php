<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiDetail extends Model
{
    use HasFactory;
    protected $table = 'mutasi_detail';
    protected $fillable = [
        'id_mutasi',
        'sk_baperjakat',
        'lampiran_sk',
        'satker_id',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
        'deleted'
    ];
}
