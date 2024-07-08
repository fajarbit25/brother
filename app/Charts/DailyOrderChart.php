<?php

namespace App\Charts;

use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Support\Facades\DB;

class DailyOrderChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\LineChart
    {
        // $order = Order::whereMonth('tanggal_order', date('m'))
        //       ->groupBy('tanggal_order')
        //       ->get();
        
        $order = Order::select('tanggal_order', DB::raw('COUNT(*) as total_orders'))
               ->whereMonth('tanggal_order', date('m'))
               ->groupBy('tanggal_order')
               ->get();

        $dataOrder = []; // Inisialisasi $dataOrder
        $dataTotalOrder = []; // Inisialisasi $dataTotalOrder
        
        foreach($order as $or) {
            $totalOrder = Order::where('tanggal_order', $or->tanggal_order)->count();
            $dataOrder[] = $or->tanggal_order;
            $dataTotalOrder[] = $totalOrder;
        }
        
        return $this->chart->lineChart()
            ->setTitle('Report Daily Order')
            ->setSubtitle('Chart Order Harian.')
            ->addData('Total Order', $dataTotalOrder)
            ->setFontColor('#ff6384')
            ->setColors(['#FFC107', '#303F9F'])
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setXAxis($dataOrder);
    }
}
