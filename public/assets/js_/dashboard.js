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
    var url = "/dashboad/table";
    $("#table-order").load(url);
}

/**Pagination */
function paginationPreviousPage(page)
{
    var prevPage = page-1;
    var url = "/dashboad/table?page="+ prevPage;
    $("#table-order").load(url);
}
function paginationPage(page)
{
    var url = "/dashboad/table?page="+ page;
    $("#table-order").load(url);
}
function paginationNext(page)
{
    var nextPage = page+1;
    var url = "/dashboad/table?page="+ nextPage;
    $("#table-order").load(url);
}
/**End Pagination */