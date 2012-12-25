<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');
include('../header.php');

$db = connectDb();
$stmt = $db->prepare('SELECT * FROM purchases WHERE id = :id');
$stmt->execute(array(
    ':id'   => $_GET['id'],
));
if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $purchase = $result;
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">View purchase #<?php echo $_GET['id'];?></h3>
        <form action="" method="POST">
            <div class="control-group">
                <label>Quantity</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo $purchase['quantity'];?>
                </div>
            </div>

            <div class="control-group">
                <label>Toal charge</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo $purchase['total_charge'];?>$
                </div>
            </div>

            <div class="control-group">
                <label>Card holder</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['card_holder']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Card number</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['card_number']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Expired dater</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['expired_date']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Secured code</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['secured_code']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Date time</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo date('d/m/Y h:i:s', strtotime($purchase['createtime']));?>
                </div>
            </div>

            <div class="form-actions">
                <a href="./">Back</a>
            </div>
        </form>
    </div>
    <br class="clear" />
</div>

<?php include('../footer.php'); ?>
