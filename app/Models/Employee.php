<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tanggal_masuk',
        'gender',
        'ktp',
        'kk',
        'tempat_lahir',
        'tanggal_lahir',
        'telpon_darurat',
        'pendidikan',
        'alamat',
    ];
}
