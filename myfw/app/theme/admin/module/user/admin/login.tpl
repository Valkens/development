<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>User login</title>
    @$this->inc('@_theme_/block/css')
</head>
<body>
<div id="alertMessage"></div>
<div id="loginWrapper">
    <form id="frmLogin" method="post">
        <div class="loginPic">
            <img src="{{$baseUrl}}/app/theme/admin/img/userLogin.png">
        </div>
        <input type="text" class="loginUsername required" placeholder="Username" name="username" />
        <input type="password" class="loginPassword required" placeholder="Password" name="password" />
        <div class="loginControl">
            <input id="submit" type="submit" class="button buttonM bBlue" value="Login" name="submit" />
            <div class="clear"></div>
        </div>
    </form>
</div>

@$this->inc('@_theme_/block/javascript')

<script type="text/javascript">
$(function(){
    $('#frmLogin').validate({
        submitHandler: function() {
            loading('Checking', 1);
            $('#frmLogin .albox').hide();
            $.post('{{$this->url('route_user_auth')}}', $('#frmLogin').serialize(), function(response) {
            }, 'json')
            .success(function(response) {
                setTimeout('unloading()', 1500);
                setTimeout(function(){
                    if (response.success == 0) {
                        showAlertMessageError('Username or Password is invalid', 1500);
                    } else {
                        showAlertMessageSuccess('Login success', 1000);
                        $('#submit').addClass('disabled').attr('disabled', 'disabled');
                        setTimeout(function(){
                            window.location.replace('{{$adminUrl}}');
                        }, 1000);
                    }
                }, 2000);
            });
        }
    });
});
</script>
</body>
</html>