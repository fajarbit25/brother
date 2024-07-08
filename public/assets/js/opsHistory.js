$("#btn-filter").click(function(){
    $("#modal-filter").modal('show')
});

$("#btn-submit").click(function(){
    $(this).attr('disabled', true)
    $(this).html('<span class="spinner-border spinner-border-sm" aria-hidden="true"></span> Loading...')

    var start = $("#start").val();
    var end = $("#end").val();
    var url = "/operational/" + start + "/" + end + "/history";

    $("#table-history").load(url);

    $("#modal-filter").modal('hide')

    $(this).attr('disabled', false)
    $(this).html('Lihat History')
});

/**Pagination */
function paginationPreviousPage(page)
{
    var start = $("#start").val();
    var end = $("#end").val();
    var prevPage = page-1;
    var url = "/operational/" + start + "/" + end + "/history?page="+ prevPage;
    $("#table-history").load(url);
}
function paginationPage(page)
{
    var start = $("#start").val();
    var end = $("#end").val();
    var url = "/operational/" + start + "/" + end + "/history?page="+ page;
    $("#table-history").load(url);
}
function paginationNext(page)
{
    var start = $("#start").val();
    var end = $("#end").val();
    var nextPage = page+1;
    var url = "/operational/" + start + "/" + end + "/history?page="+ nextPage;
    $("#table-history").load(url);
}
/**End Pagination */
