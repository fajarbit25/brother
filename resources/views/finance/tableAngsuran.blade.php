@if(count($result) == 0)
    <tr>
        <td colspan="4">
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
            <td>{{$r->merk}}</td>
            <td>{{$r->plat}}</td>
            <td>
                <a href="/asset/{{$r->id}}/payment" class="btn btn-primary btn-xs">Check <i class="bi bi-arrow-right"></i></a>
            </td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4">
            {{$result->links()}}
        </td>
    </tr>
@endif