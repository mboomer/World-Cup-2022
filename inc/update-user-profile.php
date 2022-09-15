<?php 

    // Processing form data when form is submitted by a POST and using correct button
    // if ( ($_SERVER["REQUEST_METHOD"] !== "POST") || (!isset($_POST["create-account-btn"])) ) {
    if ( ($_SERVER["REQUEST_METHOD"] !== "POST") ) {
        header("location: user-profile.php?error=accessdenied");
        exit();
    }

    // Include DB config file
    require_once "../../../.php/inc/db.worldcup.inc.php";      

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);
        
    //Receive the RAW data from the fetch POST
    $profiles = trim(file_get_contents("php://input"));

    // decode into an associative array
    $json_array = json_decode($profiles, true);

    /** 
        array of messages to be returned to the calling PHP page 
    */
    $msg_arr = array( 
                        'Success'       => 'Profile Update Successful', 
                        'Incomplete'    => 'Not all required fields are filled in', 
                        'Invaliduser'   => 'User Name contains invalid characters', 
                        'Invalidemail'  => 'User Email not in correct format', 
                        'Existingpwd'   => 'Existing password is not correct, please try again', 
                        'Passwordmatch' => 'New and Repeat Passwords Do Not Match', 
                        'Accessdenied'  => 'Access Denied', 
                        'Database'      => 'SQL execution Error',
                        'Database1'     => 'Database Update Failed',
                        'TeamExists'    => 'That team name already exists',
                        'Failure'       => 'Update Profile FAILED' 
                    );

    // Test error message
    // echo json_encode( $msg_arr[Incomplete] . " - " . $json_array[0]["UserName"] . " - " . $json_array[0]["FirstName"] . " - " . $json_array[0]["LastName"] . " - " . $json_array[0]["UserTeam"] );

    // Check if any of the following profile fields are not completed
    if ( empty(trim($json_array[0]["UserName"])) || empty(trim($json_array[0]["FirstName"])) || empty(trim($json_array[0]["LastName"])) || empty(trim($json_array[0]["UserEmail"])) ) {
        echo json_encode( $msg_arr[Incomplete] );
        exit();
    } 

    // Check if username is invalid
    if ( !preg_match("/^[a-zA-Z0-9]*$/", $json_array[0]["UserName"]) ) {
        echo json_encode( $msg_arr[Invaliduser]);
        exit();
    } 

    // Check if email is valid
    if (!filter_var($json_array[0]["UserEmail"], FILTER_VALIDATE_EMAIL)) {
        echo json_encode( $msg_arr[Invalidemail]);
        exit();
    } 
    
    // check if new password matches the repeated password
    if ($json_array[0]["NewPwd"] !== $json_array[0]["RepeatPwd"]) {
        echo json_encode( $msg_arr[Passwordmatch]);
        exit();
    }

    // check if existing password has been entered and that it matches the existing password
    if ( !empty($json_array[0]["UserPass"]) ) {

            // hash the existing password 
            $existingPwdHash = password_hash( trim($json_array[0]["UserPass"]), PASSWORD_DEFAULT);

            if ( !password_verify($json_array[0]["UserPass"], $json_array[0]["HashedPwd"]) ) {
                echo json_encode( $msg_arr[Existingpwd] );
                exit();
            }
    }

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
            header("location: sign-up.php?error=dbconnecterror&errormsg=".$e->getMessage());
            exit();
        };

        $qry = "UPDATE Users SET FirstName=:FirstName, LastName=:LastName, Phone=:Phone, UserTeam=:UserTeam WHERE ID=:UserID";
            
        // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        // bind the parameters
        $query->bindParam(':UserID',    $userid,    PDO::PARAM_STR);
        // $query->bindParam(':UserName',  $username,  PDO::PARAM_STR);
        // $query->bindParam(':UserEmail', $useremail, PDO::PARAM_STR);
        // $query->bindParam(':UserPass',  $userpass,  PDO::PARAM_STR);
        // $query->bindParam(':UserTeam',  $userteam,  PDO::PARAM_STR);
        $query->bindParam(':FirstName', $userfirst,  PDO::PARAM_STR);
        $query->bindParam(':LastName',  $userlast,   PDO::PARAM_STR);
        $query->bindParam(':Phone',     $userphone,  PDO::PARAM_STR);
        $query->bindParam(':UserTeam',  $userteam,   PDO::PARAM_STR);

        // assign the values to the place holders from JSON array
        $userid    = $json_array[0]["UserID"];
        // $username  = $json_array[0]["UserName"];
        // $useremail = $json_array[0]["UserEmail"];
        // $userpass  = $json_array[0]["UserPass"];
        $userfirst = $json_array[0]["FirstName"];
        $userlast  = $json_array[0]["LastName"];
        $userphone = $json_array[0]["Phone"];
        $userteam  = $json_array[0]["UserTeam"];

        // Execute prepared SELECT statement
        if ($query -> execute() === FALSE) {    
            echo json_encode( $msg_arr[Database] );
            exit();
        } 

    }  // end of Try
    catch (PDOException $e) {
        echo json_encode( 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine() );
    };

    // Close connection
    $dbh -> connection = null;

    echo json_encode( $msg_arr[Success] );

?>