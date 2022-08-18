<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // if you didnt get here from a update-a-fixture POST then return to home page
    if ( $_SERVER['REQUEST_METHOD'] != "POST" ) {
        header("Location: ../index.php");
        exit();
    }

    try {
        // Try and establish the database connection.
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        };

        // RESULTS 
        $sql = "SELECT \n" 
            . "  	FixtureNo		as fixtureno, \n"
            . "  	HomeScore		as homescore, \n"
            . "  	AwayScore		as awayscore, \n"
            . "  	rnd.Code        as roundcode,  \n"
            . "  	hmt.ID 			as homeid, \n"
            . "  	awt.ID 			as awayid, \n"
            . "  	res.Code		as resultcode \n"
            . "FROM  \n"
            . "  	Fixtures fx \n"
            . "INNER JOIN \n"
            . "  	Rounds rnd \n"
            . "ON \n"
            . "  	fx.RoundID = rnd.ID \n"
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

        $query = $dbh -> prepare($sql);

        /**
            no need to bind params as we are retrieving all results
            $query -> bindParam(':city', $city, PDO::PARAM_STR);
            $city = "New York";
        */

        // execute the sql query
        $query -> execute();

        // get all rows
        $fixtures = $query -> fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() == 0) {
            echo "NO FIXTURES RESULTS RETURNED";
            exit;
        } else {

            // create the arrays to hold the arrays for each result
            // create an array for each result and push it to the results array
            $results = array();
            $result  = array();

            // loop through the fixtures
            foreach($fixtures as $key => $fixture) {
            
                $fixno      = $fixture -> fixtureno;
                $homeid     = $fixture -> homeid;
                $homescore  = $fixture -> homescore;
                $awayscore  = $fixture -> awayscore;
                $awayid     = $fixture -> awayid;
                $rndcode    = $fixture -> roundcode;
                $resultcode = $fixture -> resultcode;

                $result = array(
                            "fixtureno"     => $fixno,
                            "hometeamid"    => $homeid,
                            "homescore"     => $homescore,
                            "awayscore"     => $awayscore,
                            "awayteamid"    => $awayid,
                            "resultcode"    => $resultcode,
                            "stage"         => $rndcode
                            );

                // add the fixture to the array
                array_push($results, $result);

            }; // end of fixtures foreach
            
        }; // end of fixtures else rowcount

        /** 
            array to be returned to the calling PHP stage 
        */
        $msg_arr = array(   
                        'Success' => 'SUCCESSFUL', 
                        'Failure' => 'FAILED'
                        );


        // USERS
        $sql = "SELECT ID, UserName, Points, CreatedDate FROM Users WHERE Predictions = 1";

        $query = $dbh -> prepare($sql);

        // no need to bind params
        // $query -> bindParam(':city', $city, PDO::PARAM_STR);
        // $city = "New York";

        // execute sql query
        $query -> execute();

        // get all rows
        $users = $query -> fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() == 0) {
            echo "NO USERS RESULTS RETURNED";
            exit;
        } else {

            foreach($users as $user) {
            
                $userid     = $user -> ID;
                $username   = $user -> UserName;
                $userpoints = $user -> Points;
                $created    = $user -> CreatedDate;

                // GET USERS PREDICTIONS
                $sql =   "SELECT \n"
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
                    . "     pred.UserID = " . $userid . "\n"
                    . "  ORDER BY \n"
                    . "  	  pred.FixtureID \n";

                    // prepare the sql query
                    $query = $dbh -> prepare($sql);

                    /**
                        no need to bind params as we are retrieving all results
                        $query -> bindParam(':city', $city, PDO::PARAM_STR);
                        $city = "New York";
                    */

                    // execute the sql query
                    $query -> execute();

                    // get all predictions for the userid
                    $predictions = $query -> fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() == 0) {
                        echo "NO PREDICTIONS RESULTS RETURNED";
                        exit;
                    } else {

                        // create the arrays to hold the arrays for each result
                        // create an array for each result and push it to the results array
                        $predicts = array();
                        $predict  = array();

                        // initialise the points total for each user
                        $TotalPoints = 0;

                        // initialse the points totals for the predictions 
                        $pts    = 0; 
                        $bonus  = 0;

                        foreach($predictions as $key => $prediction) {
                        
                            $predict = array(
                                        "fixtureno"     => $prediction -> fixtureno,
                                        "hometeamid"    => $prediction -> homeid,
                                        "homescore"     => $prediction -> homescore,
                                        "awayscore"     => $prediction -> awayscore,
                                        "awayteamid"    => $prediction -> awayid,
                                        "resultcode"    => $prediction -> resultcode,
                                        "stage"         => $prediction -> stage
                                        );

                            array_push($predicts, $predict);

                            $r   = $results[$prediction -> fixtureno-1];
                            $p   = $predict;

                            if ($r["resultcode"] == $p["resultcode"]) {

                                $pts = $pts + 1;
                                
                                if ( ($r["homescore"] == $p["homescore"]) && ($r["awayscore"] == $p["awayscore"])) {
                                    $pts = $pts + 2;
                                };
                            };

                            if ( ($r["hometeamid"] == $p["hometeamid"]) ) {

                                if ($p["stage"] == "LS") {                                
                                    $bonus = $bonus + 1;
                                } else if ($p["stage"] == "QF") {                                
                                    $bonus = $bonus + 1;
                                } else if ($p["stage"] == "SF") {
                                    $bonus = $bonus + 2;
                                } else if ($p["stage"] == "PL") {                                
                                    $bonus = $bonus + 1;
                                } else if ($p["stage"] == "FI") {
                                    $bonus = $bonus + 3;
                                };

                            };

                            if ( ($r["awayteamid"] == $p["awayteamid"]) ) {

                                if ($p["stage"] == "LS") {                                
                                    $bonus = $bonus + 1;
                                } else if ($p["stage"] == "QF") {                                
                                    $bonus = $bonus + 1;
                                } else if ($p["stage"] == "SF") {
                                    $bonus = $bonus + 2;
                                } else if ($p["stage"] == "PL") {                                
                                    $bonus = $bonus + 1;
                                } else if ($p["stage"] == "FI") {
                                    $bonus = $bonus + 3;
                                };

                            };

                        }; // end of predictions foreach
                        
                        $TotalPoints = $TotalPoints + ($pts + $bonus);

                        // echo "-----------------------------------------------------" . "<br>";
                        // echo "User : " . $userid . "-" . $username . " Points : " . $pts . ", " . $bonus . ", Total: " . $TotalPoints . "<br>";
                        // echo "-----------------------------------------------------" . "<br>";

                    }; // end of PREDICTIONS else rowcount

                    /**
                        save the points total to the USER record
                    */

                    //prepare the update sql statement
                    $sql = "UPDATE Users SET Points = :Points WHERE ID = :ID";

                    // prepare the query for the database connection
                    $query = $dbh -> prepare($sql);

                    // bind the parameters
                    $query->bindParam(':ID',     $userid,      PDO::PARAM_INT);
                    $query->bindParam(':Points', $TotalPoints, PDO::PARAM_INT);

                    /** 
                        execute the query and check if it fails to insert prediction
                        have to return something formatted as JSON to the calling PHP file
                    */
                    if ($query -> execute() === FALSE) {    
                        echo $msg_arr[Failure] . " - Updating Points Total for User " . $userid;
                        exit;            
                    } else {
                         // echo $msg_arr[Success] . " - Updating Points Total for User " . $userid;
                    };

            }; // end of USERS foreach

            echo $msg_arr[Success] . " - Updating Points Total for Users";

        }; // end of USERS else rowcount

    }  // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>