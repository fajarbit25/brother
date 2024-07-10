$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadtable()
});

function loadtable()
{
    var url = "/inventory/return/table";
    $("#table-return").load(url);
}

function approveRetur(id, product, teknisi)
{
    var btn = "#btn-approve-" + id;
    $(btn).attr('disabled', true)
    $(btn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/inventory/return/approve";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            product:product,
            teknisi:teknisi
        },
        success:function(response){
            $(btn).addClass('btn btn-success')
            $(btn).html('<i class="bi bi-check-circle"></i> Approved')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Cangrats..',
                subtitle: 'Success',
                body: response.message,
            })

        },
        error:function(){
            $(btn).attr('disabled', false)
            $(btn).html('<i class="bi bi-pencil-square"></i> Approve')

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Subtitle',
                body: 'Terjadi kesalahan'
            })
        }
    });


}

function deleteRetur(id, product, teknisi)
{
    var btn = "#btn-delete-retur-" + id;
    $(btn).attr('disabled', true)
    $(btn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> deleting...')

    var url = "/inventory/return/delete";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            product:product,
            teknisi:teknisi
        },
        success:function(response){
            $(btn).html('<i class="bi bi-check-circle"></i> deleted')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Cangrats..',
                subtitle: 'Success',
                body: response.message,
            })

        },
        error:function(){
            $(btn).attr('disabled', false)
            $(btn).html('<i class="bi bi-trash3"></i>')

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Subtitle',
                body: 'Terjadi kesalahan'
            })
        }
    });

}