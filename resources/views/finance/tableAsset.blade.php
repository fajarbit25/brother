@if(count($result) == 0)
    <tr>
        <td colspan="8">
            <strong>
                <i>
                    Tidak ada data!
                </i>
            </strong>
        </td>
    </tr>
@else 
    @foreach ($result as $r)
        <tr>
            <td>{{$loop->iteration}}</td>
            <td>{{$r->roda}}</td>
            <td>{{$r->tipe}}</td>
            <td>{{$r->merk}}</td>
            <td>{{$r->plat}}</td>
            <td>{{$r->tahun}}</td>
            <td>{{$r->kondisi}}</td>
            <td>
                <button type="button" class="btn btn-success btn-xs" onclick="edit('{{$r->id}}', '{{$r->roda}}', '{{$r->tipe}}', '{{$r->plat}}', '{{$r->tahun}}', '{{$r->kondisi}}', '{{$r->merk}}')">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="8">
            {{$result->links()}}
        </td>
    </tr>
@endif