<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apel extends Model
{
    use HasFactory;
    protected $table = 'absensi_apel';
    protected $fillable = [
        'id',
        'user_id',
        'date',
        'time_in',
        'type',
        'location',
        'foto',
	'face_message'
    ];
}
