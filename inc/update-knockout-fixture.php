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
    $fixtures = trim(file_get_contents("php://input"));

    // decode into an associative array
    $json_array = json_decode($fixtures, true);
   
    // get the ID's for the teams, need these to decide which SQL statement to execute
    $hometeamid = $json_array[0]['HomeTeamID'];
    $awayteamid = $json_array[0]['AwayTeamID'];

    /* array to be returned to the calling PHP stage */
    $msg_arr = array(   
                    'Success' => 'Update fixture - SUCCESSFUL', 
                    'Failure' => 'Update fixture - FAILED'
                    );

    if ($json_array[0]['FixtureID'] < 49) {
        echo json_encode( $msg_arr['Failure'] . " - Only Fixtures in the Knockout Stage can be updated");
        exit;
    }

    if ($hometeamid != 0 && $awayteamid != 0) {
        echo json_encode( $msg_arr['Failure'] . " - Unable to update BOTH home team and away team at the same time");
        exit;
    }

    if ($hometeamid == 0 && $awayteamid == 0) {
        echo json_encode( $msg_arr['Failure'] . " - No Home or Away Team Selected");
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

        //prepare the sql statements for setting either the home team or the away team
        if ($awayteamid == 0) {
            $sql = "UPDATE Fixtures SET HomeTeamID = :TeamID WHERE FixtureNo = :FixtureNo"; 
        } else {
            $sql = "UPDATE Fixtures SET AwayTeamID = :TeamID WHERE FixtureNo = :FixtureNo"; 
        }

        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':FixtureNo',  $fixtureno,  PDO::PARAM_INT);

        if ($awayteamid == 0) {
            $query->bindParam(':TeamID', $hometeamid, PDO::PARAM_INT);
        } else {
            $query->bindParam(':TeamID', $awayteamid, PDO::PARAM_INT);
        }

        /* need to have this header in place to make the return of the JSON successful */ 
        header("Content-Type: application/json");

        foreach($json_array as $key => $fixture)  {
    
            /** assign the values to the place holders - the userid is stored with the predictions so can be extracted from the json array */
            $fixtureno = $fixture['FixtureID'];

            if ($awayteamid == 0) {
                $hometeamid = $fixture['HomeTeamID'];
            } else {
                $awayteamid = $fixture['AwayTeamID'];
            }

            /* execute the query and check if it fails to insert prediction - have to return something formatted as JSON to the calling PHP file */
            if ($query -> execute() === FALSE) {    
                echo json_encode( $msg_arr['Failure'] . " Fixture : " . $fixtureno . " " . $hometeamid . " -- " . $awayteamid);
                exit;
            };

        };       // end of Fixtures ForEach loop

        echo json_encode( $msg_arr['Success'] . " Fixture : " . $fixtureno . " - " . $hometeamid . " -v- " . $awayteamid);

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>