<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: ../login.php');
    exit();
}

include('../../pdo.php');
include('../header.php');

$stmt = $pdo->prepare('SELECT img FROM deal');
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$deal = $stmt->fetchAll();

$stmt = $pdo->prepare('DELETE FROM deal WHERE dealid = :id');
$stmt->execute(array('id' => $_GET['id']));

if (file_exists('../../pics/' . $deal['img'])) {
    unlink('../../pics/' . $deal['img']);
}

header('location: ./');
edit();