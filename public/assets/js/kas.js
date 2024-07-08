$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadTable()
});

function loadTable()
{
    var url = "/finance/tableKhas";
    $("#table-kas").load(url)
}

/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/finance/tableKhas?page="+ prevPage;
    $("#table-kas").load(url);
}
function paginationPage(page)
{
    var url = "/finance/tableKhas?page="+ page;
    $("#table-kas").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/finance/tableKhas?page="+ nextPage;
    $("#table-kas").load(url);
}
/**End Pagination */

$("#btn-modal").click(function(){
    $("#modal-kas").modal('show');
});

$("#btn-submit").click(function(){
    $(this).attr('disabled', true);
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var form = $("#form-kas")[0];
    var data = new FormData(form);
    var url = "/finance/khas/store";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            $("#btn-submit").attr('disabled', false);
            $("#btn-submit").html('Submit')

            /**Close modal & reset Form */
            $("#form-kas")[0].reset();
            $("#modal-kas").modal('hide');

            loadTable()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

        },
        error:function(){
            $("#btn-submit").attr('disabled', false);
            $("#btn-submit").html('Submit')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: 'Terjadi kesalahan, Periksa Koneksi Anda!',
            })
        }
    });
});