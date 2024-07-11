<tbbody>
    @if(count($order) == 0)
        <tr>
            <td colspan="6">
                <strong>
                    <i>Tidak ada data!</i>
                </strong>
            </td>
        </tr>
    @else
        @foreach($order as $o)
            <tr>
                <td> {{$loop->iteration}} </td>
                <td>
                    <a href="/order/{{$o->uuid}}/show">{{$o->uuid}}</a>
                </td>
                <td> {{$o->costumer_name}} </td>
                <td> 
                    @if($o->invoice_id == 'none')
                        <button class="btn btn-primary btn-xs" onclick="modalInvoice({{$o->idorder}})">
                            <i class="bi bi-plus-circle"></i> Buat Invoice
                        </button>
                    @else
                        {{$o->invoice_id}} 
                    @endif
                </td>
                <td>{{$o->invoice_date}}</td>
                <td>
                    @php
                        $tanggalJatuhTempo = Carbon\Carbon::parse($o->due_date);
                        $sekarang = Carbon\Carbon::now();
                        $selisihHari = $sekarang->diffInDays($tanggalJatuhTempo);
                    @endphp

                    @if ($selisihHari <= 5)
                    <span style="color: red;">{{$o->due_date}} (H-{{ $selisihHari }})</span>
                    @else
                        {{$o->due_date}}
                    @endif
                </td>
                <td>
                    @if($o->status == 'Create') <span class="badge badge-secondary">{{$o->status}}</span>
                    @elseif($o->status == 'Review') <span class="badge badge-warning">{{$o->status}}</span>
                    @elseif($o->status == 'Approved') <span class="badge badge-primary">{{$o->status}}</span>
                    @elseif($o->status == 'Sending') <span class="badge badge-info">{{$o->status}}</span>
                    @else <span class="badge badge-success">{{$o->status}}</span> @endif
                </td>
                <td>
                    @if($o->invoice_id != 'none')
                        <button class="btn btn-success btn-xs" onclick="modalEditInvoice('{{$o->invoice_date}}', '{{$o->idorder}}', '{{$o->invoice_id}}', '{{$o->total_tagihan}}')">
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                    @else
                        <button class="btn btn-success btn-xs" disabled>
                            <i class="bi bi-pencil-square"></i> Edit
                        </button>
                    @endif
                    
                    @if($o->file == 'none')
                        <button type="button" class="btn btn-danger btn-xs" title="Upload Invoice" onclick="modalUpload({{$o->id}})">
                            <i class="bi bi-upload"></i> Upload
                        </button>
                    @else
                        {{-- <button type="button" class="btn btn-primary btn-xs" title="Lihat Invoice" onclick="viewInvoice('{{$o->file}}', '{{$o->costumer_name}}')">
                            <i class="bi bi-eye"></i>
                        </button> --}}
                        <a href="/storage/invoice/{{$o->file}}" target="_blank" class="btn btn-primary btn-xs" title="Lihat Invoice">
                            <i class="bi bi-eye"></i> Lihat
                        </a>

                        @if(Auth::user()->privilege == 1)
                            @if($o->status == 'Review')
                                <button id="btn-approve-{{$o->id}}" onclick="approveInvoice({{$o->id}})" class="btn btn-info btn-xs" title="Lihat Invoice">
                                    <i class="bi bi-check-circle"></i> Approve
                                </button>
                            @endif
                        @endif

                        @if($o->status == 'Approved')
                            <button id="btn-send-{{$o->id}}" onclick="sendInvoice({{$o->id}})" class="btn btn-danger btn-xs" title="Lihat Invoice">
                                <i class="bi bi-send-check-fill"></i> Kirim
                            </button>
                        @endif

                        @if($o->status == 'Sending')
                            <button id="btn-paid-{{$o->id}}" onclick="paidInvoice({{$o->id}})" class="btn btn-warning btn-xs" title="Lihat Invoice">
                                <i class="bi bi-database-check"></i> Paid
                            </button>
                        @endif

                    @endif
                </td>
            </tr>
        @endforeach
    @endif
</tbbody>