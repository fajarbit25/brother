<?php

namespace App\Charts;

use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class DailyIncomeChart
{
    protected $incomeChart;

    public function __construct(LarapexChart $chart)
    {
        $this->incomeChart = $chart;
    }

    // public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    // {

    //     // $order = Order::select('tanggal_order', DB::raw('SUM(total_price) as total_prices'))
    //     //        ->whereMonth('tanggal_order', date('m'))
    //     //        ->groupBy('tanggal_order')
    //     //        ->get();

    //     $order = Order::select(
    //             DB::raw('DATE(tanggal_order) as tanggal_order'),
    //             DB::raw('SUM(total_price) as total_prices')
    //         )
    //         ->whereMonth('tanggal_order', date('m'))
    //         ->groupBy(DB::raw('DATE(tanggal_order)'))
    //         ->orderBy('tanggal_order', 'asc')
    //         ->get();

    //     $dataOrder = []; // Inisialisasi $dataOrder
    //     $dataTotalOrder = []; // Inisialisasi $dataTotalOrder
        
    //     foreach($order as $or) {
    //         $totalOrder = Order::where('tanggal_order', $or->tanggal_order)->sum('total_price');
    //         $dataOrder[] = $or->tanggal_order;
    //         // $dataTotalOrder[] = $totalOrder;
    //         if ($totalOrder >= 1000) {
    //             $short = number_format($totalOrder / 1000, 0) . 'K';
    //         } else {
    //             $short = number_format($totalOrder, 0);
    //         }
    //     }

    //     return $this->incomeChart->lineChart()
    //         ->setTitle('Sales during 2021.')
    //         ->setSubtitle('Total Nilai Transaksi.')
    //         ->addData('Total Transaksi', $dataTotalOrder)
    //         // ->addData('Digital sales', [70, 29, 77, 28, 55, 45])
    //         ->setXAxis($dataOrder);
    // }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        // $order = Order::whereMonth('tanggal_order', date('m'))
        //       ->groupBy('tanggal_order')
        //       ->get();
        
        $order = Order::select('tanggal_order', DB::raw('SUM(total_unit) as total_units'))
               ->whereMonth('tanggal_order', date('m'))
               ->groupBy('tanggal_order')
               ->get();

        $dataOrder = []; // Inisialisasi $dataOrder
        $dataTotalOrder = []; // Inisialisasi $dataTotalOrder
        
        foreach($order as $or) {
            $totalOrder = Order::where('tanggal_order', $or->tanggal_order)->sum('total_price');
            $dataOrder[] = $or->tanggal_order;
            $dataTotalOrder[] = $totalOrder;
        }
        
        return $this->incomeChart->lineChart()
            ->setTitle('Report Daily Income')
            ->setSubtitle('Chart Transaksi Harian.')
            ->addData('Total Price', $dataTotalOrder)
            ->setFontColor('#3ef308')
            ->setColors(['#0869f3', '#0869f3'])
            ->setMarkers(['#FF5722', '#0869f3'], 7, 10)
            ->setXAxis($dataOrder);
    }
}
