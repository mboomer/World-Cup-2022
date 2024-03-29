<?php
    // Include config file
    require_once "../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);

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
    // $userid = 1;

    // If logged in store the userid from session 
    if ( isset($_SESSION['userid']) ) {
        $userid = $_SESSION["userid"];    
    }; 

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

            }; // end of results foreach     

        };  // end of $query->rowCount() else

    $qry =   "SELECT \n"
        . "  	    pred.UserID     as userid, \n"
        . "  		pred.FixtureID  as fixtureno, \n"
        . "  		pred.Stage      as stage, \n" 
        . "  		pred.HomeScore  as homescore, \n" 
        . "  		pred.AwayScore  as awayscore, \n" 
        . "  		usr.UserName    as username, \n" 
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
        . "  			Users usr \n"
        . "  		ON \n" 
        . "  			pred.UserID = usr.ID \n"
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

            // create the arrays to hold the arrays for each result
            // create an array for each result and push it to the results array
            $predicts = array();
            $predict  = array();

            // counter to count if prediction has correct score, result, hometeam and away team
            $correct = 0;

            // loop through the predictions
            foreach($predictions as $key => $prediction) {

                // flag to indicate if prediction has correct score, result, hometeam and away team
                $isCorrect = false;

                $userid     = $prediction -> userid;
                $username   = $prediction -> username;
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

                $pts   = 0; 
                $bonus = 0;

                $r = $results[$fixno-1];
                $p = $predict;
                
                if ($r["resultcode"] == $p["resultcode"]) {
 
                    // result is correct
                    $isCorrect = true;

                    // display a green tick to indicate actual result and predicted result MATCH  
                    $resultchar = "&#10004;";
                    $resclass = "res res-match";

                    $pts = $pts + 1;
                    
                    if ( ($r["homescore"] == $p["homescore"]) && ($r["awayscore"] == $p["awayscore"])) {
                        // score is correct
                        $isCorrect = true;
                        $pts = $pts + 2;
                    } else {
                        $isCorrect = false;
                    };
                } else {
                        $isCorrect = false; 

                        if ($r["resultcode"] == "NP") {
                            $resultchar = $p["resultcode"];
                            $resclass = "res";
                        } else {
                            // display X to indicate actual result and predicted result DONT match  
                            $resultchar = "&cross;";
                            $resclass = "res res-nomatch";
                        };

                };

                if ( ($r["hometeamid"] == $p["hometeamid"]) ) {

                    if ($p["stage"] != "GS") {                                
                        // home team is correct
                        $isCorrect = true;
                    };                                

                    if ($p["stage"] == "LS") {                                
                        $bonus = $bonus + 1;
                    } else if ($p["stage"] == "QF") {                                
                        $bonus = $bonus + 2;
                    } else if ($p["stage"] == "SF") {
                        $bonus = $bonus + 3;
                    } else if ($p["stage"] == "PL") {                                
                        $bonus = $bonus + 4;
                    } else if ($p["stage"] == "FI") {
                        $bonus = $bonus + 4;
                    };

                } else {
                    // home team is not correct
                    $isCorrect = false;
                };

                if ( ($r["awayteamid"] == $p["awayteamid"]) ) {

                    if ($p["stage"] != "GS") {                                
                        // away team is correct
                        $isCorrect = true;
                    };                                
                         
                    if ($p["stage"] == "LS") {                                
                        $bonus = $bonus + 1;
                    } else if ($p["stage"] == "QF") {                                
                        $bonus = $bonus + 2;
                    } else if ($p["stage"] == "SF") {
                        $bonus = $bonus + 3;
                    } else if ($p["stage"] == "PL") {                                
                        $bonus = $bonus + 4;
                    } else if ($p["stage"] == "FI") {
                        $bonus = $bonus + 4;
                    };

                } else {
                    // away team is not correct
                    $isCorrect = false;
                };

                $TotalPoints = $TotalPoints + ($pts + $bonus);
                
                // if still true then increment counter
                if ($isCorrect === true) {
                    $correct = $correct + 1;
                };

                // colorize the stages to identify the LS, QF, SF, PL and FI
                if ($stage === "LS") {
                    $rowclass = "  <tr class='ls-color'>";
                } else if ($stage === "QF") {
                    $rowclass = "  <tr class='qf-color'>";
                } else if ($stage === "SF") {
                    $rowclass = "  <tr class='sf-color'>";
                } else if ($stage === "PL") {
                    $rowclass = "  <tr class='pl-color'>";
                } else if ($stage === "FI") {
                    $rowclass = "  <tr class='fi-color'>";
                } else {
                    $rowclass = "  <tr>";
                }

                // colorize the pts awarded for correct result
                if ($pts > 0) {
                    $ptsclass = "  <td class='points'>";
                } else {
                    $ptsclass = "  <td class='pts'>";
                }

                // colorize the bonus awarded for correct teams
                if ($bonus > 0) {
                    $bonusclass = "  <td class='bonus'>";
                } else {
                    $bonusclass = "  <td class='bon'>";
                }

                $html = $html 
                        . $rowclass 
                        . "      <td class='predno'>" . htmlspecialchars($fixno) . "</td>"
                        . "      <td class='stage hidden'>" . $stage . "</td>" 
                        . "      <td class='homeid hidden'>" . $homeid . "</td>"
                        . "      <td class='predictions-home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>"      
                        . "      <td class='home'>" . $hometeam . "</td>"
                        . "      <td class='h-rank'>" . $homerank . "</td>"
                        . "      <td class='pos'>" . htmlspecialchars($homescore) . "</td>"                     // Data input by user
                        . "      <td class='pos'>" . htmlspecialchars($awayscore) . "</td>"                     // DAta input by user
                        . "      <td class='a-rank'>" . $awayrank . "</td>"
                        . "      <td class='awayid hidden'>" . $awayid . "</td>"
                        . "      <td class='away'>" . $awayteam . "</td>"
                        . "      <td class='predictions-away-flag'><img src='../img/teams/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>"      
                        . "      <td class='" . $resclass . "'>" . $resultchar . "</td>"
                        . "      " . $ptsclass . $pts . "</td>"
                        . "      " . $bonusclass . $bonus . "</td>"
                        . "  </tr>";
            }

            $html = "  <div id='predictions-tbl'>"
                . "      <table>"
                . "          <thead class='blueheader'>"
                . "              <tr>"
                . "                  <th class='tbl-header' colspan='9'>PREDICTIONS / POINTS</th><th colspan='3'>Points : " . $TotalPoints . "</th>"
                . "              </tr>"
                . "              <tr>"
                . "              <tr>"
                . "                  <th>No.</th><th class='hidden'><th class='hidden'></th><th colspan='2'>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th>"
                . "                  <th class='hidden'></th> <th colspan='2'>AWAY</th><th class='res-header'>Res</th><th class='res-header'>Pts</th><th class='res-header'>Bon</th>"
                . "              </tr>"
                . "          </thead>"
                . "          <tbody>" 
                . $html
                . "          </tbody>"
                . "      </table>"
                . "  </div>  <!-- end of predictions-tbl div -->";     

    };

    // return the HTML back to the calling page
    echo $html;

?>  