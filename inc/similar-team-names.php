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
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);
        
    //Receive the RAW data from the fetch POST
    $checkteam = trim(file_get_contents("php://input"));

    // decode into an associative array
    // $json_array = json_decode($profiles, true);

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

        // ---------------------------------------------------------------------------------
        // Check if the Team already exists, if it does return the users with that TeamName
        // ---------------------------------------------------------------------------------
        $qry = "SELECT DISTINCT UserTeam FROM Users WHERE UserTeam LIKE :UserTeam";
            
        // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        // bind the parameters
        $query->bindParam(':UserTeam', $userteam, PDO::PARAM_STR);

        // assign the values to the place holders from JSON array
        $userteam  = $checkteam."%";

        // Execute prepared SELECT statement
        $query -> execute();

        // get all rows
        $teams = $query -> fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() == 0) {
            echo "<div>Click Save to make this your Team name</div>";
        } else {

            // echo "  <tbody>";  

            // loop through the Teams
            foreach($teams as $key => $team) {

                // echo "      <tr>";      
                // echo "          <td>" . $team -> UserTeam . "</td>";      
                // echo "      </tr>";    

                echo "  <div data-tm='" . $team -> UserTeam . "'>" . $team -> UserTeam . "</div>";      

            }; // end of team users foreach
                    
            // echo "  </tbody>";  

        }; // end of team users else rowcount

    }  // end of Try
    catch (PDOException $e) {
        echo json_encode( 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine() );
    };

    // Close connection
    $dbh -> connection = null;

?>