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
    $userid = trim(file_get_contents("php://input"));

    // use this when testing
    // $userid = 2;

    // // If logged in store the userid from session 
    // if ( isset($_SESSION['userid']) ) {
    //     $userid = $_SESSION["userid"];    
    // }; 

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    };

    $qry = "    SELECT \n" 
            . "  	FixtureNo		as fixtureno, \n"
            . "  	DatePlayed		as dateplayed, \n"
            . "  	TimePlayed		as timeplayed, \n"
            . "  	HomeScore		as homescore, \n"
            . "  	AwayScore		as awayscore, \n"
            . "  	grp.Description as groupdesc, \n"
            . "  	rnd.Code        as roundcode,  \n"
            . "  	vnu.City		as city, \n"
            . "  	vnu.Stadium		as stadium, \n"
            . "  	hmt.ID 			as homeid, \n"
            . "  	hmt.Team 		as hometeam, \n"
            . "  	hmt.Ranking 	as homerank, \n"
            . "  	awt.Ranking 	as awayrank, \n"
            . "  	awt.Team 		as awayteam, \n"
            . "  	awt.ID 			as awayid, \n"
            . "  	res.Code		as resultcode, \n"
            . "  	res.Description	as resultdesc \n"
            . "FROM  \n"
            . "  	Fixtures fx \n"
            . "INNER JOIN \n"
            . "  	GroupStage grp \n"
            . "ON \n"
            . "  	fx.GroupID = grp.ID \n"
            . "INNER JOIN \n"
            . "  	Rounds rnd \n"
            . "ON \n"
            . "  	fx.RoundID = rnd.ID \n"
            . "INNER JOIN \n"
            . "  	Venues vnu \n"
            . "ON \n"
            . "  	fx.VenueID = vnu.ID \n"
            . "INNER JOIN \n"
            . "  	Teams hmt \n"
            . "ON \n"
            . "  	fx.HomeTeamID = hmt.ID \n"
            . "INNER JOIN \n"
            . "  	Teams awt \n"
            . "ON \n"
            . "  	fx.AwayTeamID = awt.ID \n"
            . "INNER JOIN \n"
            . "  	Results res \n"
            . "ON \n"
            . "  	fx.ResultID = res.ID \n"
            . "ORDER BY \n"
            . "  	FixtureNo \n";

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
        $fixtures = $query -> fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() == 0) {
            echo "<div>NO RESULTS RETURNED</div>";
            exit;
        } else {

            // echo "  <div id='results-tbl'>";
            // echo "      <table>";
            // echo "          <thead class='greenheader'>";
            // echo "              <tr>";
            // echo "                  <th class='tbl-header' colspan='10'>FIXTURES / RESULTS</th>";
            // echo "              </tr>";
            // echo "              <tr>";
            // echo "                  <th>No</th><th class='hidden'><th class='hidden'></th><th colspan='2'>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th>";
            // echo "                  <th class='hidden'></th> <th colspan='2'>AWAY</th><th class='res-header'>Res</th>";
            // echo "              </tr>";
            // echo "          </thead>";
            // echo "          <tbody>";

            // create the arrays to hold the arrays for each result
            // create an array for each result and push it to the results array
            $results = array();
            $res     = array();

            // loop through the results
            foreach($fixtures as $key => $fixture) {

                $fixno      = $fixture -> fixtureno;
                $homeid     = $fixture -> homeid;
                $hometeam   = $fixture -> hometeam;
                $homerank   = $fixture -> homerank;
                $homescore  = $fixture -> homescore;
                $awayrank   = $fixture -> awayrank;
                $awayteam   = $fixture -> awayteam;
                $awayid     = $fixture -> awayid;
                $awayscore  = $fixture -> awayscore;
                $rndcode    = $fixture -> roundcode;
                $resultcode = $fixture -> resultcode;

                $res = array(
                            "fixtureno"     => $fixno,
                            "hometeamid"    => $homeid,
                            "homescore"     => $homescore,
                            "awayscore"     => $awayscore,
                            "awayteamid"    => $awayid,
                            "resultcode"    => $resultcode,
                            "stage"         => $rndcode
                            );

                array_push($results, $res);

                // echo "  <tr>";
                // echo "      <td class='predno'>" . $fixno . "</td>";
                // echo "      <td class='stage hidden'>" . $rndcode . "</td>";                                // hidden cell for code of the tournament stage 
                // echo "      <td class='homeid hidden'>" . $homeid . "</td>";                                // hidden cell for ID of home team
                // echo "      <td class='results-home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>";      
                // echo "      <td class='home'>" . $hometeam . "</td>";
                // echo "      <td class='h-rank'>" . $homerank . "</td>";
                // echo "      <td>" . $homescore . "</td>";
                // echo "      <td>" . $awayscore . "</td>";
                // echo "      <td class='a-rank'>" . $awayrank . "</td>";
                // echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                // echo "      <td class='away'>" . $awayteam . "</td>";
                // echo "      <td class='results-away-flag'><img src='../img/teams/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>";      
                // echo "      <td class='res'>" . $resultcode . "</td>";
                // echo "  </tr>";

            }; // end of results foreach 

            // echo "          </tbody>";
            // echo "      </table>";   
            // echo "  </div>  <!-- end of results-tbl div -->";     

        };  // end of $query->rowCount() else

    // echo "</div> <!-- end of results -->";

    // echo "<div id='predictions'>"; 

    $qry =   "SELECT \n"
        . "  	    pred.UserID     as userid, \n"
        . "  		pred.FixtureID  as fixtureno, \n"
        . "  		pred.Stage      as stage, \n" 
        . "  		pred.HomeScore  as homescore, \n" 
        . "  		pred.AwayScore  as awayscore, \n" 
        . "  		fx.GroupID      as groupid, \n"
        . "  	    hmt.ID          as homeid, \n"
        . "  		hmt.Team        as hometeam, \n" 
        . "  		hmt.Ranking     as homerank, \n"
        . "  		awt.Ranking     as awayrank, \n"
        . "  		awt.Team        as awayteam, \n"
        . "  		awt.ID          as awayid, \n"
        . "  	    res.Code		as resultcode, \n"
        . "  	    res.Description	as resultdesc \n"
        . "  	FROM \n"
        . "  		Predictions pred \n" 
        . "  	INNER JOIN \n"						
        . "  			Fixtures fx \n"
        . "  		ON \n" 
        . "  			pred.FixtureID = fx.FixtureNo \n"
        . "  	INNER JOIN \n"						 
        . "  			Teams hmt \n" 
        . "  		ON \n" 
        . "  			pred.HomeTeam = hmt.ID \n" 
        . "  	INNER JOIN \n"						 
        . "  			Teams awt \n"
        . "  		ON \n"
        . "  			pred.AwayTeam = awt.ID \n" 
        . "     INNER JOIN \n"
        . "  	    Results res \n"
        . "     ON \n"
        . "  	    pred.ResultID = res.ID \n"
        . "WHERE  \n"
        // . "     pred.UserID = " . $userid . "\n"
        . "     pred.UserID = :UserID \n"
        . "  ORDER BY \n"
        . "  	  pred.FixtureID \n";

        // prepare the query for the database connection
        $query = $dbh -> prepare($qry);

        /** bind the parameters */
        $query->bindParam(':UserID', $userid, PDO::PARAM_INT);

        /** assign the values to the place holders 
         this is will be passed by the fetch
        $userid = 1;
         */

        /** 
        * execute the query and check if it fails 
        * have to return something formatted as text to the calling PHP file
        */

        // execute the sql query
        $query -> execute();
                                        
        // get all rows
        $predictions = $query -> fetchAll(PDO::FETCH_OBJ);

        /** 
        string to hold the html to be passed back to the saved-predictions page
        need to build this as the script to execute the total points doesnt execute when returned to the saved-predictions apge
        */

        $html = "";

        if ($query->rowCount() == 0) {
            echo "<div>NO PREDICTIONS RETURNED</div>";
            exit;
        } else {
            // echo "  <div id='predictions-tbl'>";
            // echo "      <table>";
            // echo "          <thead class='blueheader'>";
            // echo "              <tr>";
            // echo "                  <th class='tbl-header' colspan='9'>PREDICTIONS / POINTS</th><th id='points-total' colspan='3'>Points : </th>";
            // echo "              </tr>";
            // echo "              <tr>";
            // echo "              <tr>";
            // echo "                  <th>No.</th><th class='hidden'><th class='hidden'></th><th colspan='2'>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th>";
            // echo "                  <th class='hidden'></th> <th colspan='2'>AWAY</th><th class='res-header'>Res</th><th class='res-header'>Pts</th><th class='res-header'>Bonus</th>";
            // echo "              </tr>";
            // echo "          </thead>";
            // echo "          <tbody>";

            // create the arrays to hold the arrays for each result
            // create an array for each result and push it to the results array
            $predicts = array();
            $predict  = array();

            // loop through the predictions
            foreach($predictions as $key => $prediction) {

                $userid     = $prediction -> userid;
                $fixno      = $prediction -> fixtureno;
                $homeid     = $prediction -> homeid;
                $hometeam   = $prediction -> hometeam;
                $homescore  = $prediction -> homescore;
                $homerank   = $prediction -> homerank;
                $awayrank   = $prediction -> awayrank;
                $awayscore  = $prediction -> awayscore;
                $awayteam   = $prediction -> awayteam;
                $awayid     = $prediction -> awayid;
                $grpdesc    = $prediction -> groupdesc;
                $rndcode    = $prediction -> roundcode;
                $resultcode = $prediction -> resultcode;
                $resultdesc = $prediction -> resultdesc;
                $stage      = $prediction -> stage;

                $predict = array(
                            "fixtureno"  => $fixno,
                            "hometeamid" => $homeid,
                            "homescore"  => $homescore,
                            "awayscore"  => $awayscore,
                            "awayteamid" => $awayid,
                            "resultcode" => $resultcode,
                            "stage"      => $stage
                            );

                array_push($predicts, $predict);

                $pts    = 0; 
                $bonus  = 0;

                $r   = $results[$fixno-1];
                $p   = $predict;

                if ($r["resultcode"] == $p["resultcode"]) {

                    $pts = $pts + 1;
                    
                    if ( ($r["homescore"] == $p["homescore"]) && ($r["awayscore"] == $p["awayscore"])) {
                        $pts = $pts + 2;
                    };
                };

                if ( ($r["hometeamid"] == $p["hometeamid"]) ) {

                    if ($p["stage"] == "QF") {                                
                        $bonus = $bonus + 1;
                    } if ($p["stage"] == "SF") {
                        $bonus = $bonus + 2;
                    } if ($p["stage"] == "FI") {
                        $bonus = $bonus + 3;
                    };
                };

                if ( ($r["awayteamid"] == $p["awayteamid"]) ) {

                    if ($p["stage"] == "QF") {                                
                        $bonus = $bonus + 1;
                    } if ($p["stage"] == "SF") {
                        $bonus = $bonus + 2;
                    } if ($p["stage"] == "FI") {
                        $bonus = $bonus + 3;
                    };
                };

                // echo "<script>console.log(" . $TotalPoints . " - " . $pts . " - " . $bonus . ");" . "</script>;";

                // echo "<script>console.log('Points : '" . $pts . ',' . $bonus . ',' . $TotalPoints . "');</script>";

                $TotalPoints = $TotalPoints + ($pts + $bonus);

                // colorize the stages to identify the QF, SF and FI
                if ($stage === "QF") {
                    $rowclass = "  <tr class='qf-color'>";
                } else if ($stage === "SF") {
                    $rowclass = "  <tr class='sf-color'>";
                } else if ($stage === "FI") {
                    $rowclass = "  <tr class='fi-color'>";
                } else {
                    $rowclass = "  <tr>";
                }

                $html = $html 
                        . $rowclass 
                        . "      <td class='predno'>" . $fixno . "</td>"
                        . "      <td class='stage hidden'>" . $stage . "</td>" 
                        . "      <td class='homeid hidden'>" . $homeid . "</td>"
                        . "      <td class='predictions-home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>"      
                        . "      <td class='home'>" . $hometeam . "</td>"
                        . "      <td class='h-rank'>" . $homerank . "</td>"
                        . "      <td class='pos'>" . $homescore . "</td>"
                        . "      <td class='pos'>" . $awayscore . "</td>"
                        . "      <td class='a-rank'>" . $awayrank . "</td>"
                        . "      <td class='awayid hidden'>" . $awayid . "</td>"
                        . "      <td class='away'>" . $awayteam . "</td>"
                        . "      <td class='predictions-away-flag'><img src='../img/teams/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>"      
                        . "      <td class='res'>" . $resultcode . "</td>"
                        . "      <td class='pts'>" . $pts . "</td>"
                        . "      <td class='bon'>" . $bonus . "</td>"
                        . "  </tr>";

                // echo "  <tr>";
                // echo "      <td class='predno'>" . $fixno . "</td>";
                // echo "      <td class='stage hidden'>" . $rndcode . "</td>";                                // hidden cell for code of the tournament stage 
                // echo "      <td class='homeid hidden'>" . $homeid . "</td>";                                // hidden cell for ID of home team
                // echo "      <td class='predictions-home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>";      
                // echo "      <td class='home'>" . $hometeam . "</td>";
                // echo "      <td class='h-rank'>" . $homerank . "</td>";
                // echo "      <td class='pos'>" . $homescore . "</td>";
                // echo "      <td class='pos'>" . $awayscore . "</td>";
                // echo "      <td class='a-rank'>" . $awayrank . "</td>";
                // echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                // echo "      <td class='away'>" . $awayteam . "</td>";
                // echo "      <td class='predictions-away-flag'><img src='../img/teams/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>";      
                // echo "      <td class='res'>" . $resultcode . "</td>";
                // echo "      <td class='pts'>" . $pts . "</td>";
                // echo "      <td class='bon'>" . $bonus . "</td>";
                // echo "  </tr>";
            }

            $html = "  <div id='predictions-tbl'>"
                . "      <table>"
                . "          <thead class='blueheader'>"
                . "              <tr>"
                . "                  <th class='tbl-header' colspan='9'>PREDICTIONS / POINTS</th><th id='points-total' colspan='3'>User " . $userid . " Pts : " . $TotalPoints . "</th>"
                . "              </tr>"
                . "              <tr>"
                . "              <tr>"
                . "                  <th>No.</th><th class='hidden'><th class='hidden'></th><th colspan='2'>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th>"
                . "                  <th class='hidden'></th> <th colspan='2'>AWAY</th><th class='res-header'>Res</th><th class='res-header'>Pts</th><th class='res-header'>Bonus</th>"
                . "              </tr>"
                . "          </thead>"
                . "          <tbody>" 
                . $html
                . "          </tbody>"
                . "      </table>"
                . "  </div>  <!-- end of predictions-tbl div -->";     

        // echo "          </tbody>";
        // echo "      </table>";   
        // echo "  </div>  <!-- end of predictions-tbl div -->";     
    };

    // echo "<script>console.log(" . $TotalPoints . ");</script>;";
    // echo "<script>document.getElementById('points-total').innerText = 'Points : " . $TotalPoints . "'</script>";

    // return the HTML back to the calling page
    echo $html;

    // <!-- end of the predictions php -->

?>  