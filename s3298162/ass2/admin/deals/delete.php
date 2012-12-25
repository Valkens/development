<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../../login.php');
    exit();
}

include('../../include/function.php');
include('../header.php');

$db = connectDb();

$stmt = $db->prepare('SELECT image FROM deals WHERE id=:id');
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute(array('id' => $_GET['id']));
$deal = $stmt->fetch();

$stmt = $db->prepare('DELETE FROM deals WHERE id = :id');
$stmt->execute(array('id' => $_GET['id']));

if (file_exists('../../' . $deal['image'])) {
    unlink('../../' . $deal['image']);
}


header('location: ./');
edit();