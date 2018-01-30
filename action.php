<?php
    include_once "connection.php";
    include("auth.php");
    $id =  $_GET["status"];
    $sqlstmt = "UPDATE events SET Status='$id' WHERE event_id = " .$_GET["id"] . "";
    $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
    echo "Successful";
    header("location: staff.php");

?>
