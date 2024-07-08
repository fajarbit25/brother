<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalment extends Model
{
    use HasFactory;
    protected $fillable = [
        'asset_id',
        'jatuh_tempo',
        'pembiayaan',
        'jumlah',
        'lunas',
        'tag_lock',
    ];
}
