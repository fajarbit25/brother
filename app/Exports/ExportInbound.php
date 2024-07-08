<?php

namespace App\Exports;

use App\Models\Inbounditem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportInbound implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function collection()
    {
        return Inbounditem::join('products', 'products.diproduct', 'inbounditems.product_id')
                ->join('inbounds', 'inbounds.id', '=', 'inbounditems.inbound_id')
                ->join('suppliers', 'suppliers.idsupplier', '=', 'inbounds.supplier_id')
                ->join('branches', 'branches.idbranch', '=', 'inbounds.branch_id')
                ->whereBetween('inbounds.tanggal', [$this->start, $this->end])
                ->select('tanggal', 'do', 'supplier_name', 'product_name', 'harga_beli', 'harga_jual', 'qty', 'jumlah', 'branch_name')
                ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal Transaksi',
            'Delivery Order',
            'Nama Supplier',
            'Nama Barang',
            'Harga Beli',
            'Harga Jual',
            'Qty',
            'Jumlah',
            'Cabang',
        ];
    }
}
