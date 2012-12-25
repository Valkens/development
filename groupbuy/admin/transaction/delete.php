<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../user/login.php');
    exit();
}

include('../../libs/config.php');
include('../../libs/db.php');

$conn = dbConnect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
$stmt = $conn->prepare('DELETE FROM transactions WHERE id = :id');
$stmt->execute(array('id' => $_GET['id']));

header('location: ./');
edit();