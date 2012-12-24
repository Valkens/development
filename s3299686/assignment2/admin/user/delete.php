<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

include('../../pdo.php');

$stmt = $pdo->prepare('DELETE FROM users WHERE userid = :id');
$stmt->execute(array('id' => $_GET['id']));

header('location: ./');
edit();