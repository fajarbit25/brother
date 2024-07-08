<?php

namespace App\Http\Controllers;

use App\Exports\ExportsOrder;
use App\Models\Branch;
use App\Models\Costumer;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Ordermaterial;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Middleware\OrderMiddleware;
use App\Models\Merk;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('order');
    }
    /**Order Menu */
    public function index(): View
    {
        $data = [
            'title'     => 'Orders',
            'item'      => Item::all(),
            'costumers' => Costumer::all(),
            'teknisi'   => User::where('privilege', 9)->where('teknisi_order_count', '<=', 3)->get(),
            'helper'    => User::where('privilege', 10)->get(),
        ];
        return view('order.index', $data);
    }

    /**Detail Order */
    public function show($id) //: View
    {
         $load = Order::where('uuid', $id)->first();
        $data = [
            'title'     => 'Detail Order BRO9842',
            'order'     => $load,
            'costumer'  => Costumer::where('idcostumer', $load->costumer_id)->first(),
            'teknisi'   => User::where('id', $load->teknisi)->first(),
            'helper'    => User::where('id', $load->helper)->first(),
            'order_item'=> Orderitem::where('order_id', $load->uuid)->join('items', 'items.iditem', 'orderitems.item_id')->get(),
            'timeline'  => Timeline::where('order_id', $load->idorder)
                            ->join('users', 'users.id', '=', 'timelines.user_id')
                            ->select('timelines.keterangan', 'timelines.created_at', 'timelines.timeline_status', 'users.name')
                            ->get(),
            'material'  => Ordermaterial::where('order_id', $load->idorder)->join('products', 'products.diproduct', '=', 'ordermaterials.product_id')
                            ->join('units', 'units.idunit', '=', 'products.satuan')->select('product_name as item', 'qty', 'unit_code as satuan', 'price', 'jumlah')
                            ->get(),
                            
            'sum_mat'   => Ordermaterial::where('order_id', $load->idorder)->sum('jumlah'),
        ];
        return view('order.show', $data);
    }

    /**Edit / New Order */
    public function edit($uuid): View
    {
        $data = [
            'title'         => 'Form Order',
            'costumers'     => Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')->where('uuid', $uuid)->first(),
            'item'          => Item::all(),
            'teknisi'       => User::where('privilege', 9)->get(),
            'helper'        => User::where('privilege', 10)->get(),
            'order'         => Order::where('uuid', $uuid)->first(),
            'merk'          => Merk::all(),
        ];
        return view('order.form', $data);
    }

    /**Load Ajax table Form */
    public function loadForm($uuid): View
    {
        $data = [
            'result'        => DB::table('orderitems')//->where('status_invoice', NULL)
                                ->join('orders', 'orders.uuid', '=', 'orderitems.order_id')
                                ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->join('items', 'items.iditem', '=', 'orderitems.item_id')
                                ->where('order_id', $uuid)->get(),
            'order'         => Order::where('uuid', $uuid)->first(),
        ];
        return view('order.tableForm', $data);
    }

    /**Store data order */
    public function store(Request $request)
    {
        /**Check Order Active */
        $chek = Order::where('branch_id', Auth::user()->branch_id)->where('progres', 'New')->count();
        if($chek == 1){
            $load = Order::where('branch_id', Auth::user()->branch_id)->where('progres', 'New')->first();
            $uuid = $load->uuid;
            return response(['success' => 'fail', 'uuid' => $uuid]);
        }

        /**create UUID */
        $tahun = date('y');
        $bulan = date('m');
        $kodeAwal = 'BTI'.$tahun.$bulan;

        $count = Order::where('uuid', 'LIKE', '%'.$kodeAwal.'%')->count();
        $jumlahOrder = substr($count, -3);
        $penjumlahan = 1000;
        $hasilPenjumlahan = $penjumlahan+$jumlahOrder;


        $nomorOrder = 'BTI'.$tahun.$bulan.$hasilPenjumlahan;


        $data = [
            'uuid'          => $nomorOrder,
            'tanggal_order' => $request->tanggal,
            'costumer_id'   => $request->costumer_id,
            'total_unit'    => 0,
            'progres'       => 'New',
            'status'        => 'Open',
            'tag_invoice'   => 0,
            'total_price'   => 0,
            'teknisi'       => NULL,
            'helper'        => NULL,
            'jadwal'        => NULL,
            'request_jam'   => NULL,
            'branch_id'     => Auth::user()->branch_id,
            'ppn'           => NULL,
            'discount'      => 0,
        ];
        $order = Order::create($data);

        /**Added Timeline */
        $idorder = $order->id;
        Timeline::create([
            'order_id'          => $idorder,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order berhasil diinput',
            'keterangan'        => 'Order Created'
        ]);

        /**Update jumlah order */
        $loadCostumer = Costumer::where('idcostumer', $request->costumer_id)->first();
        $jumlahAwal = $loadCostumer->jumlah_order;
        $jumlahAkhir = $jumlahAwal+1;
        Costumer::where('idcostumer', $request->costumer_id)->update(['jumlah_order' => $jumlahAkhir]);

        return response(['success' => 'true', 'uuid' => $nomorOrder]);
    }

    /**Add order list */
    public function orderAdd(Request $request)
    {
        $request->validate([
            'item'      => 'required',
            'merk'      => 'required',
            'price'     => 'required',
            'qty'       => 'required',
            'disc'      => 'required',
        ]);

        $inputPrice = $request->price*$request->qty;
        $disc = $request->disc;

        //Mengambil informasi dari order
        $load = Order::where('uuid', $request->uuid)->first();
        $loadPrice = $load->total_price;
        $newPrice = $loadPrice+$inputPrice;
        $loadDisc = $load->discount;

        $unit = $load->total_unit;
        $total_unit = $unit+1;

        Order::where('uuid', $request->uuid)->update([
            'total_price'   => $newPrice-$disc, 
            'discount'      => $loadDisc+$disc,
            'total_unit'    => $total_unit,
        ]);

        $data = [
            'order_id'      => $request->uuid,
            'merk'          => $request->merk,
            'pk'            => $request->pk,
            'qty'           => $request->qty,
            'price'         => $inputPrice,
            'disc'          => $disc,
            'lantai'        => 0,
            'ruangan'       => 0,
            'item_id'       => $request->item,
            'branch_id_order'   => Auth::user()->branch_id,
        ];
        Orderitem::create($data);
        return response(['success' => 'Data Order berhasil ditambahkan!']);
    }

    /**Table Order */
    public function table(): View
    {
        $orders = DB::table('orders')
                    ->leftJoin('users as teknisi', 'orders.teknisi', '=', 'teknisi.id')
                    ->leftJoin('users as helper', 'orders.helper', '=', 'helper.id')
                    ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                    ->join('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
                    ->select(
                        // Pilih kolom yang dibutuhkan dari tabel orders
                        'orders.idorder', 'orders.uuid', 'orders.branch_id',
                        'orders.tanggal_order', 'orders.teknisi', 'orders.progres',
                        'orders.total_price', 'orders.discount', 'orders.ppn',
                        'orders.keterangan', 'orders.payment',

                        // Pilih kolom yang dibutuhkan dari tabel users (teknisi)
                        'teknisi.name as teknisi_name',
                        
                        // Pilih kolom yang dibutuhkan dari tabel users (helper)
                        'helper.name as helper_name',
                        
                        // Pilih kolom yang dibutuhkan dari tabel costumers
                        'costumers.costumer_status', 'costumers.costumer_name',
                    )
                    ->where('orders.branch_id', Auth::user()->branch_id)
                    ->where('progres', '!=', 'Created')
                    ->where('progres', '!=', 'Cancel')->where('status_invoice', null)->get();
        $data = [
            'result'    => $orders,
            // 'totalMaterial' => Ordermaterial::join('orders', 'orders.idorder', '=', 'ordermaterials.order_id')
            //                                 ->where('orders.branch_id', Auth::user()->branch_id)
            //                                 ->where('progres', '!=', 'Cancel')->where('status_invoice', null)
            //                                 ->select('ordermaterials.id as idmaterial', 'orders.idorder', 'order_id', 'ordermaterials.jumlah')
            //                                 ->get(),
        'totalMaterial' => Ordermaterial::join('orders', 'orders.idorder', '=', 'ordermaterials.order_id')
            ->where('orders.branch_id', Auth::user()->branch_id)
            ->where('progres', '!=', 'Cancel')
            ->whereNull('status_invoice') // alternatif menggunakan where('status_invoice', null)
            ->whereRaw('CAST(ordermaterials.jumlah AS SIGNED) > 0') // pastikan jumlah adalah numerik dan positif
            ->select('ordermaterials.id as idmaterial', 'orders.idorder', 'order_id', 'ordermaterials.jumlah')
            ->get(),
        ];

        return view('order.table', $data);
    }



    public function tableJadwal()
    {
        $data = [
            'result'    => DB::table('orders')->where('progres', '!=', 'Complete')
                            ->join('users as teknisi', 'orders.teknisi', '=', 'teknisi.id')
                            ->join('users as helper', 'orders.helper', '=', 'helper.id')
                            ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                            ->join('orderitems', 'orderitems.order_id', '=', 'orders.uuid')
                            ->join('items', 'items.iditem', '=', 'orderitems.item_id')
                            ->select('orders.*', 'teknisi.name as teknisi_name', 'helper.name as helper_name', 'teknisi.teknisi_order_count as count', 'costumers.*', 'items.*')
                            ->where('orders.branch_id', Auth::user()->branch_id)->get(),
        ];

        return view('order.tableJadwal', $data);
    }

    /**Delete Item */
    public function itemDelete(Request $request)
    {
        /**variabel id */
        $id = $request->id;
        $uuid = $request->uuid;

        /**load total harga order */
        $load = Order::where('uuid', $uuid)->first();
        $totalPrice = $load->total_price;
        $discount = $load->discount;

        /**load Harga yg akan dihapus */
        $loadPrice = Orderitem::where('idoi', $id)->first();
        $disc = $loadPrice->disc;
        $priceItem = $loadPrice->price-$disc;

        /**Total Unit */
        $unitAwal = $load->total_unit;
        $unitAkhir = $unitAwal-1;

        /**Total Akhir */
        $finalPrice = $totalPrice-$priceItem;
        Order::where('uuid', $request->uuid)->update([
            'total_price'       => $finalPrice, 
            'total_unit'        => $unitAkhir,
            'discount'          => $discount-$disc,
        ]);

        /**Menghapus Item */
        Orderitem::where('idoi', $id)->delete();
        return response(['success' => 'Deleted!']);
    }

    /**Cek Jadwal Teknisi */
    public function cekJadwalTeknisi($id)
    {
        $data = Orderitem::where('tanggal_order', date('Y-m-d'))->where('teknisi', $id)->get();
        return json_encode($data);
    }

    /**Submit Order */
    public function submit(Request $request)
    {
        $request->validate([
            'id'        => 'required',
        ]);

        $idorder = $request->id;

        Order::where('idorder', $idorder)->update([
            'progres'       => 'Created',
        ]);

        return response(['success' => 'Data berhasil disubmit!']);
    }

    /**Jadwal */
    public function jadwal():View
    {
        $data = [
            'title' => 'Jadwal',
        ];
        return view('order.jadwal', $data);
    }
    /**submit Jadwal */
    public function submitJadwal(Request $request)
    {
        $request->validate([
            'idorder'   => 'required',
        ]);
        $idorder = $request->idorder;
        $teknisi = $request->teknisi;
        $helper = $request->helper;
        $data = [
            //'jadwal'        => $request->jadwalEdit,
            //'request_jam'   => $request->jamEdit,
            'teknisi'       => $teknisi,
            'helper'        => $helper,
            'progres'       => 'Delivered',
        ];
        Order::where('idorder', $idorder)->update($data);

        /**Update Jumlah order teknsi per-H */
        $loadTeknisi = User::where('id', $teknisi)->first();
        $orderTeknisi = $loadTeknisi->teknisi_order_count;
        $newOrderTeknisi = $orderTeknisi+1;
        User::where('id', $teknisi)->update(['teknisi_order_count' => $newOrderTeknisi]);
        User::where('id', $helper)->update(['teknisi_order_count' => $newOrderTeknisi]);

        /**Added Timeline */
        Timeline::create([
            'order_id'          => $idorder,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order telah didistribusikan ke teknisi',  
            'keterangan'        => 'Order Delivered'
        ]);
        return response(['success' => 'Jadwal pekerjaan berhasil diatur!']);
    }
    /**cek Jadwal */
    public function cekJadwal(Request $request)
    {
        $jadwal = $request->jadwalEdit;
        $teknisi = $request->teknisi;

        $cek = Order::where('progres', '!=', 'Complete')->where('teknisi', $teknisi)->where('jadwal', $jadwal)->count();

        if($cek > 0){
            return response(['success' => 'true']);
        }else{
            return response(['success' => 'false']);
        }
    }

    /**Approve Nota */
    public function approveNota(Request $request)
    {
        $orderid = $request->idorder;
        $load = Order::where('idorder', $orderid)->first();
        Order::where('idorder', $orderid)->update([
            'progres'   => 'Complete',
        ]);

        /**update count order teknisi */
        $loadTeknisi = User::where('id', $load->teknisi)->first();
        $loadHelper = User::where('id', $load->helper)->first();
        $countTeknisi = $loadTeknisi->teknisi_order_count-1;
        $countHelper = $loadHelper->teknisi_order_count-1;

        User::where('id', $loadTeknisi->id)->update(['teknisi_order_count' => $countTeknisi]);
        User::where('id', $loadHelper->id)->update(['teknisi_order_count' => $countHelper]);

        return response()->json(['success' => 'Nota berhasil diapprove!', 'uuid' => $load->uuid]);
    }

    /**Reject Nota */
    public function rejectNota(Request $request)
    {
        $request->validate([
            'idorder'   => 'required',
        ]);
        $orderid = $request->idorder;
        $load = Order::where('idorder', $orderid)->first();
        Order::where('idorder', $orderid)->update([
            'progres'   => 'Processing',
        ]);
        return response()->json([
            'status'    => 200,
            'success'   => 'Nota di reject!',
        ]);
    }

    /**proses payment */
    public function prosesPayment(Request $request)
    {
        $order = $request->idorder;
        $method = $request->method;

        if($method == 'Pending'){

            /**Delete Invoice */
            Invoice::where('order_id', $order)->delete();

            Order::where('idorder', $order)->update([
                'payment'       => $method,
            ]);
            return response()->json(['success' => 'Payment method is update!']);

        }elseif($method == 'Termin'){

            /**Delete Invoice */
            Invoice::where('order_id', $order)->delete();

            Order::where('idorder', $order)->update([
                        'payment'   => $method,
                        'due_date'  => $request->due_date,
                        'status_invoice'=> 'Unpaid',
                        'invoice_id'    => 'none',
                    ]);

            /**Load Order */
            $loadOrder = Order::where('idorder', $order)->first();
            /**Create Invoice */
            Invoice::create([
                'to'                => $loadOrder->costumer_id,
                'invoice_date'      => 'yyy-mm-dd',
                'order_id'          => $order,
                'file'              => 'none',
                'status'            => 'Created',
                'tag_active'        => 1,
                'total_tagihan'     => 0,
            ]);

            return response()->json(['success' => 'Payment method is update!']);
            
        }else{

            /**Delete Invoice */
            Invoice::where('order_id', $order)->delete();

            Order::where('idorder', $order)->update([
                'payment'       => $method,
                'due_date'      => date('Y-m-d'),
                'status'        => 'Close',
                'status_invoice'=> 'Paid',
                'invoice_id'    => time(),
                'tag_invoice'   => 1,
            ]);
            return response()->json(['success' => 'Payment method is update!']);
        }
    }

    /**Cancel Order */
    public function cancel(Request $request)
    {
        $request->validate([
            'id'            => 'required',
            'keterangan'    => 'required',
        ]);

        /**Cek teknisi */
        $order = Order::where('uuid', $request->id)->first();

        if($order->teknisi == NULL){
            Order::where('uuid', $request->id)->update([
                'keterangan'    => $request->keterangan,
                'progres'       => 'Cancel',
                'status'        => 'Close',
                'payment'       => 'None',
                'total_price'   => 0,
                'teknisi'       => NULL,
                'helper'        => NULL,
            ]);

            /**Added Timeline */
            $idorder = $order->idorder;
            Timeline::create([
                'order_id'          => $idorder,
                'user_id'           => Auth::user()->id,
                'timeline_status'   => 'Order dibatalkan ('.$request->keterangan.')',
                'keterangan'        => 'Order Cancel'
            ]);
        }else{

            /**update count order teknisi */
            $loadTeknisi = User::where('id', $order->teknisi)->first();
            $loadHelper = User::where('id', $order->helper)->first();
            $countTeknisi = $loadTeknisi->teknisi_order_count-1;
            $countHelper = $loadHelper->teknisi_order_count-1;

            User::where('id', $loadTeknisi->id)->update(['teknisi_order_count' => $countTeknisi]);
            User::where('id', $loadHelper->id)->update(['teknisi_order_count' => $countHelper]);

            Order::where('uuid', $request->id)->update([
                'keterangan'    => $request->keterangan,
                'progres'       => 'Cancel',
                'teknisi'       => NULL,
                'helper'        => NULL,
            ]);

            /**Added Timeline */
            $idorder = $order->idorder;
            Timeline::create([
                'order_id'          => $idorder,
                'user_id'           => Auth::user()->id,
                'timeline_status'   => 'Order dibatalkan ('.$request->keterangan.')',
                'keterangan'        => 'Order Cancel'
            ]);

        }
        return response()->json(['status' => 200, 'message' => 'Order dicancel']);
    }
    /**End Cancel Order */

    /**
     * Report
     */
    public function report():View
    {
        $data = [
            'title'     => 'Laporan Order',
            'teknisi'   => User::where('privilege', 9)->get(),
            'branch'    => Branch::all(),
        ];
        return view('order.report', $data);
    }
    public function tableByDate($start, $end, $branch):View
    {
        $data = [
            'result'    => Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->join('users', 'users.id', '=', 'orders.teknisi')
                                ->where('orders.branch_id', $branch)
                                ->whereBetween('tanggal_order', [$start, $end])->paginate(10),
        ];

        return view('order.table_report', $data);
    }

    public function tableByDateSearch($start, $end, $branch, $key):View
    {
        $data = [
            'result'    => Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->join('users', 'users.id', '=', 'orders.teknisi')
                                ->where('orders.branch_id', $branch)
                                ->whereBetween('tanggal_order', [$start, $end])
                                ->where('costumers.costumer_name', 'LIKE', '%'.$key.'%')
                                ->paginate(1000000),
        ];

        return view('order.table_report', $data);
    }

    public function tableByDateTeknisi($start, $end, $branch, $teknisi):View
    {
        $data = [
            'result'    => Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->join('users', 'users.id', '=', 'orders.teknisi')
                                ->where('orders.branch_id', $branch)
                                ->whereBetween('tanggal_order', [$start, $end])
                                ->where('teknisi', $teknisi)
                                ->paginate(1000000),
        ];

        return view('order.table_report', $data);
    }
    
    public function export($start, $end, $branch)
    {
        return Excel::download(new ExportsOrder($start, $end, $branch), 'order_report_'.$start.'_sd_'.$end.'.xlsx');
    }
    /**
     * End Report
     */

     /**master ORder */
     public function master():View
     {
        $data = [
            'title'     => 'Master Order',
        ];
        return view('order.master', $data);
     }
     /**Table Item */
     public function tableItem():View
     {
        $data = [
            'result'    => Item::all(),
        ];
        return view('order.tableItem', $data);
     }

     /**Table Merk */
     public function tableMerk(): View
     {
        $data = [
            'result'    => Merk::all(),
        ];
        return view('order.table_merk', $data);
     }

     /**Add Merk */
     public function addMerk(Request $request)
     {
        $request->validate([
            'merk_name' => 'required',
        ]);
        Merk::create([
            'merk_name' => $request->merk_name,
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Merk ditambahkan!',
        ]);
     }

     /**Delete Merk */
     public function deleteMerk(Request $request)
     {
        $request->validate([
            'id' => 'required',
        ]);
        Merk::where('id', $request->id)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Merk dihapus!',
        ]);
     }

     /**add item */
     public function addItem(Request $request)
     {
        $request->validate([
            'item'      => 'required',
        ]);
        Item::create([
            'item_name'     => $request->item,
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil disimpan!',
        ]);
     }

     /**delete item */
     public function deleteItem(Request $request)
     {
        $request->validate([
            'id'    => 'required',
        ]);
        $iditem = $request->id;
        Item::where('iditem', $iditem)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil dihapusx!',
        ]);
     }

     /**Add TAX */
     public function addTax(Request $request)
     {
        $request->validate([
            'ppn'   => 'required',
            'id'    => 'required',
        ]);
        $id = $request->id;
        Order::where('idorder', $id)->update([
            'ppn'   => $request->ppn,
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Tax ditambahkan!',
        ]);
     }
     
      /**table jadwal */
    public function jadwalOrder():view
    {
        $data = [
            'title'     => 'Jadwal Order',
            'teknisi' => User::where('privilege', 9)->get(),
            'helper' => User::where('privilege', 10)->get(),
        ];

        return view('order.jadwal-order', $data);
    }

    public function jadwalOrderTable():view
    {
        $data = [
            'table' => Orderitem::leftJoin('orders', 'orders.uuid', '=', 'orderitems.order_id')
                            ->leftJoin('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                            ->leftJoin('items', 'items.iditem', '=', 'orderitems.item_id')
                            ->where('orders.progres', 'Created')
                            ->select('costumer_name', 'jadwal', 'costumer_address', 'item_name', 'tanggal_order', 'idorder', 'request_jam', 'uuid')
                            ->get(),
            'teknisi' => User::where('privilege', 9)->get(),
            'helper' => User::where('privilege', 10)->get(),
        ];
        return view('order.jadwal-order-table', $data);
        //return response()->json($data);
    }

    public function buatJadwal(Request $request)
    {
        $id = $request->id;
        $data = [
            'jadwal'        => $request->jadwal,
            'request_jam'   => $request->jam,
        ];

        Order::where('idorder', $id)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Jadwal diperbaharui!',
        ]);
    }

    public function pekerjaanJasa(): View
    {
        $data = [
            'title'     => 'Pekerjaan Jasa',
        ];
        return view('order.pekerjaan-jasa', $data);
    }

    public function nomorNota(): View
    {
        $data = [
            'title'     => 'Nomor Nota',
        ];
        return view('order.nomor-nota', $data);
    }
     
}
