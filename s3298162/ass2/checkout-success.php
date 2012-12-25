<?php
session_start();
include 'include/function.php';
$db = connectDb();

?>
<?php include 'public/header.php';?>

<div id="main">
    <div id="sidebar" class="float_l">
        <?php include 'public/categories.php';?>
    </div>
    <div id="content" class="float_r">
        <h4 style="color:#009900">Your purchase is success</h4>
    </div>
    <div class="cleaner"></div>
</div>

<?php include 'public/bottom.php';