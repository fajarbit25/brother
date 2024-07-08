$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loadTable()
    tableForm()
    tableReport()
    loadSatuan()
    loadCategory()
    $("#btn-excel").hide();
});

function loadTable()
{
    var url = "/invemtoty/table/inbound";
    $("#table-inbound").load(url);
}

function tableReport()
{
    var id = $("#idproduct").val();
    var url = "/inventory/" + id +"/tableMutasi"
    $("#table-mutasi").load(url);
}

function loadSatuan()
{
    var url = "/inventory/tableSatuan";
    $("#table-satuan").load(url)
}

function loadCategory()
{
    var url = "/inventory/tableCatergory";
    $("#table-category").load(url)
}


/**Pagination */
function paginationPreviousPage(page)
{
    var id = $("#idproduct").val();
    var prevPage = page-1;
    var url = "/inventory/" + id +"/tableMutasi?page="+ prevPage;
    $("#table-mutasi").load(url);
}
function paginationPage(page)
{
    var id = $("#idproduct").val();
    var url = "/inventory/" + id +"/tableMutasi?page="+ page;
    $("#table-mutasi").load(url);
}
function paginationNext(page)
{
    var id = $("#idproduct").val();
    var nextPage = page+1;
    var url = "/inventory/" + id +"/tableMutasi?page="+ nextPage;
    $("#table-mutasi").load(url);
}
/**End Pagination */

$("#btn-inbound").click(function(){
    $("#modal-inbound").modal('show');
});

$("#btn-create").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var supplier = $("#supplier").val();
    var url = "/inventory/inbound/create";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            supplier:supplier,
        },
        success:function(response){
            window.location = "/inventory/inbound/new";
        },
        error:function(){
            $(this).attr('disabled', false)
            $(this).html('Buat Pesanan')
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Subtitle',
                body: 'Terjadi kesalahan'
            })
        }
    });
});

function tableForm()
{
    var id = $("#inboundID").val();
    var url = "/invemtoty/table/" + id + "/inboundForm";
    $("#table-form").load(url);
}


$("#btn-add-item").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/inventory/inbound/additem";
    var inbound_id = $("#inboundID").val();
    var product_id = $("#product").val();
    var qty = $("#qty").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            inbound_id:inbound_id,
            product_id:product_id,
            qty:qty,
        },
        success:function(response){
            tableForm();
            $("#btn-add-item").attr('disabled', false)
            $("#btn-add-item").html('<i class="bi bi-plus-lg"></i> Tambahkan ')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            tableForm();
            $("#btn-add-item").attr('disabled', false)
            $("#btn-add-item").html('<i class="bi bi-plus-lg"></i> Tambahkan ')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });

});

function deleteItem(id)
{
    var url = "/inventory/inbound/deleteItem";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            tableForm()
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            tableForm()
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });
}

function setClose(id)
{
    $("#btn-save").attr('diabled', true)
    $("#btn-save").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/inventory/inbound/updateStatus";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(){
            window.location = "/inventory/inbound"
        },
        error:function(){
            $("#btn-save").attr('diabled', false)
            $("#btn-save").html('Simpan Data')
            
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });

}

function modalEdit(id, delivery)
{
    console.log(delivery)

    $("#modal-edit").modal('show')
    $("#inbound_id").val(id)
    $("#do").val(delivery);
}

function updateDo()
{
    $("#btn-update").attr('disabled', true)
    $("#btn-update").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading')

    var url = "/inventory/inbound/updateDo";
    var inbound_id = $("#inbound_id").val();
    var delivery = $("#do").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            inbound_id:inbound_id,
            delivery:delivery,
        },
        success:function(response){
            $("#btn-update").attr('disabled', false)
            $("#btn-update").html('Update')
            loadTable()
            $("#modal-edit").modal('hide')
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            $("#btn-update").attr('disabled', false)
            $("#btn-update").html('Update')
             /**Notifikasi */
             $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });
}

$("#btn-approve").click(function(){
    $(this).attr('disabled', true);
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idinbound = $("#idinbound").val();
    var url = "/inventory/inbound/inboundApproved";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idinbound:idinbound,
        },
        success:function(response){
            window.location = "/inventory/inbound";
        },
        error:function(){
            $("#btn-approve").attr('disabled', false)
            $("#btn-approve").html('Update')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });
});

