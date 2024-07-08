<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'user_id',
        'branch_id',
        'masuk',
        'izin',
        'alfa',
        'lembur',
        'off',
        'tag_absen',
        'alasan_lembur',
    ];
}
