$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**Animasi */
    $("#btn-create-spin").hide();
    $("#btn-loading").hide();
    $("#btn-loading-jadwal").hide();
    $("#form-due_date").hide();

    /**Load All */
    setInterval(loadAll, 1000);
});

function loadAll()
{
    var uuid = $("#uuid").val();
    var urlTable = "/order/" + uuid + "/loadForm";
    var urlTableOrder = "/order/table";
    var urlTableItem = "/order/tableItem";
    var urlTableMerk = "/order/tableMerk";
    $("#tableForm").load(urlTable);
    $("#tableOrder").load(urlTableOrder);
    $("#table-item").load(urlTableItem)
    $("#table-merk").load(urlTableMerk)
    $("#tableJadwal").load("/order/tableJadwal");
}

function createOrder()
{
    /**Animasi */
    $("#btn-create-plus").hide();
    $("#btn-create-spin").show();
    
    var url = "/order";
    var costumer_id = $("#costumer_id").val();
    var tanggal = $("#tanggal").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            costumer_id:costumer_id,
            tanggal:tanggal,
        },
        success:function(response){
            /**Animasi */
            $("#btn-create-plus").show();
            $("#btn-create-spin").hide();

            if(response.success == 'true'){
                window.location = "/order/" + response.uuid + "/edit";
            }
            if(response.success == 'fail'){
                window.location = "/order/" + response.uuid + "/edit";
            }
        }
    });
}


function addOrder()
{
    var form = $("#formItem")[0];
    var data = new FormData(form);
    var url = "/order/add";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            loadAll()
            console.log(response.success)

            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })

            /**Reset Form */
            $("#formItem")[0].reset();

            /**Close Modal */
            $("#modal-xl").modal('hide');
        },
        error:function(){
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

/** Delete Item */
function itemDelete(id)
{
    var url = "/order/itemDelete";
    var uuid = $("#uuid").val();
    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            uuid:uuid,
        },
        success:function(response){
            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Alert..',
                subtitle: 'Delete...',
                body: response.success
            })
            /**load All */
            loadAll()
        },
        error:function(){
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

/**Submit Order */
function submitOrder(id)
{
    console.log(id);
    $("#btn-loading").show();
    $("#btn-submit").hide();

    var disc = $("#disc").val()

    $.ajax({
        url:"/order/submit",
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })
            window.location = "/order";
        },
        error:function(){
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })

            $("#btn-loading").hide();
            $("#btn-submit").show();
        }
    });
}

/**Jadwal */
function modalJadwal(uuid)
{
    console.log(uuid);
    $("#modalJadwal").modal('show');
    $("#idorder").val(uuid);
}
function cekJadwal()
{
    /**Animasi */
    $("#btn-loading-jadwal").show();
    $("#btn-submit-jadwal").hide();

    var form = $("#formJadwal")[0];
    var data = new FormData(form);
    var url = "/order/cekJadwal";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            if(response.success === 'false'){
                createJadwal();
            }else{
                /**Animasi */
                $("#btn-loading-jadwal").hide();
                $("#btn-submit-jadwal").show();

                /**close Modal */
                $("#modalJadwal").modal('hide');

                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Oops..',
                    subtitle: 'Alert...',
                    body: 'Jadwal Untuk Teknisi Tersebut Telah Terisi, Gunakan Jadwal Lain!'
                })
            }
        },
        error:function(){
            /**Animasi */
            $("#btn-loading-jadwal").hide();
            $("#btn-submit-jadwal").show();

            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Oops..',
                subtitle: 'Alert...',
                body: 'Terjadi Kesalahan, Periksa Koneksi Anda!'
            })
        }
    });
}
function createJadwal()
{

    var form = $("#formJadwal")[0];
    var data = new FormData(form);
    var url = "/order/submit/jadwal";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            /**Animasi */
            $("#btn-loading-jadwal").hide();
            $("#btn-submit-jadwal").show();

            /**reset Form dan tutup modal*/
            $("#formJadwal")[0].reset();
            $("#modalJadwal").modal('hide');

            /**load tabel */
            loadAll();

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
            $("#btn-loading-jadwal").hide();
            $("#btn-submit-jadwal").show();

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

function paymentMethod(id)
{
    var today = new Date().toISOString().slice(0, 10);
    $("#due_date").val(today);
    $("#idorder-payment").val(id);
    $("#payment-modal").modal('show')

}

function prosesPayment()
{
    $("#btn-proses-payment").attr('disabled', true);
    $("#btn-proses-payment").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idorder = $("#idorder-payment").val();
    var method = $("#method").val();
    var due_date = $("#due_date").val();
    var url = "/order/proses/payment";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idorder:idorder,
            method:method,
            due_date:due_date,
        },
        success:function(response){
            $("#btn-proses-payment").attr('disabled', false);
            $("#btn-proses-payment").html('Proses Payment')
            $("#payment-modal").modal('hide')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })

            /**Load All */
            loadAll();
            
        },
        error:function(){
            $("#btn-proses-payment").attr('disabled', false);
            $("#btn-proses-payment").html('Proses Payment')

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

function modalcancel()
{
    $("#modal-cancel").modal('show');
}

function cancel()
{
    $("#btn-cancel").attr('Disabled', true);
    $("#btn-cancel").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/order/cancel";
    var id = $("#uuid").val();
    var keterangan = $("#keterangan").val();

    if(keterangan.trim() === ""){

        $("#btn-cancel").attr('Disabled', false);
        $("#keterangan").addClass('is-invalid')
        $("#btn-cancel").html('Ulangi')

        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Oops..',
            subtitle: 'Error...',
            body: 'Keterangan tidak boleh kosong!'
        })

    }else{
        $.ajax({
            url:url,
            type:'POST',
            cache:false,
            data:{
                id:id,
                keterangan:keterangan,
            },
            success:function(response){
                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Congrats..',
                    subtitle: 'Success...',
                    body: response.message,
                })

                window.location = "/order";
            },
            error:function(){
                $("#btn-cancel").attr('Disabled', false);
                $("#btn-cancel").html('Ulangi')

                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Oops..',
                    subtitle: 'Error...',
                    body: 'Permintaan gagal, Terjadi kesalahan!'
                })
            }
        });
    }
}

