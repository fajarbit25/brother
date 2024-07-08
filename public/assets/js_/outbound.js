$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /**Hide Element */
    $("#formFilter").hide();

    /**load All */
    loadTable()
    loadTableBranch()
    loadBrangMasuk()
});

function loadBrangMasuk()
{
    var url = "/inventory/outbound/branch/tableReceived";
    $("#table-branch-received").load(url)
}

function loadTableBranch()
{
    var url = "/inventory/outbound/branch/table";
    $("#table-branch").load(url)
}

function loadTable()
{
    var url = "/outbound/table";
    $("#outbound-table").load(url)
}

$("#btn-filter").click(function() {
    // animasi
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...');

    // Mengambil nilai dari input
    var start = $("#start").val();
    var end = $("#end").val();
    var url = '/outbound/' + start + '/' + end + '/filter';
    
    // Menunda eksekusi kode selama 2 detik
    setTimeout(function() {
        // Menghapus efek visual pada tombol filter
        $("#btn-filter").html('<i class="bi bi-funnel"></i> Filter');

        // Memuat data dari URL
        $("#outbound-table").load(url);
    }, 1000); // Waktu delay dalam milidetik (2 detik = 2000 milidetik)
});

/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/outbound/table?page="+ prevPage;
    $("#outbound-table").load(url);
}
function paginationPage(page)
{
    var url = "/outbound/table?page="+ page;
    $("#outbound-table").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/outbound/table?page="+ nextPage;
    $("#outbound-table").load(url);
}
/**End Pagination */

$("#filter").click(function(){
    $("#formFilter").show();
});

function modalBranch()
{
    $("#modal-branch").modal('show')
}

$("#btn-send-branch").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...');

    var branch = $("#branch").val()
    var product = $("#product").val()
    var qty = $("#qty").val()
    var url = "/inventory/outbound/branchForm";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            branch:branch,
            product:product,
            qty:qty,
        },
        success:function(response){
            $("#btn-send-branch").attr('disabled', false)
            $("#btn-send-branch").html('Submit');
            $("#modal-branch").modal('hide')
            loadTableBranch()
            /**Notifikasi */
            if(response.status === 500){
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Oops..',
                    subtitle: 'Error...',
                    body: response.message
                })
            } else if (response.status === 200){
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Congrats..',
                    subtitle: 'Success...',
                    body: response.message,
                })
            }
            
        },
        error:function(){
            $("#btn-send-branch").attr('disabled', false)
            $("#btn-send-branch").html('Submit');

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
});

function approvedBranch(id)
{
    var namaBtn = "#btn-approve-branch-"+id;
    $(namaBtn).attr('disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...');

    var url = "/inventory/outbound/approveBranch";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('<i class="bi bi-check-circle"></i> Approved');

            loadBrangMasuk()

            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('<i class="bi bi-check-circle"></i> Approved');

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });
}

function deleteBranch(id)
{
    var namaBtn = "#btn-delete-branch-"+id;
    $(namaBtn).attr('disabled', true)
    $(namaBtn).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>');

    var url = "/inventory/outbound/deleteBranch";

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            id:id,
        },
        success:function(response){
            loadTableBranch()
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Congrats..',
                subtitle: 'Success...',
                body: response.message,
            })
        },
        error:function(){
            $(namaBtn).attr('disabled', false)
            $(namaBtn).html('<i class="bi bi-trash3"></i>');

            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Oops..',
                subtitle: 'Error...',
                body: 'Permintaan gagal, Terjadi kesalahan!'
            })
        }
    });

}