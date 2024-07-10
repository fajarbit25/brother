<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingOrder extends Model
{
    use HasFactory;
    protected $fillable = [
       'track_id',
       'order_id',
       'item_id',
        'teknisi',
        'helper',
    ];
}
