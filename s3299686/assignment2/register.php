<?php
include("pdo.php");

$username=$_POST["username"];
$email=$_POST["email"];
$password=md5($_POST["password"]);

$sql ="insert into users(username,email,password) values('$username','$email', '$password')";
$pdo->exec($sql);

echo "<script type='text/javascript'>";
echo "alert('Register successfully');";
echo "window.location ='./'";
echo "</script>";
?>