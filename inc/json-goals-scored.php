<?php

    // if you didnt get here from BUTTON ON HOME PAGE then return to home page
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
    $dumydata = trim(file_get_contents("php://input"));

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    };

    $qry = "  SELECT \n" 
            . "     Player, \n"
            . "    	tm.Team as Team, \n"
            . "    	H1Minute, \n"
            . "    	H2Minute, \n"
            . "    	ET1Minute,  \n"
            . "    	ET2Minute, \n"
            . "    	Penalty, \n"
            . "    	OwnGoal \n"
            . "    FROM  \n"
            . "    	GoalsScored gs \n"
            . "    INNER JOIN \n"
            . "    	Teams tm \n"
            . "    ON \n"
            . "    	gs.TeamID = tm.ID \n"
            . "    ORDER BY \n"  
            . "     gs.ID ASC";
            
        // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        /* bind the parameters - no parameters used in this query */
        /* $query->bindParam(':FixtureNo', $fixtureno, PDO::PARAM_INT); */

        /* assign the values to the place holders - no placeholders used in the sql statement */
        /* $fixtureno = $fixture['FixtureNo']; */

        /* execute the query and check if it fails - have to return something formatted as JSON to the calling PHP file */

        // execute the sql query
        $query -> execute();
                                        
        // get all rows
        $results = $query -> fetchAll(PDO::FETCH_OBJ);

        /* start the JSON Object */
        $jsondata = '{"Goals":[ <br>';

        if ($query->rowCount() == 0) {            
            // close empty JSON
            $jsondata .= ']}';
        } else {

            foreach($results as $key => $result) {

                $jsondata .= '{';
                $jsondata .= ' "Player":"' . $result -> Player  . '", ';
                $jsondata .= ' "Team":"' . $result -> Team . '", ';
                $jsondata .= ' "H1 Minute": ' . $result -> H1Minute . ', ';
                $jsondata .= ' "H2 Minute": ' . $result -> H2Minute  . ', ';
                $jsondata .= ' "ET1 Minute": ' . $result -> ET1Minute . ', ';
                $jsondata .= ' "ET2 Minute": ' . $result -> ET2Minute . ', ';
                $jsondata .= ' "Penalty": ' . $result -> Penalty   . ', ';
                $jsondata .= ' "OwnGoal": ' . $result -> OwnGoal;

                /* dont include the comma after last object */
                if ( ($key + 1) >= $query->rowCount()) {
                    $jsondata .= '} <br>';
                } else {
                    $jsondata .= '}, <br>';
                }

            }; // end of users foreach 

            // close JSON
            $jsondata .= ']}';

        };  // end of $query->rowCount() else

    // return the JSON data to the calling page
    echo json_encode($jsondata);

?>  