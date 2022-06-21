<?php 
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

        // Create database connection
        $conn = new mysqli($servername, $username, $password, $db);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error . "<br");
        } else {
            // echo "<div>" . "Connection successful" . "</div>";
        }

        $qry =    "SELECT \n" 
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

            $result = $conn->query($qry);

            if ($result->num_rows == 0) {
                echo "<div>NO RESULTS RETURNED</div>";
            } else {
                // create the arrays to hold the arrays for each result
                // create an array for each result and push it to the results array
                $results = array();
                $res     = array();

                while ($row = $result->fetch_assoc()) {

                        $fixno      = $row["fixtureno"];
                        $homeid     = $row["homeid"];
                        $hometeam   = $row["hometeam"];
                        $homerank   = $row["homerank"];
                        $homescore  = $row["homescore"];
                        $awayscore  = $row["awayscore"];
                        $awayrank   = $row["awayrank"];
                        $awayteam   = $row["awayteam"];
                        $awayid     = $row["awayid"];
                        $grpdesc    = $row["groupdesc"];
                        $rndcode    = $row["roundcode"];
                        $resultcode = $row["resultcode"];

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
                
                }   // end of while loop

        };

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
                . "  	INNER JOIN \n"						# get the GroupID from the Fixture table 
                . "  			Fixtures fx \n"
                . "  		ON \n" 
                . "  			pred.FixtureID = fx.FixtureNo \n"
                . "  	INNER JOIN \n"						# get the Home Team from the Teams table 
                . "  			Teams hmt \n" 
                . "  		ON \n" 
                . "  			pred.HomeTeam = hmt.ID \n" 
                . "  	INNER JOIN \n"						# get the Away Team from the Teams table 
                . "  			Teams awt \n"
                . "  		ON \n"
                . "  			pred.AwayTeam = awt.ID \n" 
                . "     INNER JOIN \n"
                . "  	    Results res \n"
                . "     ON \n"
                . "  	    pred.ResultID = res.ID \n"
                . "  ORDER BY \n"
                . "  	  pred.FixtureID \n";

            $result = $conn->query($qry);

            if ($result->num_rows == 0) {
                echo "<div>NO RESULTS RETURNED</div>";
            } else {
                // create the arrays to hold the arrays for each result
                // create an array for each result and push it to the results array
                $predicts = array();
                $predict  = array();

                while ($row = $result->fetch_assoc()) {

                        $userid     = $row["userid"];
                        $fixno      = $row["fixtureno"];
                        $homeid     = $row["homeid"];
                        $hometeam   = $row["hometeam"];
                        $homescore  = $row["homescore"];
                        $homerank   = $row["homerank"];
                        $awayrank   = $row["awayrank"];
                        $awayscore  = $row["awayscore"];
                        $awayteam   = $row["awayteam"];
                        $awayid     = $row["awayid"];
                        $grpdesc    = $row["groupdesc"];
                        $rndcode    = $row["roundcode"];
                        $resultcode = $row["resultcode"];
                        $resultdesc = $row["resultdesc"];
                        $stage      = $row["stage"];

                        $predict = array(
                                    "fixtureno"     => $fixno,
                                    "hometeamid"    => $homeid,
                                    "homescore"     => $homescore,
                                    "awayscore"     => $awayscore,
                                    "awayteamid"    => $awayid,
                                    "resultcode"    => $resultcode,
                                    "stage"         => $stage
                                    );

                        array_push($predicts, $predict);

                        $pts    = 0; 
                        $bonus  = 0;
                        $TotalPoints = $pts + $bonus;

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
                            } if ($p["stage"] == "SF") {
                                $bonus = $bonus + 3;
                            };
                        };

                        if ( ($r["awayteamid"] == $p["awayteamid"]) ) {

                            if ($p["stage"] == "QF") {                                
                                $bonus = $bonus + 1;
                            } if ($p["stage"] == "SF") {
                                $bonus = $bonus + 2;
                            } if ($p["stage"] == "SF") {
                                $bonus = $bonus + 3;
                            };
                        };

                        $TotalPoints = $TotalPoints + ($pts + $bonus);

                        echo $p["fixtureno"] . "-Result     : " . $r["homescore"] . "-" . $r["awayscore"];
                        echo "<br>";
                        echo "Prediction : " . $p["homescore"] . "-" . $p["awayscore"];
                        echo "<br>";
                        echo  " Correct Prediction " . $r["resultcode"] . " - " . $p["resultcode"];
                        echo "<br>";
                        echo  " Pts " . $pts . " Bonus " . $bonus . " Total : " . $TotalPoints;
                        echo "<br>";
                        echo "-----------------------------------------------------------------------<br>";
                }

        };

    // -------------------------------------------------------
    // 1 pt for correct result H, A, D
    // 2 pts for correct score
    // -------------------------------------------------------
    // BONUS POINTS
    // -------------------------------------------------------
    // LAST SIXTEEN & QUARTERFINAL
    //      1 Point for predicting the correct home team
    //      1 Point for predicting the correct away team
    // -------------------------------------------------------
    // SEMI FINAL 
    //      2 Points for predicting the correct home team
    //      2 Points for predicting the correct away team
    // -------------------------------------------------------
    // SEMI FINAL 
    //      3 Points for predicting the correct home team
    //      3 Points for predicting the correct away team
    // -------------------------------------------------------

                // $TotalPoints = 0; 

                // for ($x = 0; $x < count($results); $x++){

                //     $pts    = 0; 
                //     $bonus  = 0;

                //     $r   = $results[$x];
                //     $p   = $predicts[$x];

                //     if ($r["resultcode"] == $p["resultcode"]) {

                //         $pts = $pts + 1;
                        
                //         if ( ($r["homescore"] == $p["homescore"]) && ($r["awayscore"] == $p["awayscore"])) {
                //             $pts = $pts + 2;
                //         };
                //     };

                //     if ( ($r["hometeamid"] == $p["hometeamid"]) ) {

                //         if ($p["stage"] == "QF") {                                
                //             $bonus = $bonus + 1;
                //         } if ($p["stage"] == "SF") {
                //             $bonus = $bonus + 2;
                //         } if ($p["stage"] == "SF") {
                //             $bonus = $bonus + 3;
                //         };
                //     };

                //     if ( ($r["awayteamid"] == $p["awayteamid"]) ) {

                //         if ($p["stage"] == "QF") {                                
                //             $bonus = $bonus + 1;
                //         } if ($p["stage"] == "SF") {
                //             $bonus = $bonus + 2;
                //         } if ($p["stage"] == "SF") {
                //             $bonus = $bonus + 3;
                //         };
                //     };

                //     $TotalPoints = $TotalPoints + ($pts + $bonus);

                //     echo $p["fixtureno"] . "-Result     : " . $r["homescore"] . "-" . $r["awayscore"];
                //     echo "<br>";
                //     echo "Prediction : " . $p["homescore"] . "-" . $p["awayscore"];
                //     echo "<br>";
                //     echo  " Correct Prediction " . $r["resultcode"] . " - " . $p["resultcode"];
                //     echo "<br>";
                //     echo  " Pts " . $pts . " Bonus " . $bonus . " Total : " . $TotalPoints;
                //     echo "<br>";
                //     echo "-----------------------------------------------------------------------<br>";

                // }; // end of of For loop

?>