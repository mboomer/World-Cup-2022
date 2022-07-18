<?php
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // checks if session exists
    session_start();

    // $_SESSION["worldcup"]  = true;
    // $_SESSION["loggedin"]  = true;
    // $_SESSION["userid"]    = $userid;                            
    // $_SESSION["username"]  = $username;                            
    // $_SESSION["useremail"] = $email;

    //Receive the RAW data from the fetch POST
    $users = trim(file_get_contents("php://input"));

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

        if ($query->rowCount() == 0) {
            echo "<div>NO GOALS RETURNED</div>";
            exit;
        } else {

            echo "  <div id='goal-tbl'>";
            echo "      <table>";
            echo "          <thead class='blueheader'>";
            echo "              <tr>";
            echo "                  <th class='team-flag'>Team</th><th class='align-left'>Player</th><th class='cols'>Scored</th><th class='cols'>Penalties</th>";
            echo "              </tr>";
            echo "          </thead>";
            echo "          <tbody>";

            foreach($goals as $key => $goal) {

                $team      = $goal -> country;
                $player    = $goal -> scorer;
                $scored    = $goal -> scored;
                $penalties = $goal -> pemalties;

                echo "  <tr>";
                echo "      <td class='team-flag'><img src='img/flags/" . $team . ".png' alt='" . $team . " team flag'></td>";
                echo "      <td class='align-left'>" . $player . "</td>"; 
                echo "      <td class='cols'>" . $scored . "</td>"; 
                echo "      <td class='cols'>" . $penalties . "</td>"; 
                echo "  </tr>";

            }; // end of users foreach 

            echo "          </tbody>";
            echo "      </table>";   
            echo "  </div>  <!-- end of goals-tbl div -->"; 

        };  // end of $query->rowCount() else

?>  