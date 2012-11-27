<?php
function dbConnect($host, $username, $password, $dbname)
{
    try {
        $conn = new PDO('mysql:host='.$host.';dbname='.$dbname,$username,$password,
                        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    return $conn;
}