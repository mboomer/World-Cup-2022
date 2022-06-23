<?php 

    // // checks if session exists
    // session_start();

    // // If already logged in go on to weekly-plan page
    // // if not logged in continue to sign up
    // if ( isset($_SESSION['session']) ) {
    //     header("location: ../weekly-plan.php");    
    // } 

    // Include DB config file
    require_once "../../../.php/inc/db.worldcup.inc.php";      

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // Define variables and initialize with empty values
    $login_name     = "";
    $login_password = "";

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
        };

        // Check if username is empty
        if ( empty(trim($_POST["username"])) ) {
            header("location: login.php?error=nousername");
            exit();
        };

        // Check if password is empty
        if ( empty(trim($_POST["password"])) ) {
            header("location: login.php?error=nopassword&name=".$login_name);
            exit();
        };
    };
        
    try {
        // Try and establish the database connection - if connection fails return to sign-up page with error message
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            header("location: login.php?error=dbconnecterror&errormsg=".$e->getMessage());
            exit();
        };

        // sql statement to retrieve username
        $sql = "SELECT ID, UserName, UserEmail, UserPass, UserTeam, CreatedDate, Predictions FROM Users WHERE Username = :UserName";            
            
        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':UserName', $username, PDO::PARAM_STR);

        // assign the values to the place holders from the POST FormData
        $username = $login_name;

        // Execute prepared SELECT statement
        if ($query -> execute() === FALSE) {    
            header("location: login.php?error=sqlexecerror");
            exit();
        } else {
                // Store the result of the query
                $results = $query -> fetchAll(PDO::FETCH_OBJ);
                
                // if a matching row is retrieved then the user exists 
                if($query -> rowCount() > 0) {

                    // get the users details
                    foreach($results as $result) {
                    
                        // store values for session data
                        $userid    = $result -> ID;
                        $username  = $result -> UserName;
                        $useremail = $result -> UserEmail;

                        // retrieve the encrypted password from the database 
                        $hashedPassword = $result -> UserPass;
                        
                        // Does the user have saved Predictions
                        $predictions = $result -> Predictions;
                    };

                // check the password matches the encrypted password - if not return to login.php
                if (password_verify($login_password, $hashedPassword) === false) {
                    header("location: login.php?error=invalidpassword");
                    exit();
                } else {
                    // Password is correct, Start a new session
                    session_start();
                    // Store session variables
                    $_SESSION["worldcup"]  = true;
                    $_SESSION["loggedin"]  = true;
                    $_SESSION["userid"]    = $userid;                            
                    $_SESSION["username"]  = $username;                            
                    $_SESSION["useremail"] = $email;

                    // Redirect user to Predictions page
                    if ($predictions) {
                        header("location: saved-predictions.php");
                    } else {
                        header("location: predictions.php");
                    };

                } // end of check passwords    

            } else {
                header("location: login.php?error=invalidusername");
                exit();
            }                       // end of query -< rowCount

        } // end of query -> execute

    } // end of Try 
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };
                
    // close and release databse connection
    $dbh -> connection = null;

?>
