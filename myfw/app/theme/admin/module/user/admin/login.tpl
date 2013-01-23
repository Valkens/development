<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>User login</title>
    [[ $this->addCss(array('/public/css/reset.css',
                           'css/common.less',
                           'css/main.less'))
    ]]
</head>
<body>
<div id="loginWrapper">
    <form id="frmLogin" method="post">
        <div class="loginPic">
            <img src="{{$baseUrl}}/app/theme/admin/img/userLogin.png">
        </div>
        <p class="albox mError hidden">Username or Password is invalid</p>
        <input type="text" class="loginUsername required" placeholder="Username" name="username" />
        <input type="password" class="loginPassword required" placeholder="Password" name="password" />
        <div class="loginControl">
            <input type="submit" class="buttonM bBlue" value="Login" name="submit" />
            <div class="clear"></div>
        </div>
    </form>
</div>
[[ $this->addScript(array('/public/js/jquery/jquery.js',
                          '/public/js/jquery/form/validation.js'))
]]
<script type="text/javascript">
$(function(){
    $('#frmLogin').validate({
        submitHandler: function() {
            $('#frmLogin .albox').hide();
            var jqxhr = $.post('{{$adminUrl}}/auth', $('#frmLogin').serialize(), function(response) {
            }, 'json')
            .success(function(response) {
                if (response.success == 0) {
                    $('#frmLogin .albox').slideDown(200);
                } else {
                    $('#frmLogin .albox').hide();
                    window.location.replace('{{$adminUrl}}');
                }
            });
        }
    });
});
</script>
</body>
</html>