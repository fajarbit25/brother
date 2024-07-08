<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Inbound;
use App\Models\Instalment;
use App\Models\Salarie;
use App\Models\Saving;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index(): View
    {
        $data = [
            'title'     => 'List Orders',
        ];
        return view('finance.index', $data);
    }

    /**Invoice */
    public function invoice(): View
    {
        $data = [
            'title'     => 'Invocie',
        ];
        return view('finance.invoice', $data);
    }

    /**salary repoert */
    public function salaryReport():View
    {
        $data = [
            'title'     => 'Report Salary',
        ];
        return view('finance.salaryReport', $data);
    }

    /**Table Report Salary */
    public function tableReportSalary($id):View
    {
        $data = [
            'result'    => Salarie::where('periode', $id)->join('users', 'users.id', '=', 'salaries.user_id')
                            ->get(),
        ];
        return view('finance.tableReportSalary', $data);
    }
    /**Kas Perusahaan */
    public function khas():View
    {
        $kas = Saving::orderBy('id', 'DESC')->first();
        $saldo = $kas->saldo ?? 0;
        $data = [
            'title'     => 'Laporan Kas Perusahaan',
            'kas'       => $saldo,
        ];
        return view('finance.khas', $data);
    }
    /**Store kas */
    public function khasStore(Request $request)
    {
        $request->validate([
            'amount'    => 'required',
            'tipe'      => 'required',
            'keterangan'=> 'required',
        ]);
        $loadSaldo = Saving::orderBy('id', 'DESC')->first();
        $converSaldo = $loadSaldo->saldo ?? 0;
        if($request->tipe == 'IN'){
            $saldo = $converSaldo+$request->amount;
        }else{
            $saldo = $converSaldo-$request->amount;
        }
        $data = [
            'txid'      => time(),
            'tipe'      => $request->tipe,
            'amount'    => $request->amount,
            'saldo'     => $saldo,
            'status'    => 'Success',
            'keterangan'=> $request->keterangan,
        ];
        Saving::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil disubmit!'
        ]);
    }

    /**Table Kas */
    public function tableKhas():View
    {
        $data = [
            'result'    => Saving::limit(100)->orderBy('id', 'DESC')->paginate(10),
        ];
        return view('finance.tableKas', $data);
    }

    /**Asset */
    public function asset(): View
    {
        $data = [
            'title'     => 'Asset Perusahaan',
        ];
        return view('finance.asset', $data);
    }
    /**Store Asset */
    public function storeAsset(Request $request)
    {
        $validated = $request->validate([
            'roda'      => 'required',
            'tipe'      => 'required',
            'plat'      => 'required',
            'tahun'     => 'required',
            'kondisi'   => 'required',
            'merk'      => 'required',
        ]);
        Asset::create($validated);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil disubmit!'
        ]);
    }

    /**Table Asset */
    public function tableAsset():View
    {
        $data = [
            'result'    => Asset::paginate(10),
        ];
        return view('finance.tableAsset', $data);
    }
    /**update Asset */
    public function updateAsset(Request $request)
    {
        $request->validate([
            'idasset'       => 'required',
            'rodaEdit'      => 'required',
            'tipeEdit'      => 'required',
            'platEdit'      => 'required',
            'tahunEdit'     => 'required',
            'kondisiEdit'   => 'required',
            'merkEdit'      => 'required',
        ]);
        $id = $request->idasset;
        $data = [
            'roda'      => $request->rodaEdit,
            'tipe'      => $request->tipeEdit,
            'plat'      => $request->platEdit,
            'tahun'     => $request->tahunEdit,
            'kondisi'   => $request->kondisiEdit,
            'merk'      => $request->merkEdit,
        ];
        Asset::where('id', $id)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!'
        ]);
    }
    /** Angsuran Asset */
    public function paymentAsset():View
    {
        $data = [
            'title'     => 'Pembayaran Asset Perusahaan',
        ];
        return view('finance.paymentAsset', $data);
    }

    /**table Angsuran */
    public function tableAngsuran(): View
    {
        $data = [
            'result'    => Asset::paginate(10),
        ];
        return view('finance.tableAngsuran', $data);
    }

    /**cicilan asset */
    public function cicilanAsset($id):View
    {
        $data = [
            'title'     => 'Simulasi Pembayaran Angsuran',
            'asset_id'  => $id,
            'asset'     => Asset::where('id', $id)->first(),
            'tag_lock'  => Instalment::where('asset_id', $id)->where('tag_lock', 0)->count(),
        ];
        return view('finance.cicilanAsset', $data);
    }

    /**Table Form */
    public function tableForm($id):View
    {
        $data = [
            'result'     => Instalment::where('asset_id', $id)->get(),
        ];
        return view ('finance.tableForm', $data);
    }

    /**store form */
    public function storeForm(Request $request)
    {
        $request->validate([
            'id'      => 'required',
        ]);
        $data = [
            'asset_id'      => $request->id,
            'jatuh_tempo'   => NULL,
            'pembiayaan'    => NULL,
            'jumlah'        => 0,
            'lunas'         => 'NOK',
            'tag_lock'      => 0,
        ];
        Instalment::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil disimpan!'
        ]);
    }
    
    /**Update Form */
    public function updateForm(Request $request)
    {
        $request->validate([
            'id'            => 'required',
            'jatuh_tempo'   => 'required',
            'pembiayaan'    => 'required',
            'jumlah'        => 'required',
        ]);
        $id = $request->id;
        $data = [
            'jatuh_tempo'   => $request->jatuh_tempo,
            'pembiayaan'    => $request->pembiayaan,
            'jumlah'        => $request->jumlah,
        ];
        Instalment::where('id', $id)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!'
        ]);
    }
    /**set Bayar */
    public function setBayar(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $id = $request->id;
        Instalment::where('id', $id)->update([
            'lunas'  => 'OK',
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!'
        ]);
    }

    /**Simpan Data */
    public function saveForm(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $id = $request->id;
        Instalment::where('asset_id', $id)->update([
            'tag_lock'      => 1,
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!'
        ]);
    }
    /**delete form */
    public function deleteForm(Request $request)
    {
        $request->validate([
            'id'    => 'required'
        ]);
        $id = $request->id;
        Instalment::where('id', $id)->delete();
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil dihapus!'
        ]);
    }
    /**bayar angsuran */
    public function bayarAngsuran(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $id = $request->id;
        Instalment::where('id', $id)->update(['lunas' => 'OK']);

        $loadInstalment = Instalment::where('id', $id)->first();
        $loadasset = Asset::where('id', $loadInstalment->asset_id)->first();

        /**update kas */
        $loadSaldo = Saving::orderBy('id', 'DESC')->first();
        $converSaldo = $loadSaldo->saldo ?? 0;
        if($request->tipe == 'IN'){
            $saldo = $converSaldo+$loadInstalment->jumlah;
        }else{
            $saldo = $converSaldo-$loadInstalment->jumlah;
        }
        $data = [
            'txid'      => time(),
            'tipe'      => 'OUT',
            'amount'    => $loadInstalment->jumlah,
            'saldo'     => $saldo,
            'status'    => 'Success',
            'keterangan'=> 'Pembayaran Angsuran '.$loadasset->merk,
        ];
        Saving::create($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil disubmit!'
        ]);
    }

    /**
     * Inbound Payment
     */
    public function inboundPayment(): View
    {
        $data = [
            'title'     => 'Inbound Payment',
        ];
        return view('finance.inboundPayment', $data);
    }

    public function inboundTable(): View
    {
        $data = [
            'result'        => DB::table('inbounds')
                                    ->join('suppliers', 'suppliers.idsupplier', '=', 'inbounds.supplier_id')
                                    ->join('branches', 'branches.idbranch', '=', 'inbounds.branch_id')
                                    ->join('inbounditems', 'inbounds.id', '=', 'inbounditems.inbound_id')
                                    ->select('inbounds.*', 'suppliers.supplier_name', 'branches.branch_name', 
                                        DB::raw('SUM(inbounditems.jumlah) as total_jumlah'))
                                    ->groupBy('inbounds.id', 'inbounds.tanggal', 'do', 'supplier_id', 'supplier_name', 'branch_name',
                                            'tag_approved', 'temp_status', 'branch_id', 'status_payment', 'inbounds.created_at', 'inbounds.updated_at')
                                    ->where('status_payment', 'Unpaid')->get(),
        ];
        return view('finance.table_inbound', $data);
    }

    public function prosesPayment(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);
        $id = $request->id;
        Inbound::where('id', $id)->update([
            'status_payment'    => 'Paid',
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil disubmit!'
        ]);
    }
}
