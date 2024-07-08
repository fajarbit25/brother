$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadTable()
});

function loadOption()
{
    var url = "/absen/option_user";
    $("#karyawan").load(url);
}

function loadTable()
{
    var url = "/absen/data_table";
    $("#data-table").load(url)
}

$("#btn-new").click(function(){
    $("#modal-new").modal('show');
});

$("#btn-create").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/absensi/new";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        success:function(){
            window.location = "/employee/absensi";
        },
        error:function()
        {
            $(this).attr('disabled', false)
            $(this).html('Create')
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

$("#btn-add").click(function(){
    loadOption()
    $("#modal-add").modal('show');
});

$("#btn-added").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/absensi/post";
    var user_id = $("#karyawan").val();
    var absensi = $("#absensi").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            user_id:user_id,
            absensi:absensi,
        },
        success:function(response){
            $("#btn-added").attr('disabled', false)
            $("#btn-added").html('Simpan')

            loadOption()
            loadTable()

        },error:function(){
            $("#btn-added").attr('disabled', false)
            $("#btn-added").html('Simpan')

            loadTable()

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

function modalLembur(id)
{
    $("#idabsen").val(id);
    $("#modal-lembur").modal('show');

}

$("#btn-lembur").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var id = $("#idabsen").val();
    var jam = $("#jam").val();
    var url = "/absen/lembur/update";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            jam:jam,
        },
        success:function(response){
            $("#btn-lembur").attr('disabled', false)
            $("#btn-lembur").html('Simpan')
            $("#modal-lembur").modal('hide');

            loadTable()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Cangrats..',
                subtitle: 'Success',
                body: response.message,
            })
        },
        error:function(){
            $("#btn-lembur").attr('disabled', false)
            $("#btn-lembur").html('Simpan')

            loadTable()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error',
                body: 'Tarjadi Kesalahan!',
            })
        }
    });
});

function deleteAbsen(id)
{
    console.log(id)
    var namaBtn = "#btn-delete-" + id;
    var url = "/absen/delete";
    $(namaBtn).attr('disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>')

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){

            window.location = "/employee/absensi";
        },
        error:function(){

            loadTable()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error',
                body: 'Tarjadi Kesalahan!',
            })
        }
    });

}

$("#btn-cari").click(function(){
    var start = $("#start").val();
    var url = "/absen/" + start + "/report";

    $("#tabel-report-absen").load(url);
    console.log(url)
});

function absenPulang(id)
{
    var btn = "#btn-pulang-" + id;
    var url = "/absensi/pulang";
    $(btn).attr('disabled', true)
    $(btn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){

            loadTable()
        },
        error:function(){

            loadTable()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error',
                body: 'Tarjadi Kesalahan!',
            })
        }
    });
}