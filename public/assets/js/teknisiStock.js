$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

function modalRetur(id)
{
    $("#retur-modal").modal('show')
    $("#idretur").val(id)
    console.log(id)
}

function prosesRetur()
{
    $("#btn-proses-return").attr('Disabled', true);
    $("#btn-proses-return").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var id = $("#idretur").val();
    var qty = $("#qty-retur").val();
    var url = "/teknisi/return";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            qty:qty,
        },
        success:function(response){
            if(response.status === 404){
                $("#btn-proses-return").attr('Disabled', false);
                $("#btn-proses-return").html('Proses Retur')
                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Oopss..',
                    subtitle: 'Error...',
                    body: response.message,
                })
                $("#retur-modal").modal('hide')
            }else{
                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Congrats..',
                    subtitle: 'Success...',
                    body: response.success,
                })
                window.location = "/teknisi/stock";
            }
            
        },
        error:function(){
            $("#btn-proses-return").attr('Disabled', false);
            $("#btn-proses-return").html('Proses Retur')
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oopss..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan',
            })
        }
    });
}