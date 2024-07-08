$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btn-loading").hide();
});

/**Proses Login */
function login()
{
    $("#btn-login").hide();
    $("#btn-loading").show();

    var url = '/login';
    var email = $("#email").val();
    var password = $("#password").val();

    $.ajax({
        url:url,
        type:'POST',
        cache:false,
        data:{
            email:email,
            password:password,
        }, success:function(response){
            if(response.auth == 'true'){
                window.location = "/dashboard";
            }else{
                $("#btn-loading").hide();
                $("#btn-login").show();

                /**Notifikasi */
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Oops',
                    subtitle: 'Error',
                    body: 'Access Denied!',
                })
            }
        }, error:function(error){
            $("#btn-loading").hide();
            $("#btn-login").show();
            /**Notifikasi */
            $(document).Toasts('create', {
                class: 'bg-warning',
                title: 'Oops',
                subtitle: 'Error Mesege',
                body: 'Kesalahan Koneksi!',
            })
        }
    });
}