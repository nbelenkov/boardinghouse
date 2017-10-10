<?php
include_once 'connection.php';
include_once 'functions.php';
include("auth.php");

$user_id = $_SESSION["user_id"];
$sqlstmt = "SELECT Name, Surname, Year, Overseas FROM student WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
$data = mysqli_fetch_array($result);
if ($data["Name"] != null){
  $_SESSION ["Name"] = $data["Name"];
  $_SESSION ["Surname"] = $data["Surname"];
  $_SESSION ["Year"] = $data["Year"];
  $_SESSION ["Overseas"] = $data["Overseas"];
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
            <li><a href="student.php">Dashboard</a></li>
            <li><a href="#">Settings</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <h1 class="page-header">Welcome <?php echo $_SESSION["Name"]; ?></h1>
    </div>

    <div class="col-xs-6 col-sm-3 placeholder">
      <h3><a href="inandout.php">Sign In and Out</a></h3>
      <span class="text-muted">Sign out to leave the house and then Sign back in. </span>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
      <h3><a href="weekend.php">Request Permission from Hsm</a></h3>
      <span class="text-muted">Request permission to miss meals and leave the house</span>
    </div>
    <?php
    if ($_SESSION["Overseas"] == "1"){
      echo "
      <div class='col-xs-6 col-sm-3 placeholder'>
      <h3><a href='leaveout.php'>Complete Your Exeat Leave Out form</a></h3>
      <span class='text-muted'>You can complete your exeat leave out form here</span>
      </div>";
    }
    ?>
