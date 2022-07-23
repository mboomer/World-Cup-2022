<?php
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    };

    // only process users who have saved predictions 
    $qry = "  SELECT \n" 
            . "    UserName, \n"
            . "    TopScorer, \n"
            . "    GoalsScored, \n"
            . "    Points \n"
            . "FROM \n"
            . "    Users \n"
            . "WHERE \n"
            . "    Predictions = 1 \n"
            . "ORDER BY \n"
            . "    Points DESC \n"
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
        $users = $query -> fetchAll(PDO::FETCH_OBJ);

        if ($query->rowCount() == 0) {
            echo "<div>NO USERS RETURNED</div>";
            exit;
        } else {

                $html = "";

                $fh = fopen("top-ten-users.html", "w"); 
                
                $html = "  <div id='user-tbl'>"
                        . "      <table>"
                        . "          <thead class='blueheader'>"
                        . "              <tr>"
                        . "                  <th class='align-left'>User Name</th><th class='cols'>Points</th><th class='align-left'>Top Scorer</th><th class='cols'>Goals</th>"
                        . "              </tr>"
                        . "          </thead>"
                        . "          <tbody>";

                foreach($users as $key => $user) {

                    $username  = $user -> UserName;
                    $points    = $user -> Points;
                    $topscorer = $user -> TopScorer;
                    $goals     = $user -> GoalsScored;

                    $html .= "  <tr>"
                             . "      <td class='align-left'>" . $username . "</td>"
                             . "      <td class='cols'>" . $points . "</td>"
                             . "      <td class='align-left'>" . $topscorer . "</td>" 
                             . "      <td class='cols'>" . $goals . "</td>" 
                             . "  </tr>";

                }; // end of users foreach 

                    $html .= "          </tbody>"
                          .  "      </table>"   
                          . "  </div>  <!-- end of users-tbl div -->"; 

        };  // end of $query->rowCount() else

    // write the HTML to the file
    fwrite($fh, $html);
    // close the file handle
    fclose($fh);

    // return success message
    echo "Success - Top Ten Users updated";

?>  
