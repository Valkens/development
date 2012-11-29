<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: user/login.php');
} else {
    header('location: dashboard');
}
exit();