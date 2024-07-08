<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class ExportsInvoice implements FromCollection, WithHeadings
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
        return Invoice::whereBetween('invoice_date', [$this->start, $this->end])
            ->join('orders', 'orders.idorder', '=', 'invoices.order_id')
            ->join('costumers', 'costumers.idcostumer', 'orders.costumer_id')
            ->select('uuid', 'costumer_name', 'invoice_id', 'invoice_date', 'due_date', 'tanggal_order', 'invoices.status as status',
            'total_tagihan', 'costumer_phone', 'costumer_email', 'costumer_address')
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Order',
            'Customer Name',
            'Invoice ID',
            'Invoice Date',
            'Due Date',
            'Order Date',
            'Status',
            'Total Invoice',
            'Costumer Phone',
            'Costumer Email',
            'Costumer Address',
        ];
    }
}
