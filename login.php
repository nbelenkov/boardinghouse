<?php

include_once "connection.php";
include_once "functions.php";


if  ($_SERVER["REQUEST_METHOD"] == "POST"){

    $$sqlstmt = "SELECT SchoolID, username, password, name, staffcheck FROM DATABASE WHERE email = ?";

    if ($stmt = mysqli_prepare($mysqli, $sql)){
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        if(mysqli_stmt_execute($stmt)){
            mysqli_stmt_store_result($stmt);
            if(mysqli_stmt_num_rows($stmt) == 1){
                mysqli_stmt_bind_result($stmt, $username, $hashed_password, $schoolID, $name, $staffcheck);
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
                $username_err = 'No account found with that username.';
            }
        }else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    mysqli_stmt_close($stmt);
}

?>