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
           . "      <div class='stat-title'>Games Played</div> \n";

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
               . "      <div class='stat-title'>Goals Scored</div> \n";

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
               . "      <div class='stat-title'>Most Goals - Team</div> \n";

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
         . "    WHERE  \n"
         . "        HomeScore != 'NULL' \n"
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
               . "      <div class='stat-title'>Most Goals - Game</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div id='is_null' class='stat-value'>0</div> \n";

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
    // PENALTIES AWARDED SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // PENALTIES SAVED SO FAR
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
            . "    	SUM(PenaltysSaved) as Saved \n"
            . "  FROM  \n"
            . "    	TeamStats";

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

        $html .= "  <div id='penalties-saved'> \n"
               . "      <div class='stat-title'>Penalties Saved</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $html .= "      <div class='stat-value'>" . $row -> Saved . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // PENALTIES SAVED SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // OWN GOALS SCORED SO FAR
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
            . "    	COUNT(ID) as OwnGoals \n"
            . "  FROM  \n"
            . "    	GoalsScored \n"
            . "  WHERE \n"
            . "    	OwnGoal = 1 \n";

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

        $html .= "  <div id='owngoals'> \n"
               . "      <div class='stat-title'>Own Goals</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $html .= "      <div class='stat-value'>" . $row -> OwnGoals . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // OWN GOALS SCORED SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // RED CARDS SO FAR
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
            . "    	SUM(RedCards) as RedCards \n"
            . "  FROM  \n"
            . "    	TeamStats";

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

        $html .= "  <div id='red-cards'> \n"
               . "      <div class='stat-title'>Red Cards</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $html .= "      <div class='stat-value'>" . $row -> RedCards . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // RED CARDS SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // YELLOW CARDS SO FAR
    // ---------------------------------------------------------------
    $qry = "  SELECT \n" 
            . "    	SUM(YellowCards) as YellowCards \n"
            . "  FROM  \n"
            . "    	TeamStats";

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

        $html .= "  <div id='yellow-cards'> \n"
               . "      <div class='stat-title'>Yellow Cards</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            $html .= "      <div class='stat-value'>" . $row -> YellowCards . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // YELLOW CARDS SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // TEAM WITH MOST CARDS SO FAR
    // ---------------------------------------------------------------

    $qry = "  SELECT \n" 
            . " TM.Team AS TeamName, \n"
            . " SUM(RedCards + YellowCards) AS TotalCards \n"
            . "FROM \n" 
            . "	TeamStats TS \n"
            . "INNER JOIN \n"
            . "	Teams TM \n"
            . "ON \n"
            . "	TS.TeamID = TM.ID \n"
            . "GROUP BY \n"
            . "	TS.TeamID \n"
            . "ORDER BY \n"
            . "	TotalCards \n"
            . "DESC \n"
            . "LIMIT 1";

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

        $html .= "  <div id='most-cards'> \n"
               . "      <div class='stat-title'>Most Cards - Team</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {

            if ($row -> TotalCards == 0) {
                $html .= "      <div class='stat-value'>&nbsp;</div> \n";
            } else {
                $html .= "      <div class='stat-value'>" . $row -> TeamName . "</div> \n";
            };

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // TEAM WITH MOST CARDS SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // AVERAGE CORNERS PER GAME SO FAR
    // ---------------------------------------------------------------

    $qry = "  SELECT \n" 
            . " SUM(CornersBy) AS Corners \n"
            . "FROM \n" 
            . "	TeamStats \n";

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

        $html .= "  <div id='average-corners'> \n"
               . "      <div class='stat-title'>Corners per game</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            if ($gamesplayed > 0) {
                $corneraverage = number_format( ($row -> Corners / $gamesplayed), 2);
            } else {
                $corneraverage = 0; 
            };

            $html .= "      <div class='stat-value'>" . $corneraverage . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // AVERAGE CORNERS PER GAME SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // AVERAGE THROWINS PER GAME SO FAR
    // ---------------------------------------------------------------

    $qry = "  SELECT \n" 
            . " SUM(ThrowinsBy) AS Throwins \n"
            . "FROM \n" 
            . "	TeamStats \n";

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

        $html .= "  <div id='average-throwins'> \n"
               . "      <div class='stat-title'>Throw-Ins per game</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            if ($gamesplayed > 0) {
                $throwinaverage = number_format( ($row -> Throwins / $gamesplayed), 2);
            } else {
                $throwinaverage = 0; 
            };

            $html .= "      <div class='stat-value'>" . $throwinaverage . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // AVERAGE THROWINS PER GAME SO FAR
    // ---------------------------------------------------------------

    // ---------------------------------------------------------------
    // AVERAGE FOULS PER GAME SO FAR
    // ---------------------------------------------------------------

    $qry = "  SELECT \n" 
            . " SUM(FoulsBy) AS Fouls \n"
            . "FROM \n" 
            . "	TeamStats \n";

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

        $html .= "  <div id='average-fouls'> \n"
               . "      <div class='stat-title'>Fouls per game</div> \n";

        if ($query->rowCount() == 0) {

              $html .= "      <div class='stat-value'>0</div> \n";

        } else {

        foreach($rows as $key => $row) {
        
            if ($gamesplayed > 0) {
                $foulsaverage = number_format( ($row -> Fouls / $gamesplayed), 2);
            } else {
                $foulsaverage = 0; 
            };

            $html .= "      <div class='stat-value'>" . $foulsaverage . "</div> \n";

        }; // end of foreach 

        };  // end of $query->rowCount() else    

        $html .= "  </div> \n";

    // ---------------------------------------------------------------
    // AVERAGE FOULS PER GAME SO FAR
    // ---------------------------------------------------------------

    // return Success message
    echo "Competition Statistics Updated";

    // write the HTML to the file
    fwrite($fh, $html);
    // close the file handle
    fclose($fh);

?>  