<?php
session_start();
include ("pdo.php");
$id = (int) $_GET['id'];
$sql = "SELECT * FROM deal where dealid=$id";
$result = $pdo->query($sql);
$deal = $result->fetch();

if (isset($_POST['checkout']) || isset($_POST['update'])) {

    $_SESSION['cart'][$id] = array(
        'quantity' => (int) $_POST['quantity'],
        'card_holder' => $_POST['card_holder'],
        'card_number' => $_POST['card_number'],
        'expired_date' => $_POST['expired_date'],
        'secured_code' => $_POST['secured_code'],
        'total_charge' => (int) $_POST['quantity'] * $deal['price']
    );

    if (isset($_POST['checkout'])) {
        $stmt = $pdo->prepare('INSERT INTO purchase(userid,dealid,quantity,totalcharge,creholder,cardnumber,
                                                         expiredate,securedcode,createtime)
                                               VALUES(:userid,:dealid,:quantity,:totalcharge,:creholder,
                                                      :cardnumber,:expiredate,:securedcode,NOW())');
        $cart = $_SESSION['cart'][$id];

        $stmt->execute(array(
            'userid' => $_SESSION['userid'],
            'dealid' => $id,
            'quantity' => $cart['quantity'],
            'totalcharge' => $cart['total_charge'],
            'creholder' => $cart['card_holder'],
            'cardnumber' => $cart['card_number'],
            'expiredate' => $cart['expired_date'],
            'securedcode' => $cart['secured_code']
        ));

        if ($stmt->rowCount()) {
            $_SESSION['cart'] = null;
            header('location: ./checkout-success.php');
            exit();
        }
    }
} else {
    if (!isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id] = array(
            'quantity' => 1,
            'card_holder' => '',
            'card_number' => '',
            'expired_date' => '',
            'secured_code' => '',
            'total_charge' => 0
        );
    }
}

$cart = $_SESSION['cart'][$id];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $deal['dealname'];?></title>
    <link rel="stylesheet" href="./css/style3.css" type="text/css" />
    <script src="js/jquery-1.2.6.pack.js" type="text/javascript"></script>
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
                        echo '<a href="./changepass.php?id= ' . $_SESSION['userid'] . '">Change password</a><br />';
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
                <form id="frmcart" action="" method="post">
                <table>
                    <tr>
                        <th>Deal name</th>
                        <td><?php echo $deal['dealname'];?></td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>
                            <select id="quantity" name="quantity">
                            <?php for ($i = 1;$i <= 10;$i++) {
                                $selected = ($cart['quantity'] == $i) ? ' selected="selected"' : '';
                                echo "<option value='{$i}'$selected>{$i}</option>";
                            }
                            ?>
                        </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Total charge</th>
                        <td id="total_charge"></td>
                    </tr>

                    <tr>
                        <th>Credit card holder (*)</th>
                        <td>  <input type="text" maxlength="60" id="card_holder" name="card_holder" value="<?php echo $cart['card_holder'];?>" /></td>
                    </tr>

                    <tr>
                        <th>Card number (*)</th>
                        <td><input type="text" maxlength="30" id="card_number" name="card_number" value="<?php echo $cart['card_number'];?>" /></td>
                    </tr>

                    <tr>
                        <th>Expired date (*)</th>
                        <td><input type="text" maxlength="5" id="expired_date" name="expired_date" value="<?php echo $cart['expired_date'];?>" /></td>
                    </tr>


                    <tr>
                        <th>Secured code (*)</th>
                        <td><input type="text" maxlength="4" id="secured_code" name="secured_code" value="<?php echo $cart['secured_code'];?>" /></td>
                    </tr>

                    <tr>
                        <th>&nbsp;</th>
                        <td>
                            <input type="submit" name="update" value="Update" />
                            <input type="submit" name="checkout" value="Checkout" />
                        </td>
                    </tr>
                </table>
                </form>
            </div>
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

    <script type="text/javascript">
        $(function(){
            var deal_price = <?php echo $deal['price'];?>;
            $('#total_charge').html((deal_price * $('#quantity').val()) + '$');
            $('#quantity').change(function(){
                $('#total_charge').html((deal_price * $('#quantity').val()) + '$');
            });

            // Form submit
            $('#frmcart').submit(function(){
                if ($.trim($('#card_holder').val()) == ''
                        || $.trim($('#card_number').val()) == ''
                        || $.trim($('#expired_date').val()) == ''
                        || $.trim($('#secured_code').val()) == ''
                        ) {
                    alert('Please complete all of the required fields');
                    return false;
                }
            });
        });
    </script>
</html>