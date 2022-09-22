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

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    };
                    
    // open file for writing
    $fh = fopen("../static/competition-stats.html", "w"); 

    // ---------------------------------------------------------------
    // GAMES PLAYED SO FAR, ResultID = 6 (NP Not Played)
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
         . "    COUNT(ResultID) as PlayedSoFar \n"
         . "  FROM  \n"
         . "    Fixtures \n"
         . "  WHERE ResultID <> :ResultID \n";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':ResultID', $resultid, PDO::PARAM_INT);    

    /** assign the values to the place holders */ 
    $resultid = 6;

    /** execute the query and check if it fails */
    $query -> execute();
                                    
    // get all rows
    $rows = $query -> fetchAll(PDO::FETCH_OBJ);

    // initialise the HTML string
    $html  = "  <div id='games-played'> \n"
           . "      <div class='stat-title'>Games Played So Far</div> \n";

    if ($query->rowCount() == 0) {

        $html .= "      <div class='stat-value'>No Value Found</div> \n";

    } else {

        foreach($rows as $key => $row) {

            $gamesplayed = $row -> PlayedSoFar;
        
            $html .= "      <div class='stat-value'>" . $row -> PlayedSoFar . "</div> \n";

        }; // end of foreach 

    };  // end of $query->rowCount() else    

    $html .= "  </div>\n";

    // ---------------------------------------------------------------
    // END OF GAMES PLAYED SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // TOTAL GOALS SO FAR
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
            . "    	COUNT(ID) as TotalGoals \n"
            . "  FROM  \n"
            . "    	GoalsScored\n";

        // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        /** bind the parameters
        * no parameters used in this query
        * $query->bindParam(':FixtureNo', $fixtureno, PDO::PARAM_INT);
        */

        /** 
        * assign the values to the place holders - 
        * no placeholders used in the sql statement
        * $fixtureno = $fixture['FixtureNo'];
        */

        /** 
        * execute the query and check if it fails 
        * have to return something formatted as JSON to the calling PHP file
        */

        // execute the sql query
        $query -> execute();
                                        
        // get all rows
        $rows = $query -> fetchAll(PDO::FETCH_OBJ);

        $html .= "  <div id='total-goals'> \n"
               . "      <div class='stat-title'>Total Goals</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>No Value Found</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $totalgoals = $row -> TotalGoals;

            $html .= "      <div class='stat-value'>" . $row -> TotalGoals . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // END OF TOTAL GOALS SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // AVERAGE GOALS PER GAME
    // ---------------------------------------------------------------

    if ($totalgoals > 0 && $gamesplayed > 0) {
        $gameaverage = number_format( ($totalgoals / $gamesplayed), 2);
    } else {
        $gameaverage = 0; 
    };

    $html .= "  <div id='goals-per-game'> \n"
           . "      <div class='stat-title'>Goals Per Game</div> \n"
           . "      <div class='stat-value'>" . $gameaverage . "</div> \n"
           . "  </div> \n";

    // ---------------------------------------------------------------
    // END OF AVERAGE GOALS PER GAME
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // TEAM WITH MOST GOALS
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
            . "    	tm.Team as Team, \n"
            . "    	COUNT(TeamID) as GoalsPerTeam \n"
            . "  FROM  \n"
            . "    	GoalsScored gs \n"
            . "    	INNER JOIN  \n"
            . "    		Teams tm  \n"
            . "    	   ON \n"
            . "    		gs.TeamID = tm.ID \n"   	
            . "    	GROUP BY \n"
            . "    		TeamID \n"
            . "    	ORDER BY \n"
            . "    		GoalsPerTeam \n"
            . "    	DESC \n"
            . "    	LIMIT  \n"
            . "    		1 \n";

        // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        /** bind the parameters
        * no parameters used in this query
        * $query->bindParam(':FixtureNo', $fixtureno, PDO::PARAM_INT);
        */

        /** 
        * assign the values to the place holders - 
        * no placeholders used in the sql statement
        * $fixtureno = $fixture['FixtureNo'];
        */

        /** 
        * execute the query and check if it fails 
        * have to return something formatted as JSON to the calling PHP file
        */

        // execute the sql query
        $query -> execute();
                                        
        // get all rows
        $rows = $query -> fetchAll(PDO::FETCH_OBJ);

        $html .= "  <div id='top-team'> \n"
               . "      <div class='stat-title'>Most Goals By Team</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $html .= "      <div class='stat-value'>" . $row -> GoalsPerTeam . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // END OF TEAM WITH MOST GOALS
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // GAME WITH MOST GOALS
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
         . "    (HomeScore + AwayScore) as TotalScore \n"
         . "    FROM  \n"
         . "    	Fixtures \n"
         . "    ORDER BY \n"
         . "    	TotalScore DESC \n"
         . "    LIMIT 1 \n";

            // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        /** bind the parameters
        * no parameters used in this query
        * $query->bindParam(':FixtureNo', $fixtureno, PDO::PARAM_INT);
        */

        /** 
        * assign the values to the place holders - 
        * no placeholders used in the sql statement
        * $fixtureno = $fixture['FixtureNo'];
        */

        /** 
        * execute the query and check if it fails 
        * have to return something formatted as JSON to the calling PHP file
        */

        // execute the sql query
        $query -> execute();
                                        
        // get all rows
        $rows = $query -> fetchAll(PDO::FETCH_OBJ);

        $html .= "  <div id='top-game'> \n"
               . "      <div class='stat-title'>Most Goals In A Game</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>No Value Found</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $html .= "      <div class='stat-value'>" . $row -> TotalScore . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // END OF GAME WITH MOST GOALS
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // PENALTIES  SO FAR
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
            . "    	COUNT(ID) as Penalties \n"
            . "  FROM  \n"
            . "    	GoalsScored \n"
            . "  WHERE \n"
            . "    	Penalty = 1 \n";

        // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        /** bind the parameters
        * no parameters used in this query
        * $query->bindParam(':FixtureNo', $fixtureno, PDO::PARAM_INT);
        */

        /** 
        * assign the values to the place holders - 
        * no placeholders used in the sql statement
        * $fixtureno = $fixture['FixtureNo'];
        */

        /** 
        * execute the query and check if it fails 
        * have to return something formatted as JSON to the calling PHP file
        */

        // execute the sql query
        $query -> execute();
                                        
        // get all rows
        $rows = $query -> fetchAll(PDO::FETCH_OBJ);

        $html .= "  <div id='penalties'> \n"
               . "      <div class='stat-title'>Penalties</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $html .= "      <div class='stat-value'>" . $row -> Penalties . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // PENALTIES SO FAR
    // ---------------------------------------------------------------

    // return Success message
    echo "Competition Statistics Updated";

    // write the HTML to the file
    fwrite($fh, $html);
    // close the file handle
    fclose($fh);

?>  