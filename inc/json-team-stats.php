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
            . "     tm.Team as Team, \n"
            . "    	RedCards, \n"
            . "    	YellowCards, \n"
            . "    	FoulsBy, \n"
            . "    	FoulsAg, \n"
            . "    	CornersBy, \n"
            . "    	CornersAg, \n"
            . "    	ThrowinsBy, \n"
            . "    	ThrowInsAg, \n"
            . "    	PenaltysSaved, \n"
            . "    	PenaltysMissed \n"
            . "    FROM  \n"
            . "    	TeamStats ts \n"
            . "    INNER JOIN \n"  
            . "     Teams tm \n"  
            . "    ON \n"  
            . "     tm.ID = ts.TeamID \n"  
            . "    Order BY \n"  
            . "     ts.ID";
            
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
        $jsondata = '{"Team Statistics":[ <br>';

        if ($query->rowCount() == 0) {            
            // close empty JSON
            echo ']}';
        } else {

            foreach($results as $key => $result) {

                $jsondata .= '{';
                $jsondata .= ' "Team":"' . $result -> Team  . '", ';
                $jsondata .= ' "Red Cards":"' . $result -> RedCards  . '", ';
                $jsondata .= ' "Yellow Cards":"' . $result -> YellowCards  . '", ';
                $jsondata .= ' "Fouls For":"' . $result -> FoulsBy  . '", ';
                $jsondata .= ' "Fouls Against":"' . $result -> FoulsAg . '", ';
                $jsondata .= ' "Corners For":"' . $result -> CornersBy  . '", ';
                $jsondata .= ' "Corners Against":"' . $result -> CornersAg . '", ';
                $jsondata .= ' "Throwins For":"' . $result -> ThrowinsBy  . '", ';
                $jsondata .= ' "Throwins Against":"' . $result -> ThrowInsAg . '", ';
                $jsondata .= ' "Penalties Saved":"' . $result -> PenaltysSaved  . '", ';
                $jsondata .= ' "Penalties Missed":"' . $result -> PenaltysMissed . '"';

                /* dont include the comma after last object */
                if ( ($key + 1) >= $query->rowCount()) {
                    $jsondata .=  '} <br>';
                } else {
                    $jsondata .= '}, <br>';
                }

            }; // end of users foreach 

            // close JSON
            $jsondata .=  ']}';

        };  // end of $query->rowCount() else

    // return the JSON data to the calling page
    echo json_encode($jsondata);

?>  