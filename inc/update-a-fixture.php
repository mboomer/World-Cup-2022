<?php

    // checks if session exists
    session_start();

    // these are the session variables
    // $_SESSION["worldcup"]  = true;
    // $_SESSION["loggedin"]  = true;
    // $_SESSION["userid"]    = $userid;                            
    // $_SESSION["username"]  = $username;                            
    // $_SESSION["useremail"] = $email;

    // If user is logged in, store the userid from session variable 
    if ( isset($_SESSION['userid']) ) {
        $userid   = $_SESSION["userid"];    
        $username = $_SESSION["username"];    
    }; 
    
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
        echo("Error: " . $e->getMessage());
        exit("Error: " . $e->getMessage());
    };
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Update Fixture Scores</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles-update-fixtures.css">
        
    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <?php 
                    $headeritems = "username";
                    $menuitems = array("Logout");        
                    include "../include/header1.inc.php"; 
                ?>
            </header>

            <!-- Tab links -->
            <div id="tabs" class="tab">
                <button id="fixtures-btn" name="FIXTURES" class="tablinks">Fixtures | Goals Scored | Statistics | Data Import</button>
            </div>

            <section id="tournament">
                
                <div id="FIXTURES" class="tabcontent">

                  <div id="results-tbl">  

                      <table>          
                          <thead class="greenheader">              
                              <tr>                  
                                  <th class="tbl-header" colspan="10">FIXTURES / RESULTS</th>              
                              </tr>              
                              <tr>                  
                                  <th>No</th><th class="hidden"></th><th class="hidden"></th><th colspan="2">HOME</th> <th>Rk</th> <th colspan="2">SCORE</th> <th>Rk</th>                  
                                  <th class="hidden"></th> <th colspan="2">AWAY</th><th class="res-header">Update</th>              
                              </tr>          
                          </thead>          
                          <tbody>  

                                <?php

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

                                        $query = $dbh -> prepare($qry);

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

                                            // loop through the fixtures
                                            foreach($fixtures as $key => $fixture) {

                                                $fixno      = $fixture -> fixtureno;
                                                $stage      = $fixture -> roundcode;
                                                $homeid     = $fixture -> homeid;
                                                $hometeam   = $fixture -> hometeam;
                                                $homerank   = $fixture -> homerank;
                                                $homescore  = $fixture -> homescore;
                                                $awayscore  = $fixture -> awayscore;
                                                $awayrank   = $fixture -> awayrank;
                                                $awayid     = $fixture -> awayid;
                                                $awayteam   = $fixture -> awayteam;
                                                $rndcode    = $fixture -> roundcode;
                                                $resultcode = $fixture -> resultcode;
                                            
                                                // colorize the stages to identify the LS, QF, SF, PL and FI
                                                if ($stage === "GS") {
                                                    echo "  <tr>";
                                                } else if ($stage === "LS") {
                                                    echo "  <tr class='ls-color'>";
                                                } if ($stage === "QF") {
                                                    echo "  <tr class='qf-color'>";
                                                } else if ($stage === "SF") {
                                                    echo "  <tr class='sf-color'>";
                                                } else if ($stage === "PL") {
                                                    echo "  <tr class='pl-color'>";
                                                } else if ($stage === "FI") {
                                                    echo "  <tr class='fi-color'>";
                                                }

                                                // echo "<tr>";      
                                                echo "    <td class='fixno'>" . $fixno . "</td>";      
                                                echo "    <td class='stage hidden'>" . $stage . "</td>";      
                                                echo "    <td class='homeid hidden'>" . $homeid . "</td>";      
                                                echo "    <td class='results-home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>";      
                                                echo "    <td class='home'>" . $hometeam . "</td>";      
                                                echo "    <td class='h-rank'>" . $homerank .  "</td>";      
                                                echo "    <td><input class='homescore' name='fixtureno" . $fixno.  "' data-h-fixtureno='" . $fixno . "' value='" . $homescore . "' type='number' min='0' placeholder='0'></td>";      
                                                echo "    <td><input class='awayscore' name='fixtureno" . $fixno.  "' data-a-fixtureno='" . $fixno . "' value='" . $awayscore . "' type='number' min='0' placeholder='0'></td>";      
                                                echo "    <td class='a-rank'>" . $awayrank . "</td>";      
                                                echo "    <td class='awayid hidden'>" . $awayid . "</td>";      
                                                echo "    <td class='away'>" . $awayteam . "</td>";      
                                                echo "    <td class='results-away-flag'><img src='../img/teams/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>";      
                                                echo "    <td><button class='transparent-btn-blue' ";
                                                echo "    id='fixtureno" . $fixno . "' data-fx='" . $fixno . "' data-hs='" . $homescore . "' data-as='" . $awayscore . "'> Update </button></td>";  
                                                echo "</tr>";    

                                            }; // end of fixtures foreach
                                            
                                            // echo "------------------------------" . "<br>";
                                        
                                        }; // end of fixtures else rowcount

                                    ?>

                            </tbody>      
                      </table>  

                    </div>  <!-- end of results-tbl div -->
                
                </div>  <!-- end of FIXTURES -->

                <div id="GOALS-SCORED" class="tabcontent">

                    <section id='goals-scored'>

                        <div id='goals-scored-selections'>

                            <table>
                                <thead class='greenheader'>
                                    <tr>                  
                                        <th class="tbl-header" colspan="10">GOAL SCORED</th>              
                                    </tr>              
                                    <tr>                  
                                        <th class="cols">Fixture</th>
                                        <th class="country">Team</th>
                                        <th class="player">Goal Scorer</th>
                                        <th class="cols">Minute (1H)</th> 
                                        <th class="cols">Minute (2H)</th> 
                                        <th class="cols">Minute (1ET)</th> 
                                        <th class="cols">Minute (2ET)</th> 
                                        <th class="cols">Penalty</th> 
                                        <th class="cols">Own Goal</th> 
                                        <th class="cols">Update</th> 
                                    </tr>          
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> <input id='goal-fixture' type='text'   placeholder='Fixture Number' min=1 max=31 value=1> </td>
                                        <td>    
                                            <select title= "Team" name="goal-team" id="goal-team">

                                                <option value="0"></option>

                                                <?php

                                                // Try and establish the database connection.
                                                try {
                                                    $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                                                }
                                                catch (PDOException $e) {
                                                    echo("Error: " . $e->getMessage());
                                                    exit("Error: " . $e->getMessage());
                                                };

                                                $sql =    "SELECT \n" 
                                                        . "  	ID, \n"
                                                        . "  	Team, \n"
                                                        . "  	Ranking \n"
                                                        . "FROM  \n"
                                                        . "  	Teams tm \n"
                                                        . "WHERE  \n"
                                                        . "  	Ranking != 0 \n"
                                                        . "ORDER BY \n"
                                                        . "  	Ranking \n";

                                                        $query = $dbh -> prepare($sql);

                                                        /**
                                                            no need to bind params as we are retrieving all results
                                                            $query -> bindParam(':city', $city, PDO::PARAM_STR);
                                                            $city = "New York";
                                                        */

                                                        // execute the sql query
                                                        $query -> execute();

                                                        // get all rows
                                                        $results = $query -> fetchAll(PDO::FETCH_OBJ);

                                                        if ($query->rowCount() == 0) {
                                                            echo "NO TEAMS RETURNED";
                                                            exit;
                                                        } else {

                                                            // loop through the fixtures
                                                            foreach($results as $key => $result) {

                                                                $teamid = $result -> ID;
                                                                $team   = $result -> Team;

                                                                echo "<option value=" . $teamid . ">" . $team . "</option>";

                                                            }; // end of results foreach
                                                                                                    
                                                        }; // end of results else rowcount

                                                ?>
                                            </select>
                                        </td>
                                        <td> <input id='goal-scorer'  type='text'   placeholder='Goal Scorer' value=""> </td> 
                                        <td> <input id='goal-h1min'   type='number' min=0 max=65 value=1> </td>
                                        <td> <input id='goal-h2min'   type='number' min=0 max=65 value=0> </td>
                                        <td> <input id='goal-et1min'  type='number' min=0 max=65 value=0> </td>
                                        <td> <input id='goal-et2min'  type='number' min=0 max=65 value=0> </td>
                                        <td> <input id='goal-penalty' type='number' min=0 max=1  value=0> </td>
                                        <td> <input id='goal-own'     type='number' min=0 max=1  value=0> </td>
                                        <td><button id='goal-upd-btn' class='goal-btn-blue'>Update</button></td>  
                                    </tr>
                                </tbody>
                            </table>      

                        </div> <!-- end of GOALS SCORED SELECTIONS div -->

                        <div id="update-msg"></div> <!-- end of database update message -->      

                    </section> <!-- end of GOALS SCORED section -->

                    <section id="update-user-points">

                        <div id='statistics-update'>

                            <table id='stats-update-tbl'>
                                <thead class='blueheader'>
                                    <tr>                  
                                        <th class="tbl-header">Update Statistics</th>              
                                    </tr>              
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><button id='update-user-points-btn' name='update-user-points-btn' class='stats-update-btn'>Update User Points</button></td>
                                    </tr>
                                    <tr>
                                        <td><button id='update-top-ten-btn' name='update-top-ten-btn' class='stats-update-btn'>Top Ten Users</button></td>
                                    </tr>
                                    <tr>
                                        <td><button id='update-top-scorer-btn' name='update-top-scorer-btn' class='stats-update-btn'>Top Scorer</button></td>
                                    </tr>
                                    <tr>
                                        <td><button id='update-latest-results-btn' name='update-latest-results-btn' class='stats-update-btn'>Latest Results</button></td>
                                    </tr>
                                    <tr>
                                        <td><button id='update-upcoming-fixtures-btn' name='update-upcoming-fixtures-btn' class='stats-update-btn'>Upcoming Fixtures</button></td>
                                    </tr>
                                    <tr>
                                        <td><button id='update-comp-stats-btn' name='update-comp-stats-btn' class='stats-update-btn'>Competition Stats</button></td>
                                    </tr>
                                </tbody>
                            </table>      
                        </div>

                        <div id='data-import'>

                            <table id='data-import-tbl'>
                                <thead class='blueheader'>
                                    <tr>                  
                                        <th class="tbl-header">Import Data</th>              
                                    </tr>              
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class='confirm-import'>
                                            <button id='import-fixtures-btn'     class='stats-update-btn'>Import Fixtures</button>
                                            <button id='import-fixtures-no-btn'  class='stats-update-btn'>Cancel</button>
                                            <button id='import-fixtures-yes-btn' class='stats-update-btn'>Continue</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='confirm-import'>
                                            <button id='import-groups-btn'     class='stats-update-btn'>Import groups</button>
                                            <button id='import-groups-no-btn'  class='stats-update-btn'>Cancel</button>
                                            <button id='import-groups-yes-btn' class='stats-update-btn'>Continue</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='confirm-import'>
                                            <button id='import-results-btn'     class='stats-update-btn'>Import Results</button>
                                            <button id='import-results-no-btn'  class='stats-update-btn'>Cancel</button>
                                            <button id='import-results-yes-btn' class='stats-update-btn'>Continue</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='confirm-import'>
                                            <button id='import-rounds-btn'     class='stats-update-btn'>Import Rounds</button>
                                            <button id='import-rounds-no-btn'  class='stats-update-btn'>Cancel</button>
                                            <button id='import-rounds-yes-btn' class='stats-update-btn'>Continue</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='confirm-import'>
                                            <button id='import-teams-btn'     class='stats-update-btn'>Import Teams</button>
                                            <button id='import-teams-no-btn'  class='stats-update-btn'>Cancel</button>
                                            <button id='import-teams-yes-btn' class='stats-update-btn'>Continue</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class='confirm-import'>
                                            <button id='import-venues-btn'     class='stats-update-btn'>Import Venues</button>
                                            <button id='import-venues-no-btn'  class='stats-update-btn'>Cancel</button>
                                            <button id='import-venues-yes-btn' class='stats-update-btn'>Continue</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>      
                        </div>

                    </section>

                </div>  <!-- end of GOALS SCORED -->

            </section> <!-- end of Tournament -->

            <footer id="footer">
                <?php include "../include/footer.inc.php"; ?>
            </footer>
            
        </main>
    
        <script type="text/javascript" src="../js/header1.js"></script>

        <script type="text/javascript">

            document.getElementById("update-msg").style.display = "none";

            document.getElementById("import-fixtures-no-btn").style.display = "none";
            document.getElementById("import-fixtures-yes-btn").style.display = "none";

            document.getElementById("import-groups-no-btn").style.display = "none";
            document.getElementById("import-groups-yes-btn").style.display = "none";

            document.getElementById("import-results-no-btn").style.display = "none";
            document.getElementById("import-results-yes-btn").style.display = "none";

            document.getElementById("import-rounds-no-btn").style.display = "none";
            document.getElementById("import-rounds-yes-btn").style.display = "none";

            document.getElementById("import-teams-no-btn").style.display = "none";
            document.getElementById("import-teams-yes-btn").style.display = "none";

            document.getElementById("import-venues-no-btn").style.display = "none";
            document.getElementById("import-venues-yes-btn").style.display = "none";

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                // event listeners for the fixture update buttons
                if (event.target.matches('.transparent-btn-blue')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating Scores...please wait";

                    const fixtureid = document.getElementById(event.target.id);

                    fxnum  = fixtureid.dataset.fx 
                    hscore = fixtureid.dataset.hs 
                    ascore = fixtureid.dataset.as 

                    // update the fixture id for the goal scored table
                    document.getElementById("goal-fixture").value = fxnum;

                    // initialise the object and array to hold the fixture details
                    let fixtures = [];
                    let fixture = {};
            
                    /** push the fixture scores to the first element in the array */

                    fixture = { FixtureNo : fxnum, 
                                HomeScore : hscore, 
                                AwayScore : ascore,
                                ResultID  : 0,
                                Points    : 0
                              };

                    // home win ID - 1, away win ID - 2, draw ID - 3 
                    if (hscore > ascore) {
                        fixture.ResultID = 1;
                        fixture.Points = 3;                           
                    } else if (hscore < ascore) {
                        fixture.ResultID = 2;
                        fixture.Points = 3;                           
                    } else if (hscore == ascore) {
                        fixture.ResultID = 3;
                        fixture.Points = 1;                           
                    };

                    // add the fixture scores and result to the fixtures Array                                                                
                    fixtures.push(fixture);

                    // process the fixtures array and save result to fixtures table
                    fetch('https://www.worldcup2022predictor.com/inc/update-fixture-scores.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                                },
                            body: JSON.stringify(fixtures),

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.json();
                            };

                            // Otherwise, throw an error
                            return response.json().then(function (msg) {
                                console.log(msg);
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };

                // event listeners for the goals update button
                if (event.target.matches('#goal-upd-btn')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating Goals Scored...please wait";

                    // initialise the object to hold each goal
                    let goals = [];
                    let goal  = {};
            
                    /** push the goal to the first element in the array */

                    goal = { 
                            FixtureID : document.getElementById('goal-fixture').value,
                            TeamID    : document.getElementById('goal-team').value,
                            Player    : document.getElementById('goal-scorer').value, 
                            H1Minute  : document.getElementById('goal-h1min').value,
                            H2Minute  : document.getElementById('goal-h2min').value,
                            ET1Minute : document.getElementById('goal-et1min').value,
                            ET2Minute : document.getElementById('goal-et2min').value,
                            Penalty   : document.getElementById('goal-penalty').value,
                            OwnGoal   : document.getElementById('goal-own').value
                           };

                    // add the goal scorer and time goal was scored to the goals array                                                                
                    goals.push(goal);

                    // now process the goals array and save result to goals-scored table
                    fetch('https://www.worldcup2022predictor.com/inc/update-goals-scored.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                                },
                            body: JSON.stringify(goals),

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.json();
                            };

                            // Otherwise, throw an error
                            return response.json().then(function (msg) {
                                // console.log(response.json());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };

                // event listeners for the update user points button
                if (event.target.matches('#update-user-points-btn')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating User Points Totals...please wait";

                    fetch('https://www.worldcup2022predictor.com/inc/update-user-points.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click update-user-points-btn

                // event listener for the top ten users btn
                if (event.target.matches('#update-top-ten-btn')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating User Points Totals...please wait";

                    fetch('https://www.worldcup2022predictor.com/inc/static-top-ten.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click update-top-ten-btn

                // event listener for the top goal scorer update button
                if (event.target.matches('#update-top-scorer-btn')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating To Goal Scorer...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/inc/static-top-goal-scorer.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click update-top-scorer-btn

                // event listeners for the update latest results button
                if (event.target.matches('#update-latest-results-btn')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating Latest Results...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/inc/static-latest-results.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click update-latest-results-btn

                // event listeners for the update latest results button
                if (event.target.matches('#update-upcoming-fixtures-btn')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating Upcoming Fixtures...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/inc/static-upcoming-fixtures.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click update-competition-stats-btn

                // event listeners for the update competition Statistics button
                if (event.target.matches('#update-comp-stats-btn')) {

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Updating Competition Statistics Fixtures...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/inc/static-statistics.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click update-competition-stats-btn

                // ------------------------------------------------
                // event listeners for the import Fixtures button
                // ------------------------------------------------
                if (event.target.matches('#import-fixtures-btn')) {

                    document.getElementById("import-fixtures-btn").style.display = "none";
                    document.getElementById("import-fixtures-no-btn").style.display = "block";
                    document.getElementById("import-fixtures-yes-btn").style.display = "block";

                };  // end of click import-fixtures-btn

                // event listeners for the import fixtures button
                if (event.target.matches('#import-fixtures-no-btn')) {

                    document.getElementById("import-fixtures-btn").style.display = "block";
                    document.getElementById("import-fixtures-no-btn").style.display = "none";
                    document.getElementById("import-fixtures-yes-btn").style.display = "none";

                };  // end of click import-fixtures-no-btn

                // event listeners for the import Venues button
                if (event.target.matches('#import-fixtures-yes-btn')) {

                    document.getElementById("import-fixtures-btn").style.display = "block";
                    document.getElementById("import-fixtures-no-btn").style.display = "none";
                    document.getElementById("import-fixtures-yes-btn").style.display = "none";

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Importing Fixtures...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/mysql/fixtures_import.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click import-fixtures-yes-btn

                // ------------------------------------------------
                // event listeners for the import groups button
                // ------------------------------------------------
                if (event.target.matches('#import-groups-btn')) {

                    document.getElementById("import-groups-btn").style.display = "none";
                    document.getElementById("import-groups-no-btn").style.display = "block";
                    document.getElementById("import-groups-yes-btn").style.display = "block";

                };  // end of click import-groups-btn

                // event listeners for the import groups button
                if (event.target.matches('#import-groups-no-btn')) {

                    document.getElementById("import-groups-btn").style.display = "block";
                    document.getElementById("import-groups-no-btn").style.display = "none";
                    document.getElementById("import-groups-yes-btn").style.display = "none";

                };  // end of click import-groups-no-btn

                // event listeners for the import Venues button
                if (event.target.matches('#import-groups-yes-btn')) {

                    document.getElementById("import-groups-btn").style.display = "block";
                    document.getElementById("import-groups-no-btn").style.display = "none";
                    document.getElementById("import-groups-yes-btn").style.display = "none";

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Importing groups...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/mysql/groups_import.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click import-groups-yes-btn

                // ------------------------------------------------
                // event listeners for the import results button
                // ------------------------------------------------
                if (event.target.matches('#import-results-btn')) {

                    document.getElementById("import-results-btn").style.display = "none";
                    document.getElementById("import-results-no-btn").style.display = "block";
                    document.getElementById("import-results-yes-btn").style.display = "block";

                };  // end of click import-results-btn

                // event listeners for the import results button
                if (event.target.matches('#import-results-no-btn')) {

                    document.getElementById("import-results-btn").style.display = "block";
                    document.getElementById("import-results-no-btn").style.display = "none";
                    document.getElementById("import-results-yes-btn").style.display = "none";

                };  // end of click import-results-no-btn

                // event listeners for the import Venues button
                if (event.target.matches('#import-results-yes-btn')) {

                    document.getElementById("import-results-btn").style.display = "block";
                    document.getElementById("import-results-no-btn").style.display = "none";
                    document.getElementById("import-results-yes-btn").style.display = "none";

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Importing results...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/mysql/results_import.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click import-results-yes-btn

                // ------------------------------------------------
                // event listeners for the import rounds button
                // ------------------------------------------------
                if (event.target.matches('#import-rounds-btn')) {

                    document.getElementById("import-rounds-btn").style.display = "none";
                    document.getElementById("import-rounds-no-btn").style.display = "block";
                    document.getElementById("import-rounds-yes-btn").style.display = "block";

                };  // end of click import-rounds-btn

                // event listeners for the import rounds button
                if (event.target.matches('#import-rounds-no-btn')) {

                    document.getElementById("import-rounds-btn").style.display = "block";
                    document.getElementById("import-rounds-no-btn").style.display = "none";
                    document.getElementById("import-rounds-yes-btn").style.display = "none";

                };  // end of click import-rounds-no-btn

                // event listeners for the import Venues button
                if (event.target.matches('#import-rounds-yes-btn')) {

                    document.getElementById("import-rounds-btn").style.display = "block";
                    document.getElementById("import-rounds-no-btn").style.display = "none";
                    document.getElementById("import-rounds-yes-btn").style.display = "none";

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Importing rounds...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/mysql/rounds_import.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click import-rounds-yes-btn

                // ------------------------------------------------
                // event listeners for the import teams button
                // ------------------------------------------------
                if (event.target.matches('#import-teams-btn')) {

                    document.getElementById("import-teams-btn").style.display = "none";
                    document.getElementById("import-teams-no-btn").style.display = "block";
                    document.getElementById("import-teams-yes-btn").style.display = "block";

                };  // end of click import-teams-btn

                // event listeners for the import teams button
                if (event.target.matches('#import-teams-no-btn')) {

                    document.getElementById("import-teams-btn").style.display = "block";
                    document.getElementById("import-teams-no-btn").style.display = "none";
                    document.getElementById("import-teams-yes-btn").style.display = "none";

                };  // end of click import-teams-no-btn

                // event listeners for the import Venues button
                if (event.target.matches('#import-teams-yes-btn')) {

                    document.getElementById("import-teams-btn").style.display = "block";
                    document.getElementById("import-teams-no-btn").style.display = "none";
                    document.getElementById("import-teams-yes-btn").style.display = "none";

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Importing teams...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/mysql/teams_import.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click import-teams-yes-btn

                // ------------------------------------------------
                // event listeners for the import Venues button
                // ------------------------------------------------
                if (event.target.matches('#import-venues-btn')) {

                    document.getElementById("import-venues-btn").style.display = "none";
                    document.getElementById("import-venues-no-btn").style.display = "block";
                    document.getElementById("import-venues-yes-btn").style.display = "block";

                };  // end of click import-venues-btn

                // event listeners for the import Venues button
                if (event.target.matches('#import-venues-no-btn')) {

                    document.getElementById("import-venues-btn").style.display = "block";
                    document.getElementById("import-venues-no-btn").style.display = "none";
                    document.getElementById("import-venues-yes-btn").style.display = "none";

                };  // end of click import-venues-no-btn

                // event listeners for the import Venues button
                if (event.target.matches('#import-venues-yes-btn')) {

                    document.getElementById("import-venues-no-btn").style.display = "none";
                    document.getElementById("import-venues-yes-btn").style.display = "none";
                    document.getElementById("import-venues-btn").style.display = "block";

                    document.getElementById("update-msg").style.display = "block";
                    document.getElementById("update-msg").innerHTML = "Importing Venues...Please Wait";

                    fetch('https://www.worldcup2022predictor.com/mysql/venues_import.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: "Dummy Data",

                        }).then(function (response) {

                            // If the response is successful, get the JSON
                            if (response.ok) {
                                return response.text();
                            };

                            // Otherwise, throw an error
                            return response.text().then(function (msg) {
                                // console.log(response.text());
                                throw msg;
                            });

                        }).then(function (data) {

                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            document.getElementById("update-msg").style.display = "block";
                            document.getElementById("update-msg").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                };  // end of click import-venues-yes-btn

            }, false);   // end of CLICK event listener
            
            // ==================================================================
            // add CHANGE event listener for the INPUT fields
            // ==================================================================
            document.addEventListener('change', function (event) {

                /**
                 * When the scores are changed in the fixture table the update button still retains the original
                 * values for the home score and away score. So the DATA- values need updated with the new scores 
                 */
                // event listeners for the fixture update buttons
                if (event.target.matches('.homescore')) {

                    var fixid = document.getElementById(event.target.name);

                    fxnum  = fixid.dataset.fx 
                    hscore = fixid.dataset.hs 
                    ascore = fixid.dataset.as 

                    var updfixid = document.querySelectorAll("[name='" + event.target.name +  "']");

                    fixid.dataset.hs = updfixid[0].value; 

                };

                if (event.target.matches('.awayscore')) {

                    var fixid = document.getElementById(event.target.name);

                    fxnum  = fixid.dataset.fx 
                    hscore = fixid.dataset.hs 
                    ascore = fixid.dataset.as 

                    var updfixid = document.querySelectorAll("[name='" + event.target.name +  "']");

                    fixid.dataset.as = updfixid[1].value; 

                };

            }, false);   // end of CHANGE event listener

        </script>
    </body>
</html>