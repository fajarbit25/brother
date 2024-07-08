<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Rfid;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function orderApi()
    {
        $order = Order::select('uuid', 'tanggal_order', 'costumer_id', 'status')->get();
        return response()->json($order);
    }

    public function rfid($token, $rfid)
    {
        $tokenEksist = '123456';
        if($token == $tokenEksist){
            Rfid::create([
                'rfid'  => $rfid
            ]);

            return response()->json([
                'status'     => 200,
                'message'      => 'Berhasil!',
            ]);

        }else{
            return response()->json([
                'status'     => 500,
                'message'      => 'Token tidak terdaftar',
            ]);
        }
    }
}
