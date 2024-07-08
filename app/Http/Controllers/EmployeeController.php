<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Cashbon;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\Products;
use App\Models\Productuser;
use App\Models\Role;
use App\Models\Salarie;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $data = [
            'title'     => 'Employee',
            'role'      => Role::all(),
            'branch'    => Branch::all(),
        ];
        return view('employee.index', $data);
    }

    /**Profile */
    public function profile($nik): View
    {
        $load = User::where('nik', $nik)->join('roles', 'roles.idrole', '=', 'users.privilege')->first();
        $data = [
            'title'     => 'Profile',
            'user'      => $load,
            'employee'  => Employee::where('user_id', $load->id)->first(),
            'role'      => Role::all(),
            'branch'    => Branch::all(),
        ];
        return view('employee.profile', $data);
    }
    public function userCard($nik): View
    {
        $load = User::where('nik', $nik)->join('roles', 'roles.idrole', '=', 'users.privilege')->first();
        $data = [
            'title'     => 'Profile',
            'user'      => $load,
            'employee'  => Employee::where('user_id', $load->id)->first(),
        ];
        return view('employee.userCard', $data);
    }
    public function general($nik): View
    {
        $load = User::where('nik', $nik)->join('roles', 'roles.idrole', '=', 'users.privilege')->first();
        $data = [
            'title'     => 'Profile',
            'user'      => $load,
            'employee'  => Employee::where('user_id', $load->id)->first(),
        ];
        return view('employee.general', $data);
    }
    function loadForm($nik)
    {
        $load = User::where('nik', $nik)->join('roles', 'roles.idrole', '=', 'users.privilege')->first();
        $data = [
            'user'  => $load,
            'employee'  => Employee::where('user_id', $load->id)->first(),
        ];
        echo json_encode($data);
    }

    /**Payroll */
    public function payroll(): View
    {
        $data = [
            'title'     => 'Employee Payroll',
            'cek_paid'  => Payroll::where('tag_paid', 1)->count(),   
        ];
        return view('employee.payroll', $data);
    }
    public function payrollDetail($id)//: View
    {
        $user = User::where('nik', $id)->join('roles', 'roles.idrole', '=', 'users.privilege')
                        ->join('payrolls', 'payrolls.user_id', '=', 'users.id')->first();

        /**Ambil data kehadirah */
        $bulan = date('m');
        $masuk = Attendance::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->sum('masuk');
        $izin = Attendance::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->sum('izin');
        $alfa = Attendance::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->sum('alfa');
        $lembur = Attendance::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->sum('lembur');
        $off = Attendance::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->sum('off');
        $cashbon = Cashbon::where('user_id', $user->id)->where('status', 'open')->sum('amount');
        $payroll = Payroll::where('user_id', $user->id)->first();
        $cashbonList = Cashbon::where('user_id', $user->id)->where('status', 'open')->get();
        /**Akumulasi alfa */
        $kehadiran = $izin+$alfa;

        $data = [
            'title'     => 'Payroll Detail',
            'user'      => $user,
            'absensi'   => Attendance::where('user_id', $user->id)->whereMonth('tanggal', $bulan)->get(),
            'kehadiran' => $kehadiran,
            'masuk'     => $masuk,
            'izin'      => $izin,
            'alfa'      => $alfa,
            'countlembur' => $lembur,
            'off'       => $off,
            'cashbon'   => $cashbon,
            'idkaryawan'=> $user->id,
            'payroll'   => $payroll,
            'listCashbon'=> $cashbonList,
        ];
        return view('employee.payrollDetail', $data);
    }

    public function prosesPayroll(Request $request)
    {
        $request->validate([
            'idkaryawan'        => 'required',
        ]);

        $payroll = Payroll::where('user_id', $request->idkaryawan)->first();
        $cashbon = Cashbon::where('user_id', $request->idkaryawan)->where('status', 'open')->sum('amount');

        $data = [
            'user_id'   => $request->idkaryawan,
            'periode'   => date('Y-m'),
            'pokok'     => $payroll->pokok,
            'makan'     => $payroll->makan,
            'bpjs'      => $payroll->bpjs,
            'tunjangan' => $payroll->tunjangan,
            'lembur'    => $request->lembur,
            'bon'       => $cashbon,
            'kehadiran' => $request->kehadiran,
        ];
        Salarie::create($data);
        Payroll::where('user_id', $request->idkaryawan)->update([
            'tag_paid'  => 1,
        ]);
        Cashbon::where('user_id', $request->idkaryawan)->where('status', 'open')
                    ->update([
                        'status'    => 'Close'
                    ]);
        
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil di update!',
        ]);
    }


    public function payrollTable(): View
    {
        $key = date('Y-m');
        $data = [
            'result'    => Payroll::join('users', 'users.id', '=', 'payrolls.user_id')
                            ->join('roles', 'roles.idrole', '=', 'users.privilege')
                            ->select('payrolls.*', 'name', 'nama_role as jabatan', 'nik')->get(),
            
        ];

        return view('employee.table_payroll', $data);
    }
    public function updatePayroll(Request $request)
    {
        $request->validate([
            'id'        => 'required',
            'pokok'     => 'required',
            'makan'     => 'required',
            'tunjangan' => 'required',
            'bpjs'      => 'required',
        ]);
        $id = $request->id;
        $data = [
            'pokok'     => $request->pokok,
            'makan'     => $request->makan,
            'tunjangan' => $request->tunjangan,
            'bpjs'      => $request->bpjs,
            'lembur'    => $request->lembur,
            'kehadiran' => $request->kehadiran,
        ];
        Payroll::where('id', $id)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil di update!',
        ]);
    }

    public function resetPayroll(Request $request)
    {
        Payroll::where('tag_paid', 1)->update([
            'tag_paid'  => 0,
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil di reset!',
        ]);
    }

    /** Load ajax table */
    public function ajaxTable(): View
    {
        if(Auth::user()->privilege == 1){
            $employees = User::join('employees', 'employees.user_id', '=', 'users.id')
                            ->join('branches', 'branches.idbranch', '=', 'users.branch_id')
                            ->join('roles', 'roles.idrole', '=', 'users.privilege')
                            ->where('is_active', 1)
                            ->orderBy('id', 'DESC')->paginate(10);
        }else{
            $employees = User::join('employees', 'employees.user_id', '=', 'users.id')
                            ->join('branches', 'branches.idbranch', '=', 'users.branch_id')
                            ->join('roles', 'roles.idrole', '=', 'users.privilege')
                            ->where('users.branch_id', Auth::user()->branch_id)
                            ->where('is_active', 1)
                            ->orderBy('id', 'DESC')->paginate(10);
        }
        $data = [
            'employees'     => $employees,
        ];
        return view('employee.ajaxTable', $data);
    }

    /** Load ajax table */
    public function search($key): View
    {
        if(Auth::user()->privilege == 1){
            $employees = User::join('employees', 'employees.user_id', '=', 'users.id')
                            ->join('branches', 'branches.idbranch', '=', 'users.branch_id')
                            ->join('roles', 'roles.idrole', '=', 'users.privilege')
                            ->orWhere('name', 'LIKE', '%'.$key.'%')
                            ->orWhere('nik', 'LIKE', '%'.$key.'%')
                            ->orWhere('phone', 'LIKE', '%'.$key.'%')
                            ->where('is_active', 1)
                            ->orderBy('id', 'DESC')->paginate(10000);
        }else{
            $employees = User::join('employees', 'employees.user_id', '=', 'users.id')
                            ->join('branches', 'branches.idbranch', '=', 'users.branch_id')
                            ->join('roles', 'roles.idrole', '=', 'users.privilege')
                            ->orWhere('name', 'LIKE', '%'.$key.'%')
                            ->orWhere('nik', 'LIKE', '%'.$key.'%')
                            ->orWhere('phone', 'LIKE', '%'.$key.'%')
                            ->where('is_active', 1)
                            ->where('users.branch_id', Auth::user()->branch_id)
                            ->orderBy('id', 'DESC')->paginate(10000);
        }
        $data = [
            'employees'     => $employees,
        ];
        return view('employee.ajaxTable', $data);
    }

    /**Simpan data ajax */
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|min:3',
            'email'             => 'required|email',
            'phone'             => 'required|min:10|max:14|unique:users',
            'nik'               => 'required|min:16|max:16',
            'kk'                => 'required|min:16|max:16',
            'telpon_darurat'    => 'required|min:10|max:14',
            'tempat_lahir'      => 'required|min:2',
            'tanggal_lahir'     => 'required|min:10|max:10',
            'alamat'            => 'required|min:4',
        ]);

        /**Generate NIK Karyawan */
        $tahun_masuk = date('y');
        $branch = $request->branch;
        $tahun_lahir = substr($request->tanggal_lahir, 2, 2);

        $loadNomorUrut = User::count();
        $nilaiJumlah = 100;
        $nomorUrut = $nilaiJumlah+$loadNomorUrut;

        if($nomorUrut > 999){
            $nomorAkhir = substr($nomorUrut, -3);
        }else{
            $nomorAkhir = $nomorUrut;
        }

        $nik = $tahun_masuk.$branch.$tahun_lahir.$nomorAkhir;

        $user = User::create([
            'nik'           => $nik,
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'privilege'     => $request->role,
            'is_active'     => 1,
            'branch_id'     => $request->branch,
            'password'      => Hash::make($nik),
            'foto'          => 'user_default.png',
            'teknisi_order_count' => 0,
        ]);

        Employee::create([
            'user_id'       => $user->id,
            'tanggal_masuk' => date('Y-m-d'),
            'gender'        => $request->gender,
            'ktp'           => $request->nik,
            'kk'            => $request->kk,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'telpon_darurat'=> $request->telpon_darurat,
            'pendidikan'    => $request->pendidikan,
            'alamat'        => $request->alamat,
        ]);

        Payroll::create([
            'user_id'       => $user->id,
            'pokok'         => 0,
            'makan'         => 0,
            'bpjs'          => 0,
            'tunjangan'     => 0,
            'lembur'        => 0,
            'kehadiran'     => 0,
            'tag_paid'      => 0,
        ]);
        
        $product = Products::all();
        foreach($product as $items){
            $cek = Productuser::where('produk_id', $items->diproduct)->where('teknisi_id', $user->id)->count();
            if($cek == 0){
                Productuser::create([
                    'teknisi_id'    => $user->id,
                    'produk_id'     => $items->diproduct,
                    'qty_awal'      => 0,
                    'qty'           => 0,
                    'reservasi_id'  => 0,
                    'retur'         => 0,
                ]);
            }
        }
        

        return response(['success' => 'Data Karyawan berhasil ditambahkan!']);
    }

    /**Update Data Karyawan */
    public function update(Request $request)
    {
        $request->validate([
            'user_nik'          => 'required',
            'nama'              => 'required|min:3',
            'email'             => 'required|email',
            'phone'             => 'required',
            'nik'               => 'required|min:16|max:16',
            'kk'                => 'required|min:16|max:16',
            'nomor_darurat'     => 'required|min:10|max:14',
            'tempat_lahir'      => 'required|min:2',
            'tanggal_lahir'     => 'required|min:10|max:10',
            'alamat'            => 'required|min:4',
        ]);

        $load = User::where('nik', $request->user_nik)->first();

        $dataUser = [
            'name'          => $request->nama,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'privilege'     => $request->privilege,
            'branch_id'     => $request->branch_id,
        ];
        User::where('id', $load->id)->update($dataUser);

        $dataEmployee = [
            'gender'        => $request->gender,
            'ktp'           => $request->nik,
            'kk'            => $request->kk,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'telpon_darurat'=> $request->nomor_darurat,
            'pendidikan'    => $request->pendidikan,
            'alamat'        => $request->alamat,
        ];
        Employee::where('user_id', $load->id)->update($dataEmployee);
        return response(['success' => 'Data Karyawan berhasil diupdate!']);
    }

    /**Absensi */
    public function absensi(): View
    {
        $data = [
            'title'     => 'Absensi Karyawan',
            'cek'       => Attendance::where('tag_absen', 0)->where('branch_id', Auth::user()->branch_id)->where('tanggal', date('Y-m-d'))->count(),
        ];

        return view('employee.absensi', $data);
    }

    public function newAbsen(Request $request)
    {
        $user = User::where('privilege', '>=', 2)->where('is_active', 1)
                    ->where('branch_id', Auth::user()->branch_id)->get();

        foreach($user as $u){
            Attendance::create([
                'tanggal'       => date('Y-m-d'),
                'jam_masuk'     => 0,
                'jam_pulang'    => NULL,
                'user_id'       => $u->id,
                'branch_id'     => $u->branch_id,
                'masuk'         => 0,
                'izin'          => 0,
                'alfa'          => 0,
                'lembur'        => 0,
                'off'           => 0,
                'tag_absen'     => 0,
                'alasan_lembur' => '-',
            ]);
        }

        return response()->json(['status' => 200]);
    }

    public function option_user(): View
    {
        $data = [
            'result'    => Attendance::where('tanggal', date('Y-m-d'))->where('tag_absen', 0)
                        ->join('users', 'users.id', '=', 'attendances.user_id')->get(),
        ];
        return view('employee.option_user', $data);
    }
    public function absenPost(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'absensi'   => 'required',
        ]);

        $jam = date('H:i');
        $absensi = $request->absensi;

        if($absensi == 'masuk'){
            Attendance::where('user_id', $request->user_id)->where('tanggal', date('Y-m-d'))
                        ->where('tag_absen', 0)->update([
                            'jam_masuk'     => $jam,
                            'jam_pulang'    => '--:--', 
                            'masuk'         => 1,
                            'tag_absen'     => 1,
                        ]);
        }elseif($absensi == 'izin'){
            Attendance::where('user_id', $request->user_id)->where('tanggal', date('Y-m-d'))
                        ->where('tag_absen', 0)->update([
                            'jam_masuk'     => '--:--',
                            'jam_pulang'    => '--:--', 
                            'izin'          => 1,
                            'tag_absen'     => 1,
                        ]);
        }elseif($absensi == 'alfa'){
            Attendance::where('user_id', $request->user_id)->where('tanggal', date('Y-m-d'))
                        ->where('tag_absen', 0)->update([
                            'jam_masuk'     => '--:--',
                            'jam_pulang'    => '--:--', 
                            'alfa'          => 1,
                            'tag_absen'     => 1,
                        ]);
        }elseif($absensi == 'off'){
            Attendance::where('user_id', $request->user_id)->where('tanggal', date('Y-m-d'))
                        ->where('tag_absen', 0)->update([
                            'jam_masuk'     => '--:--',
                            'jam_pulang'    => '--:--', 
                            'off'           => 1,
                            'tag_absen'     => 1,
                        ]);
        }

        return response()->json(['status' => 200, 'message' => 'Absensi berhasil!']);
    }

    public function data_table()
    {
        $data = [
            'title'     => 'Absensi Karyawan',
            'karyawan'  => Attendance::where('tanggal', date('Y-m-d'))->where('tag_absen', 1)
                            ->join('users', 'users.id', '=', 'attendances.user_id')
                            ->select('attendances.id as id', 'name', 'jam_masuk', 'jam_pulang',
                            'masuk', 'izin', 'alfa', 'off', 'lembur', 'alasan_lembur')->orderBy('attendances.updated_at', 'DESC')->get(),
            'cek'       => Attendance::where('tanggal', date('Y-m-d'))->where('tag_absen', 0)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'masuk'     => Attendance::where('tanggal', date('Y-m-d'))->where('masuk', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'izin'     => Attendance::where('tanggal', date('Y-m-d'))->where('izin', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'alfa'     => Attendance::where('tanggal', date('Y-m-d'))->where('alfa', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'lembur'     => Attendance::where('tanggal', date('Y-m-d'))->where('lembur', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'off'     => Attendance::where('tanggal', date('Y-m-d'))->where('off', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
        ];

        return view('employee.absen_table', $data);
    }

    public function addLembur(Request $request)
    {
        $request->validate([
            'id'            => 'required',
            'jam'           => 'required',
            'alasan_lembur' => 'required',
        ]);

        Attendance::where('id', $request->id)->update([
            'lembur'        => 1,
            'jam_pulang'    => $request->jam,
            'alasan_lembur' => $request->alasan_lembur,
        ]);

        return response()->json(['status' => 200, 'message' => 'Data lembur ditambahkan!']);
    }

    public function deleteAbsen(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        Attendance::where('id', $request->id)->update([
                'jam_masuk'     => 0,
                'jam_pulang'    => NULL,
                'masuk'         => 0,
                'izin'          =>  0,
                'alfa'          =>  0,
                'lembur'        =>  0,
                'off'           =>  0,
                'tag_absen'     =>  0,

        ]);

        return response()->json(['status' => 200, 'message' => 'Data Absen dihapus']);
    }
    public function absenPulang(Request $request)
    {
        $request->validate([
            'id'    => 'required',
        ]);

        Attendance::where('id', $request->id)->update(['jam_pulang' => date('H:i')]);
        return response()->json(['status' => 200, 'message' => 'Absen pulang selesai']);
    }

    public function reportAbsen() : View
    {
        $data = [
            'title'     => 'Laporan Absensi',
        ];
        return view('employee.absen_report', $data);
    }
    public function tablereportAbsen($start)
    {
        $data = [
            'result'    => Attendance::where('attendances.branch_id', Auth::user()->branch_id)
                            ->join('users', 'users.id', '=', 'attendances.user_id')
                            ->where('tanggal', $start)->get(),
            'masuk'     => Attendance::where('tanggal', $start)->where('masuk', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'izin'     => Attendance::where('tanggal', $start)->where('izin', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'alfa'     => Attendance::where('tanggal', $start)->where('alfa', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'lembur'     => Attendance::where('tanggal', $start)->where('lembur', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
            'off'     => Attendance::where('tanggal', $start)->where('off', 1)
                            ->where('branch_id', Auth::user()->branch_id)->count(),
        ];
        return view('employee.table_report_absen', $data);
    }
    /**End absensi */

    /**Role User */

     /**Role User */
     public function role():View
     {
        $data = [
            'title'     => 'Role User',
        ];
        return view('employee.role', $data);
     }

     /**Table Role */
     public function tableRole():View
     {
        $data = [
            'result'    => Role::all(),
        ];
        return view('employee.tableRole', $data);
     }

     /**Update Role */
     public function updateRole(Request $request)
     {
        $request->validate([
            'idrole'        => 'required',
            'kode'          => 'required',
            'nama'          => 'required',
        ]);
        $idrole = $request->idrole;
        $data = [
            'kode_role'     => $request->kode,
            'nama_role'     => $request->nama,
        ];
        Role::where('idrole', $idrole)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasil diupdate!',
        ]);
     }

     /**Upload Foto Profile */
     public function uploadFoto(Request $request)
     {
        $request->validate([
            'foto'    => 'required|image|mimes:jpeg,png,jpg,gif|max:10000',
            'user_id' => 'required',
        ]);
        

        /**upload */
        $gambar = $request->file('foto');
        $nama_gambar = time().'.'.$gambar->getClientOriginalExtension();
        $path = $gambar->storeAs('public/foto-user', $nama_gambar);

        User::where('id', $request->user_id)->update([
            'foto'      => $nama_gambar,
        ]);
        return response()->json([
            'status'    => 200,
            'message'   => 'Foto profile diperbaharui!',
        ]);
     }

     /**kantor Cabang */
     public function branch():View
     {
        $data = [
            'title'     => 'Kantor Cabang',
        ];
        return view('employee.branch', $data);
     }

     /** Table Cabang */
     public function tableBranch():View
     {
        $data = [
            'result'    => Branch::all(),
        ];
        return view('employee.tableBranch', $data);
     }

     /**update branch */
     public function updateBranch(Request $request)
     {
        $request->validate([
            'idbranch'      => 'required',
            'id_office'     => 'required',
            'branch_name'   => 'required',
            'branch_address'=> 'required'
        ]);
        $id = $request->idbranch;
        $data = [
            'id_office'     => $request->id_office,
            'branch_name'   => $request->branch_name,
            'branch_address'=> $request->branch_address,
        ];
        Branch::where('idbranch', $id)->update($data);
        return response()->json([
            'status'    => 200,
            'message'   => 'Data berhasi diupdate!',
        ]);
     }

     /**Ganti Password */
     public function gantiPassword(Request $request)
     {
        $request->validate([
            'password' => 'required',
            'new_password' => 'required|min:6',
            'repeat_password' => 'required|same:new_password',
        ]);


        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('status', 'Current password is incorrect.');
        }

        $new_password = Hash::make($request->new_password);

        User::where('id', $user->id)->update([
            'password'  => $new_password,
        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');

     }
}
