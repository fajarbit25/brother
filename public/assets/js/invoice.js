$(document).ready(function(){
    console.log('ready')

    getOrder()
    $("#alert-input").hide()
    $("#alert-input-edit").hide()
    $("#btn-excel").hide();
});

function getOrder()
{
    var url = "/invoice/table";
    $("#table-order").load(url);
}

$("#modalReport").click(function(){
    $("#modal-filter").modal('show')
});

function getReport()
{
    var start = $("#start").val();
    var end = $("#end").val();
    var url = "/invoice/" + start + "/" + end + "/report";
    var urlExcel = "/invoice/" + start + "/" + end + "/export";

    $("#table-report").load(url);
    $("#btn-excel").attr('href', urlExcel);
    $("#btn-excel").show();

    $("#modal-filter").modal('hide')
}

/**
 * Pagination 
  */
function paginationPreviousPage(page)
{
    var start = $("#start").val();
    var end = $("#end").val();
    var prevPage = page-1;
    var url = "/invoice/" + start + "/" + end + "/report?page=" + prevPage;

    $("#table-report").load(url);
}
function paginationPage(page)
{
    var start = $("#start").val();
    var end = $("#end").val();
    var url = "/invoice/" + start + "/" + end + "/report?page=" + page;
    $("#table-report").load(url);
}
function paginationNext(page)
{
    var start = $("#start").val();
    var end = $("#end").val();
    var nextPage = page+1;
    var url = "/invoice/" + start + "/" + end + "/report?page=" + nextPage;
    $("#table-report").load(url);
}
/**
 * End Pagination 
*/

function modalInvoice(id)
{
    $("#idorder-invoice").val(id)
    $("#invoice-modal").modal('show');
}

function createInvoice()
{
    $("#btn-proses-invoice").attr('disabled', true)
    $("#btn-proses-invoice").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idorder = $("#idorder-invoice").val()
    var invoice_id = $("#invoice_id").val()
    var inv_date = $("#invoice_date").val()
    var total = $("#total").val()

    if(idorder === '' || invoice_id === '' || inv_date === '' || total === ''){
        $("#alert-input").html('<i class="bi bi-exclamation-circle-fill"></i> Tanggal dan Nomor Invoice tidak boleh kosong!')
        $("#alert-input").show()

        $("#btn-proses-invoice").attr('disabled', false)
        $("#btn-proses-invoice").html('Create Invoice')
    }else{
        var url = "/invoice";
        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                idorder:idorder,
                invoice_id:invoice_id,
                inv_date:inv_date,
                total:total,
            }, success:function(response){
                getOrder()

                $("#btn-proses-invoice").attr('disabled', false)
                $("#btn-proses-invoice").html('Create Invoice')
                $("#invoice-modal").modal('hide');

                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Congrats',
                    subtitle: 'Success',
                    body: response.message
                })

            }, error:function(){
                $("#btn-proses-invoice").attr('disabled', false)
                $("#btn-proses-invoice").html('Create Invoice')

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
}

function modalEditInvoice(date, order, invoice, total_tagihan)
{

    $("#idorder-invoice-edit").val(order)
    $("#invoice_id-edit").val(invoice)
    $("#invoice_date-edit").val(date)
    $("#total-edit").val(total_tagihan)

    $("#edit-invoice-modal").modal('show')
}

function updateInvoice()
{
    $("#btn-edit-invoice").attr('disabled', true)
    $("#btn-edit-invoice").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idorder = $("#idorder-invoice-edit").val()
    var invoice_id = $("#invoice_id-edit").val()
    var inv_date = $("#invoice_date-edit").val()
    var total = $("#total-edit").val()

    if(idorder === '' || invoice_id === '' || inv_date === '' || total === ''){
        $("#alert-input-edit").html('<i class="bi bi-exclamation-circle-fill"></i> Tanggal dan Nomor Invoice tidak boleh kosong!')
        $("#alert-input-edit").show()

        $("#btn-edit-invoice").attr('disabled', false)
        $("#btn-edit-invoice").html('Create Invoice')
    }else{
        var url = "/invoice";
        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                idorder:idorder,
                invoice_id:invoice_id,
                inv_date:inv_date,
                total:total,
            }, success:function(response){
                getOrder()

                $("#btn-edit-invoice").attr('disabled', false)
                $("#btn-edit-invoice").html('Update Invoice')
                $("#edit-invoice-modal").modal('hide');

                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Congrats',
                    subtitle: 'Success',
                    body: response.message
                })

            }, error:function(){
                $("#btn-edit-invoice").attr('disabled', false)
                $("#btn-edit-invoice").html('Update Invoice')

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
}

function modalUpload(id)
{
    console.log(id)
    $("#id_invoice_upload").val(id)
    $("#modal-upload").modal('show');

}

function uploadInvoice()
{
    $("#btn-upload-invoice").attr('disabled', true)
    $("#btn-upload-invoice").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')
    var formData = new FormData($('#uploadForm')[0]);
    var url = "/invoice/upload";

    $.ajax({
        url:url,
        type:'POST',
        data:formData,
        processData: false,
        contentType: false,
        success:function(response){
            $("#btn-upload-invoice").attr('disabled', false)
            $("#btn-upload-invoice").html('Upload Invoice')
            $("#modal-upload").modal('hide');

            getOrder();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })

        },
        error:function(error){
            console.log(error);

            $("#btn-upload-invoice").attr('disabled', false)
            $("#btn-upload-invoice").html('Upload Invoice')

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

function viewInvoice(file, name)
{
    console.log(file)
    console.log(name)
    $("#title-modal").html(name)
    $("#title-bottom").html('document : file_' + file + '.pdf')
    $("#modal-invoice-view").modal('show')

    $("#frame").attr("src", "/invoice/" + file + "/viewPdf")
}

function approveInvoice(id)
{
    var btnName = "#btn-approve-" + id;
    $(btnName).attr('disabled', true)
    $(btnName).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/invoice/approve";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            getOrder();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(error){
            console.log(error)
            getOrder();

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

function sendInvoice(id)
{
    var btnName = "#btn-send-" + id;
    $(btnName).attr('disabled', true)
    $(btnName).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/invoice/send";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            getOrder();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(error){
            console.log(error)
            getOrder();
            
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