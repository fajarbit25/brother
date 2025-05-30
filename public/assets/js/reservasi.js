$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**Hide Animation */
    $("#btn-loading").hide();
    $("#btn-submit").hide();
    $("#btn-loading-submit").hide();
});

$("#orderId").change(function(){
    load();
});

function load()
{
    var id = $( "#orderId" ).val();
    var url = "/reservasi/"+ id +"/table";
    $("#table-reservasi").load(url);
    $("#btn-submit").show();
}

$("#order").change(function(){
    load();
});


$("#orderId").change(function(){
    var idorder = $("#orderId").val();
    var url = "/inventory/get-item-order/" + idorder;

    $.ajax({
        url:url,
        type:'GET',
        dataType:'json',
        cache:false,
        success:function(data) {
            
            // Iterasi data dari respons
            $.each(data, function (index, item) {
                $('#itemId').append(
                    $('<option>', {
                        value: item.id, // atau item.kode, tergantung struktur data kamu
                        text: item.item_name + " - " + item.merk + " " + item.pk  // atau item.nama
                    })
                );
            });

        }, 
        error:function(){
            console.log('gagal mengambil data!');
        }
    });
});

$("#product").change(function(){
    var idproduct = $(this).val();
    var url = "/produk/"+ idproduct +"/stockJson";

    $.ajax({
        url:url,
        type:'GET',
        dataType:'json',
        cache:false,
        success:function(response) {
            $("#stockAkhir").val(response.stock)
            console.log(response.stock)
        },
        error:function(){
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Error..',
                subtitle: 'Oops...',
                body: 'Gagal Memuat Stok',
            })
        }
    });
});



/**Add Item */
$("#btn-add").click(function(){
    /**Animation */
    $("#btn-loading").show();
    $("#btn-add").hide();

    var url = "/reservasi/add";
    var order = $("#orderId").val();
    var product = $("#product").val();
    var qty = $("#qty").val();
    var item = $("#itemId").val();

    console.log(order)

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            order:order,
            product:product,
            qty:qty,
            item:item,
        },
        success:function(response){
            /**Animation */
            $("#btn-loading").hide();
            $("#btn-add").show();
            $("#qty").val("");
            $( "#order" ).prop( "disabled", true );

            /**Load */
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
            /**Animation */
            $("#btn-loading").hide();
            $("#btn-add").show();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan!',
            })
        }
    });
});

/**Detele Item */
function deleteItem(id)
{
    var url = "/reservasi/delete";
    var item = $("#itemId").val();
    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            /**Load */
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
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan!',
            })
        }
    });
}

/**Submit Outbound */
$("#btn-submit").click(function(){
    /**Animasi */
    $("#btn-submit").hide();
    $("#btn-loading-submit").show();

    var order = $("#orderId").val();
    var url = "/reservasi/submit";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            order:order
        },
        success:function(response){
            window.location = "/inventory/outbound";
        },
        error:function(){
            /**Animasi */
            $("#btn-submit").show();
            $("#btn-loading-submit").hide();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan!',
            })
        }
    });
});
