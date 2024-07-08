$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    /**load */
    load()
    loadBranch()
    
    var nik = $("#user_nik").val();
    if(nik!=null){
        loadForm()
    }

    /**Hide Animasi */
    $("#btn-loading").hide();
    $("#btn-loading-edit").hide();
    $("#formSearch").hide();
});

function loadBranch()
{
    var url = "/tableBranch";
    $("#table-branch").load(url)
}

/**load Tabel */
function load()
{
    var nik = $("#user_nik").val();
    var url = "/employee/ajax/table";
    var urlGeneral = "/employee/" + nik + "/general";
    var urlCard = "/employee/" + nik + "/userCard";
    var urlRole = "/employee/tableRole";
    $("#employee-table").load(url);
    $("#user-card").load(urlCard);
    $("#activity").load(urlGeneral);
    $("#table-role").load(urlRole)

    /**Sembunyikan form cabang */
    var priv = $("#privilegeActived").val();
    if(priv != 1){
        $("#cabangForm").hide();
    }else{
        $("#cabangForm").show();
    }
}

/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/employee/ajax/table?page="+ prevPage;
    $("#employee-table").load(url);
}
function paginationPage(page)
{
    var url = "/employee/ajax/table?page="+ page;
    $("#employee-table").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/employee/ajax/table?page="+ nextPage;
    $("#employee-table").load(url);
}
/**End Pagination */

/**Search ajax */
function openSearchForm()
{
    $("#formSearch").show();
}
function closeSearchForm()
{
    $("#formSearch").hide();
    load();
}
function cari(key)
{
    if(key.length==0){
        var url = "/employee/ajax/table";
        $("#employee-table").load(url);
    }else{
        var url = "/employee/" + key + "/search";
        $("#employee-table").load(url);
    }
}



/** open modal create */
function openModalCreate()
{
    $("#modal-create").modal('show');
}

/**submit data karyawan */
function submitEmployee()
{
    var form = $("#formEmployee")[0];
    var data = new FormData(form);
    var url = "/employee";

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        beforeSend: function(){
            $("#btn-loading").show();
            $("#btn-submit").hide();
        },
        success:function(response){
            $("#btn-loading").hide();
            $("#btn-submit").show();
            
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.success
            })

            /**Load Data */
            load()

            /**Cloase Modal Form */
            $("#formEmployee")[0].reset(),
            $("#modal-create").modal('hide');
        },
        error:function(){
            $("#btn-loading").hide();
            $("#btn-submit").show();
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

function loadForm()
{
    var nik = $("#user_nik").val();
    var url = "/employee/" + nik + "/loadForm";

    $.ajax({
        url:url,
        type:'GET',
        dataType:'json',
        success:function(data){
            $("#nama").val(data.user.name);
            $("#phone").val(data.user.phone);
            $("#email").val(data.user.email);
            $("#pendidikan").val(data.employee.pendidikan);
            $("#nik").val(data.employee.ktp);
            $("#kk").val(data.employee.kk);
            $("#tempat_lahir").val(data.employee.tempat_lahir);
            $("#tanggal_lahir").val(data.employee.tanggal_lahir);
            $("#gender").val(data.employee.gender);
            $("#alamat").val(data.employee.alamat);
            $("#nomor_darurat").val(data.employee.telpon_darurat);
            $("#privilege").val(data.user.privilege);
            $("#branch_id").val(data.user.branch_id);
            
        }
    });
}

/**Update Profile */
function updateProfile()
{
    /**Animasi */
    $("#btn-loading-edit").show();
    $("#btn-update").hide();

    var url = "/employee/update";
    var form = $("#formUpdate")[0];
    var data = new FormData(form);

    $.ajax({
        url:url,
        type:'POST',
        data:data,
        processData:false,
        contentType:false,
        success:function(response){
            /**Animasi */
            $("#btn-loading-edit").hide();
            $("#btn-update").show();

            /**Load All */
            load();
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.success
            })
        },
        error:function(){
            /**Animasi */
            $("#btn-loading-edit").hide();
            $("#btn-update").show();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            });
        }
    });
}


function editRole(id, kode, nama)
{
    $("#modal-role").modal('show');

    $("#idrole").val(id)
    $("#kode").val(kode)
    $("#nama").val(nama)
}

function updateRole()
{
    $("#btn-update-role").attr('disabled', true)
    $("#btn-update-role").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var url  = "/employee/updateRole";
    var idrole = $("#idrole").val()
    var kode = $("#kode").val()
    var nama = $("#nama").val()

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idrole:idrole,
            kode:kode,
            nama:nama,
        },
        success:function(response){
            $("#btn-update-role").attr('disabled', false)
            $("#btn-update-role").html('Submit')

            load()
            $("#modal-role").modal('hide');

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            $("#btn-update-role").attr('disabled', false)
            $("#btn-update-role").html('Submit')

             /**Notifikasi */
             $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            });
        }
    });

}

function uploadFoto()
{
    $("#btn-upload").attr('Disabled', true)
    $("#btn-upload").html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    
    var formData = new FormData($('#formUpload')[0]);
    var url = "/employee/uploadFoto";

    $.ajax({
        url:url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            $("#btn-upload").attr('Disabled', true)
            $("#btn-upload").html('Upload')

            load()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })

        },
        error: function(error) {
            $("#btn-upload").attr('Disabled', true)
            $("#btn-upload").html('Upload')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oopss..',
                subtitle: 'Error...',
                body: 'Upload Gagal!',
            })
        }
    });

}

function editBranch(id, office, name, address)
{
    $("#idbranch").val(id)
    $("#id_office").val(office)
    $("#branch_name").val(name)
    $("#branch_address").val(address)
    $("#modal-branch").modal('show')
}

$("#btn-update-branch").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var idbranch = $("#idbranch").val()
    var id_office = $("#id_office").val()
    var branch_name = $("#branch_name").val()
    var branch_address = $("#branch_address").val()
    var url = "/updateBranch";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idbranch:idbranch,
            id_office:id_office,
            branch_name:branch_name,
            branch_address:branch_address,
        },
        success:function(response){
            $("#btn-update-branch").attr('disabled', false)
            $("#btn-update-branch").html('Update')
            loadBranch()
            $("#modal-branch").modal('hide')
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.message
            })
        },
        error:function(){
            $("#btn-update-branch").attr('disabled', false)
            $("#btn-update-branch").html('Update')

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            });
        }
    });
});


