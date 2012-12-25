<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');

$stmt = $pdo->prepare('SELECT img FROM deal WHERE dealid = :id');
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute(array('id' => $_GET['id']));
$deal = $stmt->fetch();

$stmt = $pdo->prepare('DELETE FROM deal WHERE dealid = :id');
$stmt->execute(array('id' => $_GET['id']));

if (file_exists('../../' . $deal['img'])) {
    unlink('../../' . $deal['img']);
}

header('location: ./');
edit();