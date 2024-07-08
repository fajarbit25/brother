$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    /**Hide UI */
    $("#btn-loading-costumer").hide();
    $("#btn-loading-edit-costumer").hide();
    $("#btn-loading-delete-costumer").hide();
    $("#formSearch").hide();

    /**Load */
    loadTable();
});

function loadTable()
{
    var url = "/costumer/ajax/table";
    $("#costumersTable").load(url);
}
/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/costumer/ajax/table?page="+ prevPage;
    $("#costumersTable").load(url);
}
function paginationPage(page)
{
    var url = "/costumer/ajax/table?page="+ page;
    $("#costumersTable").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/costumer/ajax/table?page="+ nextPage;
    $("#costumersTable").load(url);
}
/**End Pagination */

function saveCostumer()
{
    /**Animasi */
    $("#btn-loading-costumer").show();
    $("#btn-submit-costumer").hide();
    
    /**Data */
    var url = "/costumers";
    var costumer_name = $("#costumer_name").val();
    var costumer_pic = $("#costumer_pic").val();
    var costumer_phone = $("#costumer_phone").val();
    var costumer_email = $("#costumer_email").val();
    var costumer_address = $("#costumer_address").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            costumer_name:costumer_name,
            costumer_pic:costumer_pic,
            costumer_phone:costumer_phone,
            costumer_email:costumer_email,
            costumer_address:costumer_address,
        }, success:function(response){
            /**Reset Form */
            $("#cForm")[0].reset();

            /**Animasi */
            $("#btn-loading-costumer").hide();
            $("#btn-submit-costumer").show();

            /**Close Modal */
            $("#modal-xl").modal('hide');

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.success
            })

            /**Load Table */
            loadTable();
        }, error:function(xhr, status, error){
            console.log(xhr.responseText);

            /**Animasi */
            $("#btn-loading-costumer").hide();
            $("#btn-submit-costumer").show();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Subtitle',
                body: xhr.responseText
            })
        }
    });
}

function formSearch()
{
    $("#formSearch").show();
}
function cari(key)
{
    if(key.length==0){
        var url = "/costumer/ajax/table";
        $("#costumersTable").load(url);
    }else{
        var url = "/costumer/"+ key + "/search";
        $("#costumersTable").load(url);
    }
}

/**Edit data pelanggan */
function editCostumer(id)
{
    console.log(id)
    var url = "/costumer/" + id + "/edit";
    $.ajax({
        url:url,
        type:'GET',
        dataType:'json',
        cache:false,
        success:function(data){
            $("#idcostumer_edit").val(data[0].idcostumer);
            $("#costumer_name_edit").val(data[0].costumer_name);
            $("#costumer_status_edit").val(data[0].costumer_status);
            $("#costumer_pic_edit").val(data[0].costumer_pic);
            $("#costumer_phone_edit").val(data[0].costumer_phone);
            $("#costumer_email_edit").val(data[0].costumer_email);
            $("#costumer_address_edit").val(data[0].costumer_address);
        }
    });
}

/**Update data pelanggan */
function updateCostumer()
{
    /**Animation IU */
    $("#btn-loading-edit-costumer").show();
    $("#btn-submit-edit-costumer").hide();

    /**Data */
    var url = "/costumer/update";
    var idcostumer = $("#idcostumer_edit").val();
    var costumer_name = $("#costumer_name_edit").val();
    var costumer_status = $("#costumer_status_edit").val();
    var costumer_pic = $("#costumer_pic_edit").val();
    var costumer_phone = $("#costumer_phone_edit").val();
    var costumer_email = $("#costumer_email_edit").val();
    var costumer_address = $("#costumer_address_edit").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idcostumer:idcostumer,
            costumer_name:costumer_name,
            costumer_status:costumer_status,
            costumer_pic:costumer_pic,
            costumer_phone:costumer_phone,
            costumer_email:costumer_email,
            costumer_address:costumer_address,
        }, success:function(response){
            /**Animation IU */
            $("#btn-loading-edit-costumer").hide();
            $("#btn-submit-edit-costumer").show();

            /**Close Modal */
            $("#modal-edit").modal('hide');

            /**load table */
            loadTable();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.success
            })
        }, error:function(xhr, status, error){
            /**Animation IU */
            $("#btn-loading-edit-costumer").hide();
            $("#btn-submit-edit-costumer").show();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Subtitle',
                body: xhr.responseText
            })
        }
    });
}

/**Delete Data Pelanggan */
function alertDelete(id)
{
    url = "/costumer/" + id + "/edit";
    $("#idcostumer-delete").val(id);
}
function deleteCostumer()
{
    /**Animasi */
    $("#btn-loading-delete-costumer").show();
    $("#btn-submit-delete-costumer").hide();

    var url = "/costumer/delete";
    var idcostumer = $("#idcostumer-delete").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            idcostumer:idcostumer,
        }, success:function(response){
            /**Animasi */
            $("#btn-loading-delete-costumer").hide();
            $("#btn-submit-delete-costumer").show();

            /**Close Modal */
            $("#modal-delete").modal('hide');

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats',
                subtitle: 'Success',
                body: response.success
            }) 
            
            /**Load Table */
            loadTable();
        }, error:function(xhr, status, error){
            /**Animasi */
            $("#btn-loading-delete-costumer").hide();
            $("#btn-submit-delete-costumer").show();

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Subtitle',
                body: xhr.responseText
            })
        }
    });
}



