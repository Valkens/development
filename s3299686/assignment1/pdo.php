<?php
try {
    $pdo = new PDO("mysql: host=localhost; dbname=s3299686", "s3299686", "qwerty1234",
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}