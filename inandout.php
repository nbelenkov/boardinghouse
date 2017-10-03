<?php
include_once 'connection.php';
include_once 'functions.php';
include("auth.php");
if (isset($_POST["destination"])){
  $InorOut = $_REQUEST["InorOut"];
  $destination = $_REQUEST["destination"];
  $user_id = $_SESSION["user_id"];
  $date = date("Y-m-d H:i:s");
  $dateD = date("Y-m-d");
  $sqlstmt = "SELECT * FROM events WHERE Date = '$dateD' and Even_Type = 'Gated' and user_id = '$user_id'";
  $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
  if (mysqli_num_rows($result) == 0){
    $sqlstmt = "SELECT event_id, In_Out, destination FROM signlist WHERE user_id = '$user_id' ORDER BY event_id DESC LIMIT 1";
    $results = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
    $data = mysqli_fetch_array($results);
    if ((($InorOut == "In") && ($data["In_Out"] == "Out")) || (($InorOut == "Out") && ($data["In_Out"] == "In")) || (($InorOut == "Out") && ($data["In_Out"] == ""))){
      if (($data["destination"] != $destination) && ($data["In_Out"] == "Out")){
        echo "You singed out to go to a different place. Please check";
      }else{
        $sqlstmt = "INSERT INTO signlist (user_id, In_Out, destination, dates) VALUES ('$user_id','$InorOut', '$destination', '$date')";
        $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
      }
    }else{
      echo "Have you remebered to sing back in?";
    }
  }else{
    echo "You are gated, you cant sign out";
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
          <a class="navbar-brand" href="student.php">Boarding House Administration</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="student.php">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <h1 class="page-header">Welcome</h1>
    </div>
    <div class="form-group">
        <form action = "" class="form-horizontal" method="post">
        <input type="radio" name="InorOut" value="Out" checked> Signing Out<br>
        <input type="radio" name="InorOut" value="In"> Singing In<br>
        <br>Where are you going to/returning from:<br>
        <br>
            <select name="destination">
                <option value="Town">Town</option>
                <option value="Gym">Gym</option>
                <option value="Stahl">Stahl</option>
                <option value="Talk">Talk</option>
                <option value="Vols">Vols/Comps</option>
            </select>
            <button class="btn" type="submit">Submit</button>
        </form>
        <?php
          $date = date()
          if (
        
        
        
        ?>


    </div>