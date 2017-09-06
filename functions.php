<?php  

include_once 'connection.php';

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
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $_SESSION["user_id"] = $user_id;
                        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", 
                                                                "", 
                                                                $username);
                        $_SESSION['username'] = $username;
                        $_SESSION['login_string'] = hash('sha512', 
                              $db_password . $user_browser);
                        return true;   
                    } else {
                        $now = time();
                        $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                        return false;
                    }
                }
            } else {
                return false;
            }
        }

}

function checkbrute($user_id, $mysqli) {
    $now = time();
    $valid_attempts = $now - (2*60*60);

    if ($stmt = $mysqli->prepare("SELECT time FROM login_attempts WHERE user_id = ? AND time > '$valid_attempts'")) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }

}

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) { 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ($stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 
                if (hash_equals($login_check, $login_string) ){
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {   
            return false;
        }
    } else {
        return false;
    }
}
?>

