<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../../libs/config.php');
include('../../libs/db.php');
include('../template/header.php');

$conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$stmt = $conn->prepare('SELECT * FROM transactions WHERE id = :id');
$stmt->execute(array(
    ':id'   => $_GET['id'],
));
if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $transaction = $result;
}
?>

<div id="main-content" class="pull-left">
    <div class="list-box">
        <h3 class="header">View transaction #<?php echo $_GET['id'];?></h3>
        <form action="" method="POST">
            <div class="control-group">
                <label>Quantity</label>
                <div class="controls">
                    <?php if (isset($transaction)) echo $transaction['quantity'];?>
                </div>
            </div>

            <div class="control-group">
                <label>Toal charge</label>
                <div class="controls">
                    <?php if (isset($transaction)) echo $transaction['total_charge'];?>$
                </div>
            </div>

            <div class="control-group">
                <label>Card holder</label>
                <div class="controls">
                    <?php if (isset($transaction)) echo htmlspecialchars($transaction['card_holder']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Card number</label>
                <div class="controls">
                    <?php if (isset($transaction)) echo htmlspecialchars($transaction['card_number']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Expired dater</label>
                <div class="controls">
                    <?php if (isset($transaction)) echo htmlspecialchars($transaction['expired_date']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Secured code</label>
                <div class="controls">
                    <?php if (isset($transaction)) echo htmlspecialchars($transaction['secured_code']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Date time</label>
                <div class="controls">
                    <?php if (isset($transaction)) echo date('d/m/Y h:i:s', strtotime($transaction['timestamp']));?>
                </div>
            </div>

            <div class="form-actions">
                <a href="./">Back</a>
            </div>
        </form>
    </div>
    <br class="clear" />
</div>

<?php include('../template/footer.php'); ?>
