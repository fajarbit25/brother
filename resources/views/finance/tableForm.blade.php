@if(count($result) == 0)
    <tr>
        <td colspan="6">
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
            <td>
                <input type="date" class="form-control form-control-sm" name="jatuh_tempo" id="jatuh_tempo-{{$r->id}}" value="{{$r->jatuh_tempo}}">
            </td>
            <td>
                <input type="text" class="form-control form-control-sm" name="pembiayaan" id="pembiayaan-{{$r->id}}" value="{{$r->pembiayaan}}">
            </td>
            <td>
                <input type="number" class="form-control form-control-sm" name="jumlah" id="jumlah-{{$r->id}}" value="{{$r->jumlah}}">
            </td>
            <td>
                @if($r->lunas == 'OK')
                    <button class="btn btn-success btn-sm" disabled>Lunas</button>
                @else
                    <button class="btn btn-warning btn-sm" disabled>Belum Lunas</button>
                @endif
            </td>
            <td>
                @if($r->tag_lock == 0)
                    @if($r->lunas == 'OK')
                        
                    @else
                    <button class="btn btn-primary btn-sm" id="btn-set-bayar-{{$r->id}}" onclick="setBaya({{$r->id}})" >Set Terbayar</button>
                    @endif
                @else
                    @if($r->lunas == 'OK')

                    @else
                    <button class="btn btn-primary btn-sm" id="btn-bayar-{{$r->id}}" onclick="bayarAngsuran({{$r->id}})">Bayar Sekarangan</button>
                    @endif
                @endif
            </td>
            <td>
                @if($r->lunas == 'OK')      
                @else
                    <button class="btn btn-success btn-sm" id="btn-update-form-{{$r->id}}" onclick="updateForm({{$r->id}})">Update</button>
                    <button class="btn btn-danger btn-sm" id="btn-delete-{{$r->id}}" onclick="deleteForm({{$r->id}})"><i class="bi bi-trash3"></i></button>
                @endif
            </td>
        </tr>
    @endforeach
@endif