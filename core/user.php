<?php 
    /**
     * Checks if a given username exists 
     * PARAMETERS:
     *    $username: (string) The username to check 
     * RETURNS:
     *    (boolean) Whether the username exists
     */
    function username_exists($username) {
        $SQL = "SELECT * FROM user WHERE username='$1';";
        $results = execute_sql($SQL, array($username));
        return (bool)$results->num_rows;
    }

    /**
     * Gets a specific attribute for a user. 
     * PARAMETERS:
     *    $attr    : (string) The database column to retrieve
     *    $username: (string) The username to get the field for. 
     * RETURNS:
     *    (mixed) The field, or false if none was found. 
     */
    function get_attribute_for_user($attr, $username) {
        $SQL = "SELECT $1 FROM user WHERE username='$2';";
        $results = execute_sql($SQL, array($attr, $username));
        $attribute = $results->fetch_assoc();
        if(isset($attribute[$attr])) {
            return $attribute[$attr];
        }
        return false;
    }


    /**
     * Checks if a given email exists for all users
     * PARAMETERS:
     *    $email: (string) The email to check 
     * RETURNS:
     *    (boolean) Whether the email exists
     */
    function email_exists($email) {
        $SQL = "SELECT * FROM user WHERE email='$1';";
        $results = execute_sql($SQL, array($email));
        return (bool)$results->num_rows;
    }

    /**
     * Returns the hashed and salted password from the database 
     * PARAMETERS:
     *    $username: (string) The user to retrieve the pass for 
     * RETURNS:
     *    (string) The password hash 
     */
    function get_pass_for_user($username) {
        $SQL = "SELECT password FROM user WHERE username='$1';";
        $results = execute_sql($SQL, array($username));
        if($results->num_rows) {
            $pass = $results->fetch_assoc();
            return $pass['password'];
        } else {
            return false;
        }
    }

    /**
     * Hashes and salts a password (using sha1).
     * PARAMETERS:
     *    $password: (string) The string to salt and hash. 
     * RETURNS:
     *    (string) The hashed/salted password. 
     */
    function hash_pass($password) {
        global $salt;
        return sha1($salt.$password);
    }


    /**
     * Checks if a password matches the stored password for a user. 
     * PARAMETERS:
     *    $username: (string) The user to check the password for. 
     *    $password: (string) The password to check against. 
     * RETURNS:
     *    (boolean) Whether the password is correct for that user. 
     */
    function passes_match($username, $pass) {
        if($db_pass = get_pass_for_user($username)) {
            $user_pass = hash_pass($pass);
            if($db_pass == $user_pass) {
                return true;
            }
        }
        return false;
    }
        
    /**
     * Attempts to create a user account. 
     * PARAMETERS:
     *    $username: (string) The new username. 
     *    $email   : (string) The new email.  
     *    $password: (string) The new password. 
     * RETURNS:
     *    (array) The status of the account and a success/fail message. 
     */
    function create_user($username, $email, $password) {
        if(email_exists($email)) {
            return array('status' => false, 'message' => 'Email already exists');
        } elseif(username_exists($username)) {
            return array('status' => false, 'message' => 'Username already exists');
        } else {
            $pass_hash = hash_pass($password);
            $SQL = "INSERT INTO user (`username`, `password`, `email`) VALUES ('$1', '$2', '$3')";
            $results = execute_sql($SQL, array($username, $pass_hash, $email));
            return array('status' => $results, 'message' => $results ? 'Successfully create user.' : 'Could not create user.');
        }

    }

    /**
     * Attempts to log a user in with POST variables 'username' and 'password' 
     * PARAMETERS:
     * RETURNS:
     *    (array) Array containing the status of login and message. 
     */
    function do_login() {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            if(!isset($_POST['un_hp']) || !$_POST['un_hp']) {
                if(login($_POST['username'], $_POST['password'])) {
                    $status = true;
                    $message = 'Successfully logged in.';
                } else {
                    $status = false;
                    $message = 'Incorrect username or password.';
                }
            } else {
                $status = false;
                $message = 'Nice try, bot.';
            }
            return array('status' => $status, 'message' => $message);
        } 
        return false;
    }

    function do_signup() {
        $logged_in = false;
        if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
            if(!isset($_POST['un_hp']) || !$_POST['un_hp']) {
               $results = create_user($_POST['username'], $_POST['email'], $_POST['password']);
                $status = (bool)$results['status'];
                $message = $results['message'];
                if($status) {
                    $_SESSION['un'] = $_POST['username'];
                    $logged_in = 'true';
                } 
            } else {
                $status = false;
                $message = 'Nice try, bot.';
            }
            return array('status' => $status, 'message' => $message, 'logged_in' => $logged_in);
        }
        return false;
    }
                

    /**
     * Attempts to log a user in with a given password 
     * PARAMETERS:
     *    $username: (string) The username to log in. 
     *    $password: (string) The user's password. 
     * RETURNS:
     *    (boolean) If the login succeeded.
     */
    function login($username, $pass) {
        if(passes_match($username, $pass)) {
            $_SESSION['un'] = $username;
            return true;
        }
        return false;
    }

    /**
     * Logs a user out 
     * PARAMETERS:
     * RETURNS:
     */
    function logout() {
        unset($_SESSION['un']);
        session_destroy();
    }

    /**
     * Checks if a user is logged in  
     * PARAMETERS:
     * RETURNS:
     *    (boolean) Whether or not they are logged in.  
     */
    function is_logged_in() {
        if(isset($_SESSION['un'])) {
            return true;
        }
        return false;
    }

    function auth_redirect() {
        if(!is_logged_in()) {
            header('Location: ' . '/');
        }
    }

    function get_user() {
        if(is_logged_in()) {
            $username = $_SESSION['un'];
            $attr = get_attribute_for_user('id', $username);
            return $attr;
        }
        return false;
    }
?>
