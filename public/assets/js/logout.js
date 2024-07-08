$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    /**Animasi */
    $("#logout-animasi").hide();
});

function logout()
{
    /**Animasi */
    $("#logout-animasi").show();
    console.log('proses logout');

    var url = "/user/logout";
    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        success:function(response){
            if(response.logout == 'true'){
                window.location = "/";
            }
        }
    });
}