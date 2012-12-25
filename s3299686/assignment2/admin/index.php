<?php
session_start();
if (!isset($_SESSION['username']) == 'admin') {
    header('location: ../login.php');
} else {
    header('location: dashboard');
}
exit();