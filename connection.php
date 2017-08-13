<?php

include_once 'config.php';

$conn = mysqli_connect(HOST, USER, PASWWORD);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";
?>