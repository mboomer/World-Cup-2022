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

    $qry = "  SELECT \n" 
            . "    TeamID as teamid, \n"
            . "    tm.Team as country, \n"
            . "    Player as scorer, \n"
            . "    COUNT(Player) as scored, \n"
            . "    SUM(Penalty) as penalties \n"
            . "FROM \n"
            . "    GoalsScored as gs \n"
            . "INNER JOIN \n"
            . "    Teams tm \n"
            . "ON \n"
            . "    gs.TeamID = tm.ID \n"
            . "GROUP BY \n"
            . "    Player \n"
            . "ORDER BY \n"
            . "    scored DESC \n"
            . "LIMIT 10 \n";

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
        $goals = $query -> fetchAll(PDO::FETCH_OBJ);

        // open file for writing
        $fh = fopen("../static/top-goal-scorers.html", "w"); 

        $html = "";

        $html = "  <div id='goal-tbl'>"
                . "    <table>"
                . "        <thead class='blueheader'>"
                . "            <tr>"
                . "                <th class='team-flag'>Team</th><th class='align-left'>Player</th><th class='cols'>Scored</th><th class='cols'>Penalties</th>"
                . "             </tr>"
                . "        </thead>"
                . "    <tbody>";

        if ($query->rowCount() == 0) {

            echo "Failure - No Goal Scorers Returned";

            $html .= "       <tr>"
                  .  "          <td></th><th></th><th></th><th></th>"
                  .  "       </tr>";

        } else {

            foreach($goals as $key => $goal) {

                $team      = $goal -> country;
                $player    = $goal -> scorer;
                $scored    = $goal -> scored;
                $penalties = $goal -> penalties;

                $html .= "  <tr>"
                      . "      <td class='team-flag'><img src='img/flags/" . $team . ".png' alt='" . $team . " team flag'></td>"
                      .  "      <td class='align-left'>" . htmlspecialchars($player) . "</td>" 
                      .  "      <td class='cols'>" . htmlspecialchars($scored) . "</td>"
                      .  "      <td class='cols'>" . htmlspecialchars($penalties) . "</td>"
                      .  "  </tr>";

            }; // end of users foreach 

            echo "Success - Top Goal Scorer Updated";

        };  // end of $query->rowCount() else

        $html .= "          </tbody>"
              .  "      </table>"
              .  "  </div>  <!-- end of goals-tbl div -->"; 

    // write the HTML to the file
    fwrite($fh, $html);
    // close the file handle
    fclose($fh);
    
?>  