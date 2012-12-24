<?php
include ("pdo.php");
session_start();

$username = $_POST['username'];
$password = md5($_POST['password']);

// check username and password
$sql = "select * from users where username='$username' and password='$password'";

$result = $pdo->query($sql);
$user = $result->fetch();

if ($user){
$_SESSION['username'] = $user['username'];
$_SESSION['userid'] = $user['userid'];

if ($username == 'admin') {
    header('location:./admin/');
} else {
    header('location:./');
}

} else {

header('location:./?error=1');

}

?>