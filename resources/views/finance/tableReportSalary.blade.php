@if(count($result) == 0)
    <tr>
        <td colspan="11">
            <strong>
                <i>
                    Tidak Ada Data!
                </i>
            </strong>
        </td>
    </tr>
@else 
    @foreach($result as $r)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$r->nik}}</td>
            <td>{{$r->name}}</td>
            <td>{{number_format($r->pokok)}}</td>
            <td>{{number_format($r->makan)}}</td>
            <td>{{number_format($r->bpjs)}}</td>
            <td>{{number_format($r->tunjangan)}}</td>
            <td>{{number_format($r->lembur)}}</td>
            <td>{{number_format($r->bon)}}</td>
            <td>{{number_format($r->kehadiran)}}</td>
            <td>
                {{number_format($r->pokok+$r->makan+$r->tunjangan+$r->lembur-$r->bpjs-$r->bon-$r->kehadiran)}}
            </td>
        </tr>
    @endforeach

@endif