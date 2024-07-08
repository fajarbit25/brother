$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    tableAsset()
    tableAngsuran()
    tableForm()
});


function tableForm()
{
    var id = $("#asset_id").val();
    var url = "/finance/table/" + id + "/form"
    $("#table-form").load(url)
}

function tableAsset()
{
    var url = "/finance/table/asset";
    $("#table-asset").load(url)
}


/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/finance/table/asset?page="+ prevPage;
    $("#table-asset").load(url);
}
function paginationPage(page)
{
    var url = "/finance/table/asset?page="+ page;
    $("#table-asset").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/finance/table/asset?page="+ nextPage;
    $("#table-asset").load(url);
}
/**End Pagination */

function tableAngsuran()
{
    var url = "/finance/table/angsuran";
    $("#table-angsuran").load(url)
}

$("#btn-modal").click(function(){
    $("#modal-asset").modal('show');
});

function simpanAsset()
{
    $("#btn-asset").attr('disabled', true)
    $("#btn-asset").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var form = $("#form-asset")[0];
    var data = new FormData(form);
    var url = "/finance/asset/store";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            $("#btn-asset").attr('disabled', false)
            $("#btn-asset").html('Simpan Data')

            tableAsset()
            $("#form-asset")[0].reset();
            $("#modal-asset").modal('hide');
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-asset").attr('disabled', false)
            $("#btn-asset").html('Simpan Data')

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

function edit(id, roda, tipe, plat, tahun, kondisi, merk)
{
    $("#modal-edit").modal('show')

    $("#rodaEdit").val(roda)
    $("#merkEdit").val(merk)
    $("#tipeEdit").val(tipe)
    $("#platEdit").val(plat)
    $("#tahunEdit").val(tahun)
    $("#kondisiEdit").val(kondisi)
    $("#idasset").val(id)
}

function editAsset()
{
    $("#btn-edit").attr('disabled', true)
    $("#btn-edit").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var form = $("#form-edit")[0];
    var data = new FormData(form);
    var url = "/finance/asset/update";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            $("#btn-edit").attr('disabled', false)
            $("#btn-edit").html('Update Data')

            tableAsset()
            $("#form-asset")[0].reset();
            $("#modal-edit").modal('hide');
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-edit").attr('disabled', false)
            $("#btn-edit").html('Update Data')

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

function tambahBaris(id)
{
   $("#btn-tambah").attr('disabled', true)
   $("#btn-tambah").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

   var url = "/asset/form/store";

   $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $("#btn-tambah").attr('disabled', false)
            $("#btn-tambah").html('<i class="bi bi-plus-lg"></i> Tambah Baris')

            tableForm()
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

        },
        error:function(){
            $("#btn-tambah").attr('disabled', false)
            $("#btn-tambah").html('<i class="bi bi-plus-lg"></i> Tambah Baris')

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

function updateForm(id)
{
    var namaBtn = "#btn-update-form-" + id;
    $(namaBtn).attr('disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var namaJatuhTempo = "#jatuh_tempo-" + id;
    var namaPembiayaan = "#pembiayaan-" + id;
    var namaJumlah = "#jumlah-" + id;

    var jatuh_tempo = $(namaJatuhTempo).val();
    var pembiayaan = $(namaPembiayaan).val();
    var jumlah = $(namaJumlah).val();
    var url = "/asset/form/update";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            jatuh_tempo:jatuh_tempo,
            pembiayaan:pembiayaan,
            jumlah:jumlah,
        },
        success:function(response){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

            tableForm()

            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

        },
        error:function(){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

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

function setBaya(id)
{
    var namaBtn = "#btn-set-bayar-"+id;
    $(namaBtn).attr('disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/asset/form/setBayar";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

            tableForm()

            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

        },
        error:function(){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

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

function simpanData(id)
{
    $("#btn-simpan-data").attr('disabled', true)
    $("#btn-simpan-data").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/asset/form/saveForm";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            window.location = "/asset/" + id + "/payment";
        },
        error:function(){
            $("#btn-simpan-data").attr('disabled', false)
            $("#btn-simpan-data").html('Simpan Data')

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

function deleteForm(id)
{
    var namaBtn = "#btn-delete-"+id;
    $(namaBtn).attr('disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>')

    var url = "/asset/form/deleteForm";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

            tableForm()

            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

        },
        error:function(){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

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


function bayarAngsuran(id)
{
    var namaBtn = "#btn-bayar-"+id;
    $(namaBtn).attr('disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/asset/form/bayarAngsuran";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

            tableForm()

            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

        },
        error:function(){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('Update')

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