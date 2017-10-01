<?php
include_once 'connection.php';
include("auth.php");

$maxinactive = 10;

// check to see if $_SESSION["timeout"] is set
//if (isset($_SESSION["timeout"])) {
 //   $timeactive = time() - $_SESSION["timeout"];
//    if ($timeactive > $maxinactive) {
 //       session_destroy();
 //       header("Location: logout.php");
 //   }
//}
$_SESSION["timeout"] = time();


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard Template for Bootstrap</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
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

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <h3>Events for Today</h3>
          
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Welcome, <?php echo $_SESSION['username']; ?></h1>

          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <h3><a href="meals.php">Meal Registration</a></h3>
              <span class="text-muted">See, which students will be missing meals and send notification to missing students.</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <h3><a href="weekend.php">Weekend Absenties</a></h3>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <h3><a href="gating.php">Gated list</a></h3>
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </div>

          <h2 class="sub-header">Student list</h2>
          <div class="table-responsive">
            <?php
              $sqlstmt = "SELECT * FROM student";
              $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
              echo "<table class = table table-striped>";
              echo  "<tr>
              <th>SchoolID<th>
              <th>Name</th>
              <th>Year</th>
              <th>Gated</th>
              <th>Overseas</th>
              </tr>";
              while($row = mysqli_fetch_array($result)){
                $user_id = $row["user_id"];  
                $sqlstmt = "SELECT event_id, In_Out FROM signlist WHERE user_id = '$user_id' ORDER BY event_id DESC LIMIT 1";
                $results = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
                $data = mysqli_fetch_array($results);
                $in = $data["In_Out"];
                if ($in == "Out"){
                  $out = "bgcolor = 'red'";
                }else{
                  $out = "";
                }                              
                echo "<tr>";
                echo "<td ' . $out . '>" . $user_id . "</td>";
                echo "<td ' . $out . '>" . $row['Name'] . "</td>";
                echo "<td ' . $out . '>" . $row['Surname'] . "</td>";                
                echo "<td ' . $out . '>" . $row['Year'] . "</td>";
                echo "<td ' . $out . '>" . $row['Gated'] . "</td>";
                echo "<td ' . $out . '>" . $row['Overseas'] . "</td>";
                echo "</tr>";
              }
              
              echo "/<table>";
            ?>
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
