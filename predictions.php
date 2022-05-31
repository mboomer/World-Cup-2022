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
              <button id="save-predictions" name="SAVE-PREDICTIONS" class="tablinks ">Save Predictions</button>
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
                                    . "     hmt.ID as homeid, \n"
                                    . "     hmt.Team as hometeam, \n"
                                    . "     hmt.Ranking as homerank, \n"
                                    . "     awt.Ranking as awayrank, \n"
                                    . "     awt.Team as awayteam, \n"
                                    . "     awt.ID as awayid \n"
                                    . "  FROM  \n"
                                    . "  	Fixtures fx \n"
                                    . "  	INNER JOIN						# get the Group description from GroupStage table \n"
                                    . "  		GroupStage grp \n"
                                    . "  	ON \n"
                                    . "  		fx.GroupID = grp.ID \n"
                                    . "  	INNER JOIN						# get the Home Team from the Teams table \n"
                                    . "  		Teams hmt \n"
                                    . "  	ON \n"
                                    . "  		fx.HomeTeamID = hmt.ID \n"
                                    . "  	INNER JOIN						# get the Away Team from the Teams table \n"
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
                                    echo "                  <th>No</th> <th class='hidden'></th> <th>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th> <th class='hidden'></th> <th>AWAY</th>";
                                    echo "              </tr>";
                                    echo "          </thead>";
                                    echo "          <tbody>";
                                  
                                    while ($row = $result->fetch_assoc()) {

                                            // echo "<div> IN THE WHILE LOOP </div>";
                                    
                                            $fixno    = $row["FixtureNo"];
                                            $homeid   = $row["homeid"];
                                            $hometeam = $row["hometeam"];
                                            $homerank = $row["homerank"];
                                            $awayrank = $row["awayrank"];
                                            $awayteam = $row["awayteam"];
                                            $awayid   = $row["awayid"];
                                            $grpdesc  = $row["groupdesc"];

                                                echo "  <tr>";
                                                echo "      <td class='pos'>" . $fixno . "</td>";
                                                echo "      <td class='homeid hidden'>" . $homeid . "</td>";        // hidden cell for ID of home team
                                                echo "      <td class='home'>" . $hometeam . "</td>";
                                                echo "      <td class='h-rank'>" . $homerank . "</td>";
                                                echo "      <td><input class='homescore' data-table='" . $tablename . "' type='number' value=0 min=0 placeholder=0></td>";
                                                echo "      <td><input class='awayscore' data-table='" . $tablename . "' type='number' value=0 min=0 placeholder=0></td>";
                                                echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                                echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                                                echo "      <td class='away'>" . $awayteam . "</td>";
                                                echo "  </tr>";
                                    }

                                    echo "          </tbody>";
                                    echo "      </table>";   
                                    echo "  </div>  <!-- end of group div -->";     

                                // Start SQL QRY FOR THE TABLES
                                $qry =   "SELECT \n" 
                                        . "  	ID,  \n"
                                        . "  	Ranking,  \n"
                                        . "  	Team  \n"
                                        . "  FROM  \n"
                                        . "  	Teams \n"
                                        . "  WHERE  \n"
                                        . "  	GroupID = " . $groupid . " \n"
                                        . "  ORDER BY \n"
                                        . "  	Team ASC \n";

                                    $rowno = 0;     // Initialise row counter to identify league position

                                    $result = $conn->query($qry);

                                    if ($result->num_rows == 0) {
                                        echo "<div>NO RESULTS RETURNED FOR TEAMS QUERY</div>";
                                    } else {
                                        echo "  <div id='" . $tablename . "'>"; 
                                        echo "      <table>";
                                        echo "          <thead class='blueheader'>";
                                        echo "              <tr>";
                                        echo "                  <th colspan='10'>" . $groupdesc .  "</th>";
                                        echo "              </tr>";
                                        echo "              <tr>";
                                        echo "                  <th>Pos</th><th>Team</th><th class='hidden'></th><th class='hidden'></th>";
                                        echo "                  <th>P</th><th>W</th><th>D</th><th>L</th><th>F</th><th>A</th><th>GD</th><th>Pts</th>";
                                        echo "              </tr>";
                                        echo "          </thead>";
                                        echo "          <tbody>";

                                        $rowno = 1;         

                                        while ($row = $result->fetch_assoc()) {
                                        
                                            echo "          <tr>";
                                            echo "              <td class='pos'>" . $rowno . "</td><td id=" . $tablename . "-pos" . $rowno . " class='team'>" . $row['Team'] . "</td>";
                                            echo "              <td class='hidden team-id'>" . $row['ID'] . "</td> <td class='hidden team-rk'>" . $row['Ranking'] . "</td>";
                                            echo "              <td class='cols'>0</td> <td class='cols'>0</td><td class='cols'>0</td><td class='cols'>0</td><td class='cols'>0</td>";
                                            echo "              <td class='cols'>0</td> <td class='cols'>0</td><td class='cols'>0</td>";
                                            echo "          </tr>";

                                            $rowno = $rowno + 1;    // increment row counter
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
                                <thead class="greenheader">
                                    <tr>
                                        <th colspan="7">QUARTER FINALS</th>
                                    </tr>
                                    <tr>
                                        <th>No</th> <th>HOME</th> <th class="hidden"></th> <th>Rk</th> <th colspan="2">SCORE</th> <th>Rk</th> <th class="hidden"></th> <th>AWAY</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <tr>
                                    <td class='pos'>25</td> 
                                    <td id='winnerA' class='home'>Winner A</td> 
                                    <td class='hidden q-homeid'></td> 
                                    <td class='h-rank'></td> 
                                    <td><input class='homescore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td> 
                                    <td><input class='awayscore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td>
                                    <td class='a-rank'></td> 
                                    <td class='hidden q-awayid'></td> 
                                    <td id='runnerupB' class='away'>Runner Up B</td>
                                </tr>
                                <tr>
                                    <td class='pos'>26</td> 
                                    <td id='winnerB' class='home'>Winner B</td> 
                                    <td class='hidden q-homeid'></td> 
                                    <td class='h-rank'></td> 
                                    <td><input class='homescore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td> 
                                    <td><input class='awayscore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td>
                                    <td class='a-rank'></td> 
                                    <td class='hidden q-awayid'></td> 
                                    <td id='runnerupA' class='away'>Runner Up A</td>
                                </tr>
                                <tr>
                                    <td class='pos'>27</td>
                                    <td id='winnerC' class='home'>Winner C</td> 
                                    <td class='hidden q-homeid'></td> 
                                    <td class="h-rank"></td>
                                    <td><input class='homescore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td> 
                                    <td><input class='awayscore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td>                                
                                    <td class='a-rank'></td> 
                                    <td class='hidden q-awayid'></td> 
                                    <td id='runnerupD' class='away'>Runner Up D</td>
                                </tr>
                                <tr>
                                    <td class='pos'>28</td> 
                                    <td id='winnerD' class='home'>Winner D</td> 
                                    <td class='hidden q-homeid'></td> 
                                    <td class='h-rank'></td> 
                                    <td><input class='homescore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td> 
                                    <td><input class='awayscore' data-stage='QF' type='number' min=0 placeholder=0 value=0></td>
                                    <td class='a-rank'></td> 
                                    <td class='hidden q-awayid'></td> 
                                    <td id='runnerupC' class='away'>Runner Up C</td>
                                </tr>
                              </tbody>
                            </table>        
                        </div>
                    </section> <!-- End of QF -->

                    <section id="SF">
                        <div id="SemiFinal">
                            <table>
                                <thead class="greenheader">
                                    <tr>
                                        <th colspan="7">SEMI FINALS</th>
                                    </tr>
                                    <tr>
                                        <th>No</th> <th>HOME</th> <th class="hidden"></th> <th>Rk</th> <th colspan="2">SCORE</th> <th>Rk</th> <th class="hidden"></th> <th>AWAY</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <tr>
                                    <td class='pos'>29</td> 
                                    <td id='winnerQF1' class='home'>Winner QF 1</td> 
                                    <td class='hidden s-homeid'></td> 
                                    <td class='h-rank'></td> 
                                    <td><input class='homescore' data-stage='SF' type='number' min=0 placeholder=0 value=0></td> 
                                    <td><input class='awayscore' data-stage='SF' type='number' min=0 placeholder=0 value=0></td>
                                    <td class='a-rank'></td> 
                                    <td class='hidden s-awayid'></td> 
                                    <td id='winnerQF2' class='away'>Winner QF 2</td>
                                </tr>
                                <tr>
                                    <td class='pos'>30</td> 
                                    <td id='winnerQF3' class='home'>Winner QF 3</td> 
                                    <td class='hidden s-homeid'></td> 
                                    <td class='h-rank'></td> 
                                    <td><input class='homescore' data-stage='SF' type='number' min=0 placeholder=0 value=0></td> 
                                    <td><input class='awayscore' data-stage='SF' type='number' min=0 placeholder=0 value=0></td>
                                    <td class='a-rank'></td> 
                                    <td class='hidden s-awayid'></td> 
                                    <td id='winnerQF4' class='away'>Winner QF 4</td>
                                </tr>
                              </tbody>
                            </table>        
                        </div>

                    </section> <!-- End of Semi Final -->

                    <section id="FL">
                        <div id="Final">
                            <table>
                                <thead class="greenheader">
                                    <tr>
                                        <th colspan="7">FINAL</th>
                                    </tr>
                                    <tr>
                                        <th>No</th> <th>HOME</th> <th class="hidden"></th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th> <th class="hidden"></th> <th>AWAY</th>
                                    </tr>
                                </thead>
                              <tbody>
                                <tr>
                                    <td class='pos'>31</td> 
                                    <td id='winnerSF1' class='home'>Winner SF 1</td> 
                                    <td class='hidden f-homeid'></td> 
                                    <td class='h-rank'></td> 
                                    <td><input class='homescore' data-stage='FL' type='number' min=0 placeholder=0 value=0></td> 
                                    <td><input class='awayscore' data-stage='FL' type='number' min=0 placeholder=0 value=0></td>
                                    <td class='a-rank'></td> 
                                    <td class='hidden f-homeid'></td> 
                                    <td id='winnerSF2' class='away'>Winner SF 2</td>
                                </tr>
                              </tbody>
                            </table>        
                        </div>

                    </section> <!-- End of Final -->

                </div> <!-- end of KNOCKOUT STAGES -->

                <div id="SAVE-PREDICTIONS" class="tabcontent">
                    <section id='save-predictions'>
                        <div id='confirm-save'>
                            <input type='checkbox' id='confirm-chkbox' name='confirm-chkbox'>
                            <label for="confirm-chkbox">Check to confirm that you want to save your predictions</label>
                        </div>
                        <div id='chkbox-error' style="display:none;">
                            Click the Checkbox to confirm that you want to save your predictions
                        </div>
                        <div id='confirm-btn'>
                            <button type='button' id='save-btn' class='predictions-btn'>Save Predictions</button>
                        </div>
                    </section>
                </div>  <!-- end of SAVE PREDICTIONS -->
                
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

            scores = document.querySelectorAll('.score');

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                if (event.target.matches('#save-btn')) {

                    document.getElementById("chkbox-error").style.display = "block";
                    return;                
                }
                
                if (event.target.matches('#confirm-chkbox')) {

                    document.getElementById("chkbox-error").style.display = "none";
                    return;                
                }

                // event listeners for the tab links
                if (event.target.matches('.tablinks')) {

                    displayStage(event, event.target.name);
                    event.target.className += " active";

                }

                // event listeners for the tab links
                if (event.target.matches('#knockout-stage')) {

                    // winner and runnerup teams in each of the group tables
                    let winnergroupA   = document.getElementById("TableA-pos1").innerHTML;
                    let winnergroupAid = document.getElementById("TableA-pos1").nextElementSibling.innerHTML;
                    let winnergroupArk = document.getElementById("TableA-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    // console.log(winnergroupAid, " - ", winnergroupArk);

                    let runnerupgroupA   = document.getElementById("TableA-pos2").innerHTML;
                    let runnerupgroupAid = document.getElementById("TableA-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupArk = document.getElementById("TableA-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    let winnergroupB    = document.getElementById("TableB-pos1").innerHTML;
                    let winnergroupBid  = document.getElementById("TableB-pos1").nextElementSibling.innerHTML;
                    let winnergroupBrk  = document.getElementById("TableB-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    let runnerupgroupB   = document.getElementById("TableB-pos2").innerHTML;
                    let runnerupgroupBid = document.getElementById("TableB-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupBrk = document.getElementById("TableB-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    let winnergroupC    = document.getElementById("TableC-pos1").innerHTML;
                    let winnergroupCid  = document.getElementById("TableC-pos1").nextElementSibling.innerHTML;
                    let winnergroupCrk  = document.getElementById("TableC-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    let runnerupgroupC   = document.getElementById("TableC-pos2").innerHTML;
                    let runnerupgroupCid = document.getElementById("TableC-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupCrk = document.getElementById("TableC-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    let winnergroupD    = document.getElementById("TableD-pos1").innerHTML;
                    let winnergroupDid  = document.getElementById("TableD-pos1").nextElementSibling.innerHTML;
                    let winnergroupDrk  = document.getElementById("TableD-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    let runnerupgroupD   = document.getElementById("TableD-pos2").innerHTML;
                    let runnerupgroupDid = document.getElementById("TableD-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupDrk = document.getElementById("TableD-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    // Quarter Final 1
                    document.getElementById("winnerA").innerHTML = winnergroupA;
                    document.getElementById("winnerA").nextElementSibling.innerHTML = winnergroupAid;
                    document.getElementById("winnerA").nextElementSibling.nextElementSibling.innerHTML = winnergroupArk;

                    document.getElementById("runnerupB").innerHTML = runnerupgroupB;
                    document.getElementById("runnerupB").previousElementSibling.innerHTML = runnerupgroupBid;
                    document.getElementById("runnerupB").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupBrk;

                    // Quarter Final 2
                    document.getElementById("winnerB").innerHTML = winnergroupB;
                    document.getElementById("winnerB").nextElementSibling.innerHTML = winnergroupBid;
                    document.getElementById("winnerB").nextElementSibling.nextElementSibling.innerHTML = winnergroupBrk;

                    document.getElementById("runnerupA").innerHTML = runnerupgroupA;
                    document.getElementById("runnerupA").previousElementSibling.innerHTML = runnerupgroupAid;
                    document.getElementById("runnerupA").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupArk;

                    // Quarter Final 3
                    document.getElementById("winnerC").innerHTML = winnergroupC;
                    document.getElementById("winnerC").nextElementSibling.innerHTML = winnergroupCid;
                    document.getElementById("winnerC").nextElementSibling.nextElementSibling.innerHTML = winnergroupCrk;

                    document.getElementById("runnerupD").innerHTML = runnerupgroupD;
                    document.getElementById("runnerupD").previousElementSibling.innerHTML = runnerupgroupDid;
                    document.getElementById("runnerupD").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupDrk;

                    // Quarter Final 4
                    document.getElementById("winnerD").innerHTML = winnergroupD;
                    document.getElementById("winnerD").nextElementSibling.innerHTML = winnergroupDid;
                    document.getElementById("winnerD").nextElementSibling.nextElementSibling.innerHTML = winnergroupDrk;

                    document.getElementById("runnerupC").innerHTML = runnerupgroupC;
                    document.getElementById("runnerupC").previousElementSibling.innerHTML = runnerupgroupCid;
                    document.getElementById("runnerupC").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupCrk;
                
                    // console.log("Knockout Stage clicked");

                }

            }, false);   // end of CLICK event listener

            // **********************************************************************************************************
            // Display the content of the selected tab and highlight the tab
            // **********************************************************************************************************
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
                else if (tabname == "KNOCKOUT-STAGE") {
                    document.getElementById(tabname).style.display = "flex";
                } 
                else {
                    document.getElementById(tabname).style.display = "block";
                }
            }

            // **********************************************************************************************************
            // https://atomizedobjects.com/blog/javascript/how-to-sort-an-array-of-objects-by-property-value-in-javascript/
            // return -1 arrayItemA before arrayItemB
            // return  0 not sorted as same value
            // return  1 arrayItemA after arrayItemB
            // **********************************************************************************************************
            //      Functions to sort the league table
            // **********************************************************************************************************

            function compPts(a, b) {

                if (a.Points > b.Points) {return -1}; 
                if (a.Points < b.Points) {return 1};
                return 0;
            };
            
            function compGD (a, b) {
                
                if (a.GoalDiff > b.GoalDiff) {return -1};
                if (a.GoalDiff < b.GoalDiff) {return 1};
                return 0;
            };
            
            function compGF (a, b) {

                if (a.For > b.For) {return -1};
                if (a.For < b.For) {return 1};
                return 0;
            };
            
            function leaguePosition (teamA, teamB) {
                
                // Sort by points
                const position = compPts(teamA, teamB)
                
                if (position !== 0) { return position; };

                // at this point we have 2 teams with equal points - so compare goal difference                
                const GD = compGD(teamA, teamB);
                
                if (GD !== 0) {return GD;};

                // at this point we will be looking at 2 teams with equal points and equal goal difference - so compare goals scored for
                return compGF(teamA, teamB);
                
            };
            
            // ==================================================================
            // define currentTable outside of the CHANGE event listener 
            // necessary as if its defined inside CHANGE event listener the scope
            // doesnt allow it to be accessed outside the CHANGE event listener
            // ==================================================================
            let currentTable;
            let currentTableID;
            let currentTableName;
            
            // ==================================================================
            // add CHANGE event listener for the INPUT fields
            // ==================================================================
            document.addEventListener('change', function (event) {

                if (event.target.matches('[data-stage="QF"]')) {

                    // console.log('Update Semi Final based on changes to the changes to the scores in the Quarter Finals');

                    let QF = document.querySelector('#QF');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeTeams  = QF.querySelectorAll('.home');            
                    homeScores = QF.querySelectorAll('.homescore');
                    awayScores = QF.querySelectorAll('.awayscore');
                    awayTeams  = QF.querySelectorAll('.away');

                    if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('winnerQF1').innerHTML = homeTeams[0].innerHTML;
                    } else if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('winnerQF1').innerHTML = awayTeams[0].innerHTML;
                    };
                        
                    if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('winnerQF2').innerHTML = homeTeams[1].innerHTML;
                    } else if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('winnerQF2').innerHTML = awayTeams[1].innerHTML;
                    };
 
                    if (homeScores[2].value > awayScores[2].value) {
                        document.getElementById('winnerQF3').innerHTML = homeTeams[2].innerHTML;
                    } else if (homeScores[2].value < awayScores[2].value) {
                        document.getElementById('winnerQF3').innerHTML = awayTeams[2].innerHTML;
                    };
 
                    if (homeScores[3].value > awayScores[3].value) {
                        document.getElementById('winnerQF4').innerHTML = homeTeams[3].innerHTML;
                    } else if (homeScores[3].value < awayScores[3].value) {
                        document.getElementById('winnerQF4').innerHTML = awayTeams[3].innerHTML;
                    };
                    
                    return;
                };

                if (event.target.matches('[data-stage="SF"]')) {

                    // console.log('Update Final based on changes to the changes to the scores in the Semi Finals');

                    let SF = document.querySelector('#SF');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeTeams  = SF.querySelectorAll('.home');            
                    homeScores = SF.querySelectorAll('.homescore');
                    awayScores = SF.querySelectorAll('.awayscore');
                    awayTeams  = SF.querySelectorAll('.away');

                    if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('winnerSF1').innerHTML = homeTeams[0].innerHTML;
                    } else if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('winnerSF1').innerHTML = awayTeams[0].innerHTML;
                    };
                        
                    if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('winnerSF2').innerHTML = homeTeams[1].innerHTML;
                    } else if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('winnerSF2').innerHTML = awayTeams[1].innerHTML;
                    };
                   
                    return;

                };

                if (event.target.matches('[data-table="TableA"]')) {

                    // console.log('Update Table A based on changes to the changes to the scores in Group A');
                    
                    let SectA = document.querySelector('#SectionA');
                    
                    // console.log(SectA);
                    
                    // get the teams and the scores for SectionA
                    homeTeams  = SectA.querySelectorAll('.home');            
                    homeScores = SectA.querySelectorAll('.homescore');
                    awayScores = SectA.querySelectorAll('.awayscore');
                    awayTeams  = SectA.querySelectorAll('.away');
                    
                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableA");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table A";
                    
                } else if (event.target.matches('[data-table="TableB"]')) {

                    console.log('Update Table B based on changes to the changes to the scores in Group B');

                    let SectB = document.querySelector('#SectionB');
                    
                    // console.log(SectB);
                    
                    // get the teams and the scores for SectionB
                    homeTeams  = SectB.querySelectorAll('.home');            
                    homeScores = SectB.querySelectorAll('.homescore');
                    awayScores = SectB.querySelectorAll('.awayscore');
                    awayTeams  = SectB.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableB");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table B";

                } else if (event.target.matches('[data-table="TableC"]')) {

                    // console.log('Update Table C based on changes to the changes to the scores in Group C');

                    SectC = document.querySelector('#SectionC');
                    
                    // console.log(SectC);
                    
                    // get the teams and the scores for SectionC
                    homeTeams  = SectC.querySelectorAll('.home');            
                    homeScores = SectC.querySelectorAll('.homescore');
                    awayScores = SectC.querySelectorAll('.awayscore');
                    awayTeams  = SectC.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableC");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table C";

                } else if (event.target.matches('[data-table="TableD"]')) {
                    
                    // console.log('Update Table D based on changes to the changes to the scores in Group D');

                    SectD = document.querySelector('#SectionD');
                    
                    // console.log(SectD);
                    
                    // get the teams and the scores for SectionD
                    homeTeams  = SectD.querySelectorAll('.home');            
                    homeScores = SectD.querySelectorAll('.homescore');
                    awayScores = SectD.querySelectorAll('.awayscore');
                    awayTeams  = SectD.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable      = document.getElementById("TableD");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table D";

                };  
                
                // get the teams and the scores
                //homeTeams  = document.querySelectorAll('.home');            
                //homeScores = document.querySelectorAll('.homescore');
                //awayScores = document.querySelectorAll('.awayscore');
                //awayTeams  = document.querySelectorAll('.away');
                
                // console.log(homeScores[1].value);

                // initialise the Teams Array and team object
                let teams = [];
                let team = {};
                
                // Create the array of objects that will be used to create the league table
                for (let f = 0; f < homeTeams.length; f++) {
                    
                    // check if home exists in array - if not add object for the team to the array
                    let found = teams.find(t => t.Team == homeTeams[f].textContent);
                    
                    if (found === undefined ) {                        
                        team = {Team : homeTeams[f].textContent, Played : 0, Won : 0, Drawn: 0, Lost : 0, For : 0, Against : 0, GoalDiff : 0, Points : 0};
                        teams.push(team);                        
                    };
                };

                // const Teams = [
                //    {Team : "England",          Played : 1, Won : 1, Drawn: 0, Lost : 0, For : 2, Against : 1, GoalDiff : 1,  Points : 3},
                //    {Team : "Norway",           Played : 1, Won : 0, Drawn: 0, Lost : 0, For : 0, Against : 0, GoalDiff : 0,  Points : 0},
                //    {Team : "Austria",          Played : 1, Won : 0, Drawn: 0, Lost : 1, For : 1, Against : 2, GoalDiff : -1, Points : 0},
                //    {Team : "Northern Ireland", Played : 1, Won : 0, Drawn: 0, Lost : 0, For : 0, Against : 0, GoalDiff : 0,  Points : 0}
                // ]
                
                // Update the object properties for each result

                //England	  2 1  Austria
                //Norway	  1 2  N Ireland
                //Austria	  2 1  N Ireland
                //England	  1 2  Norway
                //N Ireland   2 1  England
                //Austria	  1 2  Norway

                for (let f = 0; f < homeTeams.length; f++) {

                    let home = teams.findIndex(t => t.Team == homeTeams[f].textContent);                    
                    let away = teams.findIndex(t => t.Team == awayTeams[f].textContent);                    

                    teams[home].Played++;
                    teams[away].Played++;
                
                    if (homeScores[f].value > awayScores[f].value) {
                        teams[home].Won++;
                        teams[away].Lost++;
                    } else if (homeScores[f].value < awayScores[f].value) {
                        teams[away].Won++;
                        teams[home].Lost++;
                    } else {
                        teams[away].Drawn++;
                        teams[home].Drawn++;
                    };

                    // console.log(f + " Home Score : " + homeScores[f].value + " Away Score : " + awayScores[f].value);
                    
                    // have to convert to Number - for some reason .For and .Against are being treated as strings
                    teams[home].For      = Number(teams[home].For) + Number(homeScores[f].value);
                    teams[home].Against  = Number(teams[home].Against) + Number(awayScores[f].value);
                    teams[home].GoalDiff = teams[home].For - teams[home].Against;
                    teams[home].Points   = ((teams[home].Won * 3) + (teams[home].Drawn * 1));
                    
                    teams[away].For      = Number(teams[away].For) + Number(awayScores[f].value);
                    teams[away].Against  = Number(teams[away].Against) + Number(homeScores[f].value);                    
                    teams[away].GoalDiff = teams[away].For - teams[away].Against;
                    teams[away].Points   = ((teams[away].Won * 3) + (teams[away].Drawn * 1));

                };
                
                // sort the array of Team objects by points, goal diff, goals for
                teams.sort(leaguePosition);
                
                // outpout the sorted array
                console.log(teams);

                // Create the new table based on the sorted array
                let updatedTable = `<table>          
                    <thead class="blueheader">
                        <tr>
                            <th colspan="10"> ${currentTableName} </th>
                        </tr>
                        <tr>
                            <th>Pos</th><th>Team</th><th>P</th><th>W</th><th>D</th><th>L</th><th>F</th><th>A</th><th>GD</th><th>Pts</th>
                        </tr>
                    </thead>
                    <tbody>`;

                teams.forEach(function (team, index) {

                    updatedTable += `<tr>
                            <td class='pos'>  ${index+1}  </td><td id='${currentTableID}-pos${index+1}' class='team'> ${team.Team} </td><td class='cols'> ${team.Played} </td>
                            <td class='cols'> ${team.Won} </td><td class='cols'> ${team.Drawn} </td><td class='cols'> ${team.Lost} </td>
                            <td class='cols'> ${team.For} </td><td class='cols'> ${team.Against} </td><td class='cols'> ${team.GoalDiff} </td>
                            <td class='cols'> ${team.Points} </td>
                        </tr>`;

                });

                updatedTable += `</tbody></table>`;
                
                // Swap the contents for the current Table for the updated table
                currentTable.innerHTML = updatedTable;

            }, false);   // end of CHANGE event listener

        </script>

    </body>

</html>