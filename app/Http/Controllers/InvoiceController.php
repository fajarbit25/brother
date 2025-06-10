<?php

namespace App\Http\Controllers;

use App\Exports\ExportsInvoice;
use App\Models\AccountingApproval;
use App\Models\CompanySaldo;
use App\Models\Invoice;
use App\Models\Operational;
use App\Models\Opsitem;
use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SebastianBergmann\Exporter\Exporter;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('invoice');
    }
    public function index():View
    {
        $data = [
            'title'     => 'List order Unpaid',
        ];
        return view('invoice.index', $data);
    }
    public function table():View
    {
        $data = [
            'order' => Order::where('payment', 'Termin')->where('orders.status', 'Open')
                        ->join('costumers', 'costumers.idcostumer', '=', 'orders.costumer_id')
                        ->join('invoices', 'invoices.order_id', '=', 'orders.idorder')
                        ->orderby('due_date', 'ASC')->get(),
        ];
        return view('invoice.table', $data);

    }
    public function update(Request $request)
    {
        $request->validate([
            'idorder'       => 'required',
            'inv_date'      => 'required',
            'invoice_id'    => 'required', //nomor invoice
            'total'         => 'required',
        ]);

        /**load */
        $load = Order::where('idorder', $request->idorder)->first();
        $loadInv = Invoice::where('order_id', $request->idorder)->first();

        /**update */
        Order::where('idorder', $request->idorder)->update([
            'invoice_id'    => $request->invoice_id,
        ]);
        Invoice::where('id', $loadInv->id)->update([
            'invoice_date'      => $request->inv_date,
            'total_tagihan'     => $request->total,
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'Invoice dibuat!',
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10048',
            'id_invoice_upload' => 'required',
        ]);

        $pdfFile = $request->file('pdf_file');
        $fileName = time() . '_' . date('y-m-d').'.pdf';

        // Pindahkan file ke direktori storage
        $pdfFile->storeAs('invoice', $fileName, 'public');

        /**Update database */
        $invoices = Invoice::where('id', $request->id_invoice_upload)
                ->get();

        //Looping
        foreach ($invoices as $invoice) {

            Invoice::where('nomor', $invoice->nomor)->update([
                'file'      => $fileName,
                'status'    => 'Review',
            ]);

        }

        return response()->json([
            'status'    => 200,
            'message'   => 'Invoice diupload, tunggu feedback dari owner!',
        ]);
    }

    public function viewPdf($name)
    {
        $pdfPath = Storage::path('storage\\invoice\\'.$name); //In windows

        return response()->file($pdfPath);
    }

    public function approve(Request $request)
    {
        $request->validate([
            'id'        => 'required',
        ]);

        $id = $request->id;

        $invoice = Invoice::findOrFail($request->id);
        $invoice->update([
            'status'    => 'Approved',
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'Invoice di Approve',
        ]);
    }
    public function send(Request $request)
    {
        $request->validate([
            'id'        => 'required',
        ]);

        $id = $request->id;

        $invoice = Invoice::findOrFail($request->id);
        $invoice->update([
            'status'    => 'Sending',
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'Invoice di Terkirim',
        ]);
    }

    public function paid(Request $request)
    {
        $request->validate([
            'id'        => 'required',
            'method'    => 'required',
        ]);

        $id = $request->id;
        $method = $request->method;

        $invoice = Invoice::findOrFail($id);
        
        $order = Order::join('invoices', 'invoices.nomor', '=', 'orders.invoice_id')
                ->where('orders.invoice_id', $invoice->invoice_id)
                ->select('orders.idorder', 'invoices.id')->get();
        
        Invoice::where('nomor', $invoice->nomor)->update([
                    'status'    => 'Paid',
                    'payment_method'    => $method,
                ]);

        foreach($order as $item){
            Order::where('idorder', $item->idorder)->update([
                'status'            => 'Close',
                'status_invoice'    => 'Paid',
                'tag_invoice'       => 1,
            ]);
        }

        /**Create Operational */
        $akun = Opsitem::where('item', 'Jasa Invoice')->first();
        $data = [
            'trx_id'    => $invoice->nomor,
            'tipe'      => 'IN',
            'metode'    => $method,
            'jenis'     => $akun->id,
            'branch_id' => Auth::user()->branch_id,
            'approved'  => 1,
            'keterangan'=> 'Invoice Payment '.$invoice->nomor,
            'status'    => 'Success',
            'pesan'     => '-',
            'user_id'   => Auth::user()->id,
            'amount'    => $invoice->total_tagihan,
            'saldo'     => 0,
            'bukti_transaksi' => $invoice->file ?? '-',
            'nomor_nota'=> '-',
        ];
        Operational::create($data);

        /**Penambahan saldo */
        $saldoData = CompanySaldo::where('tipe', $method)
                ->where('branch_id', Auth::user()->branch_id)
                ->first();
        $companySaldo = CompanySaldo::findOrFail($saldoData->id);
        $companySaldo->update([
            'saldo'     => $saldoData->saldo + $invoice->total_tagihan,
        ]);
        /**End Of Penambahan saldo */

        /**Create Approval */
        AccountingApproval::create([
            'branch'        => Auth::user()->branch_id,
            'segment'       => 'Jasa Invoice',
            'referensi_id'  => $invoice->nomor,
            'tanggal'       => date('Y-m-d'),
            'tipe'          => 'debit',
            'payment_method'=> $method,
            'amount'        => $invoice->total_tagihan,
            'approval'      => 'new',
            'akun_id'       => $akun->id,
        ]);

        return response()->json([
            'status'    => 200,
            'message'   => 'Invoice telah terbayar',
        ]);
    }

    public function report(): View
    {
        $data = [
            'title'     => 'Laporan Invoice',
        ];
        return view('invoice.report', $data);
    }

    public function reportfilter($start, $end): View
    {
        $data = [
            'result' => Invoice::whereBetween('invoice_date', [$start, $end])
                        ->join('orders', 'orders.idorder', '=', 'invoices.order_id')
                        ->join('costumers', 'costumers.idcostumer', 'orders.costumer_id')
                        ->select('uuid', 'costumer_name', 'invoice_id', 'invoice_date', 'due_date', 'invoices.status as status', 'total_tagihan')->paginate(10),
        ];
        return view('invoice.table_report', $data);
    }

    public function export($start, $end)
    {
        return Excel::download(new ExportsInvoice($start, $end), 'invoice_report_'.$start.'_sd_'.$end.'.xlsx');
    }

}
