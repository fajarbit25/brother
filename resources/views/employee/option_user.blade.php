@foreach($result as $r)
    <option value="{{$r->id}}"> {{$r->name}} </option>
@endforeach