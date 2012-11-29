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
                <a href="index.html"><img src="front/template/images/logo.png" alt="LOGO"></a>
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
                        <a href="#">Login</a> | <a href="#">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
