$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadTable()
});

function loadTable()
{
    var url = "/employee/payroll/table";
    $("#table-payroll").load(url)
}

function edit(id, pokok, makan, tunjangan, bpjs, nama, jabatan, lembur, kehadiran)
{
    $("#nama").val(nama)
    $("#jabatan").val(jabatan)
    $("#id").val(id)
    $("#pokok").val(pokok)
    $("#makan").val(makan)
    $("#tunjangan").val(tunjangan)
    $("#bpjs").val(bpjs)
    $("#lembur").val(lembur)
    $("#kehadiran").val(kehadiran)

    $("#modal-edit").modal('show');
}

function update()
{
    $("#btn-update").attr('disabled', true)
    $("#btn-update").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/employee/payroll/update";
    var id = $("#id").val()
    var pokok = $("#pokok").val()
    var makan = $("#makan").val()
    var tunjangan = $("#tunjangan").val()
    var bpjs = $("#bpjs").val()
    var lembur = $("#lembur").val()
    var kehadiran = $("#kehadiran").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
            pokok:pokok,
            makan:makan,
            tunjangan:tunjangan,
            bpjs:bpjs,
            lembur:lembur,
            kehadiran:kehadiran
        },
        success:function(response){
            $("#btn-update").attr('disabled', false)
            $("#btn-update").html('Update')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
            loadTable()
            $("#modal-edit").modal('hide');
        },
        error:function(){
            $("#btn-update").attr('disabled', false)
            $("#btn-update").html('Update')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan',
            })
        }
    });
}

$("#btn-proses").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/employee/payroll/proses";
    var idkaryawan = $("#idkaryawan").val();
    var lembur = $("#lembur").val();
    var kehadiran = $("#kehadiran").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idkaryawan:idkaryawan,
            lembur:lembur,
            kehadiran:kehadiran,
        },
        success:function(response){
            window.location = "/employee/payroll";
        },
        error:function(){
            $("#btn-proses").attr('disabled', false)
            $("#btn-proses").html('Update')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan',
            })
        }
    });


});

function resetPaid(id)
{
    $("#btn-reset").attr('disabled', true);
    $("#btn-reset").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url = "/employee/payroll/reset";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $("#btn-reset").attr('disabled', false);
            $("#btn-reset").html('<i class="bi bi-arrow-repeat"></i> Reset')

            loadTable()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })

        },
        error:function(){
            $("#btn-reset").attr('disabled', false);
            $("#btn-reset").html('<i class="bi bi-arrow-repeat"></i> Reset')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Terjadi kesalahan',
            })
        }
    });
}
