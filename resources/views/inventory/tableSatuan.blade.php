@foreach($result as $r)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$r->unit_code}}</td>
        <td>{{$r->unit_name}}</td>
        <td>
            <button type="button" class="btn btn-success btn-xs" onclick="editSatuan('{{$r->idunit}}', '{{$r->unit_code}}', '{{$r->unit_name}}')">
                <i class="bi bi-pencil-square"></i>
            </button>
        </td>
    </tr>
@endforeach