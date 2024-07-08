<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashbon extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'tanggal',
        'jam',
        'status',
        'approved',
        'branch_id',
        'amount',
        'alasan_cashbon',
];
}
