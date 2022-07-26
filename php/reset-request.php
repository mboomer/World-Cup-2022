<?php

    // if you dont get here from password reset form, then return to login 
    if (empty($_POST["reset-request-submit"])) {
        header("Location: login.php");
        exit();
    }

    // if there is no password entered, return to reset-password with merror message 
    if ( empty($_POST["emailaddress"]) ) {
        header("Location: reset-password.php?reset=pwdempty");
        exit();
    }    
    
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    $selector = bin2hex(random_bytes(8));

    $token = random_bytes(32);

    $url = "https://www.9habu.com/wc2022/php/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    // token will expire in 60 munutes 
    $expires = date("U") + 3600;

    // extract the email address from the POST data
    $postemail = $_POST["emailaddress"];

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        echo("Error: " . $e->getMessage());
        exit("Error: " . $e->getMessage());
    };

    // delete any existing tokens for this user email address
    $qry = "DELETE FROM PasswordReset WHERE UserEmail = :UserEmail";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query -> bindParam(':UserEmail', $useremail, PDO::PARAM_STR);
    
    /** assign the values to the place holders */
    $useremail = $postemail;

    /** execute the query and check if it fails */
    $query -> execute();
                                    
    if ($query -> rowCount() > 0) {    
        // $count = $query -> rowCount();
        // echo $count . " rows were affected.";
    } else {
        // echo "No affected rows.";
    }

    // create a token in the database for this email address
    $qry = "INSERT INTO PasswordReset (UserEmail, Selector, Token, Expires) VALUES (:UserEmail, :Selector, :Token, :Expires)";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':UserEmail', $dbemail,    PDO::PARAM_STR);
    $query->bindParam(':Selector',  $dbselector, PDO::PARAM_STR);
    $query->bindParam(':Token',     $dbtoken,    PDO::PARAM_STR);
    $query->bindParam(':Expires',   $dbexpires,  PDO::PARAM_STR);

    // hash the password token
    $hashedtoken = password_hash($token, PASSWORD_DEFAULT);

    /** assign the values to the place holders */
    $dbemail    = $postemail;
    $dbselector = $selector;
    $dbtoken    = $hashedtoken;
    $dbexpires  = $expires;

    /** execute the query and check if it fails - if it does, return to the reset password page */
    if ($query -> execute() === FALSE) {    
        header("Location: reset-password.php?reset=failed");
        exit;            
    }; 

    $to        = $postemail;
    $subject   = "Reset your password";
    $message   = "<p>We receievd a password request, etc. etc. </p>";
    $message  .= "<p>Here is your password reset link : <br>"; 
    $message  .= "<a href='" . $url . "'>'" . $url . "'</a></p>"; 

    $headers  = "From: World Cup Predictor <mark.boomer@9habu.com> \r\n";
    $headers .= "Reply-To: mark.boomer@9habu.com \r\n";
    $headers .= "Content-Type: text/html \r\n";

    mail($to, $subject, $message , $headers);

    header("Location: reset-password.php?reset=success");

?>
