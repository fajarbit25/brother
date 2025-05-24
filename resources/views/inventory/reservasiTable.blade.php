@foreach($item as $itm)
<tr>
    <td>{{$loop->iteration}}</td>
    <td> {{ $itm->item_name ?? ''.' - '.$itm->merk ?? ''.' '.$itm->pk ?? '' }} </td>
    <td>{{$itm->product_code}}</td>
    <td> {{$itm->product_name}} </td>
    <td> {{$itm->qty}} </td>
    <td> {{number_format($itm->material_price)}} </td>
    <td> {{number_format($itm->sub_total)}} </td>
    <td>
        <button class="btn btn-danger btn-xs" onclick="deleteItem({{$itm->idoi}})"><i class="bi bi-trash3"></i></button>
    </td>
</tr>
@endforeach
<tr>
    <td colspan="6">Grand Total</td>
    <td colspan="">{{number_format($total)}}</td>
    <td></td>
</tr>
@if($total != 0)
{{-- <tr>
    <td colspan="7" class="text-end">
                <button  class="btn btn-success float-right" id="btn-submit">Submit Data</button>
                <button class="btn btn-success float-right" id="btn-loading-submit" type="button" disabled>
                  <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                  <span role="status">Loading...</span>
                </button>
    </td>
</tr> --}}
@endif
<script>
    $(document).ready(function(){
        $("#btn-loading-submit").hide();
    });
    
    /**Submit Outbound */
    $("#btn-submit").click(function(){
        /**Animasi */
        $("#btn-submit").hide();
        $("#btn-loading-submit").show();
    
        var order = $("#orderId").val();
        var url = "/reservasi/submit";
    
        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                order:order
            },
            success:function(response){
                window.location = "/inventory/outbound";
            },
            error:function(){
                /**Animasi */
                $("#btn-submit").show();
                $("#btn-loading-submit").hide();
    
                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Oops..',
                    subtitle: 'Error...',
                    body: 'Terjadi kesalahan!',
                })
            }
        });
    });

</script>
