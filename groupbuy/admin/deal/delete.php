<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../../libs/config.php');
include('../../libs/db.php');

// Delete deal
$conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$stmt = $conn->prepare('DELETE FROM deals WHERE id = :id');
$stmt->execute(array('id' => $_GET['id']));

// Delete images
$dir = '../../public/images/upload/deals/' . $_GET['id'];

foreach(glob($dir . '/*') as $file) {
    if(is_dir($file))
        rrmdir($file);
    else
        unlink($file);
}
rmdir($dir);

header('location: ./');
edit();