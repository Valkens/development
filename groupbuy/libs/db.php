<?php
function dbConnect($host, $username, $password, $dbname)
{
    try {
        $conn = new PDO('mysql:host='.$host.';dbname='.$dbname,$username,$password,
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return $conn;
}