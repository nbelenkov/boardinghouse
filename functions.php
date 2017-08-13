<<?php  

include_once 'connecting.php';

function sec_session_start() { //creates a secure session, which will be called at the top of every page
    $session_name = "sec_session_id";
    $secure = SECURE;

    $httponly = true;

    if (ini_set("session.use_only_cookies", 1) == FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    $cookieParams = session_get_cookie_params():
    session_set_cookie_params($cookieParams["Lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

    session_name($session_name);
    session_start();
    session_regenerate_id();

}

function login($email, $password, $mysql) {
    if ($stmt = $myqsl->prepare("SELECT SchoolID, username, password
        FROM members
        WHERE email = ?
        LIMIT 1")) {
            $stmt ->bind_param("s", $email);
            $stmt ->execute();
            $stmt ->store_result();

            $stmt ->bind_result($user_id, $username, $db_password);
            $stmt->fetch();

            if ($stmt->num_rows == 1) {
                if (checkbrute($user_id, $mysqli) == TRUE) {
                    return false;
                } else {
                    if (password_verify($password, $db_password)) {
                        $user_browser = $_SERVER["HTTP_USER_AGENT"];
                        $user_id = preg_replace(/"[^0-9]+/", "", $user_id);
                        $_SESSION["user_id"] = $user_id;
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                        
                    }
                }
            }
        }

}


?>>

