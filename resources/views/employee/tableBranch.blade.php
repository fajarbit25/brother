@foreach($result as $r)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$r->id_office}}</td>
        <td>{{$r->branch_name}}</td>
        <td>{{$r->branch_address}}</td>
        <td>
            <button type="button" class="btn btn-success btn-xs" onclick="editBranch('{{$r->idbranch}}', '{{$r->id_office}}', '{{$r->branch_name}}', '{{$r->branch_address}}')">
                <i class="bi bi-pencil-square"></i>
            </button>
        </td>
    </tr>
@endforeach