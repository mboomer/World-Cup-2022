<?php
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fixtures and Results</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles-fixtures-results.css">
        
        <script src="https://kit.fontawesome.com/130d5316ba.js" crossorigin="anonymous"></script>
        
    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <h1>Fixtures and Results</h1>
            </header>
            
            <nav class="options">
                 <a href="#" target="_blank" class="options-link">Home</a>
                 <a href="#" target="_blank" class="options-link">Predictions</a>
                 <a href="#" target="_blank" class="options-link">Fixtures / Results</a>
                 <a href="#" target="_blank" class="options-link">Top Scores</a>
            </nav>

            <section id="tournament">
                
                <div id="fixtures">

                    <?php
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
                                . "  	rnd.Description as rounddesc,  \n"
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
                                echo "  <div id='fixtures-tbl'>";

                                echo "      <table>";
                                echo "          <thead class='greenheader'>";
                                echo "              <tr>";
                                echo "                  <th>No</th><th class='hidden'><th class='hidden'></th><th>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th>";
                                echo "                  <th class='hidden'></th> <th>AWAY</th>";
                                echo "              </tr>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                
                                while ($row = $result->fetch_assoc()) {

                                        $fixno     = $row["fixtureno"];
                                        $homeid    = $row["homeid"];
                                        $hometeam  = $row["hometeam"];
                                        $homerank  = $row["homerank"];
                                        $homescore = $row["homescore"];
                                        $awayscore = $row["awayscore"];
                                        $awayrank  = $row["awayrank"];
                                        $awayteam  = $row["awayteam"];
                                        $awayid    = $row["awayid"];
                                        $grpdesc   = $row["groupdesc"];
                                        $rndcode   = $row["roundcode"];

                                            echo "  <tr>";
                                            echo "      <td class='fixno'>" . $fixno . "</td>";
                                            echo "      <td class='stage hidden'>" . $rndcode . "</td>";                      // hidden cell for code of the tournament stage 
                                            echo "      <td class='homeid hidden'>" . $homeid . "</td>";        // hidden cell for ID of home team
                                            echo "      <td class='home'>" . $hometeam . "</td>";
                                            echo "      <td class='h-rank'>" . $homerank . "</td>";
                                            echo "      <td>" . $homescore . "</td>";
                                            echo "      <td>" . $awayscore . "</td>";
                                            echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                            echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                                            echo "      <td class='away'>" . $awayteam . "</td>";
                                            echo "  </tr>";
                                }

                                echo "          </tbody>";
                                echo "      </table>";   
                                echo "  </div>  <!-- end of fixture-tbl div -->";     
                            };

                    ?>  <!-- end of the FIXTURES php -->

                </div> <!-- end of FIXTURES section -->

                <div id="results">

                    <?php

                        $qry =    "SELECT \n" 
                                . "  	FixtureNo		as fixtureno, \n"
                                . "  	DatePlayed		as dateplayed, \n"
                                . "  	TimePlayed		as timeplayed, \n"
                                . "  	HomeScore		as homescore, \n"
                                . "  	AwayScore		as awayscore, \n"
                                . "  	grp.Description as groupdesc, \n"
                                . "  	rnd.Description as rounddesc,  \n"
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
                                echo "  <div id='results-tbl'>";

                                echo "      <table>";
                                echo "          <thead class='blueheader'>";
                                echo "              <tr>";
                                echo "                  <th>No</th><th class='hidden'><th class='hidden'></th><th>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th>";
                                echo "                  <th class='hidden'></th> <th>AWAY</th>";
                                echo "              </tr>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                
                                while ($row = $result->fetch_assoc()) {

                                        // echo "<div> IN THE WHILE LOOP </div>";
                                
                                        $fixno     = $row["fixtureno"];
                                        $homeid    = $row["homeid"];
                                        $hometeam  = $row["hometeam"];
                                        $homerank  = $row["homerank"];
                                        $homescore = $row["homescore"];
                                        $awayscore = $row["awayscore"];
                                        $awayrank  = $row["awayrank"];
                                        $awayteam  = $row["awayteam"];
                                        $awayid    = $row["awayid"];
                                        $grpdesc   = $row["groupdesc"];
                                        $rndcode   = $row["roundcode"];

                                            echo "  <tr>";
                                            echo "      <td class='fixno'>" . $fixno . "</td>";
                                            echo "      <td class='stage hidden'>" . $rndcode . "</td>";                      // hidden cell for code of the tournament stage 
                                            echo "      <td class='homeid hidden'>" . $homeid . "</td>";        // hidden cell for ID of home team
                                            echo "      <td class='home'>" . $hometeam . "</td>";
                                            echo "      <td class='h-rank'>" . $homerank . "</td>";
                                            echo "      <td>" . $homescore . "</td>";
                                            echo "      <td>" . $awayscore . "</td>";
                                            echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                            echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                                            echo "      <td class='away'>" . $awayteam . "</td>";
                                            echo "  </tr>";
                                }

                                echo "          </tbody>";
                                echo "      </table>";   
                                echo "  </div>  <!-- end of results-tbl div -->";     
                            };

                    ?> <!-- end of the RESULTS php -->

                </div> <!-- end of RESULTS section -->

            </section> <!-- end of Tournment -->

            <footer id="social-media">
                <ul>
                    <li><a href='#' target='_blank'><i class='fab fa-facebook-square'></i></a></li>
                    <li><a href='#' target='_blank'><i class='fab fa-twitter-square'></i></a></li>
                    <li><a href='#' target='_blank'><i class='fab fa-youtube-square'></i></a></li>
                    <li><a href='#' target='_blank'><i class='fab fa-instagram-square'></i></a></li>
                </ul>
                <p>&copy; <script>document.write(new Date().getFullYear());</script> World Cup 2022 Predictor</p>
                <p>All Rights Reserved &mdash; Designed by Mark Boomer</p>
            </footer>
            
        </main>
    
        <script type="text/javascript" >

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                console.log("Something was clicked on");

            }, false);   // end of CLICK event listener

            // ==================================================================
            // add CHANGE event listener for the INPUT fields
            // ==================================================================
            document.addEventListener('change', function (event) {

                console.log("Something Changed");

            }, false);   // end of CHANGE event listener

        </script>

    </body>

</html>