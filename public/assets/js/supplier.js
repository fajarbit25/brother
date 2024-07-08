$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**btn animasi */
    $("#btn-loading").hide();
    $("#btn-loading-delete").hide();

    /**load All */
    load()
});

function load()
{
    var url = "/supplier/table";
    $("#table-supplier").load(url);
}

function modalSupplier()
{
    $("#modal-supplier").modal('show');
    $("#supplierForm")[0].reset();
    $("#btn-submit").show();
    $("#btn-update").hide();
}

function createSupplier()
{
    /**Animasi */
    $("#btn-loading").show();
    $("#btn-submit").hide();


    var form = $("#supplierForm")[0];
    var data = new FormData(form);
    var url = "/supplier";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })

            /**Animasi */
            $("#btn-loading").hide();
            $("#btn-submit").show();

            /**Reset form & tutup modal */
            $("#supplierForm")[0].reset();
            $("#modal-supplier").modal('hide');

            /**load Table */
            load();
        },
        error:function(){
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Failed...',
                body: 'Terjadi kesalahan, Periksa Koneksi Anda!',
            })

            /**Animasi */
            $("#btn-loading").hide();
            $("#btn-submit").show();
        }
    });
}

function editSupplier(id)
{
    /**load data json */
    var url = "/supplier/" + id + "/json";
    $.ajax({
        url:url,
        type:'GET',
        cache:false,
        dataType:'json',
        success:function(data){
            $("#supplier_code").val(data.supplier_code);
            $("#supplier_name").val(data.supplier_name);
            $("#supplier_address").val(data.supplier_address);
            $("#supplier_phone").val(data.supplier_phone);
            $("#supplier_email").val(data.supplier_email);
            $("#supplier_description").val(data.supplier_description);
        }
    });

    $("#modal-supplier").modal('show');
    $("#btn-submit").hide();
    $("#btn-update").show();
    $("#idsupplier").val(id);
}

function updateSupplier()
{
    /**Animasi */
    $("#btn-loading").show();
    $("#btn-update").hide();

    var form = $("#supplierForm")[0];
    var data = new FormData(form);
    var url = "/supplier/update";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        contentType:false,
        processData:false,
        success:function(response){
            /**Animasi */
            $("#btn-loading").hide();
            $("#btn-update").show();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })

            /**Reset form & tutup modal */
            $("#supplierForm")[0].reset();
            $("#modal-supplier").modal('hide');

            /**load Table */
            load();
        },
        error:function(){
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Failed...',
                body: 'Terjadi kesalahan, Periksa Koneksi Anda!',
            })

            /**Animasi */
            $("#btn-loading").hide();
            $("#btn-update").show();
        }

    });
}

function modalDelete(id)
{
    $("#modal-delete").modal('show');
    $("#delete_id").val(id);
}

function deleteSupplier()
{
    /**Animasi */
    $("#btn-loading-delete").show();
    $("#btn-delete").hide();

    var url = "/supplier/delete";
    var idsupplier = $("#delete_id").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idsupplier:idsupplier,
        },
        success:function(response){
            /**Animasi */
            $("#btn-loading-delete").hide();
            $("#btn-delete").show();
            $("#modal-delete").modal('hide');

            /**load tabel */
            load();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })


        },
        error:function(){
            /**Animasi */
            $("#btn-loading-delete").hide();
            $("#btn-delete").show();
            $("#modal-delete").modal('hide');

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Failed...',
                body: 'Terjadi kesalahan, Periksa Koneksi Anda!',
            })
        }
    });

}