<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

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

        //prepare the sql statement
        $sql = "INSERT INTO Predictions 
                    (UserID, FixtureID, HomeScore, AwayScore, HomeTeam, AwayTeam, ResultID, Points, Bonus) 
                VALUES 
                    (:UserID, :FixtureID, :HomeScore, :AwayScore, :HomeTeam, :AwayTeam, :ResultID, :Points, :Bonus)";

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
        $query->bindParam(':Bonus',     $bonus,         PDO::PARAM_INT);

        /**
            need to have this header in place to make the return of the JSON successful
        */ 
        header("Content-Type: application/json");

        /** 
            array to be returned to the calling PHP stage 
        */
        $msg_arr = array( 'Success' => 'Insert predictons into database SUCCESSFUL', 'Failure' => 'Insert predictons into database FAILED' );

    foreach($json_array as $elem)  {
   
     // assign the values to the  place holders
        $userid     = $elem['UserID'];
        $fixtureid  = $elem['FixtureID'];
        $homescore  = $elem['HomeScore'];
        $awayscore  = $elem['AwayScore'];
        $hometeamid = $elem['HomeTeamID'];
        $awayteamid = $elem['AwayTeamID'];
        $resultid   = $elem['ResultID'];
        $points     = $elem['Points'];
        $bonus      = $elem['Bonus'];

        /** 
            execute the query and check if it fails to insert prediction
            have to return something formatted as JSON to the calling PHP file
        */
        if ($query -> execute() === FALSE) {    
            echo json_encode( $msg_arr[Failure] );
            exit;            
        } 
    }                       // end of ForEach loop

    /**
        Successful completion 
    */
        echo json_encode( $msg_arr[Success] );

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>