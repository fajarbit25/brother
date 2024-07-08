<?php

namespace App\Http\Controllers;

use App\Models\Costumer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CostumerController extends Controller
{
    public function __construct()
    {
        //
    }

    /**Data Pelanggan */
    public function index(): View
    {
        $data = [
            'title'     => 'List Costumers',
        ];
        return view('costumers.index', $data);
    }

    /**Simpan data pelanggan */
    public function store(Request $request)
    {
        $request->validate([
            'costumer_name'    => 'required|min:3',
            'costumer_phone'   => 'required|min:10|max:14|unique:costumers',
        ]);

        /**Generate Id Pelanggan */
        $count = Costumer::count();
        $jumlah = 1000+$count;
        $kode = 'BTI'.$jumlah;


        Costumer::create([
            'costumer_kode'     => $kode,
            'costumer_name'     => $request->costumer_name,
            'costumer_pic'      => $request->costumer_pic,
            'costumer_phone'    => $request->costumer_phone,
            'costumer_email'    => $request->costumer_email,
            'costumer_address'  => $request->costumer_address,
            'costumer_status'   => 'Bronze',
            'jumlah_order'      => 0,
            'branch_id'         => Auth::user()->branch_id,
        ]);
        return response(['success' => 'Data pelanggan berhasil ditambahkan!']);
    }

    /**Load Ajax table */
    public function ajaxTable()
    {
        if(Auth::user()->privilege == 1){
            $costumers = Costumer::orderBy('idcostumer', 'DESC')
                        ->join('branches', 'branches.idbranch', '=', 'costumers.branch_id')
                        ->paginate(10);
        }else{
            $costumers = Costumer::where('branch_id', Auth::user()->branch_id)
                        ->join('branches', 'branches.idbranch', '=', 'costumers.branch_id')
                        ->orderBy('idcostumer', 'DESC')->paginate(10);
        }

        $data = [
            'result'    => $costumers,
        ];
        return view('costumers.ajaxTable', $data);
    }

    /**Pencarian Ajax */
    public function ajaxSearch($key)
    {
        if(Auth::user()->privilege == 1){
            $costumers = Costumer::where('costumer_name', 'LIKE', '%'.$key.'%')
                            ->orWhere('costumer_phone', 'LIKE', '%'.$key.'%')
                            ->orWhere('costumer_pic', 'LIKE', '%'.$key.'%')
                            ->paginate(1000);
        }else{
            $costumers = Costumer::where('costumer_name', 'LIKE', '%'.$key.'%')
                            ->orWhere('costumer_phone', 'LIKE', '%'.$key.'%')
                            ->orWhere('costumer_pic', 'LIKE', '%'.$key.'%')
                            ->where('branch_id', Auth::user()->branch_id)
                            ->paginate(1000);
        }

        $data = [
            'result'    => $costumers,
        ];
        return view('costumers.ajaxTable', $data);
    }

    /**Edit Ajax */
    public function edit($id)
    {
        $data = Costumer::where('idcostumer', $id)->get();
        return json_encode($data);
    }

    /**Update Ajax */
    public function update(Request $request)
    {
        $request->validate([
            'idcostumer'       => 'required',
            'costumer_name'    => 'required|min:3',
            'costumer_phone'   => 'required|min:10|max:14',
        ]);

        $data = [
            'costumer_name'     => $request->costumer_name,
            'costumer_pic'      => $request->costumer_pic,
            'costumer_phone'    => $request->costumer_phone,
            'costumer_email'    => $request->costumer_email,
            'costumer_address'  => $request->costumer_address,
            'costumer_status'   => $request->costumer_status,
        ];
        Costumer::where('idcostumer', $request->idcostumer)->update($data);
        return response(['success'  => 'Data pelanggan berhasil di update!']);
    }

    /**Delete Ajax */
    public function destroy(Request $request)
    {
        $request->validate([
            'idcostumer'    => 'required',
        ]);
        Costumer::where('idcostumer', $request->idcostumer)->delete();
        return response(['success' => 'Data pelanggan berhasil dihapus!']);
    }
}
