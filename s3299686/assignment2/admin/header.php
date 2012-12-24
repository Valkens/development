<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin area</title>
    <link rel="stylesheet" type="text/css" href="../../css/reset.css" />
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <script type="text/javascript" src="../../js/jquery-ui/js/jquery-1.8.3.js"></script>
</head>

<body>
<div id="wrapper">
    <div id="header">
        <div class="inner-wrap">
            <h3 class="brand">Admin area</h3>
            <ul class="nav">
                <li><a href="../../" target="_blank">View Site</a></li>
            </ul>
            <div id="login-info" class="pull-right">
                <div>Welcome to <font color="red"><?php echo $_SESSION['username'];?></font></div>
                | <a href="../../logout.php">Logout</a>
            </div>
        </div>
    </div>

    <div id="content-wrap" class="inner-wrap">
        <div id="col-left" class="pull-left">
            <ul id="main-menu">
                <li><a href="../dashboard">Dashboard</a></li>
                <li><a href="../deal">Deal</a></li>
                <li><a href="../category">Category</a></li>
                <li><a href="../user">User</a></li>
                <li><a href="../comment">Comment</a></li>
            </ul>
        </div>
