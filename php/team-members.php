<?php

    // if you didnt get here from a GET then return to home page
    if ( !($_SERVER['REQUEST_METHOD']) === "GET" ) {
        header("Location: ../index.php");
        exit();
    }

    // checks if session exists
    session_start();

    // these are the session variables
    //  $_SESSION["worldcup"]       = true;
    //  $_SESSION["loggedin"]       = true;
    //  $_SESSION["userid"]         = $userid;                            
    //  $_SESSION["username"]       = $username;                            
    //  $_SESSION["useremail"]      = $email;
    //  $_SESSION['last_activity']  = time();   //  your last activity was now, having logged in.

    // has the user been inactive for more than 30 minutes (1800 secs) since last activity was recorded
    if ( $_SESSION['last_activity'] + 1800 < time() ) { 
        header('Location: ../inc/logout.php'); 
    } else { 
        $_SESSION['last_activity'] = time();                
    }

    // If logged in store the session variables from session 
    if ( isset($_SESSION['userid']) ) {
        $userid      = $_SESSION["userid"];    
        $username    = $_SESSION["username"]    ; 
        $predictions = $_SESSION["predictions"];    
    }; 

    //Receive the RAW data (team name) from the GET request
    $GET_teamname = trim($_GET['tm']);

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

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

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <title>world Cup 2022 Predictor - Playing As A Team</title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="How is your team ranking against other teams and how do you rank as part of your own team ">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles-team-members.css">
                
    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <?php 
                    $headeritems = "username";
                    $menuitems = array("Profile", "Logout");
                    include '../include/header1.inc.php';
                ?>
            </header>

            <?php
                    // All teams in order of total points scored by all team members
                    $qry = "SELECT UserTeam, COUNT(UserName) AS Members, SUM(Points) As TotalPts, ROUND(AVG(Points)) AS AveragePts FROM Users WHERE UserTeam <> '' GROUP BY UserTeam ORDER BY AveragePts DESC;";

                    // prepare the query for the database connection
                    $query = $dbh -> prepare($qry);

                    /** bind the parameters */
                    // $query->bindParam(':ID', $id, PDO::PARAM_INT);

                    /** assign the values to the place holders */ 
                    // $id = $userid;

                    // execute the sql query
                    $query -> execute();
                                        
                    // get all rows, should only be one row returned
                    $results = $query -> fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() === 0) {
                        echo "<div>NO TEAMS RETURNED</div>";
                        exit;
                    } else {
                        // Create the Teams table header
                        echo "<div class='card' id='teams-details'>";
                        echo "   <h2 class='card-title'>Top Teams (Average Points) </h2>";
                        echo "      <table id='teams-tbl'>";
                        echo "          <thead class='blueheader'>";
                        echo "              <tr>";
                        echo "                  <th>Team Name</th><th>Members</th><th>Total Pts</th><th>Average Pts</th>";
                        echo "              </tr>";
                        echo "          </thead>";
                        echo "          <tbody>";

                        // loop through the results for the Teams returned
                        foreach($results as $key => $result) {

                            $userteam  = $result -> UserTeam;
                            $members   = $result -> Members;
                            $avgpoints = $result -> AveragePts;
                            $totpoints = $result -> TotalPts;

                            echo "              <tr>";
                            echo "                  <td class='left'>"   . $userteam . "</td>";
                            echo "                  <td class='center'>" . $members . "</td>";
                            echo "                  <td class='center'>" . $totpoints . "</td>";
                            echo "                  <td class='center'>" . $avgpoints . "</td>";
                            echo "              </tr>";

                        }; // end of results foreach 

                    };  // end of $query->rowCount() else

                    echo "          </tbody>";
                    echo "      </table>";                   
                    echo "</div> <!-- end of teams-details -->";
                            
                    // Team members in order of points scored by each team member
                    $qry = "SELECT * FROM Users WHERE UserTeam = :UserTeam ORDER BY Points DESC;";

                    // prepare the query for the database connection
                    $query = $dbh -> prepare($qry);

                    /** bind the parameters */
                    $query->bindParam(':UserTeam', $userteam, PDO::PARAM_STR);

                    /** assign the values to the place holders */ 
                    $userteam = $GET_teamname;

                    // execute the sql query
                    $query -> execute();
                                        
                    // get all rows, should only be one row returned
                    $results = $query -> fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() === 0) {
                        echo "<div>NO TEAM MEMBERS RETURNED</div>";
                        exit;
                    } else {
                            // Create the Team Members table header
                            echo "<div class='card' id='team-members-details'>";
                            echo "   <h2 class='card-title'>" . $GET_teamname . " - Team Members</h2>";
                            echo "      <table id='team-members-tbl'>";
                            echo "          <thead class='greenheader'>";
                            // echo "              <tr>";
                            // echo "                  <th colspan='6'>" . htmlspecialchars($post_teamname) . " - Team Members</th>";
                            // echo "              </tr>";
                            echo "              <tr>";
                            echo "                  <th>User Name</th><th>Full Name</th><th>Points</th><th></th><th>Top Scorer</th><th>Goals Scored</th>";
                            echo "              </tr>";
                            echo "          </thead>";
                            echo "          <tbody>";

                            // loop through the results for the Teams returned
                            foreach($results as $key => $result) {

                                $username    = $result -> UserName;
                                $userfname   = $result -> FirstName;
                                $userlname   = $result -> LastName;
                                $points      = $result -> Points;
                                $topscorer   = $result -> TopScorer;
                                $goalsscored = $result -> GoalsScored;

                                echo "              <tr>";
                                echo "                  <td class='left'>"   .  htmlspecialchars($username) . "</td>";
                                echo "                  <td class='left'>"   .  htmlspecialchars($userfname) . " " . htmlspecialchars($userlname) . "</td>";
                                echo "                  <td class='center'>" .  htmlspecialchars($points) . "</td>";
                                echo "                  <td class='center'>&nbsp&nbsp&nbsp&nbsp</td>";
                                echo "                  <td class='left'>" .  htmlspecialchars($topscorer) . "</td>";
                                echo "                  <td class='center'>" .  htmlspecialchars($goalsscored) . "</td>";
                                echo "              </tr>";

                            }; // end of results foreach 

                        };  // end of $query->rowCount() else

                        echo "          </tbody>";
                        echo "      </table>";   
                        echo "</div>";

                ?>

            <footer id="footer">        
                <?php include "../include/footer.inc.php"; ?>
            </footer>
            
        </main>

        <script type="text/javascript" src="../js/header1.js"></script>

        <script>

            /* hide any message that is displayed */
            // document.getElementById("update-messages").style.display = "None";
            // document.getElementById("similar-names-tbl").style.display = "None";

        </script>
    
    </body>

</html>