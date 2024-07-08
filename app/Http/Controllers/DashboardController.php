<?php

namespace App\Http\Controllers;

use App\Charts\DailyOrderChart;
use App\Models\Asset;
use App\Models\Attendance;
use App\Models\Cashbon;
use App\Models\Costumer;
use App\Models\Invoice;
use App\Models\Operational;
use App\Models\Order;
use App\Models\Outbound;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(DailyOrderChart $chart)//:view
    {
        if(Auth::user()->privilege == 9){
            return redirect('/teknisi');
        }
        $loadAsset = Asset::count();
        $asset = $loadAsset ?? 0;
        
        $data = [
            'title'     => 'Dashboard',
            'order'     => Order::count(),
            'cost'      => Costumer::count(),
            'employee'  => User::count(),
            'notif_inv'   => Invoice::where('status', 'Review')->count(),
            'asset'     => $asset,
            'chart'     => $chart->build(),
        ];

        return view('dashboard', $data);
    }

    public function teknisi()//: View
    {
        /**Cek kehadiran */
        $month = date('m');
        $izin = Attendance::where('user_id', Auth::user()->id)->whereMonth('tanggal', $month)->sum('izin');
        $alfa = Attendance::where('user_id', Auth::user()->id)->whereMonth('tanggal', $month)->sum('alfa');

        $absen = $izin+$alfa;

        $data = [
            'title'         => 'Dashboard Teknisi',
            'result'        => Order::where('progres', '!=', 'Complete')
                                ->where('teknisi', Auth::user()->id)
                                ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->get(),
            'order'         => Order::where('teknisi', Auth::user()->id)->whereMonth('tanggal_order', $month)->count(),
            'cashbon'       => Cashbon::where('user_id', Auth::user()->id)->where('status', 'Open')->where('approved', 1)->sum('amount'),
            'absen'         => $absen,
            'komplain'      => 0,
            'notif_order'   => Order::where('teknisi', Auth::user()->id)->where('progres', 'Delivered')->count(),
            'notif_inbound' => Outbound::where('outbounds.teknisi_id', Auth::user()->id)->where('reservasi_approved', 0)
                                ->select('idout as id', 'reservasi_id')
                                ->count(),
            'notif_cashbon' => Cashbon::where('user_id', Auth::user()->id)->where('approved', 0)->count(),
        ];
        return view('dash_teknisi', $data);

    }

    public function table()
    {
        $data = [
            'result'    => Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->join('users', 'users.id', '=', 'orders.teknisi')
                                ->where('orders.branch_id', Auth::user()->branch_id)
                                ->where('progres', '!=', 'Complete')->paginate(10),
        ];
        return view('table_dashboard', $data);
    }
}
