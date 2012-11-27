<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../template/header.php');
?>

<div id="content">
    dsadsa
</div>

<?php include('../template/footer.php'); ?>
