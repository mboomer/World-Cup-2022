<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials.
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    try {
    // Try and establish database connection.
        try {
            $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
            echo "Connected successfully" . "<br>";
        }
        catch (PDOException $e) {
            exit("Error: " . $e->getMessage());
        };

        //prepare the sql statement
        $sql = "INSERT INTO Predictions 
                    (UserID, FixtureID, HomeScore, AwayScore, HomeTeam, AwayTeam, ResultID, Points, Bonus) 
                VALUES 
                    (:UserID, :FixtureID, :HomeScore, :AwayScore, :HomeTeam, :AwayTeam, :ResultID, :Points, :Bonus)";

        echo "Prepare SQL successful" . "<br>";

        // prepare the query for the database connection
        $query = $dbh -> prepare($sql);

        echo "Prepare QUERY successful" . "<br>";

        // bind the parameters
        $query->bindParam(':UserID',    $userid,        PDO::PARAM_INT);
        $query->bindParam(':FixtureID', $fixtureid,     PDO::PARAM_INT);
        $query->bindParam(':HomeScore', $homescore,     PDO::PARAM_INT);
        $query->bindParam(':AwayScore', $awayscore,     PDO::PARAM_INT);
        $query->bindParam(':HomeTeam',  $hometeamid,    PDO::PARAM_INT);
        $query->bindParam(':AwayTeam',  $awayteamid,    PDO::PARAM_INT);
        $query->bindParam(':ResultID',  $resultid,      PDO::PARAM_INT);
        $query->bindParam(':Points',    $points,        PDO::PARAM_INT);
        $query->bindParam(':Bonus',     $bonus,         PDO::PARAM_INT);

        echo "BIND parameters successful" . "<br>";

        $predictions = '[
                            {"UserID":1,"FixtureID":"1","HomeScore":"3","AwayScore":"1","HomeTeamID":"1","AwayTeamID":"3","ResultID":1,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"2","HomeScore":"2","AwayScore":"2","HomeTeamID":"2","AwayTeamID":"4","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"9","HomeScore":"1","AwayScore":"3","HomeTeamID":"3","AwayTeamID":"4","ResultID":2,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"10","HomeScore":"3","AwayScore":"1","HomeTeamID":"1","AwayTeamID":"2","ResultID":1,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"17","HomeScore":"2","AwayScore":"2","HomeTeamID":"4","AwayTeamID":"1","ResultID":3,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"18","HomeScore":"1","AwayScore":"3","HomeTeamID":"3","AwayTeamID":"2","ResultID":2,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"3","HomeScore":"3","AwayScore":"1","HomeTeamID":"6","AwayTeamID":"8","ResultID":1,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"4","HomeScore":"2","AwayScore":"2","HomeTeamID":"5","AwayTeamID":"7","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"11","HomeScore":"1","AwayScore":"3","HomeTeamID":"7","AwayTeamID":"8","ResultID":3,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"12","HomeScore":"3","AwayScore":"1","HomeTeamID":"5","AwayTeamID":"6","ResultID":2,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"19","HomeScore":"2","AwayScore":"2","HomeTeamID":"8","AwayTeamID":"5","ResultID":3,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"20","HomeScore":"1","AwayScore":"3","HomeTeamID":"6","AwayTeamID":"7","ResultID":3,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"5","HomeScore":"3","AwayScore":"1","HomeTeamID":"12","AwayTeamID":"11","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"6","HomeScore":"2","AwayScore":"2","HomeTeamID":"9","AwayTeamID":"10","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"13","HomeScore":"1","AwayScore":"2","HomeTeamID":"10","AwayTeamID":"11","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"14","HomeScore":"3","AwayScore":"1","HomeTeamID":"9","AwayTeamID":"12","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"21","HomeScore":"2","AwayScore":"2","HomeTeamID":"11","AwayTeamID":"9","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"22","HomeScore":"1","AwayScore":"3","HomeTeamID":"10","AwayTeamID":"12","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"7","HomeScore":"3","AwayScore":"1","HomeTeamID":"15","AwayTeamID":"16","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"8","HomeScore":"2","AwayScore":"2","HomeTeamID":"13","AwayTeamID":"14","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"15","HomeScore":"1","AwayScore":"3","HomeTeamID":"14","AwayTeamID":"16","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"16","HomeScore":"3","AwayScore":"1","HomeTeamID":"13","AwayTeamID":"15","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"23","HomeScore":"2","AwayScore":"2","HomeTeamID":"16","AwayTeamID":"13","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"24","HomeScore":"1","AwayScore":"3","HomeTeamID":"14","AwayTeamID":"15","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"25","HomeScore":"3","AwayScore":"1","HomeTeamID":"1","AwayTeamID":"12","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"26","HomeScore":"2","AwayScore":"2","HomeTeamID":"2","AwayTeamID":"3","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"27","HomeScore":"1","AwayScore":"3","HomeTeamID":"5","AwayTeamID":"4","ResultID":3,"Points":3,"Bonus":0},
                            {"UserID":1,"FixtureID":"28","HomeScore":"3","AwayScore":"1","HomeTeamID":"8","AwayTeamID":"5","ResultID":3,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"29","HomeScore":"2","AwayScore":"2","HomeTeamID":"9","AwayTeamID":"2","ResultID":3,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"30","HomeScore":"1","AwayScore":"3","HomeTeamID":"10","AwayTeamID":"1","ResultID":3,"Points":1,"Bonus":0},
                            {"UserID":1,"FixtureID":"31","HomeScore":"3","AwayScore":"1","HomeTeamID":"14","AwayTeamID":"12","ResultID":3,"Points":1,"Bonus":0}
                        ]';

        $json_array = json_decode($predictions, true);


        foreach($json_array as $elem)  {

            // assign the values to the  place holders
            $userid     = $elem['UserID'];
            $fixtureid  = $elem['FixtureID'];
            $homescore  = $elem['HomeScore'];
            $awayscore  = $elem['AwayScore'];
            $hometeamid = $elem['HomeTeamID'];
            $awayteamid = $elem['AwayTeamID'];
            $resultid   = $elem['ResultID'];
            $points     = $elem['Points'];
            $bonus      = $elem['Bonus'];

            echo "ASSIGN VALUES successful" . "<br>";

            // execute the query
            if ($query -> execute() === FALSE) {
                echo 'Unable to insert data - ' . $elem['FixtureID'] ;
            } else {
                echo "EXECUTE QUERY successful - " . $elem['FixtureID'] . "<br>";
            }

        }                       // end of foreach loop
    }                           // end of Try
    catch (PDOException $e) {
        echo 'Database Error ' . $e->getMessage() . ' in ' . $e->getFile() . ': '.$e->getLine();
    };

?>