<?php 

    // Include DB config file
    require_once "../../../.php/inc/db.worldcup.inc.php";      

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);
        
    // checks if session exists
    // session_start();

    // If already logged in go on to weekly-plan page
    // if not logged in continue to sign up
    // if ( isset($_SESSION['session']) ) {
    //     header("location: ../weekly-plan.php");    
    // } 

    // Define variables and initialize with empty values
    $login_name       = "";
    $login_email      = "";
    $login_password   = "";
    $login_repeat_pwd = "";

    // Get values from POST
    $login_name       = trim($_POST["username"]);
    $login_email      = trim($_POST["email"]);
    $login_password   = trim($_POST["password"]);   
    $login_repeat_pwd = trim($_POST["repeat-password"]);   


    // Processing form data when form is submitted by a POST and using correct button
    if ( ($_SERVER["REQUEST_METHOD"] !== "POST") || (!isset($_POST["create-account-btn"])) ) {
        header("location: sign-up.php?error=accessdenied");
        exit();
    } else {
        // Check if any fields are not completed
        if ( empty(trim($_POST["username"])) || empty(trim($_POST["email"])) || empty(trim($_POST["password"])) || empty(trim($_POST["repeat-password"])) ) {
            header("location: sign-up.php?error=incomplete&name=".$login_name."&email=".$login_email);
            exit();
        } 

        // Check if both email and username are invalid
        if ( !filter_var($login_email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $login_name) ) {
            header("location: sign-up.php?error=invaliduseremail");
            exit();
        } 
        // Check if email is valid
        if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
            header("location: sign-up.php?error=invalidemail&name=".$login_name);
            exit();
        } 
        
        // check if username only has valid characters
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login_name)) {
            header("location: sign-up.php?error=invalidname&email=".$login_email);
            exit();
        }
        
        // check if passwords match
        if ($login_password !== $login_repeat_pwd) {
            header("location: sign-up.php?error=passwordmatch&name=".$login_name."&email=".$login_email);
            exit();
        }

    } // end of POST data validation checks

    /** 
        PDO Database connection
        Check if username already exists
        If username doesnt exist, insert user in database
    */

    try {
        // Try and establish the database connection - if connection fails return to sign-up page with error message
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            header("location: sign-up.php?error=dbconnecterror&errormsg=".$e->getMessage());
            exit();
        };

        // check if username already exists 
        $sql = "SELECT UserName, UserEmail, UserTeam FROM Users WHERE Username = :UserName";
            
        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':UserName', $username, PDO::PARAM_STR);

        // assign the values to the place holders from the POST FormData
        $username = $login_name;

        // Execute prepared SELECT statement
        if ($query -> execute() === FALSE) {    
            header("location: sign-up.php?error=sqlexecerror");
            exit();
        } else {
                // Store the result of the query
                $results = $query -> fetchAll(PDO::FETCH_OBJ);
                
                // if a matching row is retrieved then the user exists 
                if($query -> rowCount() > 0) {
                    header("location: sign-up.php?error=userexists");
                    exit();
                } 

                //prepare the sql statement
                $sql = "INSERT INTO Users 
	                        (UserName, UserEmail, UserPassword, UserTeam) 
                        VALUES 
                            (:UserName, :UserEmail, :UserPassword, :UserTeam)";

                // prepare the INSERT SQL query for the database connection
                $query = $dbh -> prepare($sql);

                // bind the parameters
                $query->bindParam(':UserName',     $username,      PDO::PARAM_STR);
                $query->bindParam(':UserEmail',    $emailaddress,  PDO::PARAM_STR);
                $query->bindParam(':UserPassword', $hashedpwd,     PDO::PARAM_STR);
                $query->bindParam(':UserTeam',     $teamname,      PDO::PARAM_STR);

                // assign values to the parameters
                $username       = $login_name;
                $emailaddress   = $login_email;
                $hashedpwd      = password_hash(trim($login_password), PASSWORD_DEFAULT);   // encrypt the password before storing
                $teamname       = "Norn Ireland";                                           // dont fill in a Team Name yet

                /** 
                    execute the query and if it fails return to sign-up with the error message
                */
                if ($query -> execute() === false) {    
                    header("location: sign-up.php?error=inserterror&name=".$username."-".$emailaddress."-".$hashedpwd."-".$teamname);
                } else {
                    header("location: sign-up.php?error=success");
                }; 

        }; // end of else

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

    // Close connection
    $dbh -> connection = null;

?>
