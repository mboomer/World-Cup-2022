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
            . "     FixtureNo		as fixtureno, \n"
            . "    	DatePlayed		as dateplayed, \n"
            . "    	TimePlayed		as timeplayed, \n"
            . "    	grp.Description as groupdesc, \n"
            . "    	rnd.Description as rounddesc,  \n"
            . "    	vnu.City		as city, \n"
            . "    	vnu.Stadium		as stadium, \n"
            . "    	hmt.Team 		as hometeam, \n"
            . "    	awt.Team 		as awayteam \n"
            . "    FROM  \n"
            . "    	Fixtures fx \n"
            . "    INNER JOIN \n"
            . "    	GroupStage grp \n"
            . "    ON \n"
            . "    	fx.GroupID = grp.ID \n"
            . "    INNER JOIN \n"
            . "    	Rounds rnd \n"
            . "    ON \n"
            . "    	fx.RoundID = rnd.ID \n"
            . "    INNER JOIN \n"
            . "    	Venues vnu \n"
            . "    ON \n"
            . "    	fx.VenueID = vnu.ID \n"
            . "    INNER JOIN \n"
            . "    	Teams hmt \n"
            . "    ON \n"
            . "    	fx.HomeTeamID = hmt.ID \n"
            . "    INNER JOIN \n"
            . "    	Teams awt \n"
            . "    ON \n"
            . "    	fx.AwayTeamID = awt.ID \n"
            . "    WHERE \n"
            . "     resultid = 6 \n"
            . "    ORDER BY \n"  
            . "     fixtureNo \n"  
            . "    ASC \n";
            
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
        $jsondata = '{"fixtures":[ <br>';

        if ($query->rowCount() == 0) {            
            // close empty JSON
            $jsondata .= ']}';
        } else {

            foreach($results as $key => $result) {

                $jsondata .= '{';
                $jsondata .= ' "Fixture No":  "' . $result -> fixtureno  . '", ';
                $jsondata .= ' "Date Played": "' . $result -> dateplayed . '", ';
                $jsondata .= ' "Time Played": "' . $result -> timeplayed . '", ';
                $jsondata .= ' "Group":       "' . $result -> groupdesc  . '", ';
                $jsondata .= ' "Round":       "' . $result -> rounddesc . '", ';
                $jsondata .= ' "City":        "' . $result -> city      . '", ';
                $jsondata .= ' "Stadium":     "' . $result -> stadium   . '", ';
                $jsondata .= ' "Home Team":   "' . $result -> hometeam  . '", ';
                $jsondata .= ' "Away Team":   "' . $result -> awayteam  . '"';

                /* dont include the comma after last object */
                if ($result -> fixtureno == 64) {
                    // echo '} <br>';
                    $jsondata .=  '} <br>';
                } else {
                    // echo '}, <br>';
                    $jsondata .=  '}, <br>';
                }

            }; // end of users foreach 

            // close JSON
            // echo ']}';
            $jsondata .= ']}';

        };  // end of $query->rowCount() else

    // return the JSON data to the calling page
    echo json_encode($jsondata);

?>  