<?php

namespace App\Http\Controllers;

use App\Exports\ExportInbound;
use App\Models\Branch;
use App\Models\Category;
use App\Models\Inbound;
use App\Models\Inbounditem;
use App\Models\Mutation;
use App\Models\Order;
use App\Models\Outbound;
use App\Models\Outboundbranch;
use App\Models\Outbounditem;
use App\Models\Products;
use App\Models\Productuser;
use App\Models\Returan;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;

class InventoryController extends Controller
{
    public function __construct()
    {
        //$this->middleware('manager')->only('inbound');
        $this->middleware('inventory');
    }
    public function products() :View
    {
        $data = [
            'title'     => 'Products',
            'unit'      => Unit::all(),
            'category'  => Category::all(),
            'supplier'  => Supplier::all(),
        ];
        return view('inventory.produk', $data);
    }
    public function tableInventory(): View
    {
        return view('inventory.tableInventory');
    }
    
    /**Mutasi Per Item */
    public function mutasi($id): View
    {
        $data = [
            'title'     => 'Mutasi',
            'id'        => $id,
        ];
        return view('inventory.mutasi', $data);
    }

    public function tableMutasi($id):view
    {
        $product = Products::where('product_code', $id)->first();
        $data = [
            'result'    => Mutation::where('mutations.branch_id', Auth::user()->branch_id)
                                ->join('users', 'users.id', '=', 'mutations.penerima')
                                ->leftJoin('orders', 'orders.uuid', 'mutations.order_id')
                                ->leftJoin('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->where('product_id', $product->diproduct)
                                ->orderBy('mutations.created_at', 'DESC')->limit(100)->paginate(10),
        ];
        return view('inventory.tabelMutasi', $data);
    }

    /**Barang Masuk */
    public function inbound(): View
    {

        $data = [
            'title'     => 'Inbound',
            'supplier'  => Supplier::all(),
            'cekInbound'=> Inbound::where('branch_id', Auth::user()->branch_id)->where('temp_status', 'Open')->count(),
        ];
        return view('inventory.inbound', $data);

    }

    public function InboundReport():View
    {
        $data = [
            'title'    => 'Report Inbound'
        ];
        return view('inventory.InboundReport', $data);
    }

    public function InboundTableReport($start, $end): View
    {
        $data = [
            'result'        => Inbounditem::join('products', 'products.diproduct', 'inbounditems.product_id')
                                ->join('inbounds', 'inbounds.id', '=', 'inbounditems.inbound_id')
                                ->join('suppliers', 'suppliers.idsupplier', '=', 'inbounds.supplier_id')
                                ->join('branches', 'branches.idbranch', '=', 'inbounds.branch_id')
                                ->whereBetween('inbounds.tanggal', [$start, $end])
                                ->select('tanggal', 'do', 'supplier_name', 'product_name', 'branch_name', 'harga_beli', 'harga_jual', 'qty', 'jumlah')->paginate(10),
        ];
        return view('inventory.tableReportInbound', $data);
    }

    public function export($start, $end)
    {
        return Excel::download(new ExportInbound($start, $end), 'inbound_report_'.$start.'_sd_'.$end.'.xlsx');
    }

    public function tableInboundForm($id):View
    {
        $data = [
            'result'    => Inbounditem::join('products', 'products.diproduct', '=', 'inbounditems.product_id')
                            ->where('inbound_id', $id)->get()
        ];
        return view('inventory.table_inbound_form', $data);
    }

    public function additem(Request $request)
    {
        $loadProduct = Products::where('diproduct', $request->product_id)->first();
        $harga_beli = $loadProduct->harga_beli;

        $data = [
            'inbound_id'    => $request->inbound_id,
            'product_id'    => $request->product_id,
            'qty'           => $request->qty,
            'price'         => $harga_beli,
            'jumlah'        => $harga_beli*$request->qty,
        ];
        Inbounditem::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Success',
        ]);
    }

    public function deleteItem(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        Inbounditem::where('id', $request->id)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Data Dihapus...',
        ]);
    }
    public function updateStatus(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        Inbound::where('id', $request->id)->update(['temp_status' => 'Close']);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data Dihapus...',
        ]);
    }

    public function updateDo(Request $request)
    {
        $request->validate([
            'inbound_id'    => 'required',
        ]);

        Inbound::where('id', $request->inbound_id)->update(['do' => $request->delivery]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data Diupdate...',
        ]);
    }

    /**Deatil Barang Masuk */
    public function inboundShow($id): View
    {
        $data = [
            'title'         => 'Detail Barang Masuk',
            'inbound'       => Inbound::join('suppliers', 'suppliers.idsupplier', '=', 'inbounds.supplier_id')
                                        ->where('id', $id)->first(),
            'result'        => Inbounditem::join('products', 'products.diproduct', '=', 'inbounditems.product_id')
                                            ->where('inbound_id', $id)->get(),
            'total'         => Inbounditem::where('inbound_id', $id)->sum('jumlah'),
        ];
        return view('inventory.inboundShow', $data);
    }

    public function inboundApproved(Request $request)
    {
        $request->validate([
            'idinbound'     => 'required',
        ]);

        $loop = Inbounditem::where('inbound_id', $request->idinbound)->get();
        foreach($loop as $l){
            $loadStock = Stock::where('branch_id', Auth::user()->branch_id)->where('product_id', $l->product_id)->first();
            $stockLama = $loadStock->stock;
            $stockAkhir = $stockLama+$l->qty;

            $inbound = Inbound::where('id', $l->inbound_id)->first();

            Stock::where('branch_id', $inbound->branch_id)->where('product_id', $l->product_id)
                    ->update(['stock' => $stockAkhir]);
            
            $getMutasi = Mutation::where('branch_id', Auth::user()->branch_id)->where('product_id', $l->product_id)
                    ->orderBy('idmutasi', 'DESC')->first();
            
            Mutation::create([
                'product_id'        => $l->product_id,
                'tanggal_mutasi'    => date('Y-m-d'),
                'jenis'             => 'Inbound',
                'order_id'          => '-',
                'reservasi_id'      => '-',
                'penerima'          => Auth::user()->id,
                'qty'               => $l->qty,
                'saldo_awal'        => $getMutasi->saldo_akhir,
                'saldo_akhir'       => $getMutasi->saldo_akhir+$l->qty,
                'branch_id'         => $inbound->branch_id,
            ]);
        }
        Inbound::where('id', $request->idinbound)->update(['tag_approved' => 1]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data Berhasil di Approve',
        ]);
    }

    public function inboundCancel(Request $request)
    {
        $request->validate([
            'idinbound'     => 'required',
        ]);
        Inbounditem::where('inbound_id', $request->idinbound)->delete();
        Inbound::where('id', $request->idinbound)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Data Berhasil di Cancel',
        ]);
    }

    /**Form Barang Masuk */
    public function inboundNew()//: View
    {

        $data = [
            'title'     => 'Inbound',
            'produk'    => Products::join('categories', 'categories.idcat', '=', 'products.cat')
                            ->join('units', 'units.idunit', '=', 'products.satuan')->get(),
            'inbound'   => Inbound::where('branch_id', Auth::user()->branch_id)
                                ->join('suppliers', 'suppliers.idsupplier', '=', 'inbounds.supplier_id')
                                ->where('temp_status', 'Open')->first(),
        ];
        return view('inventory.inboundNew', $data);

    }

    public function inboundcreate(Request $request)
    {

        $data = [
            'do'            => time(),
            'tanggal'       => date('Y-m-d'),
            'supplier_id'   => $request->supplier,
            'tag_approved'  => 0,
            'temp_status'   => 'Open',
            'branch_id'     => Auth::user()->branch_id,
            'status_payment'=> 'Unpaid',
        ];
        Inbound::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Success',
        ]);
    }

    public function tableInbound()
    {
        $data = [
            'result'    => Inbound::join('suppliers', 'suppliers.idsupplier', '=', 'inbounds.supplier_id')
                            ->join('branches', 'branches.idbranch', '=', 'inbounds.branch_id')
                            ->where('tag_approved', 0)->paginate(10),
        ];
        return view('inventory.table_inbound', $data);
    }

    /**Barang Keluar */
    public function outbound(): View
    {
        $data = [
            'title'     => 'Outbound',
        ];
        return view('inventory.outbound', $data);
    }
    public function outboundTable(): View
    {
        $data = [
            'result'    => Outbound::join('orders', 'orders.idorder', '=', 'order_id')
                                    ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                    ->join('users as teknisi', 'orders.teknisi', '=', 'teknisi.id')
                                    ->join('users as helper', 'orders.helper', '=', 'helper.id')
                                    ->where('reservasi_date', 'LIKE', '%'.date('Y-m').'%')
                                    ->select('teknisi.name as teknisi_name', 'helper.name as helper_name', 'reservasi_date', 
                                    'reservasi_id', 'uuid', 'costumer_name',  'reservasi_approved',)
                                    ->paginate(10),
        ];
        return view('inventory.outboundTable', $data);
    }
    public function filterOutbound($start, $end): View
    {
        $data = [
            'result'    => Outbound::join('orders', 'orders.idorder', '=', 'order_id')
                                    ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                    ->join('users as teknisi', 'orders.teknisi', '=', 'teknisi.id')
                                    ->join('users as helper', 'orders.helper', '=', 'helper.id')
                                    ->whereBetween('reservasi_date', [$start, $end])
                                    ->select('teknisi.name as teknisi_name', 'helper.name as helper_name', 'reservasi_date',
                                     'reservasi_id', 'uuid', 'costumer_name', 'reservasi_approved',)
                                    ->paginate(100000),
        ];
        return view('inventory.outboundTable', $data);
    }
    /**End Barang Keluar */

    /**Detail barang keluar */
    public function outboundShow($id): View
    {
        $outbound = Outbound::where('reservasi_id', $id)->first();
        $data = [
            'title'     => 'Detail Barang Keluar',
            'result'    => Outbounditem::where('order_id', $outbound->order_id)
                            ->join('products', 'products.diproduct', '=', 'outbounditems.product_id')
                            ->join('users', 'users.id', '=', 'outbounditems.teknisi')
                            ->select('product_code', 'product_name', 'qty', 'name')
                            ->get(),
            'item'      => Outbound::where('outbounds.order_id', $outbound->order_id)
                            ->leftJoin('outbounditems', 'outbounditems.outbound_id', '=', 'outbounds.idout')
                            ->leftJoin('users', 'users.id', '=', 'outbounditems.teknisi')
                            ->join('orders', 'orders.idorder', '=', 'outbounds.order_id')
                            ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                            ->select('name', 'outbounds.reservasi_date', 'costumer_name', 'uuid', 'reservasi_id', 'reservasi_approved')
                            ->first(),

        ];
        return view('inventory.outboundShow', $data);
    }

    /**Data Supplier */
    public function supplier(): View
    {
        $data = [
            'title'     => 'Data Supplier',
        ];
        return view('inventory.supplier', $data);
    }
    public function tableSupplier(): View
    {
        $data = [
            'supplier'  => Supplier::paginate(10),
        ];
        return view('inventory.tableSupplier',$data);
    }
    public function storeSupplier(Request $request)
    {
        $validated = $request->validate([
            'supplier_code'         => 'required|max:4',
            'supplier_name'         => 'required',
            'supplier_address'      => 'required',
            'supplier_email'        => 'required',
            'supplier_phone'        => 'required',
            'supplier_description'  => 'required'
        ]);
        Supplier::create($validated);
        return response(['success' => 'Data supplier berhasil ditambahkan!']);
    }
    public function supplierJson($id)
    {
        $data = Supplier::where('idsupplier', $id)->first();
        return json_encode($data);
    }
    public function updateSupplier(Request $request)
    {
        $request->validate(['idsupplier' => 'required']);
        $id = $request->idsupplier;
        $data = [
            'supplier_code'         => $request->supplier_code,
            'supplier_name'         => $request->supplier_name,
            'supplier_address'      => $request->supplier_address,
            'supplier_email'        => $request->supplier_email,
            'supplier_phone'        => $request->supplier_phone,
            'supplier_description'  => $request->supplier_description,
        ];
        Supplier::where('idsupplier', $id)->update($data);
        return response(['success' => 'Data Supplier Berhasil Diupdate!']);
    }
    public function deleteSupplier(Request $request)
    {
        $request->validate(['idsupplier' => 'required']);
        $id = $request->idsupplier;
        Supplier::where('idsupplier', $id)->delete();
        return response(['success' => 'Data Supplier Berhasil Dihapus!']);
    }

    /**Produk */
    public function stockProduct()
    {
        $stock = Stock::where('branch_id', Auth::user()->branch_id)
                        ->select('product_id as id', 'stock')->get();
        return response()->json($stock);
    }
    public function tableProduct(): View
    {
        $data = [
            'product'   => Products::join('categories', 'categories.idcat', '=', 'products.cat')
                                    ->join('units', 'units.idunit', '=', 'products.satuan')
                                    ->select('diproduct as idproduk', 'product_code', 'product_name', 'harga_beli', 'harga_jual', 'category_code', 'unit_code')
                                    ->orderBy('diproduct', 'DESC')->paginate(10),
        ];
        return view('inventory.tableProduct', $data);
    }
    public function productSearch($key): View
    {
        $data = [
            'product'   => Products::join('categories', 'categories.idcat', '=', 'products.cat')
                                    ->join('units', 'units.idunit', '=', 'products.satuan')
                                    ->where('product_code', 'LIKE', '%'.$key.'%')
                                    ->orWhere('product_name', 'LIKE', '%'.$key.'%')
                                    ->orderBy('diproduct', 'DESC')
                                    ->select('diproduct as idproduk', 'product_code', 'product_name', 'harga_beli', 'harga_jual', 'category_code', 'unit_code')
                                    ->paginate(1000)
        ];
        return view('inventory.tableProduct', $data);
    }
    public function productJson($id)
    {
        $data = Products::where('diproduct', $id)->first();
        return json_encode($data);
    }
    public function productStore(Request $request)
    {
        $request->validate([
            'product_name'  => 'required',
            'harga_jual'    => 'required',
        ]); 

        /**Generate Kode Produk */
        $load = Products::count();
        $cat = Category::where('idcat', $request->cat)->first();
        $cat_kode = $cat->category_code;

        $jumlah = 10000+$load;
        $kode_product = $cat_kode.$jumlah;

        $data = [
            'product_code'      => $kode_product,
            'cat'               => $request->cat,
            'product_name'      => $request->product_name,
            'supplier_id'       => 0,
            'satuan'            => $request->satuan,
            'harga_beli'        => $request->harga_beli,
            'harga_jual'        => $request->harga_jual,
        ];
        $produk = Products::create($data);

        $branch = Branch::all();

        foreach($branch as $br){

            $loadProduct = Products::where('product_code', $produk->product_code)->first();


            Stock::create([
                'product_id' => $loadProduct->diproduct,
                'branch_id'  => $br->idbranch,
                'stock'      => 0,
            ]);

            Mutation::create([
                'product_id'        => $loadProduct->diproduct,
                'tanggal_mutasi'    => date('Y-m-d'),
                'jenis'             => 'Inbound',
                'order_id'          => 'BTI00001',
                'reservasi_id'      => date('ymdhis'),
                'penerima'          => 1,
                'qty'               => 0,
                'saldo_awal'        => 0,
                'saldo_akhir'       => 0,
                'branch_id'         => $br->idbranch,
            ]);

        }

        return response(['success' => 'Data Product Berhasil Ditambahkan!']);
    }
    public function updateProduct(Request $request)
    {
        $request->validate([
            'diproduct' => 'required',
        ]);
        $id = $request->diproduct;
        $data = [
            'cat'               => $request->cat,
            'product_name'      => $request->product_name,
            'satuan'            => $request->satuan,
            'harga_beli'        => $request->harga_beli,
            'harga_jual'        => $request->harga_jual,
        ];
        Products::where('diproduct', $id)->update($data);
        return response(['success' => 'Data Product Berhasil Diupdate!']);
    }
    public function deleteProduct(Request $request)
    {
        $request->validate(['delete_id' => 'required']);
        $id = $request->delete_id;
        Products::where('diproduct', $id)->delete();
        return response(['success' => 'Data Product Berhasil Dihapus!']);
    }

    /**Resevasi Barang */
    public function reservasi(): View
    {
        $data = [
            'title'     => 'Reservasi',
            'order'     => Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                                ->join('users', 'users.id', '=', 'orders.teknisi')
                                ->where('orders.teknisi', '!=', null)
                                ->where('progres', '!=', 'Complete')
                                ->where('orders.branch_id', Auth::user()->branch_id)
                                ->orderBy('idorder', 'DESC')->get(),
            'product'   => Products::orderBy('diproduct', 'DESC')->get(),
        ];
        return view('inventory.reservasi', $data);
    }

    public function stockById($id)
    {
        $stock = Stock::where('product_id', $id)->where('branch_id', Auth::user()->branch_id)->first();
        $stockAkhir = $stock->stock ?? 0;

        return response()->json([
            'status'    => 200,
            'stock'     => $stockAkhir,
        ]);
    }

    public function tableReservasi($id)
    {
        $data = [
            'reservasi'     => 'data',
            'item'          => Outbounditem::where('order_id', $id)
                                ->join('products', 'products.diproduct', '=', 'outbounditems.product_id')
                                ->get(),
            'total'         => Outbounditem::where('order_id', $id)->sum('sub_total'),
        ];
        return view('inventory.reservasiTable', $data);
    }
    public function reservasiAdd(Request $request)
    {
        $request->validate([
            'product'   => 'required',
            'order'     => 'required',
            'qty'       => 'required',
        ]);

        /**load product */
        $loadProduct = Products::where('diproduct', $request->product)->first();
        $price = $loadProduct->harga_jual;
        $total_price = $price*$request->qty;

        /**load order */
        $loadOrder = Order::where('idorder', $request->order)->first();

        $data = [
            'reservasi_date'    => date('Y-m-d'),
            'outbound_id'       => 0,
            'order_id'          => $request->order,
            'product_id'        => $request->product,
            'qty'               => $request->qty,
            'material_price'    => $price,
            'sub_total'         => $total_price,
            'teknisi'           => $loadOrder->teknisi,
            'temp_status'       => 0,

        ];
        Outbounditem::create($data);

        /**insert product ke user */
        $cek = Productuser::where('produk_id', $request->product)->where('teknisi_id', $loadOrder->teknisi)->count();
        if($cek == 0){
            Productuser::create([
                'teknisi_id'    => $loadOrder->teknisi,
                'produk_id'     => $request->product,
                'qty_awal'      => 0,
                'qty'           => 0,
                'reservasi_id'  => 0,
                'retur'         => 0,
            ]);
            return response(['success' => 'Product Berhasil Ditambahkan!']);
        }else{
            return response(['success' => 'Product Berhasil Ditambahkan!']);
        }
    }
    public function reservasiDelete(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $id = $request->id;
        Outbounditem::where('idoi', $id)->delete();
        return response(['success' => 'Removed!']);
    }
    
    public function reservasiSubmit(Request $request): RedirectResponse
    {
        $request->validate([
            'order'     => 'required',
        ]);

        $loadOrder = Order::where('idorder', $request->order)->first();
        $countOutbound = Outbound::where('order_id', $request->order)->count() ?? 0;
        
        if($countOutbound > 0){
            $loadOutbound = Outbound::where('order_id', $request->order)->first();
            $revId = $loadOutbound->reservasi_id;
            
            $dataUpdate = [
                'outbound_id'       => $loadOutbound->idout,
                'teknisi'           => $loadOrder->teknisi,
                'temp_status'       => 1,
            ];
            Outbounditem::where('order_id', $request->order)->where('temp_status', 0)->update($dataUpdate);
            Outbound::where('reservasi_id', $loadOutbound->reservasi_id)->update([
                'reservasi_id' => $loadOutbound->reservasi_id,
                'reservasi_approved'    => 0,
                'reservasi_received'    => 0,
                'teknisi_id'            => $loadOrder->teknisi,
            ]);
            
        }else{
            $revId = date('Ymdhis');
            $data = [
                'order_id'              => $request->order,
                'reservasi_id'          => $revId,
                'reservasi_date'        => date('Y-m-d'),
                'reservasi_approved'    => 0,
                'reservasi_received'    => 0,
                'teknisi_id'            => $loadOrder->teknisi,
                'product_user_id'       => 0,
            ];
            $reservasi = Outbound::create($data);
    
            $dataUpdate = [
                'outbound_id'       => $reservasi->id,
                'teknisi'           => $loadOrder->teknisi,
                'temp_status'       => 1,
            ];
            Outbounditem::where('order_id', $request->order)->where('temp_status', 0)->update($dataUpdate);
            Productuser::where('reservasi_id', $request->order)->update(['reservasi_id' => $reservasi->reservasi_id]);
        }
        
        
        return redirect('/inventory/outbound');

    }

    /**
     * Return 
     * */
    public function return():View
    {
        $data = [
            'title'     => 'Data Retur Material',   
        ];
        return view('inventory.return', $data);
    }
    public function tableReturn(): View
    {
        $data = [
            'result'    => Returan::where('returans.branch_id', Auth::user()->branch_id)->where('tag_approved', 0)
                            ->join('users', 'users.id', '=', 'returans.teknisi_id')
                            ->join('products', 'products.diproduct', '=', 'returans.product_id')
                            ->join('units', 'units.idunit', '=', 'products.satuan')
                            ->select('returans.id as idretur', 'product_name as name', 'unit_code as satuan', 'tag_approved as approve',
                            'returans.qty', 'users.name as teknisi', 'diproduct as idproduct', 'teknisi_id')->get(),
            'count'     => Returan::where('returans.branch_id', Auth::user()->branch_id)->where('tag_approved', 0)->count(),
        ];
        return view('inventory.table_return', $data);
    }
    public function approveReturn(Request $request)
    {
        $request->validate([
            'id'        => 'required',
            'product'   => 'required',
            'teknisi'   => 'required',
        ]);

        $idretur = $request->id;
        $idproduct = $request->product;
        $teknisi = $request->teknisi;

        /**update table retur */
        Returan::where('id', $idretur)->update(['tag_approved' => 1]);

        /**update Stock */
        $loadReturan = Returan::where('id', $idretur)->first();
        $loadStock = Stock::where('branch_id', Auth::user()->branch_id)->where('product_id', $idproduct)->first();
        $stockLama = $loadStock->stock;
        $stokBaru = $stockLama+$loadReturan->qty;

        Stock::where('branch_id', Auth::user()->branch_id)->where('product_id', $request->product)
                ->update(['stock' => $stokBaru]);

        /**Update Stok teknisi */
        $stokTeknisi = Productuser::where('teknisi_id', $teknisi)->where('produk_id', $idproduct)->first();
        $stok = $stokTeknisi->qty-$stokTeknisi->retur;
        Productuser::where('teknisi_id', $teknisi)->where('produk_id', $idproduct)
                    ->update(['qty' => $stok, 'retur' => 0]);

        /**Insert Mutasi  */
        $getMutasi = Mutation::where('branch_id', Auth::user()->branch_id)->where('product_id', $idproduct)
                                ->orderBy('idmutasi', 'DESC')->first();
        Mutation::create([
            'product_id'        => $idproduct,
            'tanggal_mutasi'    => date('Y-m-d'),
            'jenis'             => 'Retur',
            'order_id'          => '-',
            'reservasi_id'      => '-',
            'penerima'          => Auth::user()->id,
            'qty'               => $stokTeknisi->retur,
            'saldo_awal'        => $getMutasi->saldo_akhir,
            'saldo_akhir'       => $getMutasi->saldo_akhir+$stokTeknisi->retur,
            'branch_id'         => Auth::user()->branch_id,
        ]);

        return response()->json(['status' => 200, 'message' => 'Data berhasil di approve!']);
    }

    public function deleteRetur(Request $request)
    {
        $teknisi = $request->teknisi;
        $product = $request->product;

        Productuser::where('teknisi_id', $teknisi)->where('produk_id', $product)->update(['retur' => 0]);
        Returan::where('id', $request->id)->delete();
        return response()->json(['status' => 200, 'message' => 'Data berhasil dihapus!']);
    }

    /**Master */
    public function master():View
    {
        $data = [
            'title'     => 'Master Inventory',
        ];
        return view('inventory.master', $data);
    }

    /**table satuan */
    public function tableSatuan():View
    {
        $data = [
            'result'    => Unit::all(),
        ];
        return view('inventory.tableSatuan', $data);
    }
    /**Table category */
    public function tableCatergory():View
    {
        $data = [
            'result'    => Category::all(),
        ];
        return view('inventory.tableCatergory', $data);
    }
    /**Store Satuan */
    public function storeSatuan(Request $request)
    {
        $validated = $request->validate([
            'unit_code'     => 'required',
            'unit_name'     => 'required',
        ]);
        Unit::create($validated);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil ditambahkan!',
        ]);
    }

    /**Store Category */
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'category_code'     => 'required',
            'category_name'     => 'required',
        ]);
        Category::create($validated);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil ditambahkan!',
        ]);
    }

    /**update satuan */
    public function updateSatuan(Request $request)
    {
        $validated = $request->validate([
            'idsatuan'          => 'required',
            'unit_code_edit'    => 'required',
            'unit_name_edit'    => 'required',
        ]);
        $id = $request->idsatuan;
        $data = [
            'unit_code'     => $request->unit_code_edit,
            'unit_name'     => $request->unit_name_edit,
        ];
        Unit::where('idunit', $id)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!',
        ]);
    }

    /**update category */
    public function updateCategory(Request $request)
    {
        $request->validate([
            'idcat'                 => 'required',
            'category_code_edit'    => 'required',
            'category_name_edit'    => 'required',
        ]);
        $id = $request->idcat;
        $data = [
            'category_code'     => $request->category_code_edit,
            'category_name'     => $request->category_name_edit,
        ];
        Category::where('idcat', $id)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!',
        ]);
    }

    /**Kirim produk antar kantor cabang */
    public function outboundBranch():View
    {
        $data = [
            'title'         => 'Kirim barang',
            'branch'        => Branch::all(),
            'product'       => Products::all(),
        ];
        return view('inventory.outboundBranch', $data);
    }

    /**form kirim barang */
    public function outboundBranchForm(Request $request)
    {
        $request->validate([
            'branch'    => 'required',
            'product'   => 'required',
            'qty'       => 'required',
        ]);

        /**Cek Stock */
        $cek = Stock::where('product_id', $request->product)->where('branch_id', Auth::user()->branch_id)->first();
        $stock = $cek->stock;

        if($request->qty >= $stock){
            return response()->json([
                'status'    => 500,
                'message'   => 'Stok lebih kecil dari yang di input!',
            ]);
        }

        $data = [
            'tanggal'       => date('Y-m-d'),
            'referensi'     => time(),
            'asal'          => Auth::user()->branch_id,
            'tujuan'        => $request->branch,
            'product_id'    => $request->product,
            'qty'           => $request->qty,
            'tag_temp'      => 0,
            'tag_approve'   => 0,
        ];
        Outboundbranch::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!',
        ]);
    }

    /**Table kirim branch */
    public function outboundBranchTable():View
    {
        $data = [
            'result'    => Outboundbranch::join('products', 'products.diproduct', '=', 'outboundbranches.product_id')
                            ->join('branches', 'branches.idbranch', '=', 'outboundbranches.tujuan')
                            ->where('tag_approve', 0)->where('asal', Auth::user()->branch_id)->get(),
        ];
        return view('inventory.outboundBranchTable', $data);
    }

    /**table barang masuk */
    public function outboundBranchTableRec():View
    {
        $data = [
            'result'    => Outboundbranch::join('products', 'products.diproduct', '=', 'outboundbranches.product_id')
                            ->join('branches', 'branches.idbranch', '=', 'outboundbranches.tujuan')
                            ->where('tag_approve', 0)->where('tujuan', Auth::user()->branch_id)->get(),
        ];
        return view('inventory.outboundBranchTableRec', $data);
    }

    /**Barang diterima */
    public function outboundBranchReceived():View
    {
        $data = [
            'title'     => 'Barang masuk'
        ];
        return view('inventory.outboundBranchReceived', $data);
    }
    /**Approve branch */
    public function approveBranch(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $load = Outboundbranch::where('id', $request->id)->first();
        $qty = $load->qty;

        $loadStock = Stock::where('product_id', $load->product_id)->where('branch_id', $load->tujuan)->first();
        $stockAwal = $loadStock->stock;
        $stockAkhir = $stockAwal+$qty;

        /**Penambahan stock Penerima */
        Stock::where('product_id', $load->product_id)->where('branch_id', $load->tujuan)
        ->update([
            'stock' => $stockAkhir,
        ]);

        $getMutasi = Mutation::where('branch_id', $load->tujuan)->where('product_id', $load->product_id)
                    ->orderBy('idmutasi', 'DESC')->first();

        Mutation::create([
            'product_id'        => $load->product_id,
            'tanggal_mutasi'    => date('Y-m-d'),
            'jenis'             => 'Outbound',
            'order_id'          => '-',
            'reservasi_id'      => '-',
            'penerima'          => Auth::user()->id,
            'qty'               => $load->qty,
            'saldo_awal'        => $getMutasi->saldo_akhir,
            'saldo_akhir'       => $getMutasi->saldo_akhir+$load->qty,
            'branch_id'         => $load->tujuan,
        ]);

        /**Pengurangan stock Pengirim */

        $loadStockPengirim = Stock::where('product_id', $load->product_id)->where('branch_id', $load->asal)->first();
        $stockAkhirPengirim = $loadStockPengirim->stock-$qty;

        Stock::where('product_id', $load->product_id)->where('branch_id', $load->asal)
        ->update([
            'stock' => $stockAkhirPengirim,
        ]);

        $getMutasiPenerima = Mutation::where('branch_id', $load->asal)->where('product_id', $load->product_id)
                    ->orderBy('idmutasi', 'DESC')->first();
        Mutation::create([
            'product_id'        => $load->product_id,
            'tanggal_mutasi'    => date('Y-m-d'),
            'jenis'             => 'Outbound',
            'order_id'          => '-',
            'reservasi_id'      => '-',
            'penerima'          => Auth::user()->id,
            'qty'               => $load->qty,
            'saldo_awal'        => $getMutasiPenerima->saldo_akhir,
            'saldo_akhir'       => $getMutasiPenerima->saldo_akhir-$qty,
            'branch_id'         => $load->asal,
        ]);

        Outboundbranch::where('id', $request->id)->update([
            'tag_approve'   => 1,
            'tag_temp'      => 1,
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diapprove!',
        ]);

    }

    /**hapus data kirim antar cabang */
    public function deleteBranch(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        Outboundbranch::where('id', $request->id)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil dihapus!',
        ]);
    }
    
    public function singkronUser():view
    {
        $data = [
            'title'     => 'Singkronisasi User-Produk',
            'users'      => User::all(),
        ];
        return view('inventory.singkron', $data);
    }
    
    public function singkronUserProses(Request $request)
    {
        $id = $request->id;
        $product = Products::all();
        foreach($product as $items){
            $cek = Productuser::where('produk_id', $items->diproduct)->where('teknisi_id', $id)->count();
            if($cek == 0){
                Productuser::create([
                    'teknisi_id'    => $id,
                    'produk_id'     => $items->diproduct,
                    'qty_awal'      => 0,
                    'qty'           => 0,
                    'reservasi_id'  => 0,
                    'retur'         => 0,
                ]);
            }
        }
        return redirect('/produk/singkron-user');
    }

    public function pos():View
    {
        $data = [
            'title'     => 'Point Of Sales',
        ];
        return view('inventory.pos', $data);
    }

    public function posReport(): View
    {
        $data = [
            'title'     => 'Laporan Penjualan',
        ];
        return view('inventory.pos-report', $data);
    }
    

}


