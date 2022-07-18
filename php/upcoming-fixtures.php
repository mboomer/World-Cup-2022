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
            . "    WHERE  \n"
            . "    	fx.DatePlayed = CURRENT_DATE() \n"
            . "    ORDER BY \n"
            . "    	DATE(DatePlayed) \n";    

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
        $results = $query -> fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() == 0) {
            echo "<div>NO GOALS RETURNED</div>";
            exit;
        } else {

            foreach($results as $key => $result) {
            
                $dateplayed = $result -> dateplayed;
                $timeplayed = $result -> timeplayed;
                $group      = $result -> groupdesc;
                $round      = $result -> rounddesc;
                $stadium    = $result -> stadium;
                $city       = $result -> city;
                $hometeam   = $result -> hometeam;
                $awayteam   = $result -> awayteam;

                echo "  <div class='upcoming-fixtures-tbl'>";
                echo "      <table>";
                echo "          <thead class='blueheader'>";
                echo "              <tr>";
                echo "                  <th class='align-center' colspan='7'>" . $stadium . " - ". $city . "</th>";
                echo "              </tr>";
                echo "              <tr>";
                echo "                  <th class='align-center' colspan='7'>" . $group . "</th>";
                echo "              </tr>";
                echo "          </thead>";
                echo "          <tbody>";
                echo "              <tr>";
                echo "                  <td class='team'>" . $hometeam . "</td>";
                echo "                  <td class='country-flag'><img src='img/flags/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>";
                echo "                  <td class='versus'>" . $timeplayed . "</td>"; 
                echo "                  <td class='country-flag'><img src='img/flags/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>";
                echo "                  <td class='team'>" . $awayteam . "</td>";
                echo "              </tr>";
                echo "          </tbody>";
                echo "      </table>";   
                echo "  </div>  <!-- end of goals-tbl div -->"; 

            }; // end of users foreach 

        };  // end of $query->rowCount() else

?>  