$("#method").change(function(){
    var method = $(this).val();

    if(method === 'Termin'){
        $("#form-due_date").show();
    }else{
        $("#form-due_date").hide();
    }
});

$("#btn-modal-item").click(function(){
    $("#modal-item").modal('show')
});

function createItem()
{
    $("#btn-create-item").attr('Disabled', true);
    $("#btn-create-item").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')
    
    var item = $("#item").val();
    var url = "/order/addItem";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            item:item
        },
        success:function(response){
            $("#btn-create-item").attr('Disabled', false);
            $("#btn-create-item").html('Create Item')

            $("#modal-item").modal('hide')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

            /**Load All */
            loadAll();
            
        },
        error:function(){
            $("#btn-create-item").attr('Disabled', false);
            $("#btn-create-item").html('Create Item')

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });

}

function deleteItem(id)
{
    var namaBtn = "#btn-delete-item-"+id;
    $(namaBtn).attr('Disabled', true);
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>')

    var url = "/order/deleteItem";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

            /**Load All */
            loadAll();
        },
        error:function(){
            $(namaBtn).attr('Disabled', false);
            $(namaBtn).html('<i class="bi bi-trash3"></i>')


            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

function modalTAX(id)
{
    console.log(id)
    $("#modal-tax").modal('show')
    $("#idorder-tax").val(id)
}

function prosesTax()
{
    $("#btn-proses-tax").attr('Disabled', true)
    $("#btn-proses-tax").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var ppn = $("#ppn").val()
    var id = $("#idorder-tax").val()
    var url = "/order/addTax";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            ppn:ppn,
            id:id,
        },
        success:function(response){
            $("#btn-proses-tax").attr('Disabled', false)
            $("#btn-proses-tax").html('Proses TAX')
            $("#modal-tax").modal('hide')
            /**Load All */
            loadAll();
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-proses-tax").attr('Disabled', false)
            $("#btn-proses-tax").html('Proses TAX')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

$("#btn-modal-merk").click(function(){
    $("#modal-merk").modal('show')
});

function createMerk()
{
    $("#btn-create-merk").attr('Disabled', true)
    $("#btn-create-merk").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/order/addMerk";
    var merk_name = $("#merk_name").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            merk_name:merk_name,
        },
        success:function(response){
            $("#btn-create-merk").attr('Disabled', false)
            $("#btn-create-merk").html('Create')
            $("#modal-merk").modal('hide')
            /**Load All */
            loadAll();
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-create-merk").attr('Disabled', false)
            $("#btn-create-merk").html('Create')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });

}

function deleteMerk(id)
{
    var namaBtn = "#btn-delete-merk-" + id;
    $(namaBtn).attr('Disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>')

    var url = "/order/deleteMerk";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            /**Load All */
            loadAll();
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $(namaBtn).attr('Disabled', false)
            $(namaBtn).html('<i class="bi bi-trash3"></i>')
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });

}