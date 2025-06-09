<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;
    protected $table = 'absens';
    protected $fillable = [
        'id',
        'user_id',
        'date',
        'time_in',
        'lok_in',
        'time_break',
        'lok_break',
        'time_out',
        'lok_out',
    ];
}
