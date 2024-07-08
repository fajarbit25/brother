$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    cekStatus()
    /**Load */
    loadOrder()

    loadButtonFooter()
});

function loadOrder()
{
    var url = "/teknisi/orderList";
    $("#order-list").load(url)
}


function loadItemList()
{
    var uuid = $("#uuid").val();
    var url = "/teknisi/" + uuid + "/itemList";
    $("#item-list").load(url);
}

function cekStatus()
{
    var status = $("#status-order").val();
    if(status === 'Processing'){
        /**Tampilkan List Item */
        loadItemList()

        /**Hide Button */
        $("#btn-proses").hide()
        $("#btn-pending").hide()
        $("#btn-cancel").hide()
    }else{
        $("#formUnit").hide();
    }
}

function pickupOrder(id)
{
    var btnName = "#btnPickup-" + id;
    $(btnName).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')
    var url = "/teknisi/pickup";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            loadOrder()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })
        }
    });
}

function updateProgres(id)
{
    var url = '/teknisi/' + id + '/order';
    window.location = url;
}

function proses(id)
{
    /**Hide Button */
    $("#btn-proses").hide()
    $("#btn-pending").hide()
    $("#btn-cancel").hide()

    var url = "/teknisi/update/order";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{ id:id },
        beforeSend:function(){
            $("#btn-proses").attr('Disabled', true)
            $("#btn-proses").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')
        },
        success:function(response){
            $("#btn-proses").attr('Disabled', false)
            $("#btn-proses").html('<i class="bi bi-tools"></i> Proses Pengerjaan')

            /**Load Item */
            loadItemList()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.success,
            })

            $("#formUnit").show()
        }
    });

    $("#formUnit").show()
}


function submitData(id)
{
    var namaForm = "#form-" + id;
    var form = $(namaForm)[0];
    var data = new FormData(form);

    console.log(data);
}

function prosesItem(id)
{
    /**Load data json */
    var url = "/teknisi/" + id + "/json";

    $.ajax({
        url:url,
        type:'GET',
        dataType:'json',
        success:function(data){
            $("#tipe").val(data.iditem)
            $("#merk").val(data.merk)
            $("#pk").val(data.pk)
            $("lantai").val(data.lantai)
            $("#order-itemId").val(data.id)
            $("#ruangan").val(data.ruangan)

            /**Open Modal */
            $("#modal-update").modal('show');
        },
        error:function(){
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi Kesalahan',
            })
        }
    });

}

function updateItem()
{
    var form = $("#formItem")[0];
    var data = new FormData(form);
    var url = "/teknisi/orderitem/update";

    /**Animasi */
    $("#btn-update-item").attr('Disabled', true)
    $("#btn-update-item").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading ...')

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            /**Close Modal */
            $("#modal-update").modal('hide');

            /**Animasi */
            $("#btn-update-item").attr('Disabled', false)
            $("#btn-update-item").html('Update')

            /**Load Item */
            loadItemList()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Selamat..',
                body: response.message,
            })

        },
        error: function(xhr) {
            if (xhr.status === 422) {

                // Kamus pesan kesalahan dalam bahasa Indonesia
                var errorMessages = {
                    'lantai': 'Form lantai harus diisi, (hanya angka).<br/>',
                    'ruangan': 'Form ruangan harus diisi.<br/>',
                    'order_itemId' : 'Order Id tidak diketahui.<br/>',
                };
    
                // Tanggapi kesalahan validasi dan tampilkan pesan kesalahan
                var errors = xhr.responseJSON.errors;
    
                // Menyiapkan pesan kesalahan untuk ditampilkan
                var errorMessage = '';
                for (var field in errors) {
                    errorMessage += errorMessages[field] + '\n';
                }

                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Oops..',
                    subtitle: 'error..',
                    body: errorMessage,
                })
            } else {
                // Tanggapi kesalahan lain jika diperlukan
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }

            /**Animasi */
            $("#btn-update-item").attr('Disabled', false)
            $("#btn-update-item").html('Update')

            /**Close Modal */
            $("#modal-update").modal('hide');

        }
    });

}

function modalPending ()
{
    $("#modal-pending").modal('show');
}

function pendingOrder(id)
{
    $("#btn-submit-pending").attr('disabled', true)
    $("#btn-submit-pending").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading ...')

    var keterangan = $("#keterangan").val();
    var url = "/teknisi/pending/order";

    if(keterangan.trim() === ""){
        $("#btn-submit-pending").attr('disabled', false)
        $("#btn-submit-pending").html('Ulangi Proses')
        $("#modal-pending").modal('hide');

        /**Notifikasi */
        $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Oops..',
            subtitle: 'Error...',
            body: 'Keterangan tidak boleh kosong!',
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
                window.location = "/teknisi/order";
            },
            error:function(){
                $("#btn-submit-pending").attr('disabled', false)
                $("#btn-submit-pending").html('Ulangi Proses')
                $("#modal-pending").modal('hide');
    
                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Oops..',
                    subtitle: 'Error...',
                    body: 'Terjadi Kesalahan',
                })
    
            }
        });
    }

}