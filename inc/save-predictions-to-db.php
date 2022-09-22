<?php         

    // If you didnt get from saved-predictions, return to home page
    if ( $_SERVER['REQUEST_METHOD'] != "POST" ) {
        header("Location: ../index.php");
        exit();
    }

    // checks if session exists
    session_start();

    // $_SESSION["worldcup"]  = true;
    // $_SESSION["loggedin"]  = true;
    // $_SESSION["userid"]    = $userid;                            
    // $_SESSION["username"]  = $username;                            
    // $_SESSION["useremail"] = $email;

    /** as the userid is stored along with teh predictions there is no need to extract it from the session variables */
    // If logged in store the userid from session 
    // if ( isset($_SESSION['userid']) ) {
    //     $userid = $_SESSION["userid"];    
    // }; 

    // Include config file
    require_once "../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);

    //Receive the RAW data from the fetch POST
    $predictions = trim(file_get_contents("php://input"));

    // decode into an associative array
    $json_array = json_decode($predictions, true);

    try {
        // Try and establish the database connection.
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        };

        /**
        * Insert the predictions in to the predictions table
        */

        //prepare the sql statement
        $sql = "INSERT INTO Predictions 
                    (UserID, FixtureID, HomeScore, AwayScore, HomeTeam, AwayTeam, ResultID, Points, Stage) 
                VALUES 
                    (:UserID, :FixtureID, :HomeScore, :AwayScore, :HomeTeam, :AwayTeam, :ResultID, :Points, :Stage)";

        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':UserID',    $userid,        PDO::PARAM_INT);
        $query->bindParam(':FixtureID', $fixtureid,     PDO::PARAM_INT);
        $query->bindParam(':HomeScore', $homescore,     PDO::PARAM_INT);
        $query->bindParam(':AwayScore', $awayscore,     PDO::PARAM_INT);
        $query->bindParam(':HomeTeam',  $hometeamid,    PDO::PARAM_INT);
        $query->bindParam(':AwayTeam',  $awayteamid,    PDO::PARAM_INT);
        $query->bindParam(':ResultID',  $resultid,      PDO::PARAM_INT);
        $query->bindParam(':Points',    $points,        PDO::PARAM_INT);
        $query->bindParam(':Stage',     $stage,         PDO::PARAM_STR);

        /**
            need to have this header in place to make the return of the JSON successful
        */ 
        header("Content-Type: application/json");

        /** 
            array to be returned to the calling PHP stage 
        */
        $msg_arr = array(   
                        'Success' => 'Insert predictons into database SUCCESSFUL', 
                        'Failure' => 'Insert predictons into database FAILED', 
                        'Users'   => 'Update User record FAILED' 
                        );

        foreach($json_array as $key => $elem)  {
    
            /** assign the values to the place holders - the userid is stored with the predictions so can be extracted from the json array */
            $userid     = $elem['UserID'];
            $fixtureid  = $elem['FixtureID'];
            $homescore  = $elem['HomeScore'];
            $awayscore  = $elem['AwayScore'];
            $hometeamid = $elem['HomeTeamID'];
            $awayteamid = $elem['AwayTeamID'];
            $resultid   = $elem['ResultID'];
            $points     = $elem['Points'];
            $stage      = $elem['Stage'];

            /** 
                skip the first element in the array as this holds the top scorer information 
                but store the predicted top goal scorer and number of predicted goals scored
                these are held in the first element in the array
            */
            if ($key == 0) {                 
                $topscorer   = $homescore;
                $goalsscored = $hometeamid;
                continue;
            };

            /** 
                execute the query and check if it fails to insert prediction
                have to return something formatted as JSON to the calling PHP file
            */
            if ($query -> execute() === FALSE) {    
                echo json_encode( $msg_arr[Failure] );
                exit;            
            }; 
        };                       // end of Prediction ForEach loop

        /**
        * Update the User record to record the fact that predictions have been saved to the predictions table
        */
        //prepare the update sql statement
        $sql = "UPDATE Users SET Predictions = :Predictions, TopScorer = :TopScorer, GoalsScored = :GoalsScored WHERE ID = :ID";

        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':ID',          $userid,      PDO::PARAM_INT);
        $query->bindParam(':Predictions', $predictions, PDO::PARAM_INT);
        $query->bindParam(':TopScorer',   $topscorer,   PDO::PARAM_STR);
        $query->bindParam(':GoalsScored', $goalsscored, PDO::PARAM_INT);

        // assign the values to the place holders
        // $userid is already assigned a value from previous execution
        
        // set predictions to true = 1
        $predictions = 1;

        // $topgoalscorer and goalsscored are already assigned a value from the first element in the array
        // $topgoalscorer = $homescore;
        // $goalsscored   = $hometeamid;

        /** 
            execute the query and check if it fails to insert prediction
            have to return something formatted as JSON to the calling PHP file
        */
        if ($query -> execute() === FALSE) {    
            echo json_encode( $msg_arr[Users] );
            exit;            
        }; 

    /**
        Successful completion 
    */
        echo json_encode( $msg_arr[Success] );

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>