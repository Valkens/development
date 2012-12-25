<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Ninja Group Buy</title>
    <link href="public/css/template.css" rel="stylesheet" type="text/css" />
    <script src="public/js/jquery-1.8.3.min.js"></script>
</head>
<body>

<div id="wrapper">
    <div id="header">
        <div id="header_right">
            <?php
                if (isset($_SESSION['username'])) {
                    echo '<a href="change-password.php">Change password</a> | ';
                    echo '<a href="logout.php">Logout</a>';
                } else {
                    echo '<a href="login.php">Log In</a> | ';
                    echo '<a href="registry.php">Registry</a>';
                }
            ?>
        </div>

        <div class="cleaner"></div>
    </div>

    <div id="menu">
        <div id="top_nav">
            <ul>
                <li><a href="./" class="selected">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <br style="clear: left" />
        </div>
    </div>

    <div id="middle">
        <div class="backgrounds">
            <div class="item item_1">
                <img src="public/images/deal/4.jpg" />
            </div>
        </div>
    </div>