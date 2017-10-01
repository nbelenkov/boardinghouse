<?php
include_once 'connection.php';
session_start();
if (isset($_POST["email"])){
  $email = stripslashes($_REQUEST["email"]);  
  $email = mysqli_real_escape_string($conn,$email);    
  $password = stripslashes($_REQUEST['password']);
  $password = mysqli_real_escape_string($conn,$password);  
  $sqlstmt = "SELECT user_id, password, username, staffcheck, email FROM members WHERE email = '$email'";
  $result = mysqli_query($conn, $sqlstmt) or die(mysqli_error($conn));
  $data = mysqli_fetch_array($result);
  if ($data["email"] == $email){
      if ($data["password"] == md5($password)){
          $_SESSION["user_id"] = $data["user_id"];        
          $_SESSION["username"] = $data["username"];
          $_SESSION["staffcheck"] = $data["staffcheck"];
          if ($data["staffcheck"] == 1){
            header("Location: staff.php");
          }else{
              header("Location: student.php");
          }
      }else{
          echo ("Incorrect password");
      }
  }else{
      echo ("Email is not registered");
  }
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">
    <title>Oundle Boarding House</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="CustomStyles.css" rel="stylesheet">
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="span4"></div>
        <div class="span4"><img class="center-block img-responsive" src="./oundle logo transparent.png" alt="Oundle" height="178" width="185" /></div>
        <div class="span4"></div>
      <form class="form-signin" method="post" action="" name ="login">
        <div class="form-group">
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" name = "email" class="form-control" placeholder="Email address" required autofocus>
          <span class="help-block"></span>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <span class="help-block"></span>
        </div>

        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div> 
  </body>
</html>
