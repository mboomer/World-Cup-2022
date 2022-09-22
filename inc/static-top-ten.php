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

        $fh = fopen("../static/top-ten-users.html", "w"); 
        
        $html = "  <div id='user-tbl'>"
              . "      <table>"
              . "          <thead class='blueheader'>"
              . "              <tr>"
              . "                  <th class='align-left'>User Name</th><th class='cols'>Points</th><th class='align-left'>Predicted Top Scorer</th><th class='cols'>Goals</th>"
              . "              </tr>"
              . "          </thead>"
              . "          <tbody>";

        if ($query->rowCount() == 0) {

            // return failure message
            echo "Failure - No Top Ten Users Returned";

            $html .= "  <tr>"
                  . "      <td></td>"
                  . "      <td></td>"
                  . "      <td></td>" 
                  . "      <td></td>" 
                  . "   </tr>";

        } else {

                foreach($users as $key => $user) {

                    $username  = $user -> UserName;
                    $points    = $user -> Points;
                    $topscorer = $user -> TopScorer;
                    $goals     = $user -> GoalsScored;

                    $html .= "  <tr>"
                          . "      <td class='align-left'>" . htmlspecialchars($username) . "</td>"
                          . "      <td class='cols'>" . htmlspecialchars($points) . "</td>"
                          . "      <td class='align-left'>" . htmlspecialchars($topscorer) . "</td>" 
                          . "      <td class='cols'>" . htmlspecialchars($goals) . "</td>" 
                          . "  </tr>";

                }; // end of users foreach 

            // return success message
            echo "Success - Top Ten Users Updated";

        };  // end of $query->rowCount() else

        $html .= "          </tbody>"
              .  "      </table>"   
              . "  </div>  <!-- end of users-tbl div -->"; 

    // write the HTML to the file
    fwrite($fh, $html);
    // close the file handle
    fclose($fh);

?>  
