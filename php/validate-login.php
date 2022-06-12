<?php 

    // checks if session exists
    session_start();

    // If already logged in go on to weekly-plan page
    // if not logged in continue to sign up
    if ( isset($_SESSION['session']) ) {
        header("location: ../weekly-plan.php");    
    } 

    // Define variables and initialize with empty values
    $login_name     = "";
    $login_password = "";

    require_once "../../../.php/inc/db.meals.inc.php";        
        
    // Get entered values from POST
    $login_name     = trim($_POST["username"]);
    $login_password = trim($_POST["password"]);        

    // Processing form data when form is submitted using correct button
    if ( ($_SERVER["REQUEST_METHOD"] !== "POST") || (!isset($_POST["login-btn"])) ) {
        header("location: login.php?error=accessdenied");
        exit();
    } else {
        // Check if both username and password are empty
        if ( empty(trim($_POST["username"])) && empty(trim($_POST["password"])) ) {
            header("location: login.php?error=nousernopw");
            exit();
        } 
        // Check if username is empty
        if ( empty(trim($_POST["username"])) ) {
            header("location: login.php?error=nousername");
            exit();
        }         
        // Check if password is empty
        if ( empty(trim($_POST["password"])) ) {
            header("location: login.php?error=nopassword&name=".$login_name);
            exit();
        } 
        
        // Create DB connection
        $conn = mysqli_connect($servername, $username, $password, $db);

        // Check connection, if fails return to login page
        if (!$conn) {
            header("location: login.php?error=dbconnecterror");
            exit();
        } else {
            
            // sql statement to retrieve username
            $sql = "SELECT idx, login_name, login_email, login_password FROM users WHERE login_name = ?";
            
            // prepare the sql statement
            $stmt = mysqli_prepare($conn, $sql);

            // Bind variables to prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_login_name);

            // assign parameters to values
            $param_login_name = $login_name;

            // Execute prepared statement, if fails
            if(!mysqli_stmt_execute($stmt)){
                header("location: login.php?error=sqlexecerror");
                exit();
            } else {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1) {
                
                    // Bind result variables, these are the fields available after fetch
                    mysqli_stmt_bind_result($stmt, $id, $username, $email, $password);
                    
                    // fetch the result
                    if (mysqli_stmt_fetch($stmt)) {
                        
                        // encrypt the password before comparing with encrypted in db
                        $checkPasswords = password_verify($password, login_password);
                        
                        if (!checkPasswords) {
                            header("location: login.php?error=invalidpassword");
                            exit();
                        } else {
                            
                            // Password is correct, Start new session
                            session_start();
                            // Store session variables
                            $_SESSION["mariesmeals"]  = "true";
                            $_SESSION["loggedin"] = true;
                            $_SESSION["userid"]   = $id;                            
                            $_SESSION["username"] = $username;                            
                            $_SESSION["email"] = $email;

                            // Redirect user to weekly plan page
                            header("location: weekly-plan.php");
    
                        } // end of check passwords    

                    } // end of mysqli_stmt_fetch                    
                } else {
                    header("location: login.php?error=invalidusername");
                    exit();
                }  // end of mysqli_stmt_num_rows

            // Close statement
            mysqli_stmt_close($conn);

            } // end of mysqli_stmt_execute

        // Close connection
        mysqli_close($conn);
        } // end of db connection
        
    } // end of POST

?>
