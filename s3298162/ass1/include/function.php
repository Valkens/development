<?php
function connectDb()
{
    try {
        $conn = new PDO('mysql:host=localhost;dbname=s3298162','s3298162','qwerty1234',
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return $conn;
}