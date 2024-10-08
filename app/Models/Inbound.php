<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbound extends Model
{
    use HasFactory;
    protected $fillable = [
        'tanggal',
        'do',
        'supplier_id',
        'tag_approved',
        'temp_status',
        'branch_id',
        'status_payment',
    ];
}
