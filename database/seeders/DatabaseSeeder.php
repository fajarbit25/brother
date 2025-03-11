<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Costumer;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Merk;
use App\Models\Opsitem;
use App\Models\Payroll;
use App\Models\Products;
use App\Models\Role;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'nik'           => '24000001',
            'name'          => 'Cecep Firmansyah',
            'email'         => 'cecep@gmail.com',
            'phone'         => '081000000001',
            'privilege'     => 1,
            'is_active'     => 1,
            'branch_id'     => 1,
            'password'      => Hash::make('brotech'),
            'foto'          => 'user_default.png',
        ]);
        
        Employee::create([
            'user_id'       => 1,
            'tanggal_masuk' => '2020-12-01',
            'gender'        => 'Laki-laki',
            'ktp'           => '7300000000000001',
            'kk'            => '7300000000000002',
            'tempat_lahir'  => 'Makassar',
            'tanggal_lahir' => '2023-12-31',
            'telpon_darurat'=> '081342342342',
            'pendidikan'    => 'Diploma',
            'alamat'        => 'Jl. Rappokalling Raya Lr.1 No.6 Makassar'
        ]);
        
        Payroll::create([
            'user_id'       => 1,
            'pokok'         => 0,
            'makan'         => 0,
            'bpjs'          => 0,
            'tunjangan'     => 0,
            'lembur'        => 0,
            'kehadiran'     => 0,
            'tag_paid'      => 0,
        ]);




        Branch::create([
            'id_office'     =>'BTIMKS01',
            'branch_name'   => 'Makassar',
            'branch_address'=> 'Jl. Rappokalling Raya Lr.1 No.6 Makassar',
            'owner'         => 1,
            'manager_area'  => 0,
        ]);
        Branch::create([
            'id_office'     =>'BTIENR01',
            'branch_name'   => 'Enrekang',
            'branch_address'=> 'Jl. Emmy Saelan No.2, Juppandang, Enrekang',
            'owner'         => 1,
            'manager_area'  => 0,
        ]);
        Branch::create([
            'id_office'     =>'BTIPAL01',
            'branch_name'   => 'Palopo',
            'branch_address'=> 'Jl. Rambutan Ruko Terminal No. 21 E, Wara, Palopo',
            'owner'         => 1,
            'manager_area'  => 0,
        ]);


        /**Role */
        Role::create(['kode_role' => 'CEO', 'nama_role' => 'Direktur']);
        Role::create(['kode_role' => 'SEK', 'nama_role' => 'Sekretaris']);
        Role::create(['kode_role' => 'MGR', 'nama_role' => 'Manager Area']);
        Role::create(['kode_role' => 'SPV', 'nama_role' => 'Supervisior']);
        Role::create(['kode_role' => 'WH', 'nama_role' => 'Admin Warehouse']);
        Role::create(['kode_role' => 'CS', 'nama_role' => 'Costumer Service']);
        Role::create(['kode_role' => 'FIN', 'nama_role' => 'Finance']);
        Role::create(['kode_role' => 'HR', 'nama_role' => 'Human Resource']); 
        Role::create(['kode_role' => 'TK', 'nama_role' => 'Teknisi']);
        Role::create(['kode_role' => 'HP', 'nama_role' => 'Helper']);

        Item::create(['item_name' => 'Cleaning']);
        Item::create(['item_name' => 'Bongpas']);
        Item::create(['item_name' => 'Service']);
        Item::create(['item_name' => 'Pengecekan']);
        Item::create(['item_name' => 'Pasang Baru']);
        Item::create(['item_name' => 'Pasang Second']);
        Item::create(['item_name' => 'Pekerjaan Civil']);
        Item::create(['item_name' => 'Drain']);
        Item::create(['item_name' => 'Bongkar Unit']);
        Item::create(['item_name' => 'Komplain']);
        Item::create(['item_name' => 'Pengelasan']);
        Item::create(['item_name' => 'Pipa Drain']);
        Item::create(['item_name' => 'Tarik Pipa']);
        Item::create(['item_name' => 'Modul']);

        Unit::create(['unit_code' => 'UNIT', 'unit_name' => 'Unit']);
        Unit::create(['unit_code' => 'PCS', 'unit_name' => 'Pcs']);
        Unit::create(['unit_code' => 'BTG', 'unit_name' => 'Batang']);
        Unit::create(['unit_code' => 'M', 'unit_name' => 'Meter']);
        Unit::create(['unit_code' => 'CM', 'unit_name' => 'Centimeter']);
        Unit::create(['unit_code' => 'L', 'unit_name' => 'Liter']);
        Unit::create(['unit_code' => 'GR', 'unit_name' => 'Gram']);
        Unit::create(['unit_code' => 'KG', 'unit_name' => 'Kilogram']);
        Unit::create(['unit_code' => 'PSI', 'unit_name' => 'Pound per Square Inch']);

        Category::create(['category_code' => 'UNIT', 'category_name' => 'Air Conditioner']);
        Category::create(['category_code' => 'PIPA', 'category_name' => 'Pipa']);
        Category::create(['category_code' => 'KABL', 'category_name' => 'Kabel Listrik']);
        Category::create(['category_code' => 'ACCS', 'category_name' => 'Aksesories']);
        
        Opsitem::create(['item' => 'BBM']);
        Opsitem::create(['item' => 'Komsumsi']);
        Opsitem::create(['item' => 'Kebutuhan Kantor']);
        Opsitem::create(['item' => 'Lainnya']);
    }
}
