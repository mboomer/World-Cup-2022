<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

   //Receive the RAW data from the fetch POST
    $goals = trim(file_get_contents("php://input"));

    // decode into an associative array
    $json_array = json_decode($goals, true);
    
    
    try {
        // Try and establish the database connection.
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        };

        //prepare the sql statement
        $sql = "INSERT INTO GoalsScored 
                    (Player, TeamID, H1Minute, H2Minute, ET1Minute, ET2Minute, Penalty, OwnGoal)
                VALUES
                    (:Player, :TeamID, :H1Minute, :H2Minute, :ET1Minute, :ET2Minute, :Penalty, :OwnGoal)"; 

        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':Player',    $player,    PDO::PARAM_STR);
        $query->bindParam(':TeamID',    $teamid,    PDO::PARAM_INT);
        $query->bindParam(':H1Minute',  $h1minute,  PDO::PARAM_INT);
        $query->bindParam(':H2Minute',  $h2minute,  PDO::PARAM_INT);
        $query->bindParam(':ET1Minute', $et1minute, PDO::PARAM_INT);
        $query->bindParam(':ET2Minute', $et2minute, PDO::PARAM_INT);
        $query->bindParam(':Penalty',   $penalty,   PDO::PARAM_INT);
        $query->bindParam(':OwnGoal',   $owngoal,   PDO::PARAM_INT);
 
        /**
            need to have this header in place to make the return of the JSON successful
        */ 
        header("Content-Type: application/json");

        /** 
            array to be returned to the calling PHP stage 
        */
        $msg_arr = array(   
                        'Success' => 'Update goal - SUCCESSFUL', 
                        'Failure' => 'Update goal - FAILED'
                        );

        foreach($json_array as $key => $goal)  {
                
            /** assign the values to the place holders - the userid is stored with the predictions so can be extracted from the json array */
            $fixtureid = $goal['FixtureID'];
            $player    = $goal['Player'];
            $teamid    = $goal['TeamID'];
            $h1minute  = $goal['H1Minute'];
            $h2minute  = $goal['H2Minute'];
            $et1minute = $goal['ET1Minute'];
            $et2minute = $goal['ET2Minute'];
            $penalty   = $goal['Penalty'];
            $owngoal   = $goal['OwnGoal'];

            /** 
                execute the query and check if it fails to insert prediction
                have to return something formatted as JSON to the calling PHP file
            */
            if ($query -> execute() === FALSE) {    
                echo json_encode( $msg_arr[Failure] . " - Index : " . $key . " Goal : " . $player . " - " . $h1minute . " - " . $h2minute);
                // exit;            
            } else {
                echo json_encode( $msg_arr[Success] . " Scored By : " . $player);
            };

        };       // end of Fixtures ForEach loop

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>