<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../pdo.php');

$stmt = $pdo->prepare('DELETE FROM category WHERE id = :id');
$stmt->execute(array('id' => $_GET['id']));

header('location: ./');
edit();