<?php
include_once 'connection.php';
include_once 'functions.php';
session_start();

if (isset($_POST["submit"])){  
  $sqlstmt = "INSERT INTO events (user_id, Date, Even_Type, Breakfast_Miss, Lunch_Miss, Supper_Miss, Overnight, Status) VALUES ('". $_SESSION['user_id'] ."', '". $_REQUEST['date'] ."', '". $_REQUEST['Even_Type'] ."', '". $_REQUEST["breakfast"] . "','". $_REQUEST['lunch'] ."','". $_REQUEST['supper'] ."', '". $_REQUEST['Overnight'] ."', 'Pending')";
  $results = mysqli_query($conn, $sqlstmt) or die (mysqli_error($conn));
  echo "<script type='text/javascript'>alert('Submitted Successfully')</script>";
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
      <h1 class="page-header">Welcome <?php echo $_SESSION["Name"]; ?></h1>
      <div class="row">
      <form action = "" class="form-horizontal" method="post">
        <p>When do you need to leave?</p>
        <input type="date" name="date">
        <p>Are you leaving Overnight?</p>
        <input type="radio" name="Overnight" value="Yes"> Yes<br>
        <input type="radio" name="Overnight" value="No" checked> No<br>
        <p>Why are you leaving?</p>
        <br>
            <select name="Even_Type">
                <option value="Match">Match</option>
                <option value="MealwithParents">Meal with Parents</option>
                <option value="MissingMeal">Missing a meal for other reason</option>
                <option value="Other">Other</option>
            </select>
        <p>What meals are you missing?</p>
        <input type="hidden" name="breakfast" value="No"><br>
        <input type="checkbox" name="breakfast" value="Yes"> Breakfast<br>
        <input type="hidden" name="lunch" value="No"><br>
        <input type="checkbox" name="lunch" value="Yes" checked> Lunch<br>
        <input type="hidden" name="supper" value="No"><br>
        <input type="checkbox" name="supper" value="Yes"> Supper<br>
        <button class='btn' type='submit'>Submit</button>
      </form> 
      <hr>
      <p> Already submitted requests and their status</p>
      <?php
        $sqlstmt = "SELECT Date, Even_Type, status FROM events WHERE user_id = " . $_SESSION["user_id"] . " ORDER BY event_id DESC ";
        $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
        echo "<table class = table table-striped>";
        while($row = mysqli_fetch_array($result)){
          //echo "<script type='text/javascript'>alert(". $row["Even_Type"] .")</script>";
          echo "<tr>";
          echo "<td>" . $row["Date"] . "</td>";   
          echo "<td>" . $row["Even_Type"] . "</td>";  
          echo "<td>" . $row["status"] . "</td>";       
          echo "</tr>";
        }
        echo "</table>";

      ?>
      </div>
    </div>