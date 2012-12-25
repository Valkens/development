<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');

$db = connectDb();

$stmt = $db->prepare('DELETE FROM questions WHERE id = :id');
$stmt->execute(array('id' => $_GET['id']));

header('location: ./');
edit();