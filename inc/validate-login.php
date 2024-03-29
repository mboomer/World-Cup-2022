<?php 

    // if you didnt get here from login page return to home page
    if ( !isset($_POST["login-btn"]) ) {
        header("Location: ../index.php");
        exit();
    }

    // Include DB config file
    require_once "../../.php/inc/db.worldcup.inc.php";      

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);

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
            header("location: ../php/login.php?error=nousernopw");
            exit();
        };

        // Check if username is empty
        if ( empty(trim($_POST["username"])) ) {
            header("location: ../php/login.php?error=nousername");
            exit();
        };

        // Check if password is empty
        if ( empty(trim($_POST["password"])) ) {
            header("location: ../php/login.php?error=nopassword&name=".$login_name);
            exit();
        };
    };
        
    try {
        // Try and establish the database connection - if connection fails return to sign-up page with error message
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            header("location: ../php/login.php?error=dbconnecterror&errormsg=".$e->getMessage());
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
            header("location: ../php/login.php?error=sqlexecerror");
            exit();
        } else {
                // Store the result of the query
                $results = $query -> fetchAll(PDO::FETCH_OBJ);
                
                // if a matching row is retrieved then the user exists 
                if($query -> rowCount() > 0) {

                    // get the users details
                    foreach($results as $result) {
                    
                        // store values for session data
                        $userid      = $result -> ID;
                        $username    = $result -> UserName;
                        $useremail   = $result -> UserEmail;

                        // retrieve the encrypted password from the database 
                        $hashedPassword = $result -> UserPass;
                        
                        // Does the user have saved Predictions
                        $predictions = $result -> Predictions;
                    };

                // check the password matches the encrypted password - if not return to login.php
                if (password_verify($login_password, $hashedPassword) === false) {
                    header("location: ../php/login.php?error=invalidpassword");
                    exit();
                } else {
                    // Password is correct, Start a new session
                    session_start();

                    // Store session variables
                    $_SESSION["worldcup"]      = true;
                    $_SESSION["loggedin"]      = true;
                    $_SESSION["userid"]        = $userid;                            
                    $_SESSION["username"]      = $username;                            
                    $_SESSION["useremail"]     = $email;
                    $_SESSION["predictions"]   = $predictions;
                    $_SESSION['last_activity'] = time();                                

                        /* *************************** */
                        /* Update the Last Login Field */
                        /* *************************** */

                        //prepare the update sql statement
                        $sql = "UPDATE Users SET LastLogin = :LastLogin WHERE ID = :ID";

                        // prepare the query for the database connection
                        $query = $dbh -> prepare($sql);

                        // bind the parameters
                        $query->bindParam(':ID',        $userid,    PDO::PARAM_INT);
                        $query->bindParam(':LastLogin', $lastlogin, PDO::PARAM_STR);

                        // assign the values to the place holders
                        // $userid is already assigned a value from previous execution
                        
                        // this will likely be 1 hour out as now using DST
                        $lastlogin = gmdate("Y-m-d H:i:s");

                        /* execute the query and check if it fails to update the login date / time 
                        have to return something formatted as JSON to the calling PHP file */
                        if ($query -> execute() === FALSE) {    
                            // echo json_encode( $msg_arr['Failure'] );
                            // echo 'Failure to update last login date';
                            exit;            
                        }; 

                        /* *************************** */

                    // Redirect admin user to admin page
                    if ($username == "worldcupadmin") {
                        header("location: update-a-fixture.php");
                        exit();
                    };

                    // Redirect user to Predictions page
                    if ($predictions) {
                        header("location: ../php/saved-predictions.php");
                    } else {
                        header("location: ../php/predictions.php");
                    };

                } // end of check passwords    

            } else {
                header("location: ../php/login.php?error=invalidusername");
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
