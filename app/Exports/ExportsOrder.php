<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportsOrder implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;
    protected $branch;

    public function __construct($start, $end, $branch)
    {
        $this->start = $start;
        $this->end = $end;
        $this->branch = $branch;
    }

    public function collection()
    {
        return Order::join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                    ->join('users', 'users.id', '=', 'orders.teknisi')
                    ->where('orders.branch_id', $this->branch)
                    ->whereBetween('tanggal_order', [$this->start, $this->end])
                    ->select('uuid', 'tanggal_order', 'costumer_name', 'costumer_phone', 'costumer_email',
                    'costumer_address', 'name', 'jadwal', 'progres', 'total_price', 'ppn', 'payment', 'status_invoice', 'nomor_nota', 'invoice_id')
                    ->get();
    }

    public function headings(): array
    {
        return [
            'Order Id',
            'Order Date',
            'Costumer Name',
            'Costumer Phone',
            'Costumer Email',
            'Costumer Address',
            'Technician',
            'Execute Time',
            'Progres Status',
            'Service Fee',
            'TAX',
            'Payment Method',
            'Payment Status',
            'Note Number',
            'Invoice Id',
        ];
    }
}
