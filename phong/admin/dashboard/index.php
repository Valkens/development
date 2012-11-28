<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../template/header.php');
?>

<div id="main-content" class="pull-left">
    <h3>Welcome to Dashboard.</h3>
    <br class="clear" />
</div>

<?php include('../template/footer.php'); ?>
