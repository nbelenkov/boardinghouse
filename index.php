<?php
#include_once "connection.php";
include_once "functions.php";

$email = $password = "";
$email_err = $password_err = "";

if  ($_SERVER["REQUEST_METHOD"] == "POST"){

    $sqlstmt = "SELECT SchoolID, username, password, name, staffcheck FROM DATABASE WHERE email = ?";

    if ($stmt = mysqli_prepare($mysqli, $sqlstmt)){
        mysqli_stmt_bind_param($stmt, "s", $param_email);
        $param_email = $email;
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            echo("first");
            if(mysqli_stmt_num_rows($stmt) == 1){
              echo("second");

                mysqli_stmt_bind_result($stmt, $schoolID, $username, $hashed_password, $name, $staffcheck);
                if(mysqli_stmt_fetch($stmt)){
                    if(password_verify($password, $hashed_password)){
                        session_start();
                        $_SESSION['username'] = $username; 
                        $_SESSION["SchoolID"] = $schoolID;
                        $_SESSION["name"] = $name;
                        $_SESSION["staffcheck"] = $staffcheck;     
                        if ($staffcheck == "True"){
                            header("staff.php");
                        }else{
                            header("student.php");
                        }
                    }else{
                        $password_err = 'The password you entered was not valid.';
                    }    
                }
            }else{
                $email_err = 'No account found with that email.';
            }
        }else {
            echo "Oops! Something went wrong. Please try again later.";
        }
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
      <form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="email" class="form-control" placeholder="Email address" value="<?php echo $email; ?>" required autofocus>
          <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="password" class="form-control" placeholder="Password" required>
          <span class="help-block"><?php echo $password_err; ?></span>
        </div>

        <div class="checkbox">
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
      </form>
    </div> 
  </body>
</html>
