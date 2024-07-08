<?php

namespace App\Http\Controllers;

use App\Models\Cashbon;
use App\Models\Operational;
use App\Models\Opsitem;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OperationalController extends Controller
{
    public function __construct()
    {
        $this->middleware('opex');
    }
    public function index(): View
    {
        $khas = Operational::where('branch_id', Auth::user()->branch_id)->where('approved', 1)
                                ->orderBy('created_at', 'DESC')->first();
        $data = [
            'title'     => 'Operational',
            'opsitem'   => Opsitem::all(),
            'kas'       => $khas->saldo ?? 0,
        ];
        return view('operational.index', $data);
    }

    public function pengeluaran(): View
    {
        $khas = Operational::where('branch_id', Auth::user()->branch_id)->where('approved', 1)
                                ->orderBy('created_at', 'DESC')->first();
        $data = [
            'title'     => 'Operational',
            'opsitem'   => Opsitem::all(),
            'kas'       => $khas->saldo ?? 0,
        ];
        return view('operational.pengeluaran', $data);
    }

    public function tableOps(): View
    {
        $bulan = date('m');
        $data = [
            'result'    => Operational::join('opsitems', 'opsitems.id', '=', 'operationals.jenis')
                                        ->whereMonth('operationals.updated_at', $bulan)
                                        ->where('tipe', 'IN')
                                        ->select('operationals.id as id', 'trx_id', 'operationals.created_at',
                                        'tipe', 'item', 'nomor_nota', 'amount', 'saldo', 'metode', 'keterangan')
                                        ->orderBy('operationals.created_at', 'DESC')->paginate(10),
        ];
        return view('operational.tableops', $data);
    }

    public function tableOpsUot(): View
    {
        $bulan = date('m');
        $data = [
            'result'    => Operational::join('opsitems', 'opsitems.id', '=', 'operationals.jenis')
                                        ->whereMonth('operationals.updated_at', $bulan)
                                        ->where('tipe', 'OUT')
                                        ->select('operationals.id as id', 'trx_id', 'operationals.created_at',
                                        'tipe', 'item', 'nomor_nota', 'amount', 'saldo', 'metode', 'keterangan')
                                        ->orderBy('operationals.created_at', 'DESC')->paginate(10),
        ];
        return view('operational.tableopsout', $data);
    }

    public function history():View
    {
        $data = [
            'title'     => 'History Transaksi',
        ];
        return view('operational.report', $data);
    }

    public function tableHistory($start, $end):View
    {
        $data = [
            'result'    => Operational::join('opsitems', 'opsitems.id', '=', 'operationals.jenis')
                                        ->whereBetween('operationals.updated_at', [$start, $end])
                                        ->orderBy('operationals.created_at', 'DESC')->paginate(10),
        ];
        return view('operational.tableops', $data);
    }

    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'tipe'              => 'required',
            'jenis'             => 'required',
            'amount'            => 'required',
            'metode'            => 'required',
        ]);

        if($request->bukti_transaksi){
            $gambar = $request->file('bukti_transaksi');
            $nama_gambar = time().'.'.$gambar->getClientOriginalExtension();
            $path = $gambar->storeAs('public/foto-nota', $nama_gambar);
        }else{
            $nama_gambar = "no-evidence.png";
        }
        
        $ops = Operational::where('branch_id', Auth::user()->branch_id)
                            ->where('metode', $request->metode)
                            ->orderBy('id', 'DESC')->first();
                            
        $saldo_awal = $ops ? $ops->saldo : 0;
        $saldoAkhir = $saldo_awal-$request->amount;

        $data = [
            'trx_id'    => time(),
            'tipe'      => $request->tipe,
            'metode'    => $request->metode,
            'jenis'     => $request->jenis,
            'branch_id' => Auth::user()->branch_id,
            'approved'  => 1,
            'keterangan'=> $request->keterangan,
            'status'    => 'Success',
            'pesan'     => '-',
            'user_id'   => Auth::user()->id,
            'amount'    => $request->amount,
            'saldo'     => $saldoAkhir,
            'bukti_transaksi' => $nama_gambar,
            'nomor_nota'=> '-',
        ];

        Operational::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Submit Success..!'
        ]);


    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe'      => 'required',
            'jenis'     => 'required',
            'amount'    => 'required',
            'nomor_nota'=> 'required',
            'metode'    => 'required',
        ]);

        $ops = Operational::where('branch_id', Auth::user()->branch_id)
                            ->where('metode', $request->metode)
                            ->orderBy('id', 'DESC')->first();
        $saldo_awal = $ops ? $ops->saldo : 0;
        $saldoAkhir = $saldo_awal+$request->amount;

        $data = [
            'trx_id'    => time(),
            'tipe'      => $request->tipe,
            'metode'    => $request->metode,
            'jenis'     => $request->jenis,
            'branch_id' => Auth::user()->branch_id,
            'approved'  => 1,
            'keterangan'=> $request->keterangan,
            'status'    => 'Success',
            'pesan'     => '-',
            'user_id'   => Auth::user()->id,
            'amount'    => $request->amount,
            'saldo'     => $saldoAkhir,
            'bukti_transaksi' => '-',
            'nomor_nota'=> $request->nomor_nota,
        ];

        Operational::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Submit Success..!'
        ]);
    }

    /**Master */
    public function master(): View
    {
        $data = [
            'title'    => 'Master Operational',
        ];
        return view('operational.master', $data);
    }

    /**table item */
    public function tableItem():View
    {
        $data = [
            'result'    => Opsitem::all(),
        ];
        return view('operational.opsitem', $data);
    }

    /**New Item */
    public function newItem(Request $request)
    {
        $request->validate([
            'item'      => 'required',
        ]);
        Opsitem::create([
            'item'  => $request->item
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Item Added..'
        ]);
    }

    /**update item */
    public function updateItem(Request $request)
    {
        $request->validate([
            'item'  => 'required',
            'id'    => 'required',
        ]);
        Opsitem::where('id', $request->id)->update([
            'item'  => $request->item,
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Item Updated..'
        ]);
    }

    /**Delete Item */
    public function deleItem(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $id = $request->id;
        Opsitem::where('id', $id)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Item Deleted..'
        ]);
    }

    /**Saldo */
    public function saldoJson()
    {
        $saldoTunai = Operational::where('branch_id', Auth::user()->branch_id)
                                    ->where('metode', 'Cash')
                                    ->orderBy('id', 'DESC')->first();
        $saldoNonTunai = Operational::where('branch_id', Auth::user()->branch_id)
                                    ->where('metode', 'BCA')
                                    ->orderBy('id', 'DESC')->first();
        $saldoNonTunaiLainnya = Operational::where('branch_id', Auth::user()->branch_id)
                                    ->where('metode', 'Mandiri')
                                    ->orderBy('id', 'DESC')->first();
        //deklarasi saldo
        $saldoT = $saldoTunai->saldo ?? 0;
        $saldoNT = $saldoNonTunai->saldo ?? 0;
        $saldoNTLainnya = $saldoNonTunaiLainnya->saldo ?? 0;
        $data = [
            'tunai'     => number_format($saldoT),
            'nontunai'  => number_format($saldoNT),
            'lainnya'   => number_format($saldoNTLainnya),
            ];
        return response()->json($data);
    }

    /**
     * Bon Karyawan
     */
    public function cashbon()
    {
        $data = [
            'title'     => 'Bon Karyawan',
            'user'      => User::where('branch_id', Auth::user()->branch_id)->where('privilege', '>', 1)
                            ->join('roles', 'roles.idrole', '=', 'users.privilege')->get(),
        ];
        return view('operational.cashbon', $data);
    }
    public function storeCashbon(Request $request)
    {
        $request->validate([
            'id'            => 'required',
            'amount'        => 'required',
            'alasan_cashbon'=> 'required',
        ]);

        /**Cek total cashbon */
        $month = date('m');
        $load = Cashbon::where('user_id', $request->id)->whereMonth('tanggal', $month)->sum('amount');
        $saldo = $load ?? 0;
        $new = $request->amount;

        $cek = $new+$saldo;

        if($cek <= 1000001){
            $data = [
                'user_id'       => $request->id,
                'tanggal'       => date('Y-m-d'),
                'jam'           => date('H:i'),
                'status'        => 'Open',
                'approved'      => 0,
                'branch_id'     => Auth::check() ? Auth::user()->branch_id : null,
                'amount'        => $request->amount,
                'alasan_cashbon' => $request->alasan_cashbon,
            ];
    
            Cashbon::create($data);
            return response()->json([
                'status'    => 200,
                'message'   => 'Data berhasil disubmit, Tunggu apporval penerima!',
            ]);
        }else{
            return response()->json([
                'status'    => 500,
                'message'   => 'Total cashbon tidak boleh lebih dari 1 Juta!',
            ]);
        }



    }
    public function tableCashbon($month)
    {
        $data = [
            'result'    => Cashbon::whereMonth('tanggal', $month)
                            ->join('users', 'users.id', '=', 'cashbons.user_id')
                            ->join('roles', 'roles.idrole', '=', 'users.privilege')
                            ->select('users.*', 'nama_role', 'tanggal', 'jam', 'amount', 'status', 
                                        'approved', 'alasan_cashbon', 'cashbons.id AS cid')
                            ->paginate(10),
        ];
        return view('operational.tableCashbon', $data);
    }
    
    public function filterCashbon($karyawan, $bulan)
    {
        $data = [
            'result'    => Cashbon::where('user_id', $karyawan)->whereMonth('tanggal', $bulan)
                        ->join('users', 'users.id', '=', 'cashbons.user_id')
                        ->join('roles', 'roles.idrole', '=', 'users.privilege')->paginate(900000),
        ];
        return view('operational.tableCashbon', $data);
    }

    public function userCashbon():View
    {
        $data = [
            'title'     => 'Cashbon Karyawan',
            'result'    => Cashbon::where('user_id', Auth::user()->id)->where('status', 'Open')->get(),
        ];
        return view('operational.usercashbon', $data);
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

            $saldo_awal = $ops ? $ops->saldo : 0;

            /**Load data cashbon */
            $cashbon = Cashbon::find($request->id);
            $cashbon_amount = $cashbon->amount;

            $saldoAkhir = $saldo_awal-$cashbon_amount;

            Operational::create([
                'trx_id'        => time(),
                'tipe'          => 'OUT',
                'jenis'         => 4,
                'branch_id'     => Auth::user()->branch_id,
                'approved'      => 1,
                'keterangan'    => 'Cashbon',
                'status'        => 'Success',
                'pesan'         => '-',
                'user_id'       => Auth::user()->id,
                'amount'        => $cashbon_amount,
                'saldo'         => $saldoAkhir,
                'bukti_transaksi'=> 'no-image.jpg',
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

    public function deleteCashbon(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $id = $request->id;
        Cashbon::where('id', $id)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Deleted',
        ]);
    }
    /**
     * End Bon Karyawan
     */
     
    public function deleteMutasi(Request $request)
    {
        $request->validate([
            'id'    => 'required',    
        ]);
        $mutasi = Operational::findOrFail($request->id);
        $mutasi->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Deleted',
        ]);
    }

}
