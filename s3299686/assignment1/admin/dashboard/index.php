<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../../login.php');
    exit();
}

include('../header.php');
?>

<div id="main-content" class="pull-left">
    <h3>Dashboard</h3>
    <br class="clear" />
</div>

<?php include('../footer.php'); ?>
