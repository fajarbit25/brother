$(document).ready(function(){
    $("#alert-input").hide();
    $("#btn-excel").hide();
    $("#formSearch").hide();
    $("#formTeknisi").hide();
});

$("#modalReport").click(function(){
    $("#modal-filter").modal('show');
});

function getReport()
{
    var branch = $("#branch").val()
    var start = $("#start").val()
    var end = $("#end").val()
    var url = "/order/" + start + "/" + end + "/" + branch + "/report";
    var urlExcel = "/order/" + start + "/" + end + "/" + branch + "/export";

    $("#table-report").load(url)
    $("#btn-excel").show();
    $("#btn-excel").attr('href', urlExcel);
    $("#modal-filter").modal('hide');
    $("#formSearch").show();
    $("#formTeknisi").show();

}

/**Pagination */
function paginationPreviousPage(page)
{
    var branch = $("#branch").val()
    var start = $("#start").val()
    var end = $("#end").val()
    var prevPage = page-1;
    var url = "/order/" + start + "/" + end + "/" + branch + "/report?page=" + prevPage;
    $("#table-report").load(url);
}
function paginationPage(page)
{
    var branch = $("#branch").val()
    var start = $("#start").val()
    var end = $("#end").val()
    var url = "/order/" + start + "/" + end + "/" + branch + "/report?page=" + page;
    $("#table-report").load(url);
}
function paginationNext(page)
{
    var branch = $("#branch").val()
    var start = $("#start").val()
    var end = $("#end").val()
    var nextPage = page+1;
    var url = "/order/" + start + "/" + end + "/" + branch + "/report?page=" + nextPage;
    $("#table-report").load(url);
}
/**End Pagination */

function cari(key)
{
    var branch = $("#branch").val()
    var start = $("#start").val()
    var end = $("#end").val()

    if(key.length==0){
        var url = "/order/" + start + "/" + end + "/" + branch + "/report";
    }else{
        var url = "/order/" + start + "/" + end + "/" + branch +  "/" + key + "/search";
    }
    $("#table-report").load(url);
    $("#btn-excel").hide();
}

function cariTeknisi()
{
    $("#formSearch").hide();
    var branch = $("#branch").val()
    var start = $("#start").val()
    var end = $("#end").val()
    var teknisi = $("#teknisi").val()

    var url = "/order/" + start + "/" + end + "/" + branch +  "/" + teknisi + "/tableByDateTeknisi"; 
    $("#table-report").load(url);
    $("#btn-excel").hide();
}