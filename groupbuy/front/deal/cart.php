<?php
if (!isset($_SESSION['customer'])) {
    header('location: ./');
    exit();
}

$stmt = $conn->prepare('SELECT * FROM deals WHERE id=:id');
$stmt->execute(array('id' => $_GET['did']));
$deal = $stmt->fetch(PDO::FETCH_ASSOC);

// Cart info
$deal_id = $_GET['did'];
if ($_POST) {
    $_SESSION['cart'][$deal_id] = array(
        'quantity' => (int) $_POST['quantity'],
        'card_holder' => $_POST['card_holder'],
        'card_number' => $_POST['card_number'],
        'expired_date' => $_POST['expired_date'],
        'secured_code' => $_POST['secured_code'],
        'total_charge' => (int) $_POST['quantity'] * $deal['group_buy_price']
    );

    if (isset($_POST['checkout'])) {
        $stmt = $conn->prepare('INSERT INTO transactions(id_customer,id_deal,quantity,total_charge,card_holder,card_number,
                                                     expired_date,secured_code,timestamp)
                                           VALUES(:id_customer,:id_deal,:quantity,:total_charge,:card_holder,
                                                  :card_number,:expired_date,:secured_code,NOW())');
        $cart = $_SESSION['cart'][$deal_id];

        $stmt->execute(array(
            'id_customer' => $_SESSION['customer']['id'],
            'id_deal' => $deal_id,
            'quantity' => $cart['quantity'],
            'total_charge' => $cart['total_charge'],
            'card_holder' => $cart['card_holder'],
            'card_number' => $cart['card_number'],
            'expired_date' => $cart['expired_date'],
            'secured_code' => $cart['secured_code']
        ));

        if ($stmt->rowCount()) {
            $_SESSION['cart'] = null;
            header('location: ./?m=deal&a=checkout');
            exit();
        }
    }
} else {
    if (!isset($_SESSION['cart'][$deal_id])) {
        $_SESSION['cart'][$deal_id] = array(
            'quantity' => 1,
            'card_holder' => '',
            'card_number' => '',
            'expired_date' => '',
            'secured_code' => '',
            'total_charge' => 0
        );
    }
}

$cart = $_SESSION['cart'][$deal_id];
?>
<div id="contents">
    <div id="main">
        <form id="cart-form" action="" method="post">
            <p>
                <label>Deal</label>
                <span><?php echo $deal['name'];?></span>
            </p>
            <p>
                <label>Quantity</label>
                <select id="quantity" name="quantity">
                    <?php for ($i = 1;$i <= 10;$i++) {
                        $selected = ($cart['quantity'] == $i) ? ' selected="selected"' : '';
                        echo "<option value='{$i}'$selected>{$i}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label>Total</label>
                <span id="total_charge"></span>
            </p>
            <fieldset>
                <legend>Payment information</legend>
                <p>
                    <label>(*) Credit card holder</label>
                    <input type="text" maxlength="100" id="card_holder" name="card_holder" value="<?php echo $cart['card_holder'];?>" />
                </p>
                <p>
                    <label>(*) Card number</label>
                    <input type="text" maxlength="30" id="card_number" name="card_number" value="<?php echo $cart['card_number'];?>" />
                </p>
                <p>
                    <label>(*) Expired date</label>
                    <input type="text" maxlength="5" id="expired_date" name="expired_date" value="<?php echo $cart['expired_date'];?>" />
                    (month/year - Ex: 03/16)
                </p>
                <p>
                    <label>(*) Secured code</label>
                    <input type="text" maxlength="4" id="secured_code" name="secured_code" value="<?php echo $cart['secured_code'];?>" />
                </p>
            </fieldset>
            <br class="clear" />
            <p>
                <label>&nbsp;</label>
                <input type="submit" name="update" value="Update" />
                <input type="submit" name="checkout" value="Checkout" />
            </p>
        </form>
        <br class="clear" />
    </div>
</div>

<script type="text/javascript">
    $(function(){
        var deal_price = <?php echo $deal['group_buy_price'];?>;
        $('#total_charge').html((deal_price * $('#quantity').val()) + '$');
        $('#quantity').change(function(){
            $('#total_charge').html((deal_price * $('#quantity').val()) + '$');
        });

        // Form submit
        $('#cart-form').submit(function(){
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