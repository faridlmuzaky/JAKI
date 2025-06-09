<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzbelAudit extends Model
{
    use HasFactory;
    protected $table = 'Izbels_Audit';
    protected $fillable = [
        'izbels_id',
        'users_id',
        'description'
    ];
}
