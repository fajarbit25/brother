$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**Hide */
    $("#btn-loading").hide();
    $("#formSearch").hide();
    $("#btn-update").hide();
    $("#btn-loading-delete").hide();

    load();
});

function load()
{
    var url = "/produk/table";
    $("#table-product").load(url);
}
/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/produk/table?page="+ prevPage;
    $("#table-product").load(url);
}
function paginationPage(page)
{
    var url = "/produk/table?page="+ page;
    $("#table-product").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/produk/table?page="+ nextPage;
    $("#table-product").load(url);
}
/**End Pagination */

function formSearch()
{
    $("#formSearch").show();
}

function cari(key)
{
    if(key.length==0){
        var url = "/produk/table";
        $("#table-product").load(url);
    }else{
        var url = "/produk/"+ key + "/search";
        $("#table-product").load(url);
    }
}

function modalProduct()
{
    $('#productForm')[0].reset();
    $("#modal-product").modal('show');
    $("#btn-update").hide();
    $("#btn-submit").show();
}

function createProduct()
{
    /**Animasi */
    $("#btn-submit").hide();
    $("#btn-loading").show();

    var form = $("#productForm")[0];
    var data = new FormData(form);
    var url = "/produk";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            /**Animasi */
            $("#btn-submit").show();
            $("#btn-loading").hide();

            /**Close modal & reset Form */
            $("#productForm")[0].reset();
            $("#modal-product").modal('hide');
            load();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })

        },
        error:function(){
            /**Animasi */
            $("#btn-submit").show();
            $("#btn-loading").hide();

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

function editProduct(id)
{
    console.log(id)

    $("#diproduct").val(id);
    $("#modal-product").modal('show');
    $("#btn-submit").hide();
    $("#btn-update").show();

    /**Load data */
    var url = "/produk/" + id + "/json";

    $.ajax({
        url:url,
        dataType:'json',
        success:function(data){
            $("#product_name").val(data.product_name);
            $("#satuan").val(data.satuan);
            $("#cat").val(data.cat);
            $("#harga_jual").val(data.harga_jual);
            $("#harga_beli").val(data.harga_beli);
        }
    });
}


function updateProduct()
{
    /**Animasi */
    $("#btn-update").hide();
    $("#btn-loading").show();

    var form = $("#productForm")[0];
    var data = new FormData(form);
    var url = "/produk/update";

    
    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            /**Animasi */
            $("#btn-update").show();
            $("#btn-loading").hide();

            /**Close modal & reset Form */
            $("#productForm")[0].reset();
            $("#modal-product").modal('hide');
            load();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })

        },
        error:function(){
            /**Animasi */
            $("#btn-update").show();
            $("#btn-loading").hide();

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

function deleteProduct(id)
{
    $("#modal-delete").modal('show');
    $("#delete_id").val(id);
}

function destroyProduct()
{
    /**Animasi */
    $("#btn-delete").hide();
    $("#btn-loading-delete").show();

    var delete_id = $("#delete_id").val();
    var url = "/produk/delete";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            delete_id:delete_id,
        },
        success:function(response){
            /**Animasi */
            $("#btn-delete").show();
            $("#btn-loading-delete").hide();

            /**close modal & load table */
            load();
            $("#modal-delete").modal('hide');

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
            $("#btn-delete").show();
            $("#btn-loading-delete").hide();

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

