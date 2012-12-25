<?php
session_start();
include 'include/function.php';
$db = connectDb();

$id = (int) $_GET['id'];
$sql = "SELECT * FROM deals where id=$id";
$result = $db->query($sql);
$deal = $result->fetch();

if ($_POST) {
    $_SESSION['cart'][$id] = array(
        'quantity' => (int) $_POST['quantity'],
        'card_holder' => $_POST['card_holder'],
        'card_number' => $_POST['card_number'],
        'expired_date' => $_POST['expired_date'],
        'secured_code' => $_POST['secured_code'],
        'total_charge' => (int) $_POST['quantity'] * $deal['group_buy_price']
    );

    if (isset($_POST['checkout'])) {
        $stmt = $db->prepare('INSERT INTO purchases(id_user,id_deal,quantity,total_charge,card_holder,card_number,
                                                     expired_date,secured_code,createtime)
                                           VALUES(:id_user,:id_deal,:quantity,:total_charge,:card_holder,
                                                  :card_number,:expired_date,:secured_code,NOW())');
        $cart = $_SESSION['cart'][$id];

        $stmt->execute(array(
            'id_user' => $_SESSION['userid'],
            'id_deal' => $id,
            'quantity' => $cart['quantity'],
            'total_charge' => $cart['total_charge'],
            'card_holder' => $cart['card_holder'],
            'card_number' => $cart['card_number'],
            'expired_date' => $cart['expired_date'],
            'secured_code' => $cart['secured_code']
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

<?php include 'public/header.php';?>

<div id="main">
    <div id="sidebar" class="float_l">
        <?php include 'public/categories.php';?>
    </div>
    <div id="content" class="float_r">
        <h2>Deal "<?php echo $deal['name'];?>"</h2>
        <div class="content_half float_l">
            <div class="error">
                <?php
                if (isset($errors)) {
                    foreach ($errors as $error) {
                        echo "<li>$error</li>";
                    }
                }
                ?>
            </div>
            <div id="form_login">
                <form id="form_buy" method="post" action="#">
                    <label>Quantity (*):</label>
                    <select id="quantity" name="quantity">
                    <?php for ($i = 1;$i <= 10;$i++) {
                        $selected = ($cart['quantity'] == $i) ? ' selected="selected"' : '';
                        echo "<option value='{$i}'$selected>{$i}</option>";
                    }
                    ?>
                    </select>
                    <div class="cleaner h10"></div>

                    <label>Total charge: <span id="total_charge"></span></label>
                    <div class="cleaner h10"></div>

                    <label>Credit card holder (*)</label>
                    <input type="text" maxlength="60" id="card_holder" name="card_holder" value="<?php echo $cart['card_holder'];?>" />
                    <div class="cleaner h10"></div>

                    <label>Card number (*)</label>
                        <input type="text" maxlength="30" id="card_number" name="card_number" value="<?php echo $cart['card_number'];?>" />
                    <div class="cleaner h10"></div>

                    <label>Expired date (*)</label>
                    <input type="text" maxlength="5" id="expired_date" name="expired_date" value="<?php echo $cart['expired_date'];?>" />
                    <div class="cleaner h10"></div>

                    <label>Secured code (*)</label>
                    <input type="text" maxlength="4" id="secured_code" name="secured_code" value="<?php echo $cart['secured_code'];?>" />
                    <div class="cleaner h10"></div>

                    <input type="submit" value="Update" name="update" class="submit_btn float_l" />
                    <input type="submit" value="Checkout" name="checkout" class="submit_btn float_l" />
                </form>
            </div>
        </div>
    </div>
    <div class="cleaner"></div>
</div>

<?php include 'public/bottom.php';?>

<script type="text/javascript">
    $(function(){
        var deal_price = <?php echo $deal['group_buy_price'];?>;
        $('#total_charge').html((deal_price * $('#quantity').val()) + '$');
        $('#quantity').change(function(){
            $('#total_charge').html((deal_price * $('#quantity').val()) + '$');
        });

        $('#form_buy').submit(function(){
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