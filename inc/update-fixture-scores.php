<?php

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
   
    try {
        // Try and establish the database connection.
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        };

        //prepare the sql statement
        $sql = "UPDATE Fixtures SET HomeScore = :HomeScore, AwayScore = :AwayScore, ResultID = :ResultID WHERE FixtureNo = :FixtureNo"; 

        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        // bind the parameters
        $query->bindParam(':FixtureNo', $fixtureno, PDO::PARAM_INT);
        $query->bindParam(':HomeScore', $homescore, PDO::PARAM_INT);
        $query->bindParam(':AwayScore', $awayscore, PDO::PARAM_INT);
        $query->bindParam(':ResultID',  $resultid,  PDO::PARAM_INT);

        /**
            need to have this header in place to make the return of the JSON successful
        */ 
        header("Content-Type: application/json");

        /** 
            array to be returned to the calling PHP stage 
        */
        $msg_arr = array(   
                        'Success' => 'Update fixture scores - SUCCESSFUL', 
                        'Failure' => 'Update fixture scores - FAILED'
                        );

        foreach($json_array as $key => $fixture)  {
    
            /** assign the values to the place holders - the userid is stored with the predictions so can be extracted from the json array */
            $fixtureno = $fixture['FixtureNo'];
            $homescore = $fixture['HomeScore'];
            $awayscore = $fixture['AwayScore'];
            $resultid  = $fixture['ResultID'];

            /** 
                execute the query and check if it fails to insert prediction
                have to return something formatted as JSON to the calling PHP file
            */
            if ($query -> execute() === FALSE) {    
                echo json_encode( "Update fixture scores - FAILED : " . " Index : " . $key . " Fixture : " . $fixtureno . " " . $homescore . " -v- " . $awayscore . " Result : " . $resultid);
                exit;
            };

        };       // end of Fixtures ForEach loop

        echo json_encode( "Update fixture scores - SUCCESSFUL : " . " Fixture : " . $fixtureno . " " . $homescore . " -v- " . $awayscore . " Result ID : " . $resultid);

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>