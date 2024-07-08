$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadTable();

    $("#filter").hide();
});

function filter()
{
    $("#filter").show();
}

function filterProses()
{
    var bulan = $("#bulan").val();
    var karyawan = $("#karyawan").val();
    var url = "/cashbon/" + karyawan + "/" + bulan + "/filter";
    $("#table-cashbon").load(url);
}

function loadTable()
{
    var bulanSekarang = (new Date().getMonth() + 1).toString().padStart(2, '0');
    var url = "/cashbon/"+ bulanSekarang +"/table";
    $("#table-cashbon").load(url);
}

/**Pagination */
function paginationPreviousPage(page)
{
    var bulanSekarang = (new Date().getMonth() + 1).toString().padStart(2, '0');
    var prevPage = page-1;
    var url = "/cashbon/"+ bulanSekarang +"/table?page=" + prevPage;
     $("#table-cashbon").load(url);
}
function paginationPage(page)
{
    var bulanSekarang = (new Date().getMonth() + 1).toString().padStart(2, '0');
    var url = "/cashbon/"+ bulanSekarang +"/table?page=" + page;
     $("#table-cashbon").load(url);
}
function paginationNext(page)
{
    var bulanSekarang = (new Date().getMonth() + 1).toString().padStart(2, '0');
    var nextPage = page+1;
    var url = "/cashbon/"+ bulanSekarang +"/table?page=" + nextPage;
     $("#table-cashbon").load(url);
}
/**End Pagination */

$("#btn-submit").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/opx/cashbon";
    var id = $("#user_id").val()
    var amount = $("#amount").val()

    if(amount === ''){
        $("#btn-submit").attr('disabled', false)
        $("#btn-submit").html('Submit')

        $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Oops..',
            subtitle: 'Error message',
            body: 'Kolom Amount tidak boleh kosong!'
        })
    }else{
        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                id:id,
                amount:amount,
            },
            success:function(response){
                $("#btn-submit").attr('disabled', false)
                $("#btn-submit").html('Submit')
                $("#modal-xl").modal('hide')

                if(response.status === 500){

                    $(document).Toasts('create', {
                        class: 'bg-warning',
                        title: 'Oops..',
                        subtitle: 'Error Message..',
                        body: response.message,
                    })

                }else{

                    $("#amount").val('');

                    loadTable()

                    $(document).Toasts('create', {
                        class: 'bg-success',
                        title: 'Congrats..',
                        subtitle: 'Success Info..',
                        body: response.message,
                    })
                }

            },
            error:function(){
                $("#btn-submit").attr('disabled', false)
                $("#btn-submit").html('Submit Ulang')

                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Error message..',
                    subtitle: 'Success Info..',
                    body: 'Terjadi kesalahan, periksa koneksi anda!',
                })
            }
        });
    }
});