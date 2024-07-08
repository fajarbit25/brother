$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#btn-approved").click(function(){
    $(this).attr('Disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/teknisi/material/approved";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        success:function(){
            console.log('approve success');
        },
        error:function(){
            $(this).attr('Disabled', false)
            $(this).html('<i class="bi bi-check-lg"></i> Approve Material')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan',
            })
        }
    });
});

function approveMaterial(id)
{
    var btnName = "#btn-approved-" + id;
    $(btnName).attr('disabled', true)
    $(btnName).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/teknisi/material/approved";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(){
            console.log('approve success');
            window.location = "/teknisi/material";
        },
        error:function(){
            $(this).attr('Disabled', false)
            $(this).html('<i class="bi bi-check-lg"></i> Approve Material')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan',
            })
        }
    });
}