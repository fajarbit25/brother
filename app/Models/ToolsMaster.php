<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToolsMaster extends Model
{
    use HasFactory;
    protected $fillable = [
        'tools_name',
        'merk',
        'nomor_seri',
        'stock',
        'stock_teknisi',
        'branch_id',
    ];
}
