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

    // $qry = "  SELECT \n" 
    //         . "     FixtureNo		as fixtureno, \n"
    //         . "    	DatePlayed		as dateplayed, \n"
    //         . "    	TimePlayed		as timeplayed, \n"
    //         . "    	HomeScore		as homescore, \n"
    //         . "    	AwayScore		as awayscore, \n"
    //         . "    	ResultID		as resultid, \n"
    //         . "    	grp.Description as groupdesc, \n"
    //         . "    	rnd.Description as rounddesc,  \n"
    //         . "    	vnu.City		as city, \n"
    //         . "    	vnu.Stadium		as stadium, \n"
    //         . "    	hmt.Team 		as hometeam, \n"
    //         . "    	awt.Team 		as awayteam \n"
    //         . "    FROM  \n"
    //         . "    	Fixtures fx \n"
    //         . "    INNER JOIN \n"
    //         . "    	GroupStage grp \n"
    //         . "    ON \n"
    //         . "    	fx.GroupID = grp.ID \n"
    //         . "    INNER JOIN \n"
    //         . "    	Rounds rnd \n"
    //         . "    ON \n"
    //         . "    	fx.RoundID = rnd.ID \n"
    //         . "    INNER JOIN \n"
    //         . "    	Venues vnu \n"
    //         . "    ON \n"
    //         . "    	fx.VenueID = vnu.ID \n"
    //         . "    INNER JOIN \n"
    //         . "    	Teams hmt \n"
    //         . "    ON \n"
    //         . "    	fx.HomeTeamID = hmt.ID \n"
    //         . "    INNER JOIN \n"
    //         . "    	Teams awt \n"
    //         . "    ON \n"
    //         . "    	fx.AwayTeamID = awt.ID \n"
    //         . "    WHERE \n"
    //         . "     resultid <> 6 AND DatePlayed = DATE_FORMAT(NOW(), '%Y/%m/%d' ) \n"
    //         . "    ORDER BY \n"  
    //         . "      TimePlayed DESC \n"
    //         . "    LIMIT 3";

    $qry =   "SELECT \n"  
	        . "  * \n"
            . "FROM \n" 
	        . "( \n"
            . "  SELECT \n" 
            . "     FixtureNo		as fixtureno, \n"
            . "    	DatePlayed		as dateplayed, \n"
            . "    	TimePlayed		as timeplayed, \n"
            . "    	HomeScore		as homescore, \n"
            . "    	AwayScore		as awayscore, \n"
            . "    	ResultID		as resultid, \n"
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
            . "     resultid <> 6 \n"
            . "    ORDER BY \n"  
            . "      FixtureNo DESC \n"
            . "    LIMIT 4"
            . ") FixturesByTimePlayed \n" 
            . "ORDER BY \n" 
	        . "  TimePlayed DESC \n"
            . "LIMIT 3";
            
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

        // open the file for writing
        $fh = fopen("../static/latest-results.html", "w");

        if ($query->rowCount() == 0) {

            $html .= "  <div class='latest-results-tbl'>"
                    . "      <table>"
                    . "          <thead class='blueheader'>"
                    . "              <tr>"
                    . "                  <th class='align-center' colspan='7'>Qatar World Cup 2022</th>"
                    . "              </tr>"
                    . "              <tr>"
                    . "                  <th class='align-center' colspan='7'>Tournament Has Not Started</th>"
                    . "              </tr>"
                    . "          </thead>"
                    . "          <tbody>"
                    . "              <tr>"
                    . "                  <td> - </td>"
                    . "              </tr>"
                    . "              <tr>"
                    . "                  <td><strong>Tournament Starts 20 November 2022</strong></td>"
                    . "              </tr>"
                    . "              <tr>"
                    . "                  <td> - </td>"
                    . "              </tr>"
                    . "          </tbody>"
                    . "      </table>"   
                    . "  </div>  <!-- end of latest-results-tbl div -->"; 

            echo "Failure - No Results Updated";

        } else {
            // initial the string to hold the HTML
            $html = "";

            foreach($results as $key => $result) {
            
                $dateplayed = $result -> dateplayed;
                $timeplayed = $result -> timeplayed;
                $group      = $result -> groupdesc;
                $round      = $result -> rounddesc;
                $stadium    = $result -> stadium;
                $city       = $result -> city;
                $hometeam   = $result -> hometeam;
                $awayteam   = $result -> awayteam;
                $homescore  = $result -> homescore;
                $awayscore  = $result -> awayscore;

                $html .= "  <div class='latest-results-tbl'>"
                      . "      <table>"
                      . "          <thead class='blueheader'>"
                      . "              <tr>"
                      . "                  <th class='align-center' colspan='7'>" . $stadium . " - ". $city . "</th>"
                      . "              </tr>"
                      . "              <tr>"
                      . "                  <th class='align-center' colspan='7'>" . $group . " - " . $dateplayed . " - " . $timeplayed . "</th>"
                      . "              </tr>"
                      . "          </thead>"
                      . "          <tbody>"
                      . "              <tr>"
                      . "                  <td class='team'>" . $hometeam . "</td>"
                      . "                  <td class='country-flag'><img src='img/flags/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>"
                      . "                  <td class='versus'>" . htmlspecialchars($homescore) . " - " . htmlspecialchars($awayscore) . "</td>" 
                      . "                  <td class='country-flag'><img src='img/flags/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>"
                      . "                  <td class='team'>" . $awayteam . "</td>"
                      . "              </tr>"
                      . "          </tbody>"
                      . "      </table>"   
                      . "  </div>  <!-- end of latest-results-tbl div -->"; 

            }; // end of users foreach 

            echo "Success - Latest Results Updated";

        };  // end of $query->rowCount() else

    // write the HTML to the file
    fwrite($fh, $html);
    // close the file handle
    fclose($fh);
    
?>  