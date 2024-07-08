@foreach($result as $r)
<tr>
    <td>{{$loop->iteration}}</td>
    <td>
        <span class="text-primary">{{$r->nik}}</span> {{$r->name}}
    </td>
    <td>{{$r->jabatan}}</td>
    <td>{{number_format($r->pokok)}}</td>
    <td>{{number_format($r->makan)}}</td>
    <td>{{number_format($r->tunjangan)}}</td>
    <td>{{number_format($r->bpjs)}}</td>
    <td>{{number_format($r->lembur)}}</td>
    <td>{{number_format($r->kehadiran)}}</td>
    <td>
        @if($r->tag_paid == 0)
            <span class="badge badge-warning">Unpaid</span>
        @else 
            <span class="badge badge-success">Paid</span>
        @endif
    </td>
    <td>
        <button class="btn btn-success btn-xs" 
        onclick="edit('{{$r->user_id}}', '{{$r->pokok}}', '{{$r->makan}}', '{{$r->tunjangan}}', '{{$r->bpjs}}', '{{$r->name}}', '{{$r->jabatan}}', '{{$r->lembur}}', '{{$r->kehadiran}}')">
            <i class="bi bi-pencil-square"></i> Edit
        </button>
        <a href="/employee/{{$r->nik}}/payroll" class="btn btn-primary btn-xs">
            @if($r->tag_paid == 0)
                Proses 
            @else 
                Check
            @endif
        <i class="bi bi-chevron-right"></i></a>
    </td>
</tr>
@endforeach
