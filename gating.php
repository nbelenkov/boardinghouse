<?php
include_once 'connection.php';
include_once 'functions.php';
include("auth.php");

if (isset($_POST["length"])){
    $length = stripslashes($_REQUEST["length"]);  
    $length = mysqli_real_escape_string($conn,$length);
    $reason = stripslashes($_REQUEST["reason"]);  
    $reason = mysqli_real_escape_string($conn,$reason);
    $user_id = $_REQUEST["student"];
    $date = date("Y-m-d");
    $sqlstmt = "INSERT INTO events (user_id, Date, Even_Type) VALUES ('$user_id','$date', 'Gated')";
    $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
    if ($length > 1){
        
    }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Boarding House Administration</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="dashboard.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Boarding House Administration</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="staff.php">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div>
    <h1 class="page-header">Welcome to gating page</h1>

        <form action="" method="post">
        <br> Choose student to gate<br>
        <select name="student">
        <?php
            $sqlstmt = "SELECT user_id, Name FROM student";
            $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
            while($row = mysqli_fetch_array($result)){
                $user = $row["user_id"];
                $name = $row["Name"];
                echo "<option value=" . $user . ">". $name ."</option>";
            }
        ?> 
        </select>
        <br>
        <br>
        Length of gating(days):<br>
        <input type="text" name="length" required>
        <br>
        Reason:<br>
        <input type="test" name="reason" required><br>
        <br>
        <button class="btn" type="submit" >Add to list</button>

        </form>
    </div>