$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    getTable()
    getSaldo()
    getTableOut()
});

function getSaldo()
{
    var url = "/operational/saldo/json";

    $.ajax({
        url:url,
        type:'GET',
        dataType:'json',
        success:function(data){
            var formattedNumber = formatNumber(data.saldo);

            $("#saldoKas").text(formattedNumber)
        },
        error:function(){
            $("#saldoKas").text('Loading Error...')
        }
    });
}

function formatNumber(number) {
    // Assuming you want to format the number with commas
    return number.toLocaleString(); // Formats number with commas
}

function getTableOut()
{
    var url = "/operational/tableopsUot";
    $("#table-ops-out").load(url)
}

function getTable()
{
    var url = "/operational/tableops";
    $("#table-ops").load(url);
}
/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/operational/tableops?page="+ prevPage;
    $("#table-ops").load(url);
}
function paginationPage(page)
{
    var url = "/operational/tableops?page="+ page;
    $("#table-ops").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/operational/tableops?page="+ nextPage;
    $("#table-ops").load(url);
}
/**End Pagination */

$("#btn-submit").click(function(){
    /**Animasi */
    $("#btn-submit").attr('disabled', true)
    $("#btn-submit").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var form = $("#formOps")[0];
    var data = new FormData(form);
    var url = "/ops";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            /**Animasi */
            $("#btn-submit").attr('disabled', false)
            $("#btn-submit").html('Submit')
            $("#modal-xl").modal('hide');

            getTable()
            getSaldo()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(error){
            /**Animasi */
            $("#btn-submit").attr('disabled', false)
            $("#btn-submit").html('Submit')

            console.log(error)

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

$("#btn-submitOut").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var data = new FormData($("#formOpsOut")[0])
    var url = "/operational/storePengeluaran";


    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            /**Animasi */
            $("#btn-submitOut").attr('disabled', false)
            $("#btn-submitOut").html('Submit')
            $("#modal-xl").modal('hide');
            $("#formOpsOut")[0].reset()


            getTableOut()
            getSaldo()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(error){
            /**Animasi */
            $("#btn-submitOut").attr('disabled', false)
            $("#btn-submitOut").html('Submit')

            console.log(error)

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

function buktiTransaksi(foto) {
    //var fotoNotaUrl = "{{asset('/storage/foto-nota/" + foto + "')}}";
    $("#fotoNota").attr('src', "/storage/foto-nota/" + foto);
    $("#modal-foto").modal('show');
    //console.log(fotoNotaUrl)
}
