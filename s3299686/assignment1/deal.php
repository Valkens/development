<?php
session_start();
include ("pdo.php");
$id = (int) $_GET['id'];
$sql = "SELECT * FROM deal where dealid=$id";
$result = $pdo->query($sql);
$deal = $result->fetch();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $deal['dealname'];?></title>
    <link rel="stylesheet" href="./css/style3.css" type="text/css" />
    <style type="text/css">
        table td{
            font-size: 14px;
        }
    </style>
</head>

<body>
<div id="wrapper">

    <div id="top">

        <div id="head">
            <div id="header">
                <div id="login">
                    <?php
                    if (isset($_SESSION['username'])) {
                        echo '<font color="white">Welcome to ' . $_SESSION['username'] . '</font><br />';
                        echo '<a href="#">Change password</a><br />';
                        echo '<a href="./logout.php">Logout</a>';
                    } else {
                        if (isset($_REQUEST["error"])) {
                            echo "<font color='red'>Log In Failed</font>";
                        } ?>
                        <form action="./login.php" method="post" style="color:#fff">
                            Username <input type="text" name="username" />
                            Password <input type="password" name="password"/>
                            <input type="submit" value="Log in"/>
                            <br/>
                            <font color="white">Not a member?</font>
                            <br/>
                            <a href="signup.php">Sign up</a>
                        </form>
                        <?php } ?>

                </div>
            </div>

            <ul id='navigation'>
                <li><a href="./" target="_self">HOME</a></li>
                <?php
                $sql = "SELECT * FROM category";
                $result = $pdo->query($sql);
                $list_category = $result->fetchAll();
                foreach ($list_category as $category) {
                    echo "<li><a href='category.php?id={$category['id']}' target='_self'>{$category['category']}</a></li>";
                }
                ?>
            </ul>
            <div id="texta">
                <table>
                    <tr>
                        <th>Deal name</th>
                        <td><?php echo $deal['dealname'];?></td>
                    </tr>
                    <tr>
                        <th>Deal description</th>
                        <td><?php echo $deal['description'];?></td>
                    </tr>
                    <tr>
                        <th>Original price</th>
                        <td><?php echo $deal['olprice'];?></td>
                    </tr>

                    <tr>
                        <th>Deal price</th>
                        <td><?php echo $deal['price'];?></td>
                    </tr>

                    <tr>
                        <th>Saving</th>
                        <td><?php echo $deal['saving'];?></td>
                    </tr>

                    <tr>
                        <th>Number of current buyer</th>
                        <td><?php echo $deal['currentbuyer'];?></td>
                    </tr>


                    <tr>
                        <th>Expire time</th>
                        <td><?php echo $deal['exptime'];?></td>
                    </tr>

                    <tr>
                        <th>Status</th>
                        <td><?php echo ($deal['status'] == 1) ? 'Active' : 'Sold out';?></td>
                    </tr>

                    <tr>
                        <th>Condition</th>
                        <td><?php echo $deal['conditiondescript'];?></td>
                    </tr>
            </div>
        </div>
        <div id="searchwindow">

        </div>
        <div id="add">
            <a href="#" onclick="<?php echo (!isset($_SESSION['username'])) ? 'return false' : '';?>"><img src="pics/buy.png"/></a>
        </div>
        <div id="game">
            <div id="game1">
                <img src="<?php echo $deal['img'];?>" width= 350px height="350">
            </div>


        </div>
        <div id="t1">
            <p><?php echo $deal['dealname'];?></p>
        </div>
        <div id="abouttitle">
            Hot Deal
        </div>
        <div id="about">
        </div>

        <div id="bottom">
            <div id="box1">
                <li><a href="link.html" target="_self">News</a></li><br/>
                <li><a href="link.html" target="_self">About AGB</a></li><br/>
                <li><a href="link.html" target="_self">Forum</a></li><br/>
                <li><a href="link.html" target="_self">Blog</a></li><br/>
                <br/>
                <br/>
                <b>AGB. All Rights Reserved</b>
            </div>
            <div id="box2">
                <li><a href="link.html" target="_self">FAQ</a></li><br/>
                <li><a href="link.html" target="_self">Customer Support</a></li><br/>
                <li><a href="link.html" target="_self">Return Policy</a></li><br/>
                <li><a href="link.html" target="_self">Terms of Use</a></li><br/>
            </div>
            <div id="box3">
                <li><a href="link.html" target="_self">More...</a></li><br/>
                <li><a href="link.html" target="_self">Gift Cards</a></li><br/>
                <li><a href="link.html" target="_self">Mobile</a></li><br/>
                <li><a href="link.html" target="_self">Live off AGD</a></li><br/>
                <br/>
                <br/>
                <b>2012</b>
            </div>
            <div id="box4">
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <br/>
                <li><a href="link.html" target="_self"><b>Facebook</b></a></li><br/>
            </div>
        </div>

    </div>


</html>