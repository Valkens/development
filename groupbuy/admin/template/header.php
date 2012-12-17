<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin control panel</title>
    <link rel="stylesheet" type="text/css" href="../../public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../../public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="../template/css/style.css" />
    <script type="text/javascript" src="../../public/js/jquery-1.8.3.min.js"></script>
</head>

<body>
<div id="wrapper">
    <div id="header">
        <div class="inner-wrap">
            <h3 class="brand">Admin area</h3>
            <ul class="nav">
                <li><a href="../../" target="_blank">Visit Site</a></li>
            </ul>
            <div id="login-info" class="pull-right">
                <div>Welcome to <font color="red"><?php echo $_SESSION['username'];?></font></div>
                | <a href="../user/logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div id="content-wrap" class="inner-wrap">
        <div id="col-left" class="pull-left">
            <ul id="main-menu">
                <li class="nav-header">Main menu</li>
                <li><a href="../dashboard/">Dashboard</a></li>
                <li><a href="../category/">Category</a></li>
                <li><a href="../deal/">Deal</a></li>
                <li><a href="../customer/">Customer</a></li>
                <li><a href="../question/">Question</a></li>
                <li><a href="../transaction/">Transaction</a></li>
            </ul>
        </div>