$("#btn-cancel").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idinbound = $("#idinbound").val();
    var url = "/inventory/inbound/inboundCancel";
    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idinbound:idinbound,
        },
        success:function(response){
            window.location = "/inventory/inbound";
        },
        error:function(){
            $("#btn-cancel").attr('disabled', false)
            $("#btn-cancel").html('Approve')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });
});

$("#filter").click(function(){
    $("#modal-tanggal").modal('show')
});

$("#btn-report").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var start = $("#start").val()
    var end = $("#end").val()

    var url = "/inventory/inbound/" + start + "/" + end + "/report";

    var urlExport = "/inventory/inbound/" + start + "/" + end + "/export";

    $("#table-report").load(url)
    $("#btn-excel").show();
    $("#btn-excel").attr('href',urlExport )

    $("#modal-tanggal").modal('hide')

    $(this).attr('disabled', false)
    $(this).html('Lihat')
});

function modalSatuan()
{
    $("#modal-satuan").modal('show')
}

$("#btn-create-satuan").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/inventory/storeSatuan";
    var unit_code = $("#unit_code").val()
    var unit_name = $("#unit_name").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            unit_code:unit_code,
            unit_name:unit_name,
        },
        success:function(response){
            $("#btn-create-satuan").attr('disabled', false)
            $("#btn-create-satuan").html('Submit')
            loadSatuan()
            $("#modal-satuan").modal('hide')
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            $("#btn-create-satuan").attr('disabled', false)
            $("#btn-create-satuan").html('Submit')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });
});

function modalCategory()
{
    $("#modal-category").modal('show')
}

$("#btn-create-category").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/inventory/storeCategory";
    var category_code = $("#category_code").val()
    var category_name = $("#category_name").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            category_code:category_code,
            category_name:category_name,
        },
        success:function(response){
            $("#btn-create-category").attr('disabled', false)
            $("#btn-create-category").html('Submit')
            loadCategory()
            $("#modal-category").modal('hide')
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            $("#btn-create-category").attr('disabled', false)
            $("#btn-create-category").html('Submit')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });
});

function editSatuan(id, kode, name)
{
    $("#modal-satuan-edit").modal('show')
    $("#idsatuan").val(id)
    $("#unit_code_edit").val(kode)
    $("#unit_name_edit").val(name)

}

$("#btn-update-satuan").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idsatuan = $("#idsatuan").val()
    var unit_code_edit = $("#unit_code_edit").val()
    var unit_name_edit = $("#unit_name_edit").val()
    var url = "/inventory/updateSatuan";


    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            unit_code_edit:unit_code_edit,
            unit_name_edit:unit_name_edit,
            idsatuan:idsatuan,
        },
        success:function(response){
            $("#btn-update-satuan").attr('disabled', false)
            $("#btn-update-satuan").html('Update')
            loadSatuan()
            $("#modal-satuan-edit").modal('hide')
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            $("#btn-update-satuan").attr('disabled', false)
            $("#btn-update-satuan").html('Update')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });
});

function editCategory(id, kode, name)
{
    $("#modal-category-edit").modal('show')
    $("#idcat").val(id)
    $("#category_code_edit").val(kode)
    $("#category_name_edit").val(name)

}

$("#btn-update-category").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idcat = $("#idcat").val()
    var category_code_edit = $("#category_code_edit").val()
    var category_name_edit = $("#category_name_edit").val()
    var url = "/inventory/updateCategory";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idcat:idcat,
            category_code_edit:category_code_edit,
            category_name_edit:category_name_edit,
        },
        success:function(response){
            $("#btn-update-category").attr('disabled', false)
            $("#btn-update-category").html('Update')
            loadCategory()
            $("#modal-category-edit").modal('hide')
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            $("#btn-update-category").attr('disabled', false)
            $("#btn-update-category").html('Update')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops',
                subtitle: 'Error Message',
                body: 'Terjadi kesalahan!'
            })
        }
    });

});

