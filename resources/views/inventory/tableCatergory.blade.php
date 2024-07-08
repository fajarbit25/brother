@foreach($result as $r)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$r->category_code}}</td>
        <td>{{$r->category_name}}</td>
        <td>
            <button type="button" class="btn btn-success btn-xs" onclick="editCategory('{{$r->idcat}}', '{{$r->category_code}}', '{{$r->category_name}}')">
                <i class="bi bi-pencil-square"></i>
            </button>
        </td>
    </tr>
@endforeach