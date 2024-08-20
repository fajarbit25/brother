<?php

namespace App\Http\Livewire\Order;

use App\Models\Operational;
use App\Models\Order;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class PekerjaanJasa extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $loading = false;
    public $start;
    public $end;
    public $jenis;
    public $teknisi;
    private $order;
    public $dataTeknisi;
    public $totalJasa;
    public $totalMaterial;
    public $modalMaterial;
    public $totalDiscount;
    public $totalPPN;
    public $row = 10;
    public $dataOps;
    public $sumUnit;

    public function mount()
    {
        $thisMonth = date('Y-m');
        $startDate = $thisMonth . "-01";
        
        // Menggunakan DateTime untuk mendapatkan tanggal akhir bulan ini
        $date = new \DateTime($startDate);
        $date->modify('last day of this month');
        $endDate = $date->format('Y-m-d');
        
        $this->start = $startDate;
        $this->end = $endDate;

        $this->teknisi = 'ALL';
        $this->getDataTeknisi();
    }

    public function loadAll()
    {
        $this->getDataOrder();
        $this->getTotalPrice();
        $this->getDataOps();
    }

    public function render()
    {
        $this->loadAll();
        return view('livewire.order.pekerjaan-jasa',[
            'order'     => $this->order,
        ]);
    }

    public function getDataOrder()
    {
        if($this->teknisi != "ALL"){
            $data = Order::leftJoin('ordermaterials', 'ordermaterials.order_id', '=', 'orders.idorder')
                        ->leftJoin('products', 'products.diproduct', '=', 'ordermaterials.product_id')
                        ->leftJoin('units', 'units.idunit', '=', 'products.satuan')
                        ->leftJoin('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
                        ->leftJoin('items', 'items.iditem', '=', 'orderitems.item_id')
                        ->leftJoin('users as teknisi', 'orders.teknisi', '=', 'teknisi.id')
                        ->leftJoin('users as helper', 'orders.helper', '=', 'helper.id')
                        ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                        ->where('orders.teknisi', $this->teknisi)
                        ->whereBetween('orders.tanggal_order', [$this->start, $this->end])
                        ->where('orders.status', 'Close')
                        ->select('uuid', 'costumer_name', 'item_name', 'orderitems.price as jasa', 'orderitems.disc', 'orderitems.qty as qty_item',
                        'ordermaterials.price as material', 'teknisi.name as teknisi', 'helper.name as helper', 'ppn', 'harga_jual',
                        'product_name', 'ordermaterials.qty as qty_material', 'units.unit_code as satuan', 'tanggal_order', 'orderitems.idoi')
                        ->paginate($this->row);
        }else{
            $data = Order::leftJoin('ordermaterials', 'ordermaterials.order_id', '=', 'orders.idorder')
                        ->leftJoin('products', 'products.diproduct', '=', 'ordermaterials.product_id')
                        ->leftJoin('units', 'units.idunit', '=', 'products.satuan')
                        ->leftJoin('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
                        ->leftJoin('items', 'items.iditem', '=', 'orderitems.item_id')
                        ->leftJoin('users as teknisi', 'orders.teknisi', '=', 'teknisi.id')
                        ->leftJoin('users as helper', 'orders.helper', '=', 'helper.id')
                        ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                        ->whereBetween('orders.tanggal_order', [$this->start, $this->end])
                        ->where('orders.status', 'Close')
                        ->select('uuid', 'costumer_name', 'item_name', 'orderitems.price as jasa', 'orderitems.disc', 'orderitems.qty as qty_item',
                        'ordermaterials.price as material', 'teknisi.name as teknisi', 'helper.name as helper', 'ppn', 'harga_jual',
                        'product_name', 'ordermaterials.qty as qty_material', 'units.unit_code as satuan', 'tanggal_order', 'orderitems.idoi')
                        ->paginate($this->row);
        }
        $this->order = $data;
    }

    public function getDataTeknisi()
    {
        $data = User::where('privilege', 9)->select('id', 'name')->get();
        $this->dataTeknisi = $data;
    }

    public function getTotalPrice()
    {
        if($this->teknisi != "ALL"){
            // Query to join tables and filter data
            $data = Order::leftJoin('ordermaterials', 'ordermaterials.order_id', '=', 'orders.idorder')
            ->leftJoin('products', 'products.diproduct', '=', 'ordermaterials.product_id')
            ->join('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
            ->leftJoin('items', 'items.iditem', '=', 'orderitems.item_id')
            ->where('orders.teknisi', $this->teknisi)
            ->whereBetween('orders.tanggal_order', [$this->start, $this->end])
            ->where('orders.status', 'Close')
            ->select(
                'orderitems.price as jasa', 
                'orderitems.disc', 
                'ordermaterials.price as material',
                'ppn', 'orders.uuid', 'harga_jual',
                'harga_beli',
            )
            ->get();

            $item = Order::join('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
            ->where('orders.teknisi', $this->teknisi)
            ->whereBetween('orders.tanggal_order', [$this->start, $this->end])
            ->where('orders.status', 'Close')
            ->select(
                'orderitems.price as jasa', 
                'orderitems.disc', 
                'ppn', 'orderitems.qty as qty_item',
            )
            ->get();

            // Calculate the total values
            $this->totalJasa = $item->sum('jasa');
            $this->totalMaterial = $data->sum('harga_jual');
            $this->modalMaterial = $data->sum('harga_beli');
            $this->totalDiscount = $item->sum('disc');
            $this->totalPPN = $item->sum('ppn') ?? 0;
            $this->sumUnit = $item->sum('qty_item') ?? 0;
            
        }else{
             // Query to join tables and filter data
             $data = Order::leftJoin('ordermaterials', 'ordermaterials.order_id', '=', 'orders.idorder')
             ->leftJoin('products', 'products.diproduct', '=', 'ordermaterials.product_id')
             ->join('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
             ->leftJoin('items', 'items.iditem', '=', 'orderitems.item_id')
             //->where('orders.teknisi', $this->teknisi)
             ->whereBetween('orders.tanggal_order', [$this->start, $this->end])
             ->where('orders.status', 'Close')
             ->select(
                 'orderitems.price as jasa', 
                 'orderitems.disc', 
                 'ordermaterials.price as material',
                 'ppn', 'harga_jual'
             )
             ->get();

             $item = Order::join('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
             ->whereBetween('orders.tanggal_order', [$this->start, $this->end])
             ->where('orders.status', 'Close')
             ->select(
                 'orderitems.price as jasa', 
                 'orderitems.disc', 
                 'ppn', 'orderitems.qty as qty_item',
             )
             ->get();
 
             // Calculate the total values
             $this->totalJasa = $item->sum('jasa');
             $this->totalMaterial = $data->sum('harga_jual');
             $this->totalDiscount = $item->sum('disc');
             $this->totalPPN = $item->sum('ppn') ?? 0;
             $this->sumUnit = $item->sum('qty_item') ?? 0;
        }
    }

    

    public function getDataOps()
    {
        $ops = Operational::join('opsitems', 'opsitems.id', '=', 'operationals.jenis')
                ->where('operationals.tipe', 'OUT')->where('status', 'Success')
                ->whereBetween('operationals.created_at', [$this->start, $this->end])
                ->select('amount', 'item')->get();
        $this->dataOps = $ops;
    }
}
