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
    $postPassword   = $_POST["password"];
    $postRepeatPwd  = $_POST["repeat-password"];

    // check that we have valid passwords
    if ( empty($postPassword) || empty($postRepeatPwd) ) {
        header("Location: create-new-password.php?error=pwdempty");
        exit();
    } else if ($postPassword != $postRepeatPwd) {
        header("Location: create-new-password.php?error=pwdnotmatch");
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

    // the expiry date of the DB token must be greater than the currentdate 
    $qry = "SELECT UserEmail, Selector, Token, Expires FROM PasswordReset WHERE Selector = :Selector";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':Selector', $selector, PDO::PARAM_STR);

    /** assign the values to the place holders */
    $selector    = $postSelector;
    $currentdate = date("U");

    // execute the sql query
    $query -> execute();
                                    
    // get all rows
    $results = $query -> fetchAll(PDO::FETCH_OBJ);

    if ($query->rowCount() == 0) {
        // echo "A valid reset request has not been found - please make a reset request from the login page." . $selector . " - " . $postSelector . " - " . $currentdate;
        header("Location: create-new-password.php?error=invalid");
        exit;
    } else {

        foreach($results as $key => $result) {

            // the token in the DB is already hashed
            $DBuseremail = $result -> UserEmail;
            $DBselector  = $result -> Selector;
            $DBtoken     = $result -> Token;
            $DBexpires   = $result -> Expires;

            if ($currentdate > $DBexpires) {
                // echo "Your password reset request has expired. Please re-submit a new reset request" . $DBexpires . " - " . $currentdate;
                header("Location: create-new-password.php?error=expired");
                exit;
            }

            $tokenBin   = hex2bin($postValidator);
            
            $tokencheck = password_verify($tokenBin, $DBtoken);

            // echo "Post Validator : " . $postValidator . "<br>";
            // echo "DB Token       : " . $DBtoken . "<br>";
            // echo "Token (BIN)    : " . $tokenBin . "<br>";
            
            if ($tokencheck === false) {
                echo "Invalid data received. Please re-submit a new password reset request";
                header("Location: create-new-password.php?error=invalid");
                // echo "Validator : " . $tokenHashed . " DB Token " . $DBtoken;
                exit();
            } 

            // echo "tokens match";

        }; // end of users foreach 

    }; // end of else 

    // UPDATE the password in the user record with the new password 
    // remember to hash the password before updating

    // Update the user record with the new password
    $qry = "UPDATE Users SET UserPass = :UserPass WHERE UserEmail = :UserEmail";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':UserPass',  $userpass,  PDO::PARAM_STR);
    $query->bindParam(':UserEmail', $useremail, PDO::PARAM_STR);

    // hash the new password before storing in the database
    $hashedPassord = password_hash($postPassword, PASSWORD_DEFAULT);

    /** assign the values to the place holders */
    $userpass  = $hashedPassord;
    $useremail = $DBuseremail;

    // execute the sql query
    $query -> execute();
                                    
    if ($query->rowCount() == 0) {
        // echo "No Update to the your password was possible - please make a new reset request";
        header("Location: create-new-password.php?error=userpwfail");
        exit;
    };

    /** delete the user token from database with same email
    * redirect to login page with message to show password was reset
    */

    // Update the user record with the new password
    $qry = "DELETE FROM PasswordReset WHERE UserEmail = :UserEmail";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':UserEmail', $useremail, PDO::PARAM_STR);

    $useremail = $DBuseremail;

    // execute the sql query
    $query -> execute();
                                    
    if ($query->rowCount() == 0) {
        // echo "No Deletion was made from Password Rest Table<br>";
        header("Location: create-new-password.php?error=deletefail");
        exit;
    };

    header("Location: create-new-password.php?error=success");

?>