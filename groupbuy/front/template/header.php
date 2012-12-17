<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Group buy site</title>
    <link rel="stylesheet" type="text/css" href="public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="public/css/style.css" />
    <link rel="stylesheet" type="text/css" href="front/template/css/style.css" />
    <script type="text/javascript" src="public/js/jquery-1.8.3.min.js"></script>
</head>

<body>
<div id="background">
    <div id="page">
        <div id="header">
            <div id="logo">
                <h3>Group buy site</h3>
            </div>
            <div id="navigation">
                <ul id="primary">
                    <?php $selected = !isset($_GET['m']) ? ' class="selected"' : '' ;?>
                    <li<?php echo $selected;?>>
                        <a href="./">Home</a>
                    </li>
                    <?php
                        $selected = '';
                        $cateId = isset($_GET['cid']) ? $_GET['cid'] : 0;
                        foreach ($categories as $category) {
                            $selected = ($cateId == $category['id']) ? ' class="selected"' : '';
                            echo "<li{$selected}><a href='./?m=category&cid={$category['id']}'>{$category['name']}</a></li>";
                        }
                    ?>
                </ul>
                <ul id="secondary">
                    <li>
                        <a href="#">Cart</a>
                    </li>
                    <li>
                        <?php
                            if (isset($_SESSION['customer'])) {
                                echo '<a href="?m=user&a=profile">' . htmlspecialchars($_SESSION['customer']['fullname']) . '</a> | ';
                                echo "<a href='?m=user&a=logout'>Logout</a>";
                            } else {
                                echo '<a href="?m=user&a=login">Login</a> | <a href="?m=user&a=signup">Signup</a>';
                            }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
