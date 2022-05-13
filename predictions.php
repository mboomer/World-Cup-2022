<?php
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Predictions</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="../css/styles-predictions.css">
        
        <script src="https://kit.fontawesome.com/130d5316ba.js" crossorigin="anonymous"></script>
        
    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <h1>World Cup 2022 Predictions</h1>
            </header>
            
            <nav class="options">
                 <a href="#" target="_blank" class="options-link">Home</a>
                 <a href="#" target="_blank" class="options-link">Predictions</a>
                 <a href="#" target="_blank" class="options-link">Fixtures / Results</a>
                 <a href="#" target="_blank" class="options-link">Top Scores</a>
            </nav>
            
            <!-- Tab links -->
            <div id="tabs" class="tab">
              <button id="group-stages" name="GROUPS" class="tablinks active">Group Stage</button>
              <button id="knockout-stage" name="KNOCKOUT-STAGE" class="tablinks ">Knockout Stage</button>
            </div>

            <section id="tournment">
                
                <div id="GROUPS" class="tabcontent">

                    <?php
                        // Create database connection
                        $conn = new mysqli($servername, $username, $password, $db);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error . "<br");
                        } else {
                            // echo "<div>" . "Connection successful" . "</div>";
                        }

                        $groupids     = array(1, 2, 3, 4);
                        $groupnames   = array("", "GroupA", "GroupB", "GroupC", "GroupD"); 
                        $groupdescs   = array("", "Group A", "Group B", "Group C", "Group D"); 
                        $sectionnames = array("", "SectionA", "SectionB", "SectionC", "SectionD"); 
                        $tablenames   = array("", "TableA", "TableB", "TableC", "TableD");

                        foreach ($groupids as $groupid) {

                            $sectionname = $sectionnames[$groupid];
                            $groupname   = $groupnames[$groupid];
                            $groupdesc   = $groupdescs[$groupid];
                            $tablename   = $tablenames[$groupid];

                            $qry =   "SELECT \n" 
                                    . "  	fx.FixtureNo,  \n"
                                    . "     grp.Description as groupdesc, \n"
                                    . "     hmt.Team as hometeam, \n"
                                    . "     hmt.Ranking as homerank, \n"
                                    . "     awt.Ranking as awayrank, \n"
                                    . "     awt.Team as awayteam\n"
                                    . "  FROM  \n"
                                    . "  	Fixtures fx \n"
                                    . "  	INNER JOIN						# get the Group description from GroupStage table \n"
                                    . "  		GroupStage grp \n"
                                    . "  	ON \n"
                                    . "  		fx.GroupID = grp.ID \n"
                                    . "  	INNER JOIN						# get the Home TEam from the Teams table \n"
                                    . "  		Teams hmt \n"
                                    . "  	ON \n"
                                    . "  		fx.HomeTeamID = hmt.ID \n"
                                    . "  	INNER JOIN						# get the Away Team from teh Teams table \n"
                                    . "  		Teams awt \n"
                                    . "  	ON \n"
                                    . "  		fx.AwayTeamID = awt.ID \n"
                                    . "  WHERE  \n"
                                    . "  	fx.GroupID = " . $groupid . " \n"
                                    . "  ORDER BY \n"
                                    . "  	fx.FixtureNo \n";

                                $result = $conn->query($qry);

                                if ($result->num_rows == 0) {
                                    echo "<div>NO RESULTS RETURNED</div>";
                                } else {
                                    echo "<section id='" . $sectionname . "'>";
                                    echo "  <div id='" . $groupname . "'>";

                                    echo "      <table>";
                                    echo "          <thead class='greenheader'>";
                                    echo "              <tr>";
                                    echo "                  <th>No</th> <th>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th> <th>AWAY</th>";
                                    echo "              </tr>";
                                    echo "          </thead>";
                                    echo "          <tbody>";
                                  
                                    while ($row = $result->fetch_assoc()) {

                                            // echo "<div> IN THE WHILE LOOP </div>";
                                    
                                            $fixno    = $row["FixtureNo"];
                                            $hometeam = $row["hometeam"];
                                            $homerank = $row["homerank"];
                                            $awayrank = $row["awayrank"];
                                            $awayteam = $row["awayteam"];
                                            $grpdesc  = $row["groupdesc"];

                                                echo "  <tr>";
                                                echo "      <td class='pos'>" . $fixno . "</td> <td class='home'>" . $hometeam . "</td> <td class='rank'>" . $homerank . "</td> ";
                                                echo "      <td><input type='number' min='0' placeholder='0'></td>";
                                                echo "      <td><input type='number' min='0' placeholder='0'></td>";
                                                echo "      <td class='rank'>" . $awayrank . "</td> <td class='away'>" . $awayteam . "</td>";
                                                echo "  </tr>";
                                    }

                                    echo "          </tbody>";
                                    echo "      </table>";   
                                    echo "  </div>  <!-- end of group div -->";     

                                // Start SQL QRY FOR THE TABLES
                                $qry =   "SELECT \n" 
                                        . "  	Team  \n"
                                        . "  FROM  \n"
                                        . "  	Teams \n"
                                        . "  WHERE  \n"
                                        . "  	GroupID = " . $groupid . " \n"
                                        . "  ORDER BY \n"
                                        . "  	Team ASC \n";

                                    $result = $conn->query($qry);

                                    if ($result->num_rows == 0) {
                                        echo "<div>NO RESULTS RETURNED FOR TEAMS QUERY</div>";
                                    } else {
                                    //     // echo "<section id='" . $sectionname . "'>";
                                    //     // echo "  <div id='" . $groupname . "'>";

                                        echo "  <div id='" . $tablename . "'>"; 
                                        echo "      <table>";
                                        echo "          <thead class='blueheader'>";
                                        echo "              <tr>";
                                        echo "                  <th colspan='10'>" . $groupdesc .  "</th>";
                                        echo "              </tr>";
                                        echo "              <tr>";
                                        echo "                  <th>Pos</th><th>Team</th><th>P</th><th>W</th><th>D</th><th>L</th><th>F</th><th>A</th><th>GD</th><th>Pts</th>";
                                        echo "              </tr>";
                                        echo "          </thead>";
                                        echo "          <tbody>";

                                        while ($row = $result->fetch_assoc()) {
                                        
                                            echo "          <tr>";
                                            echo "              <td class='pos'>1</td><td class='team'>" . $row['Team'] . "</td><td class='cols'>0</td> <td class='cols'>0</td>";
                                            echo "              <td class='cols'>0</td><td class='cols'>0</td><td class='cols'>0</td> <td class='cols'>0</td> <td class='cols'>0</td>";
                                            echo "              <td class='cols'>0</td>";
                                            echo "          </tr>";
                                        }
                                        echo "          </tbody>";
                                        echo "      </table>";
                                    } // end of nested else for Table        
                                    //     // END SQL QRY

                                        // echo "  </div> <!-- end of group table div -->";
                                    echo "</section> <!-- end of section div -->";                         

                                } // end of else

                        }   // end of foreach    

                        // Close database connection
                        $conn->close();                             
                    ?>

                </div> <!-- end of GROUPS -->

                <div id="KNOCKOUT-STAGE" class="tabcontent">

                    <section id="QF">
                        <div id="QuarterFinal">

                            <table>
                                <thead class="blueheader">
                                    <tr>
                                        <th colspan="7">QUARTER FINALS</th>
                                    </tr>
                                    <tr>
                                        <th>No</th> <th>HOME</th> <th>Rk</th> <th colspan="2">SCORE</th> <th>Rk</th> <th>AWAY</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <tr>
                                    <td class='pos'>1</td> <td class="home">Turkey</td> <td class="rank">6</td> 
                                    <td><input type="number" min="0" placeholder="0"></td> 
                                    <td><input type="number" min="0" placeholder="0"></td>
                                    <td class="rank">7</td> <td class="away">Italy</td>
                                </tr>
                                <tr>
                                    <td class='pos'>2</td> <td class="home">Wales</td> <td class="rank">14</td> 
                                    <td><input type="number" min="0" placeholder="0"></td> 
                                    <td><input type="number" placeholder="0"></td>
                                    <td class="rank">9</td> <td class="away">Switzerland</td>
                                </tr>
                                <tr>
                                    <td class='pos'>14</td> <td class="home">Turkey</td> <td class="rank">6</td>
                                    <td><input type="number" min="0" placeholder="0"></td> 
                                    <td><input type="number" min="0" placeholder="0"></td>                                
                                    <td class="rank">14</td> <td class="away">Wales</td>
                                </tr>
                                <tr>
                                    <td class='pos'>15</td> <td class="home">Italy</td> <td class="rank">7</td> 
                                    <td><input type="number" min="0" placeholder="0"></td> 
                                    <td><input type="number" min="0" placeholder="0"></td>
                                    <td class="rank">9</td> <td class="away">Switzerland</td>
                                </tr>
                              </tbody>
                            </table>        
                        </div>
                    </section> <!-- End of QF -->

                    <section id="SF">
                        <div id="SemiFinal">
                            <table>
                                <thead class="blueheader">
                                    <tr>
                                        <th colspan="7">SEMI FINALS</th>
                                    </tr>
                                    <tr>
                                        <th>No</th> <th>HOME</th> <th>Rk</th> <th colspan="2">SCORE</th> <th>Rk</th> <th>AWAY</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <tr>
                                    <td class='pos'>1</td> <td class="home">Denmark</td> <td class="rank">6</td> 
                                    <td><input type="number" placeholder="0"></td> 
                                    <td><input type="number" placeholder="0"></td>
                                    <td class="rank">7</td> <td class="away">Finland</td>
                                </tr>
                                <tr>
                                    <td class='pos'>2</td> <td class="home">Belgium</td> <td class="rank">14</td> 
                                    <td><input type="number" placeholder="0"></td> 
                                    <td><input type="number" placeholder="0"></td>
                                    <td class="rank">9</td> <td class="away">Russia</td>
                                </tr>
                              </tbody>
                            </table>        
                        </div>

                    </section> <!-- End of Semi Final -->

                    <section id="FL">
                        <div id="Final">
                            <table>
                                <thead class="blueheader">
                                    <tr>
                                        <th colspan="7">FINAL</th>
                                    </tr>
                                    <tr>
                                        <th>No</th> <th>HOME</th> <th>Rk</th> <th colspan="2">SCORE</th> <th>Rk</th> <th>AWAY</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <tr>
                                    <td class='pos'>1</td> <td class="home">Denmark</td> <td class="rank">6</td> 
                                    <td><input type="number" placeholder="0"></td> 
                                    <td><input type="number" placeholder="0"></td>
                                    <td class="rank">7</td> <td class="away">Finland</td>
                                </tr>
                              </tbody>
                            </table>        
                        </div>

                    </section> <!-- End of Final -->

                </div> <!-- end of KNOCKOUT STAGES -->

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

            // Change the display of the content tab from none to flex to display content
            // Hide the Knockout stage 
            document.getElementById("KNOCKOUT-STAGE").style.display = "none";

            // add CLICK event listener for the DOM
            document.addEventListener('click', function (event) {

                // event listeners for the tab links
                if (event.target.matches('.tablinks')) {
                    displayStage(event, event.target.name);

                    console.log(event.target.className)
                    event.target.className += " active";
                }
            }, false);

            // Display the content of the selected tab and highlight the tab
            function displayStage(evt, tabname) {

                // Declare all variables
                var i, tabcontent, tablinks;

                // Get all elements with class="tabcontent" and hide them
                tabcontent = document.getElementsByClassName("tabcontent");                
            
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                // Get all elements with class="tablinks" and remove the class "active"
                tablinks = document.getElementsByClassName("tablinks");
                                
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }
                
                // Show the selected tab content and add an "active" class to the button that selected the tab
                if (tabname == "GROUPS") {
                    document.getElementById(tabname).style.display = "grid";
                }
                else {
                    document.getElementById(tabname).style.display = "flex";
                }
            }

        </script>

    </body>

    
</html>