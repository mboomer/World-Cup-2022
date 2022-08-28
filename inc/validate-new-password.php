<?php

    // if you didnt get here from the create-new-password return to home page
    if ( !isset($_POST["reset-password-submit"]) ) {
        header("Location: ../index.php");
        exit();
    }

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // get the data from the Form POST 
    $postSelector   = $_POST["selector"];
    $postValidator  = $_POST["validator"];
    $postUsername   = $_POST["username"];
    $postPassword   = $_POST["password"];
    $postRepeatPwd  = $_POST["repeat-password"];

    // check that we have valid passwords
    if ( empty($postPassword) || empty($postRepeatPwd) ) {
        header("Location: ../php/create-new-password.php?error=pwdempty");
        exit();
    } else if ($postPassword != $postRepeatPwd) {
        header("Location: ../php/create-new-password.php?error=pwdnotmatch");
        exit();
    }

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        echo("Error: " . $e->getMessage());
        exit("Error: " . $e->getMessage());
    };

    // Prepare the SQL statement to get the selector 
    $qry = "SELECT UserName, UserEmail, Selector, Token, Expires FROM PasswordReset WHERE Selector = :Selector";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':Selector', $selector, PDO::PARAM_STR);

    /** assign the values to the place holders */
    $selector = $postSelector;

    // the expiry date of the DB token must be greater than the currentdate 
    $currentdate = date("U");

    // execute the sql query
    $query -> execute();
                                    
    // get all rows
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() == 0) {
        // A valid reset request has not been found - please make a reset request from the login page." . $selector . " - " . $postSelector . " - " . $currentdate;
        header("Location: ../php/create-new-password.php?error=invalid");
        exit;
    } else {

        foreach($results as $key => $result) {

            // the token in the DB is already hashed
            $DBusername  = $result -> UserName;
            $DBuseremail = $result -> UserEmail;
            $DBselector  = $result -> Selector;
            $DBtoken     = $result -> Token;
            $DBexpires   = $result -> Expires;

            if ($currentdate > $DBexpires) {
                // Password reset request has expired. Please re-submit a new reset request" . $DBexpires . " - " . $currentdate;
                header("Location: ../php/create-new-password.php?error=expired");
                exit;
            }

            $tokenBin   = hex2bin($postValidator);
            
            $tokencheck = password_verify($tokenBin, $DBtoken);

            if ($tokencheck === false) {
                // Invalid data received. Please re-submit a new password reset request";
                header("Location: ../php/create-new-password.php?error=invalid");
                exit();
            } 

        }; // end of users foreach 

    }; // end of else 

    // UPDATE the password in the user record with the new password 
    // remember to hash the password before updating

    // Update the user record with the new password
    $qry = "UPDATE Users SET UserPass = :UserPass WHERE UserName = :UserName AND UserEmail = :UserEmail";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':UserName',  $username,  PDO::PARAM_STR);
    $query->bindParam(':UserEmail', $useremail, PDO::PARAM_STR);
    $query->bindParam(':UserPass',  $userpass,  PDO::PARAM_STR);

    // hash the new password before storing in the database
    $hashedPassord = password_hash($postPassword, PASSWORD_DEFAULT);

    /** assign the values to the place holders */
    $username  = $DBusername;
    $useremail = $DBuseremail;
    $userpass  = $hashedPassord;

    // execute the sql query
    $query -> execute();
                                    
    if ($query->rowCount() == 0) {
        // echo "No Update to the your password was possible - please make a new reset request";
        header("Location: ../php/create-new-password.php?error=userpwfail");
        exit;
    };

    /** delete the user token from database with same email
    * redirect to login page with message to show password was reset
    */

    // Update the user record with the new password
    $qry = "DELETE FROM PasswordReset WHERE UserName = :UserName AND UserEmail = :UserEmail";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':UserName',  $username,  PDO::PARAM_STR);
    $query->bindParam(':UserEmail', $useremail, PDO::PARAM_STR);

    $username  = $DBusername;
    $useremail = $DBuseremail;

    // execute the sql query
    $query -> execute();
                                    
    if ($query->rowCount() == 0) {
        // No Deletion was made from Password Rest Table";
        header("Location: ../php/create-new-password.php?error=deletefail");
        exit;
    };

    header("Location: ../php/create-new-password.php?error=success");

?>