<?php

    // if you didnt get here from a update-a-fixture POST then return to home page
    if ( $_SERVER['REQUEST_METHOD'] != "POST" ) {
        header("Location: ../index.php");
        exit();
    }

    // Include config file
    require_once "../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);

   //Receive the RAW data from the fetch POST
    $teams = trim(file_get_contents("php://input"));

    // decode into an associative array
    $json_array = json_decode($teams, true);

    /* array to be returned to the calling PHP stage */
    $msg_arr = array(   
                    'Success' => 'Update Team Stats - SUCCESSFUL', 
                    'Failure' => 'Update Team Stats - FAILED'
                    );

    // check if a valid team has been selected 
    if ( $json_array[0]['TeamID'] >= 1 && $json_array[0]['TeamID'] <= 32) {
        // Team ID is valid
    } else {
        echo json_encode( $msg_arr['Failure'] . " - Team ID is invalid");
        exit;
    }

    try {
        // Try and establish the database connection.
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        };

        // Increment current values with values for the current match
        $sql = "UPDATE TeamStats 
                SET 
                    RedCards       = RedCards + :RedCards , 
                    YellowCards    = YellowCards + :YellowCards, 
                    FoulsBy        = FoulsBy + :FoulsBy, 
                    FoulsAg        = FoulsAg + :FoulsAg, 
                    CornersBy      = CornersBy + :CornersBy, 
                    CornersAg      = CornersAg + :CornersAg, 
                    ThrowInsBy     = ThrowInsBy + :ThrowInsBy, 
                    ThrowInsAg     = ThrowInsAg + :ThrowInsAg, 
                    PenaltysSaved  = PenaltysSaved + :PenaltysSaved,
                    PenaltysMissed = PenaltysMissed + :PenaltysMissed 
                WHERE 
                    TeamID = :TeamID"; 

        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':TeamID',         $teamid,         PDO::PARAM_INT);
        $query->bindParam(':RedCards',       $redcards,       PDO::PARAM_INT);
        $query->bindParam(':YellowCards',    $yellowcards,    PDO::PARAM_INT);
        $query->bindParam(':FoulsBy',        $foulsby,        PDO::PARAM_INT);
        $query->bindParam(':FoulsAg',        $foulsag,        PDO::PARAM_INT);
        $query->bindParam(':CornersBy',      $cornersby,      PDO::PARAM_INT);
        $query->bindParam(':CornersAg',      $cornersag,      PDO::PARAM_INT);
        $query->bindParam(':ThrowInsBy',     $throwinsby,     PDO::PARAM_INT);
        $query->bindParam(':ThrowInsAg',     $throwinsag,     PDO::PARAM_INT);
        $query->bindParam(':PenaltysSaved',  $penaltyssaved,  PDO::PARAM_INT); 
        $query->bindParam(':PenaltysMissed', $penaltysmissed, PDO::PARAM_INT);

        /* need to have this header in place to make the return of the JSON successful */ 
        header("Content-Type: application/json");

        foreach($json_array as $key => $team)  {
    
            /** assign the values from the POSTed array to the place holders */
            $teamid         = $team['TeamID'];
            $redcards       = $team['RedCard'];
            $yellowcards    = $team['YellowCard'];
            $foulsby        = $team['FoulBy'];
            $foulsag        = $team['FoulAg'];
            $cornersby      = $team['CornerBy'];
            $cornersag      = $team['CornerAg'];
            $throwinsby     = $team['ThrowinBy'];
            $throwinsag     = $team['ThrowinAg'];
            $penaltyssaved  = $team['PenaltySaved'];
            $penaltysmissed = $team['PenaltyMissed'];

            /* execute the query and check if it fails to insert prediction - have to return something formatted as JSON to the calling PHP file */
            if ($query -> execute() === FALSE) {    
                echo json_encode( $msg_arr['Failure'] . " Team Stats : " . $teamid);
                exit;
            };

        };       // end of Fixtures ForEach loop

        echo json_encode( $msg_arr['Success'] . " Team Stats : " . $teamid);

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>