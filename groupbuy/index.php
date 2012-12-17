<?php
session_start();

include 'libs/config.php';
include 'libs/db.php';

$conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Get all categories
$stmt = $conn->prepare('SELECT * FROM categories');
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();

$categories = $stmt->fetchAll();
?>
<?php include 'front/template/header.php';?>
<?php
$module = (isset($_GET['m']) && $_GET['m'] != '') ? $_GET['m'] : 'home';
$action = (isset($_GET['a']) && $_GET['a'] != '') ? $_GET['a'] : 'index';

if (file_exists('front/' . $module)) {
    include 'front/' . $module . '/' . $action . '.php';
} else {
    include 'front/error/404.php';
}
?>
<?php include 'front/template/footer.php';?>