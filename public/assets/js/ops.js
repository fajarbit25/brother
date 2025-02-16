$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    getTable()
    getSaldo()
    getTableOut()
    tableItem()
});

function getSaldo()
{
    var url = "/operational/saldo/json";

    $.ajax({
        url:url,
        type:'GET',
        dataType:'json',
        success:function(data){

            $("#saldoTunai").text(data.tunai)
            $("#saldoBCA").text(data.bca)
            $("#saldoMandiri").text(data.mandiri)
            $("#saldoBRI").text(data.bri)
        },
        error:function(){
            $("#saldoKas").text('Loading Error...')
        }
    });
}


function tableItem()
{
    var url = "/operational/tableItem";
    $("#table-opsitem").load(url)
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

function modalItem()
{
    $("#modal-item").modal('show');
}

$("#btn-submit-item").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/operational/newItem";
    var item = $("#item").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            item:item,
        },
        success:function(response){
            $("#btn-submit-item").attr('disabled', false)
            $("#btn-submit-item").html('Submit')
            $("#formItem")[0].reset()
            $("#modal-item").modal('hide');
            tableItem()            
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-submit-item").attr('disabled', false)
            $("#btn-submit-item").html('Submit')

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

function modalItemEdit(id, item)
{
    $("#iditem").val(id);
    $("#itemEdit").val(item);
    $("#modal-edit-item").modal('show');
}


$("#btn-update-item").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/operational/updateItem";
    var item = $("#itemEdit").val()
    var id = $("#iditem").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            item:item,
            id:id,
        },
        success:function(response){
            $("#btn-update-item").attr('disabled', false)
            $("#btn-update-item").html('Update')
            $("#modal-edit-item").modal('hide');
            tableItem()            
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-update-item").attr('disabled', false)
            $("#btn-update-item").html('Update')

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

function modalDeleteItem(id)
{
    console.log(id)
    $("#iditemDelete").val(id)
    $("#modal-delete-item").modal('show');
}

$("#btn-delete-item").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/operational/deleItem";
    var id = $("#iditemDelete").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $("#btn-delete-item").attr('disabled', false)
            $("#btn-delete-item").html('Update')
            $("#modal-delete-item").modal('hide');
            tableItem()            
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-delete-item").attr('disabled', false)
            $("#btn-delete-item").html('Update')

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

function modalUserCashbon(id)
{
    $("#idcashbon").val(id)
    $("#modal-usercashbon").modal('show')
}

$("#btn-usercashbon").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/operational/approveCashbon";
    var id = $("#idcashbon").val()
    var userid = $("#userId").val()
    var password = $("#password").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            userid:userid,
            password:password,
        },
        success:function(response){
            window.location = "/operational/cashbon";
        },
        error:function(){
            $("#btn-usercashbon").attr('disabled', false)
            $("#btn-usercashbon").html('Update')

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

function confirmDeleteMutasi(id)
{
    console.log(id)
    $("#idMutasiDelete").val(id)
    $("#modalDeleteMutasi").modal('show')
}

function deleteMutasi()
{
 $("#btnDeleteMutasi").attr('disabled', true)
 $("#btnDeleteMutasi").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Processing...')
 var id = $("#idMutasiDelete").val()
 var url = "/operational/mutasi/delete";
 $.ajax({
     url:url,
     type:'POST',
     cache:false,
     data:{
         id:id,
     },
     success:function(response){
            $("#btnDeleteMutasi").attr('disabled', false)
            $("#btnDeleteMutasi").html('Hapus')
            $("#modalDeleteMutasi").modal('hide')
            getTable()
            getSaldo()
            getTableOut()
            tableItem()
         /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
     },
     error:function(){
        $("#btnDeleteMutasi").attr('disabled', false)
        $("#btnDeleteMutasi").html('Hapus')
        $("#modalDeleteMutasi").modal('hide')
        /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: 'Terjadi kesalahan, Periksa Koneksi Anda!',
            })
     }
 });
}