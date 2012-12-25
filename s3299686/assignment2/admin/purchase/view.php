<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');

$stmt = $pdo->prepare('SELECT * FROM purchase WHERE id = :id');
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
                    <?php if (isset($purchase)) echo $purchase['totalcharge'];?>$
                </div>
            </div>

            <div class="control-group">
                <label>Card holder</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['creholder']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Card number</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['cardnumber']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Expired dater</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['expiredate']);?>
                </div>
            </div>

            <div class="control-group">
                <label>Secured code</label>
                <div class="controls">
                    <?php if (isset($purchase)) echo htmlspecialchars($purchase['securedcode']);?>
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
