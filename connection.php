<?php

include_once 'config.php';

$mysqli = mysqli_connect(HOST, USER, PASSWORD);

if (!$mysqli) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>