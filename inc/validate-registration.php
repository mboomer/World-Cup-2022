<?php 

    // Include DB config file
    require_once "../../.php/inc/db.worldcup.inc.php";      

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);
        
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
        header("location: ../php/sign-up.php?error=accessdenied");
        exit();
    } else {

        // Check password is at between 12 - 20 characters
        if ( strlen(trim($_POST["password"])) < 12  || strlen(trim($_POST["password"])) > 20 ) {
            header("location: ../php/sign-up.php?error=pwdlength&name=".$login_name."&email=".$login_email);
            exit();
        } 

        // Check if any fields are not completed
        if ( empty(trim($_POST["username"])) || empty(trim($_POST["email"])) || empty(trim($_POST["password"])) || empty(trim($_POST["repeat-password"])) ) {
            header("location: ../php/sign-up.php?error=incomplete&name=".$login_name."&email=".$login_email);
            exit();
        } 

        // Check if both email and username are valid
        if ( !filter_var($login_email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $login_name) ) {
            header("location: ../php/sign-up.php?error=invaliduseremail");
            exit();
        } 

        // Check if email is valid
        if (!filter_var($login_email, FILTER_VALIDATE_EMAIL)) {
            header("location: ../php/sign-up.php?error=invalidemail&name=".$login_name);
            exit();
        } 
        
        // check if username only has valid characters
        if (!preg_match("/^[a-zA-Z0-9]*$/", $login_name)) {
            header("location: ../php/sign-up.php?error=invalidname&email=".$login_email);
            exit();
        }
        
        // check if username is longer than 12 characters
        if ( strlen(trim($login_name)) < 12  || strlen(trim($login_name)) > 20 ) {
            header("location: ../php/sign-up.php?error=usernamelength&email=".$login_email);
            exit();
        }

        // check if passwords match
        if ($login_password !== $login_repeat_pwd) {
            header("location: ../php/sign-up.php?error=passwordmatch&name=".$login_name."&email=".$login_email);
            exit();
        }

        /* ----------------------------------------------------------------------------------- 
            www.coding.academy/blog/how-to-use-regular-expressions-to-check-password-strength
        /* -----------------------------------------------------------------------------------
            at least one uppercase letter
            at least one lowercase letter
            at least one number (digit)
            at least one of the following special characters !@#$%^&*-
            a minimum of 12 characters - max of 20
        ------------------------------------------------------------------------------------ */

        $pwd_check = "/(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#£$%^&*-]).{12,20}/";

        // if (preg_match("/(?=.*[0-9])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*-]).{12,20}/", "Asdfghjklzxcvb98!")) {
        //     echo "A match was found.";
        //     exit();
        // } else {
        //     echo "A match was not found.";
        //     exit();
        // }

        // check if password only has valid characters
        if (!preg_match($pwd_check, $login_password)) {
            header("location: ../php/sign-up.php?error=pwdcriteria&email=".$login_email);
            exit();
        }


    } // end of POST data validation checks

    /** 
        PDO Database connection
        Check if username already exists
        If username doesnt exist, insert as new user in database
    */

    try {
        // Try and establish the database connection - if connection fails return to sign-up page with error message
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            header("location: ../php/sign-up.php?error=dbconnecterror&errormsg=".$e->getMessage());
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
            header("location: ../php/sign-up.php?error=sqlexecerror");
            exit();
        } else {
                // Store the results of the query
                $results = $query -> fetchAll(PDO::FETCH_OBJ);
                
                // if a matching row is retrieved then the user exists 
                if($query -> rowCount() > 0) {
                    header("location: ../php/sign-up.php?error=userexists");
                    exit();
                } 

                //if no matching row is found, prepare the sql statement to insert the user
                $sql = "INSERT INTO Users 
	                        (UserName, UserEmail, UserPass, UserTeam, Predictions) 
                        VALUES 
                            (:UserName, :UserEmail, :UserPass, :UserTeam, :Predictions)";

                // prepare the INSERT SQL query for the database connection
                $query = $dbh -> prepare($sql);

                // bind the parameters
                $query->bindParam(':UserName',    $username,     PDO::PARAM_STR);
                $query->bindParam(':UserEmail',   $emailaddress, PDO::PARAM_STR);
                $query->bindParam(':UserPass',    $hashedpwd,    PDO::PARAM_STR);
                $query->bindParam(':UserTeam',    $teamname,     PDO::PARAM_STR);
                $query->bindParam(':Predictions', $predictions,  PDO::PARAM_INT);

                // assign values to the parameters
                $username     = $login_name;
                $emailaddress = $login_email;
                $hashedpwd    = password_hash(trim($login_password), PASSWORD_DEFAULT);     // encrypt the password before storing
                $teamname     = "";                                                         // default to no team                                           
                $predictions  = 0;                                                          // default to false - no predictions made for new user

                /** 
                    execute the query and if it fails return to sign-up with the error message
                */
                if ($query -> execute() === false) {    
                    header("location: ../php/sign-up.php?error=inserterror&name=".$username."-".$emailaddress);
                } else {
                    header("location: ../php/sign-up.php?error=success");
                }; 

        }; // end of else

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

    // Close connection
    $dbh -> connection = null;

?>
