<?php
include('../../libs/config.php');
include('../../libs/db.php');
session_start();

if (isset($_SESSION['username'])) {
    header('location: ../dashboard');
    exit();
}

if (isset($_POST['submit'])) {
    if ($_POST['username'] == '' || $_POST['password'] == '') {
        $error = 'Xin nhập đầy đủ thông tin';
    } else {
        $conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        $stmt = $conn->prepare('SELECT * FROM users WHERE username = :username AND password=MD5(:password)');
        $stmt->execute(array('username' => $_POST['username'], 'password' => $_POST['password']));
        if (count($stmt->fetchAll())) {
            $_SESSION['username'] = $_POST['username'];
            header('location: ../dashboard');
            exit();
        } else {
            $error = 'Thông tin đăng nhập không chính xác.';
        };
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>User login</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="../template/css/login.css" />
    <script type="text/javascript" src="../../public/js/jquery-1.8.3.min.js"></script>
</head>

<body>
    <fieldset>
        <legend>User information</legend>
        <div class="error">
            <?php if (isset($error)) echo $error;?>
        </div>
        <form action="" method="POST">
            <label>Username (*): </label>
            <input type="text" id="username" name="username" maxlength="64" />
            <br />
            <label>Password (*): </label>
            <input type="password" id="password" name="password" />
            <br />
            <label>&nbsp;</label><input type="submit" name="submit" value="Login" />
        </form>
    </fieldset>

    <script type="text/javascript">
        $(function(){
            $('form').submit(function(){
                if ($('#username').val() == '' || $('#password') == '') {
                    alert('Xin nhap day du thong tin');
                    return false;
                }
            })
        })
    </script>
</body>
</html>