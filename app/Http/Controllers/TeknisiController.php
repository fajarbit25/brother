<?php

namespace App\Http\Controllers;

use App\Models\Cashbon;
use App\Models\Costumer;
use App\Models\Item;
use App\Models\Mutation;
use App\Models\NomorNota;
use App\Models\Operational;
use App\Models\Order;
use App\Models\Orderitem;
use App\Models\Ordermaterial;
use App\Models\Outbound;
use App\Models\Outbounditem;
use App\Models\Products;
use App\Models\Productuser;
use App\Models\Returan;
use App\Models\Stock;
use App\Models\Timeline;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeknisiController extends Controller
{
public function material(): View
    {
        $data = [
            'title'     => 'Material',
            'result'    => Outbound::where('outbounds.teknisi_id', Auth::user()->id)->where('reservasi_approved', 0)
                            ->select('idout as id', 'reservasi_id')
                            ->get(),
            'item'      => Outbounditem::where('teknisi', Auth::user()->id)->where('temp_status', 1)
                            ->join('products', 'products.diproduct', '=', 'outbounditems.product_id')
                            ->join('units', 'units.idunit', '=', 'products.satuan')
                            ->select('idoi as id', 'product_name as name', 'qty', 'unit_name as satuan', 'outbound_id')
                            ->get(),
            'count'     => Outbound::where('outbounds.teknisi_id', Auth::user()->id)->where('reservasi_approved', 0)->count(),

        ];

    return view('teknisi.material', $data);

    }

    public function approveMaterial(Request $request)
    {
        $request->validate([
            'id'        => 'required',
        ]);

        $iduser = Auth::user()->id;
        $branch_id = Auth::user()->branch_id;
        $result = Outbounditem::where('outbound_id', $request->id)->where('temp_status', 1)
                    ->join('orders', 'orders.idorder', '=', 'outbounditems.order_id')
                    ->get();

        foreach($result as $r){
            /**Deklarasi */
            $product_user = Productuser::where('teknisi_id', $iduser)->where('produk_id', $r->product_id)->first();
            if ($product_user) {
                $stockAwal = $product_user->qty;
            }else{
               $stockAwal = 0;
            }
            $stockbaru = $r->qty+$stockAwal;

            /**Update product user */
            Productuser::where('teknisi_id', $iduser)->where('produk_id', $r->product_id)
                        ->update(['qty' => $stockbaru]);
            
            /**update stock */
            $load_mutasi = Mutation::where('product_id', $r->product_id)->where('branch_id', $branch_id)->orderBy('idmutasi', 'DESC')->first();
            $saldo_awal = $load_mutasi->saldo_akhir;
            $qty = $r->qty;
            $saldo_akhir = $saldo_awal-$qty;

            $loadStock = Stock::where('branch_id', Auth::user()->branch_id)
                                ->where('product_id', $r->product_id)->first();
            $stokLama = $loadStock->stock;
            $stockTerbaru = $stokLama-$r->qty;

            Stock::where('branch_id', Auth::user()->branch_id)
                    ->where('product_id', $r->product_id)
                    ->update(['stock' => $stockTerbaru]);

            /**load outbound */
            $outbound = Outbound::where('idout', $r->outbound_id)->first();
            Mutation::create([
                'product_id'        => $r->product_id,
                'tanggal_mutasi'    => date('Y-m-d'),
                'jenis'             => 'Outbound',
                'order_id'          => $r->uuid,
                'reservasi_id'      => $outbound->reservasi_id,
                'penerima'          => $r->teknisi,
                'qty'               => $qty,
                'saldo_awal'        => $saldo_awal,
                'saldo_akhir'       => $saldo_akhir,
                'branch_id'         => $branch_id,
            ]);

            /**update outbound */
            Outbound::where('idout', $r->outbound_id)
                        ->update(['reservasi_approved' => 1, 'reservasi_received' => 1]);
            
            /**update temp status */

            Outbounditem::where('idoi', $r->idoi)->update(['temp_status' => 3]);
        }

        return response()->json(['success' => 'Material berhasil diapprove!']);
    }

    /**Stock */
    public function stock()
    {
        $data = [
            'title'         => 'Stok Material',
            'stocks'        => Productuser::where('teknisi_id', Auth::user()->id)->where('qty', '!=', 0)
                                ->join('products', 'products.diproduct', '=', 'productusers.produk_id')
                                ->join('units', 'units.idunit', '=', 'products.satuan')
                                ->select('product_name as name', 'produk_id as id', 'qty', 'unit_code as satuan', 'retur')
                                ->get(),
            'count'         => Productuser::where('teknisi_id', Auth::user()->id)->where('qty', '!=', 0)->count(),
        ];
        return view('teknisi.stock', $data);
    }
    /**End stock */

    /**Return */
    public function return(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        $cek = Productuser::where('teknisi_id', Auth::user()->id)->where('produk_id', $request->id)->first();
        if($cek->qty >= $request->qty){

            Returan::create([
                'teknisi_id'    => Auth::user()->id,
                'product_id'    => $request->id,
                'tanggal'       => date('Y-m-d'),
                'qty'           => $request->qty,
                'tag_approved'  => 0,
                'branch_id'     => Auth::user()->branch_id
            ]);
            Productuser::where('teknisi_id', Auth::user()->id)->where('produk_id', $request->id)
                        ->update(['retur' => $request->qty]);
            return response()->json(['status' => 200, 'message' => 'Retur berhasil']);

        }else{
            return response()->json(['status' => 404, 'message' => 'Qty retur tidak boleh lebih besar dari Stock']);
        }

        Returan::create([
            'teknisi_id'    => Auth::user()->id,
            'product_id'    => $request->id,
            'tanggal'       => date('Y-m-d'),
            'qty'           => $request->qty,
            'tag_approved'  => 0,
            'branch_id'     => Auth::user()->branch_id
        ]);
        return response()->json(['status' => 200, 'message' => 'Retur berhasil,']);

    }
    public function dataReturn()
    {
        $data = [
            'title'         => 'Return Material',
            'stocks'        => Returan::where('teknisi_id', Auth::user()->id)->where('tag_approved', 0)
                                ->join('products', 'products.diproduct', '=', 'returans.product_id')
                                ->join('units', 'units.idunit', '=', 'products.satuan')
                                ->select('product_name as name', 'unit_code as satuan', 'qty as stock')
                                ->get(),
            'count'         => Returan::where('teknisi_id', Auth::user()->id)->where('tag_approved', 0)->count(),
        ];
        return view('teknisi.return', $data);
    }
    /**End Return */

    public function order(): View
    {
        $data = [
            'title'     => 'Work Order',
            'count'     => Order::where('progres', '!=', 'Complete')
                            ->where('teknisi', Auth::user()->id)
                            ->count(),
        ];
        return view('teknisi.order', $data);
    }
    public function orderList(): View
    {
        $data = [
            'order'     => Order::where('progres', '!=', 'Complete')
                            ->where('teknisi', Auth::user()->id)
                            ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                            ->get(),
        ];
        return view('teknisi.orderList', $data);
    }
    public function pickup(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        Order::where('idorder', $request->id)->update(['progres' => 'Pickup']);

        /**Added Timeline */
        Timeline::create([
            'order_id'          => $request->id,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order telah diterima oleh teknisi untuk selanjutanya dilakukan pengerjaan.',  
            'keterangan'        => 'Order Pickup'
        ]);
        return response(['success' => 'Selamat, Order berhasil dipickup!']);
    }
    public function show($id): View
    {
        $order = Order::where('idorder', $id)->first();

        $data = [
            'title'     => 'Work Order',
            'order'     => $order,
            'costumer'  => Costumer::where('idcostumer', $order->costumer_id)->first(),
            'items'     => Item::all(),
            'inbound'   => Outbound::where('outbounds.teknisi_id', Auth::user()->id)->where('reservasi_approved', 0)->count(),
            'countItemUnprocess' => Orderitem::where('order_id', $order->uuid)->where('ruangan', 0)->count(), //order item belum diproses
            'countItem' => Orderitem::where('order_id', $order->uuid)->count(), //Jumlah item pada order tersebut
        ];
        return view('teknisi.show', $data);
    }

    public function buttonFooter($uuid): View
    {
        $order = Order::where('uuid', $uuid)->first();
        $data = [
            'order'                 => $order,
            'countItemUnprocess'    => Orderitem::where('order_id', $order->uuid)->where('ruangan', '0')->count(), //order item belum diproses
            'countItem'             => Orderitem::where('order_id', $order->uuid)->count(), //Jumlah item pada order tersebut
            'countMaterialApprove'  => Outbounditem::where('teknisi', Auth::user()->id)
                                        ->where('temp_status', '!=', 3)->count(),
            'materialRequest'       => Outbounditem::where('order_id', $order->idorder)->count(),
            'materialUse'           => Ordermaterial::where('order_id', $order->idorder)->count(),
        ];
        return view('teknisi.buttonFooter', $data);
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        Order::where('idorder', $request->id)->update(['progres' => 'Processing']);

        /**Added Timeline */
        Timeline::create([
            'order_id'          => $request->id,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order dalam proses pengerjaan.',  
            'keterangan'        => 'Order Processing'
        ]);
        return response(['success' => 'Order Processing']);
    }
    public function orderitemJson($id)
    {
        $data = Orderitem::where('idoi', $id)
                    ->join('items', 'items.iditem', '=', 'orderitems.item_id')
                    ->select('idoi as id', 'item_name', 'iditem', 'merk', 'pk', 'lantai', 'ruangan')
                    ->first();
        return json_encode($data);
    }
    public function itemList($uuid): View
    {
        $load = Order::where('uuid', $uuid)->first();
        $data = [
            'orderitem'     => Orderitem::where('order_id', $uuid)->join('items', 'items.iditem', '=', 'orderitems.item_id')->get(),
            'order'         => Order::where('uuid', $uuid)->first(),
            'countListDone' => Orderitem::where('order_id', $uuid)->where('lantai', 0)->count(),
            'material'      => Productuser::where('teknisi_id', Auth::user()->id)->where('qty', '!=', 0)
                                ->join('products', 'products.diproduct', '=', 'productusers.produk_id')
                                ->select('product_name as name', 'produk_id as id')
                                ->get(),
            'stocks'    => Ordermaterial::where('order_id', $load->idorder)
                                ->join('products', 'products.diproduct', '=', 'ordermaterials.product_id')
                                ->join('units', 'units.idunit', '=', 'products.satuan')
                                ->select('product_name as name', 'unit_code as satuan', 'qty as stock')
                                ->get(),
        ];
        return view('teknisi.itemList', $data);
    }

    public function loadStokMaterialUse($uuid)
    {
        $load = Order::where('uuid', $uuid)->first();
        $data = [
            'stocks'    => Ordermaterial::where('order_id', $load->idorder)
                                ->join('products', 'products.diproduct', '=', 'ordermaterials.product_id')
                                ->join('units', 'units.idunit', '=', 'products.satuan')
                                ->select('product_name as name', 'unit_code as satuan', 'qty as stock', 'ordermaterials.product_id')
                                ->get(),
            'materialRequest'       => Outbounditem::where('order_id', $load->idorder)
                                        ->join('products', 'products.diproduct', '=', 'outbounditems.product_id')
                                        ->join('units', 'units.idunit', '=', 'products.satuan')
                                        ->select('product_name as name', 'qty', 'unit_code as satuan', 'outbounditems.product_id')
                                        ->get(),
        ];
        return view('teknisi.materialUse', $data);
    }

    public function productJson($id)
    {
        $data = Productuser::where('produk_id', $id)
                    ->join('products', 'products.diproduct', '=', 'productusers.produk_id')
                    ->join('units', 'units.idunit', '=', 'products.satuan')
                    ->select('product_name as name', 'unit_code as satuan', 'diproduct as id',
                    'harga_jual as price', 'productusers.qty as stock')
                    ->first();
        return response()->json($data);
    }
    public function ordermaterials(Request $request)
    {
        $request->validate([
            'qty'   => 'required',
        ]);
        
        $cek = Ordermaterial::where('order_id', $request->idorder)->where('product_id', $request->idproduct)->get();
        if(count($cek) == 0){
            Ordermaterial::create([
                'order_id'      => $request->idorder,
                'product_id'    => $request->idproduct,
                'teknisi_id'    => Auth::user()->id,
                'qty'           => $request->qty,
                'price'         => $request->price,
                'jumlah'        => $request->qty*$request->price,
            ]);
    
            /**update stock teknisi */
            $load = Productuser::where('teknisi_id', Auth::user()->id)->where('produk_id', $request->idproduct)->first();
            $stockAwal = $load->qty;
            $stokAkhir = $load->qty-$request->qty;
            Productuser::where('idpu', $load->idpu)->update(['qty' => $stokAkhir]);
        }else{
            //load stok pada user
            $loadStockEksisting = Productuser::where('teknisi_id', Auth::user()->id)->where('produk_id', $request->idproduct)->first();
            $stockEksisting = $loadStockEksisting->qty;
            
            $orderMaterial = Ordermaterial::where('order_id', $request->idorder)->where('product_id', $request->idproduct)->first();
            $stockInOrderMaterial = $orderMaterial->qty;

            $newStockPu = $stockEksisting+$stockInOrderMaterial;

            //Kembalikan Stok
            Productuser::where('produk_id', $request->idproduct)
            ->where('teknisi_id', Auth::user()->id)
            ->update([
                'qty'     => $newStockPu,
            ]);
            
            //hapus material pada order
            Ordermaterial::where('product_id', $request->idproduct)->delete();
            
            //buat material baru
            Ordermaterial::create([
                'order_id'      => $request->idorder,
                'product_id'    => $request->idproduct,
                'teknisi_id'    => Auth::user()->id,
                'qty'           => number_format($request->qty),
                'price'         => $request->price,
                'jumlah'        => $request->qty*$request->price,
            ]);
            
            
            /**update stock teknisi */
            $load = Productuser::where('teknisi_id', Auth::user()->id)->where('produk_id', $request->idproduct)->first();
            $stockAwal = $load->qty;
            $stokAkhir = $load->qty-$request->qty;
            Productuser::where('idpu', $load->idpu)->update(['qty' => $stokAkhir]);

        }

        return response()->json(['success' => 'Data berhasil di insert!']);
    }
    public function updateItem(Request $request)
    {
        $request->validate([
            'order_itemId' => 'required',
            'lantai'       => 'required|numeric',
            'ruangan'      => 'required|min:2',
        ]);


        $id = $request->order_itemId;
        $data = [
            'merk'      => $request->merk,
            'pk'        => $request->pk,
            'lantai'    => $request->lantai,
            'ruangan'   => $request->ruangan,
            'item_id'   => $request->tipe,
        ];
        Orderitem::where('idoi', $id)->update($data);
        return response()->json(['message' => 'Data order berhasil diupdate']);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
            'nomor'=> 'required',
        ]);

        $cekNota = NomorNota::where('nomor', $request->nomor)
                    ->where('user_id', Auth::user()->id)
                    ->where('tag_usage', 0)
                    ->count();

        if($cekNota >= 1){
            $gambar = $request->file('foto');
            $nama_gambar = time().'.'.$gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/nota', $nama_gambar);

            /**update data order */
            $id = $request->idorderupload;
            Order::where('idorder', $id)->update([
                'nota'      => $nama_gambar,
                'progres'   => 'Closing',
                'nomor_nota'    => $request->nomor,
            ]);

            /**Added Timeline */
            Timeline::create([
                'order_id'          => $id,
                'user_id'           => Auth::user()->id,
                'timeline_status'   => 'Order telah dikerjakan oleh tim teknisi.',  
                'keterangan'        => 'Order Closing'
            ]);

            /**Update Nomor Nota */
            NomorNota::where('nomor', $request->nomor)->update(['tag_usage' => 1]);

            return response()->json([
                'status'  => 200,
                'message' => 'Gambar berhasil diupload...'
            ]);
        }else{
            return response()->json([
                'status'  => 201,
                'message' => 'Nomor Nota Tidak Ditemukan!'
            ]);
        }

    }

    /**Pending */
    public function pending(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        /**update count order teknisi */
        $order = Order::where('idorder', $request->id)->first();
        $loadTeknisi = User::where('id', $order->teknisi)->first();
        $loadHelper = User::where('id', $order->helper)->first();
        $countTeknisi = $loadTeknisi->teknisi_order_count-1;
        $countHelper = $loadHelper->teknisi_order_count-1;

        User::where('id', $loadTeknisi->id)->update(['teknisi_order_count' => $countTeknisi]);
        User::where('id', $loadHelper->id)->update(['teknisi_order_count' => $countHelper]);

        /**update data order */
        Order::where('idorder', $request->id)->update([
            'progres'       => 'Pending',
            'teknisi'       => NULL,
            'helper'        => NULL,
            'keterangan'    => $request->keterangan,
        ]);

        /**Added Timeline */
        Timeline::create([
            'order_id'          => $request->id,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order di pending karena ('.$request->keterangan.')',  
            'keterangan'        => 'Order Pending',
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'Order dipending!',
        ]);
    }
    /**End Pending */

    /**
     * Cashbon
     */
    public function cashbon()
    {
        $data = [
            'title'     => 'Cashbon Karyawan',
            'result'    => Cashbon::where('user_id', Auth::user()->id)->where('status', 'Open')->get(),
        ];

        return view('teknisi.cashbon', $data);
    }
    public function approveCashbon(Request $request)
    {
        $request->validate([
            'id'        => 'required',
            'userid'    => 'required',
            'password'  => 'required',
        ]);
        $id = $request->userid;
        $password = $request->password;

        $load = User::find($id);
        $passwordOld = $load->password;

        if(Hash::check($password, $passwordOld)){
            Cashbon::where('id', $request->id)->update([
                'approved' => 1,
            ]);

            /**Load Saldo OPS */
            $ops = Operational::where('branch_id', Auth::user()->branch_id)->orderBy('id', 'DESC')->first();
            //$cekSaldo = $ops->saldo;
            //$saldo_awal = $ops->saldo() ?? 0;

            $saldo_awal = $ops ? $ops->saldo : 0;

            /**Load data cashbon */
            $cashbon = Cashbon::find($request->id);
            $cashbon_amount = $cashbon->amount;

            $saldoAkhir = $saldo_awal-$cashbon_amount;

            Operational::create([
                // 'trx_id'        => time(),
                // 'tipe'          => 'OUT',
                // 'jenis'         => 4,
                // 'branch_id'     => Auth::user()->branch_id,
                // 'approved'      => 1,
                // 'keterangan'    => 'Cashbon',
                // 'status'        => 'Success',
                // 'pesan'         => '-',
                // 'user_id'       => Auth::user()->id,
                // 'amount'        => $cashbon_amount,
                // 'saldo'         => $saldoAkhir,
                
                'trx_id'    => time(),
                'tipe'      => 'OUT',
                'metode'    => 'Cash',
                'jenis'     => 8,
                'branch_id' => Auth::user()->branch_id,
                'approved'  => 1,
                'keterangan'=> $request->keterangan,
                'status'    => 'Success',
                'pesan'     => '-',
                'user_id'   => Auth::user()->id,
                'amount'    => $cashbon_amount,
                'saldo'     => $saldoAkhir,
                'bukti_transaksi' => '-',
                'nomor_nota'=> '-',
            ]);
            
            
            

            return response()->json([
                'status'    => 200,
                'message'   => 'Approved',
            ]);
        }else{
            return response()->json([
                'status'    => 500,
                'message'   => 'Authentikasi Gagal!',
            ]);
        }

    }
     /**
      * End Cashbon
      */

    /**Continue Order */
    public function continueOrder(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        /**update count order teknisi */
        $order = Order::where('idorder', $request->id)->first();
        $loadTeknisi = User::where('id', $order->teknisi)->first();
        $loadHelper = User::where('id', $order->helper)->first();
        $countTeknisi = $loadTeknisi->teknisi_order_count-1;
        $countHelper = $loadHelper->teknisi_order_count-1;

        User::where('id', $loadTeknisi->id)->update(['teknisi_order_count' => $countTeknisi]);
        User::where('id', $loadHelper->id)->update(['teknisi_order_count' => $countHelper]);

        /**update data order */
        Order::where('idorder', $request->id)->update([
            'progres'       => 'Continous',
            'teknisi'       => NULL,
            'helper'        => NULL,
            'keterangan'    => $request->keterangan,
        ]);

        /**Added Timeline */
        Timeline::create([
            'order_id'          => $request->id,
            'user_id'           => Auth::user()->id,
            'timeline_status'   => 'Order di pending karena ('.$request->keterangan.')',  
            'keterangan'        => 'Order Pending',
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'Order dipending!',
        ]);
    }
}

