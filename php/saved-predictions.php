<?php
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // checks if session exists
    session_start();

    // $_SESSION["worldcup"]  = true;
    // $_SESSION["loggedin"]  = true;
    // $_SESSION["userid"]    = $userid;                            
    // $_SESSION["username"]  = $username;                            
    // $_SESSION["useremail"] = $email;

    // If logged in store the userid from session 
    if ( isset($_SESSION['userid']) ) {
        $userid = $_SESSION["userid"];    
    }; 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Saved Predictions</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link rel="stylesheet" href="../css/styles-predictions.css">
        
        <script src="https://kit.fontawesome.com/130d5316ba.js" crossorigin="anonymous"></script>

        <script>

            // **********************************************************************************************************
            // Helper functions needed to update the league tables  
            // return -1 arrayItemA before arrayItemB
            // return  0 not sorted as same value
            // return  1 arrayItemA after arrayItemB
            // **********************************************************************************************************
            //      Functions to sort the league table
            // **********************************************************************************************************

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
            
            function updateLeagueTables(event) {

                // console.log("Change Event Triggered : ", event);

                if (event.target.matches('#confirm-chkbox')) {
                    // dont complete this change event
                    // console.log("Checkbox clicked");
                    return;                
                };

                if (event.target.matches('[data-stage="QF"]')) {

                    // console.log('Update Semi Final based on changes to the changes to the scores in the Quarter Finals');

                    let QF = document.querySelector('#QF');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeIDs    = QF.querySelectorAll('.q-homeid');            
                    homeRanks  = QF.querySelectorAll('.h-rank');            
                    homeTeams  = QF.querySelectorAll('.home');            
                    homeScores = QF.querySelectorAll('.homescore');
                    awayScores = QF.querySelectorAll('.awayscore');
                    awayTeams  = QF.querySelectorAll('.away');
                    awayIDs    = QF.querySelectorAll('.q-awayid');            
                    awayRanks  = QF.querySelectorAll('.a-rank');            

                    if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('winnerQF1').innerHTML = homeTeams[0].innerHTML;
                        document.getElementById('winnerQF1flag').innerHTML = "<img src='../img/teams/" + homeTeams[0].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF1').nextElementSibling.innerHTML = homeIDs[0].innerHTML;
                        document.getElementById('winnerQF1').nextElementSibling.nextElementSibling.innerHTML = homeRanks[0].innerHTML;
                    } else if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('winnerQF1').innerHTML = awayTeams[0].innerHTML;
                        document.getElementById('winnerQF1flag').innerHTML = "<img src='../img/teams/" + awayTeams[0].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF1').nextElementSibling.innerHTML = awayIDs[0].innerHTML;
                        document.getElementById('winnerQF1').nextElementSibling.nextElementSibling.innerHTML = awayRanks[0].innerHTML;
                    };
                        
                    if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('winnerQF2').innerHTML = homeTeams[1].innerHTML;
                        document.getElementById('winnerQF2flag').innerHTML = "<img src='../img/teams/" + homeTeams[1].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF2').previousElementSibling.innerHTML = homeIDs[1].innerHTML;
                        document.getElementById('winnerQF2').previousElementSibling.previousElementSibling.innerHTML = homeRanks[1].innerHTML;
                    } else if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('winnerQF2').innerHTML = awayTeams[1].innerHTML;
                        document.getElementById('winnerQF2flag').innerHTML = "<img src='../img/teams/" + awayTeams[1].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF2').previousElementSibling.innerHTML = awayIDs[1].innerHTML;
                        document.getElementById('winnerQF2').previousElementSibling.previousElementSibling.innerHTML = awayRanks[1].innerHTML;
                    };
 
                    if (homeScores[2].value > awayScores[2].value) {
                        document.getElementById('winnerQF3').innerHTML = homeTeams[2].innerHTML;
                        document.getElementById('winnerQF3flag').innerHTML = "<img src='../img/teams/" + homeTeams[2].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF3').nextElementSibling.innerText = homeIDs[2].innerHTML;
                        document.getElementById('winnerQF3').nextElementSibling.nextElementSibling.innerText = homeRanks[2].innerHTML;
                    } else if (homeScores[2].value < awayScores[2].value) {
                        document.getElementById('winnerQF3').innerHTML = awayTeams[2].innerHTML;
                        document.getElementById('winnerQF3flag').innerHTML = "<img src='../img/teams/" + awayTeams[2].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF3').nextElementSibling.innerText = awayIDs[2].innerHTML;
                        document.getElementById('winnerQF3').nextElementSibling.nextElementSibling.innerText = awayRanks[2].innerHTML;
                    };
 
                    if (homeScores[3].value > awayScores[3].value) {
                        document.getElementById('winnerQF4').innerHTML = homeTeams[3].innerHTML;
                        document.getElementById('winnerQF4flag').innerHTML = "<img src='../img/teams/" + homeTeams[3].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF4').previousElementSibling.innerText = homeIDs[3].innerHTML;
                        document.getElementById('winnerQF4').previousElementSibling.previousElementSibling.innerText = homeRanks[3].innerHTML;
                    } else if (homeScores[3].value < awayScores[3].value) {
                        document.getElementById('winnerQF4').innerHTML = awayTeams[3].innerHTML;
                        document.getElementById('winnerQF4flag').innerHTML = "<img src='../img/teams/" + awayTeams[3].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerQF4').previousElementSibling.innerText = awayIDs[3].innerHTML;
                        document.getElementById('winnerQF4').previousElementSibling.previousElementSibling.innerText = awayRanks[3].innerHTML;
                    };
                    
                    return;
                };

                if (event.target.matches('[data-stage="SF"]')) {

                    // console.log('Update Final based on changes to the changes to the scores in the Semi Finals');

                    let SF = document.querySelector('#SF');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeIDs    = SF.querySelectorAll('.s-homeid');            
                    homeRanks  = SF.querySelectorAll('.h-rank');            
                    homeTeams  = SF.querySelectorAll('.home');            
                    homeScores = SF.querySelectorAll('.homescore');
                    awayScores = SF.querySelectorAll('.awayscore');
                    awayTeams  = SF.querySelectorAll('.away');
                    awayIDs    = SF.querySelectorAll('.s-awayid');            
                    awayRanks  = SF.querySelectorAll('.a-rank');            

                    if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('winnerSF1').innerHTML = homeTeams[0].innerHTML;
                        document.getElementById('winnerSF1flag').innerHTML = "<img src='../img/teams/" + homeTeams[0].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerSF1').nextElementSibling.innerHTML = homeIDs[0].innerHTML;
                        document.getElementById('winnerSF1').nextElementSibling.nextElementSibling.innerHTML = homeRanks[0].innerHTML;
                    } else if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('winnerSF1').innerHTML = awayTeams[0].innerHTML;
                        document.getElementById('winnerSF1flag').innerHTML = "<img src='../img/teams/" + awayTeams[0].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerSF1').nextElementSibling.innerHTML = awayIDs[0].innerHTML;
                        document.getElementById('winnerSF1').nextElementSibling.nextElementSibling.innerHTML = awayRanks[0].innerHTML;
                    };
                        
                    if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('winnerSF2').innerHTML = homeTeams[1].innerHTML;
                        document.getElementById('winnerSF2flag').innerHTML = "<img src='../img/teams/" + homeTeams[1].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerSF2').previousElementSibling.innerHTML = homeIDs[1].innerHTML;
                        document.getElementById('winnerSF2').previousElementSibling.previousElementSibling.innerHTML = homeRanks[1].innerHTML;
                    } else if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('winnerSF2').innerHTML = awayTeams[1].innerHTML;
                        document.getElementById('winnerSF2flag').innerHTML = "<img src='../img/teams/" + awayTeams[1].innerHTML.trim() + ".png'>";
                        document.getElementById('winnerSF2').previousElementSibling.innerHTML = awayIDs[1].innerHTML;
                        document.getElementById('winnerSF2').previousElementSibling.previousElementSibling.innerHTML = awayRanks[1].innerHTML;
                    };
                   
                    return;

                };

                /** the data-stage FI is diferent to the section id FL */
                if (event.target.matches('[data-stage="FI"]')) {

                    // console.log('Update Final based on changes to the changes to the scores in the Semi Finals');

                    let FL = document.querySelector('#FL');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeTeams  = FL.querySelectorAll('.home');            
                    homeScores = FL.querySelectorAll('.homescore');
                    awayScores = FL.querySelectorAll('.awayscore');
                    awayTeams  = FL.querySelectorAll('.away');

                    return;

                };

                if (event.target.matches('[data-table="TableA"]')) {

                    let SectA = document.querySelector('#SectionA');
                    
                    // get the teams, hidden id , hidden rank and the scores for SectionA
                    teamIds    = SectA.querySelectorAll('.homeid');
                    teamRks    = SectA.querySelectorAll('.h-rank');
                    homeTeams  = SectA.querySelectorAll('.home');            
                    homeScores = SectA.querySelectorAll('.homescore');
                    awayScores = SectA.querySelectorAll('.awayscore');
                    awayTeams  = SectA.querySelectorAll('.away');
                    
                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableA");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table A";

                } else if (event.target.matches('[data-table="TableB"]')) {

                    let SectB = document.querySelector('#SectionB');
                    
                    // get the teams and the scores for SectionB
                    teamIds    = SectB.querySelectorAll('.homeid');
                    teamRks    = SectB.querySelectorAll('.h-rank');
                    homeTeams  = SectB.querySelectorAll('.home');            
                    homeScores = SectB.querySelectorAll('.homescore');
                    awayScores = SectB.querySelectorAll('.awayscore');
                    awayTeams  = SectB.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableB");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table B";

                } else if (event.target.matches('[data-table="TableC"]')) {

                    let SectC = document.querySelector('#SectionC');
                    
                    // get the teams and the scores for SectionC
                    teamIds    = SectC.querySelectorAll('.homeid');
                    teamRks    = SectC.querySelectorAll('.h-rank');
                    homeTeams  = SectC.querySelectorAll('.home');            
                    homeScores = SectC.querySelectorAll('.homescore');
                    awayScores = SectC.querySelectorAll('.awayscore');
                    awayTeams  = SectC.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableC");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table C";

                } else if (event.target.matches('[data-table="TableD"]')) {
                    
                    let SectD = document.querySelector('#SectionD');
                    
                    // get the teams and the scores for SectionD
                    teamIds    = SectD.querySelectorAll('.homeid');
                    teamRks    = SectD.querySelectorAll('.h-rank');
                    homeTeams  = SectD.querySelectorAll('.home');            
                    homeScores = SectD.querySelectorAll('.homescore');
                    awayScores = SectD.querySelectorAll('.awayscore');
                    awayTeams  = SectD.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableD");
                    currentTableID   = currentTable.id;
                    currentTableName = "Table D";

                };  
                
                // const Teams = [
                //    {Team : "England",          ID : 1, Rank: 1, Played : 1, Won : 1, Drawn: 0, Lost : 0, For : 2, Against : 1, GoalDiff : 1,  Points : 3},
                //    {Team : "Norway",           ID : 1, Rank: 1, Played : 1, Won : 0, Drawn: 0, Lost : 0, For : 0, Against : 0, GoalDiff : 0,  Points : 0},
                //    {Team : "Austria",          ID : 1, Rank: 1, Played : 1, Won : 0, Drawn: 0, Lost : 1, For : 1, Against : 2, GoalDiff : -1, Points : 0},
                //    {Team : "Northern Ireland", ID : 1, Rank: 1, Played : 1, Won : 0, Drawn: 0, Lost : 0, For : 0, Against : 0, GoalDiff : 0,  Points : 0}
                // ]
                
                // initialise the Teams Array and team object
                let teams = [];
                let team = {};
                
                // console.log("Home Team Length : ", homeTeams.length);

                // Create the array of objects that will be used to create the league table
                for (let f = 0; f < homeTeams.length; f++) {
                    
                    // console.log("Team : ", homeTeams[f].textContent);

                    // check if home team exists in array - if not add object for the team to the array
                    let found = teams.find(t => t.Team == homeTeams[f].textContent);
                    
                    if (found === undefined ) {                        
                        team = {Team: homeTeams[f].textContent, ID: teamIds[f].textContent, Rank: teamRks[f].textContent, Played: 0, Won: 0, Drawn: 0, Lost: 0, For: 0, Against: 0, GoalDiff: 0, Points: 0};
                        teams.push(team);                        
                    };
                };

                // console.log(teams);

                // England	 2 1  Austria
                // Norway	 1 2  N Ireland
                // Austria	 2 1  N Ireland
                // England	 1 2  Norway
                // N Ireland 2 1  England
                // Austria	 1 2  Norway

                // Update the properties for each team object for each result
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

                    /**
                        have to convert to Number - only the INPUT fields have a value
                    */
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
                
               // Create the new table based on the sorted array
                let updatedTable = `<table>          
                    <thead class="blueheader">
                        <tr>
                            <th colspan="10"> ${currentTableName} </th>
                        </tr>
                        <tr>
                            <th>Pos</th><th>Team</th><th class='hidden'></th><th class='hidden'></th><th>P</th><th>W</th><th>D</th><th>L</th><th>F</th><th>A</th><th>GD</th><th>Pts</th>
                        </tr>
                    </thead>
                    <tbody>`;

                teams.forEach(function (team, index) {

                    updatedTable += `<tr>
                            <td class='pos'>  ${index+1}  </td><td id='${currentTableID}-pos${index+1}' class='team'> ${team.Team} </td>
                            <td class='hidden team-id'> ${team.ID} </td> <td class='hidden team-rk'> ${team.Rank} </td>
                            <td class='cols'> ${team.Played} </td>
                            <td class='cols'> ${team.Won} </td><td class='cols'> ${team.Drawn} </td><td class='cols'> ${team.Lost} </td>
                            <td class='cols'> ${team.For} </td><td class='cols'> ${team.Against} </td><td class='cols'> ${team.GoalDiff} </td>
                            <td class='cols'> ${team.Points} </td>
                        </tr>`;

                });

                updatedTable += `</tbody></table>`;
                
                /** 
                 Swap the contents of the current Table for the updated table
                */
                currentTable.innerHTML = updatedTable;
            
            } // end of function updateLeageTable

        </script>
        
    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <div id="logo">
                    <img src='../img/logo.png' alt='World Cup Fortune Teller logo'>
                </div>

                <div id="header-text">
                    <h1>World Cup 2022 Predictions</h1> 
                </div>
                
                <div id="logout">
                    <a class="transparent-btn-blue" href="https://9habu.com/wc2022/php/logout.php">Logout</a>
                </div>

            </header>
            
<!--            <nav class="options">
                 <a href="#" target="_blank" class="options-link">Home</a>
                 <a href="#" target="_blank" class="options-link">Predictions</a>
                 <a href="#" target="_blank" class="options-link">Fixtures / Results</a>
                 <a href="logout.php" target="_blank" class="options-link">Logout</a>
            </nav> -->
            
            <!-- Tab links -->
            <div id="tabs" class="tab">
              <button id="group-stages" name="GROUPS" class="tablinks active">Group Stage</button>
              <button id="knockout-stage" name="KNOCKOUT-STAGE" class="tablinks ">Knockout Stage</button>
              <button id="top-scorer" name="TOP-SCORER" class="tablinks ">Top Goal Scorer</button>
              <button id="update-predictions" name="UPDATE-PREDICTIONS" class="tablinks ">Update Predictions</button>
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
                                    . "  	    pred.UserID as userid, \n"
                                    . "  		pred.FixtureID as fixtureno, \n"
                                    . "  		pred.Stage as stage, \n" 
                                    . "  		pred.HomeScore as homescore, \n" 
                                    . "  		pred.AwayScore as awayscore, \n" 
                                    . "  		fx.GroupID as groupid, \n"
                                    . "  	    hmt.ID as homeid, \n"
                                    . "  		hmt.Team as hometeam, \n" 
                                    . "  		hmt.Ranking as homerank, \n"
                                    . "  		awt.Ranking as awayrank, \n"
                                    . "  		awt.Team as awayteam, \n"
                                    . "  		awt.ID as awayid \n"
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
                                    . "     WHERE  \n"
                                    . "         fx.GroupID = " . $groupid . " AND pred.UserID = " . $userid . "\n"
                                    . "  ORDER BY \n"
                                    . "  	  fx.FixtureNo \n";

                                $result = $conn->query($qry);

                                if ($result->num_rows == 0) {
                                    echo "<div>NO RESULTS RETURNED</div>";
                                } else {
                                    echo "<section id='" . $sectionname . "'>";
                                    echo "  <div id='" . $groupname . "'>";

                                    echo "      <table>";
                                    echo "          <thead class='greenheader'>";
                                    echo "              <tr>";
                                    echo "                  <th colspan='12'>" . $groupdesc .  "</th>";
                                    echo "              </tr>";
                                    echo "              <tr>";
                                    echo "              <tr>";
                                    echo "                  <th>No</th><th class='hidden'><th class='hidden'></th><th colspan='2'>HOME</th> <th>Rk</th> <th colspan='2'>SCORE</th> <th>Rk</th>";
                                    echo "                  <th class='hidden'></th> <th colspan='2'>AWAY</th>";
                                    echo "              </tr>";
                                    echo "          </thead>";
                                    echo "          <tbody>";
                                  
                                    while ($row = $result->fetch_assoc()) {

                                            $userid    = $row["userid"];
                                            $fixno     = $row["fixtureno"];
                                            $homeid    = $row["homeid"];
                                            $hometeam  = $row["hometeam"];
                                            $homescore = $row["homescore"];
                                            $homerank  = $row["homerank"];
                                            $awayrank  = $row["awayrank"];
                                            $awayscore = $row["awayscore"];
                                            $awayteam  = $row["awayteam"];
                                            $awayid    = $row["awayid"];
                                            $grpdesc   = $row["groupdesc"];
                                            $rndcode   = $row["roundcode"];

                                                echo "  <tr>";
                                                echo "      <td class='fixno'>" . $fixno . "</td>";
                                                echo "      <td class='stage hidden'>" . $rndcode . "</td>";                      // hidden cell for code of the tournament stage 
                                                echo "      <td class='homeid hidden'>" . $homeid . "</td>";        // hidden cell for ID of home team
                                                echo "      <td class='home-flag'><img src='../img/teams/" . $hometeam . ".png'></td>";      
                                                echo "      <td class='home'>" . $hometeam . "</td>";
                                                echo "      <td class='h-rank'>" . $homerank . "</td>";
                                                echo "      <td><input class='homescore' data-table='" . $tablename . "' value=" . $homescore . " type='number' min=0 placeholder=0></td>";
                                                echo "      <td><input class='awayscore' data-table='" . $tablename . "' value=" . $awayscore . " type='number' min=0 placeholder=0></td>";
                                                echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                                echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                                                echo "      <td class='away'>" . $awayteam . "</td>";
                                                echo "      <td class='away-flag'><img src='../img/teams/" . $awayteam . ".png'></td>";      
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
                                        echo "      </table> <!-- end of league table DIV -->"; 

                                    } // end of nested else for Table        
                                    
                                    //     // END SQL QRY

                                    echo "<script>";
                                    echo "  var event = new Event('updateTables');";
                                    echo "  tbl = document.querySelector('[data-table=" . $tablename . "]');";
                                    echo "  tbl.addEventListener('updateTables', updateLeagueTables);";
                                    // echo "  console.log('Before : ', tbl.value);";
                                    // echo "  var tempscore = tbl.value;";
                                    // echo "  tbl.value = '99';";
                                    // echo "  tbl.value = tempscore;";
                                    echo "  tbl.dispatchEvent(event);";
                                    // echo "  console.log(event, tbl)";
                                    echo "</script>";

                                    echo "</section> <!-- end of section div -->";                         

                                } // end of else

                        }   // end of foreach    

                        // Close database connection
                        // $conn->close();                             
                    ?>

                </div> <!-- end of GROUPS -->

                <div id="KNOCKOUT-STAGE" class="tabcontent">
                    
                    <?php
                    
                        $qry =   "SELECT \n"
                        . "  	    pred.UserID as userid, \n"
                        . "  		pred.FixtureID as fixtureno, \n"
                        . "  		pred.Stage as stage, \n" 
                        . "  		pred.HomeScore as homescore, \n" 
                        . "  		pred.AwayScore as awayscore, \n" 
                        . "  		fx.GroupID as groupid, \n"
                        . "  	    hmt.ID as homeid, \n"
                        . "  		hmt.Team as hometeam, \n" 
                        . "  		hmt.Ranking as homerank, \n"
                        . "  		awt.Ranking as awayrank, \n"
                        . "  		awt.Team as awayteam, \n"
                        . "  		awt.ID as awayid \n"
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
                        . "     WHERE  \n"
                        . "         fx.GroupID = 8 AND pred.UserID = " . $userid . "\n"
                        . "  ORDER BY \n"
                        . "  	  fx.FixtureNo \n";

                        $result = $conn->query($qry);

                        if ($result->num_rows == 0) {
                            echo "<div>NO RESULTS RETURNED</div>";
                        } else {    
                            
                            echo "<section id='QF'>";
                            echo "  <div id='QuarterFinal'>";

                            echo "      <table>";
                            echo "          <thead class='greenheader'>";
                            echo "              <tr>";
                            echo "                  <th colspan='9'>QUARTER FINALS</th>";
                            echo "              </tr>";
                            echo "              <tr>";
                            echo "                  <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th>";
                            echo "                  <th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>";
                            echo "              </tr>";
                            echo "          </thead>";
                            echo "          <tbody>";

                            $quarterfinalid = 1;

                            $winners = array("", "winnerA", "winnerB", "winnerC", "winnerD"); 
                            $runnersup = array("", "runnerupB", "runnerupA", "runnerupD", "runnerupC"); 
                            
                            while ($row = $result->fetch_assoc()) {

                                $winner     = $winners[$quarterfinalid];
                                $runnerup   = $runnersup[$quarterfinalid];

                                $userid    = $row["userid"];
                                $fixno     = $row["fixtureno"];
                                $homeid    = $row["homeid"];
                                $hometeam  = $row["hometeam"];
                                $homescore = $row["homescore"];
                                $homerank  = $row["homerank"];
                                $awayrank  = $row["awayrank"];
                                $awayscore = $row["awayscore"];
                                $awayteam  = $row["awayteam"];
                                $awayid    = $row["awayid"];
                                $grpdesc   = $row["groupdesc"];
                                $rndcode   = $row["roundcode"];

                                echo "  <tr>";
                                echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                echo "      <td class='hidden stage'>QF</td>"; 
                                echo "      <td id='" . $winner . "flag' class='home-flag'></td>"; 
                                echo "      <td id='". $winner . "' class='home'>". $hometeam . "</td>"; 
                                echo "      <td class='hidden q-homeid'>" . $homeid . "</td>"; 
                                echo "      <td class='h-rank'>" . $homerank . "</td>";
                                echo "      <td><input class='homescore' data-stage='QF' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                echo "      <td><input class='awayscore' data-stage='QF' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                echo "      <td class='hidden q-awayid'>" . $awayid . "</td>";
                                echo "      <td id='" . $runnerup . "' class='away'>". $awayteam . "</td>";
                                echo "      <td id='" . $runnerup . "flag' class='away-flag'></td>"; 
                                echo "  </tr>";                            

                                // there are 4 quarter finals
                                $quarterfinalid = $quarterfinalid + 1;

                            }   // end of while    
                                
                        echo "          </tbody>";
                        echo "      </table>";   
                        echo "  </div>  <!-- end of quarter final div -->";     
                        echo "</section> <!-- End of QF -->";
                            
                    }; // end of if else                     
                ?>  
                <!-- end of quarter finals -->

                <!-- start of Semi finals -->
                    <?php
                    
                        $qry =   "SELECT \n"
                        . "  	    pred.UserID as userid, \n"
                        . "  		pred.FixtureID as fixtureno, \n"
                        . "  		pred.Stage as stage, \n" 
                        . "  		pred.HomeScore as homescore, \n" 
                        . "  		pred.AwayScore as awayscore, \n" 
                        . "  		fx.GroupID as groupid, \n"
                        . "  	    hmt.ID as homeid, \n"
                        . "  		hmt.Team as hometeam, \n" 
                        . "  		hmt.Ranking as homerank, \n"
                        . "  		awt.Ranking as awayrank, \n"
                        . "  		awt.Team as awayteam, \n"
                        . "  		awt.ID as awayid \n"
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
                        . "     WHERE  \n"
                        . "         fx.GroupID = 9 AND pred.UserID = " . $userid . "\n"
                        . "  ORDER BY \n"
                        . "  	  fx.FixtureNo \n";

                        $result = $conn->query($qry);

                        if ($result->num_rows == 0) {
                            echo "<div>NO RESULTS RETURNED</div>";
                        } else {    
                            
                            echo "<section id='SF'>";
                            echo "  <div id='SemiFinal'>";

                            echo "      <table>";
                            echo "          <thead class='greenheader'>";
                            echo "              <tr>";
                            echo "                  <th colspan='9'>SEMI FINALS</th>";
                            echo "              </tr>";
                            echo "              <tr>";
                            echo "                  <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th>";
                            echo "                  <th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>";
                            echo "              </tr>";
                            echo "          </thead>";
                            echo "          <tbody>";

                            $semifinalid = 1;

                            $homewinners = array("", "winnerQF1"  , "winnerQF3"); 
                            $awaywinners = array("", "winnerQF2"  , "winnerQF4"); 

                            while ($row = $result->fetch_assoc()) {

                                $homewinner = $homewinners[$semifinalid];
                                $awaywinner = $awaywinners[$semifinalid];
                                
                                $userid    = $row["userid"];
                                $fixno     = $row["fixtureno"];
                                $homeid    = $row["homeid"];
                                $hometeam  = $row["hometeam"];
                                $homescore = $row["homescore"];
                                $homerank  = $row["homerank"];
                                $awayrank  = $row["awayrank"];
                                $awayscore = $row["awayscore"];
                                $awayteam  = $row["awayteam"];
                                $awayid    = $row["awayid"];
                                $grpdesc   = $row["groupdesc"];
                                $rndcode   = $row["roundcode"];

                                echo "  <tr>";
                                echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                echo "      <td class='hidden stage'>SF</td>"; 
                                echo "      <td id='" . $homewinner . "flag' class='home-flag'></td>"; 
                                echo "      <td id='". $homewinner . "' class='home'>". $hometeam . "</td>"; 
                                echo "      <td class='hidden s-homeid'>" . $homeid . "</td>"; 
                                echo "      <td class='h-rank'>" . $homerank . "</td>";
                                echo "      <td><input class='homescore' data-stage='SF' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                echo "      <td><input class='awayscore' data-stage='SF' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                echo "      <td class='hidden s-awayid'>" . $awayid . "</td>";
                                echo "      <td id='" . $awaywinner . "' class='away'>". $awayteam . "</td>";
                                echo "      <td id='" . $awaywinner . "flag' class='away-flag'></td>"; 
                                echo "  </tr>";                            

                                // there are 2 semi finals
                                $semifinalid = $semifinalid + 1;
                                
                            }   // end of while    
                                
                        echo "          </tbody>";
                        echo "      </table>";   
                        echo "  </div>  <!-- end of semi final div -->";     
                        echo "</section> <!-- End of SF -->";
                            
                    }; // end of if else                     
                ?> 
                <!-- end of semi finals -->
                
                <!-- start of final -->
                    <?php
                    
                        $qry =   "SELECT \n"
                        . "  	    pred.UserID as userid, \n"
                        . "  		pred.FixtureID as fixtureno, \n"
                        . "  		pred.Stage as stage, \n" 
                        . "  		pred.HomeScore as homescore, \n" 
                        . "  		pred.AwayScore as awayscore, \n" 
                        . "  		fx.GroupID as groupid, \n"
                        . "  	    hmt.ID as homeid, \n"
                        . "  		hmt.Team as hometeam, \n" 
                        . "  		hmt.Ranking as homerank, \n"
                        . "  		awt.Ranking as awayrank, \n"
                        . "  		awt.Team as awayteam, \n"
                        . "  		awt.ID as awayid \n"
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
                        . "     WHERE  \n"
                        . "         fx.GroupID = 10 AND pred.UserID = " . $userid . "\n"
                        . "  ORDER BY \n"
                        . "  	  fx.FixtureNo \n";

                        $result = $conn->query($qry);

                        if ($result->num_rows == 0) {
                            echo "<div>NO RESULTS RETURNED</div>";
                        } else {    
                            
                            echo "<section id='FL'>";
                            echo "  <div id='Final'>";

                            echo "      <table>";
                            echo "          <thead class='greenheader'>";
                            echo "              <tr>";
                            echo "                  <th colspan='9'>FINAL</th>";
                            echo "              </tr>";
                            echo "              <tr>";
                            echo "                  <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th>";
                            echo "                  <th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>";
                            echo "              </tr>";
                            echo "          </thead>";
                            echo "          <tbody>";

                            $finalid = 1;

                            $homewinners = array("", "winnerSF1"); 
                            $awaywinners = array("", "winnerSF2"); 

                            while ($row = $result->fetch_assoc()) {

                                $homewinner = $homewinners[$finalid];
                                $awaywinner = $awaywinners[$finalid];

                                $userid    = $row["userid"];
                                $fixno     = $row["fixtureno"];
                                $homeid    = $row["homeid"];
                                $hometeam  = $row["hometeam"];
                                $homescore = $row["homescore"];
                                $homerank  = $row["homerank"];
                                $awayrank  = $row["awayrank"];
                                $awayscore = $row["awayscore"];
                                $awayteam  = $row["awayteam"];
                                $awayid    = $row["awayid"];
                                $grpdesc   = $row["groupdesc"];
                                $rndcode   = $row["roundcode"];

                                echo "  <tr>";
                                echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                echo "      <td class='hidden stage'>FI</td>"; 
                                echo "      <td id='" . $homewinner . "flag' class='home-flag'></td>"; 
                                echo "      <td id='". $homewinner . "' class='home'>". $hometeam . "</td>"; 
                                echo "      <td class='hidden f-homeid'>" . $homeid . "</td>"; 
                                echo "      <td class='h-rank'>" . $homerank . "</td>";
                                echo "      <td><input class='homescore' data-stage='FI' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                echo "      <td><input class='awayscore' data-stage='FI' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                echo "      <td class='hidden f-awayid'>" . $awayid . "</td>";
                                echo "      <td id='" . $awaywinner . "' class='away'>". $awayteam . "</td>";
                                echo "      <td id='" . $awaywinner . "flag' class='away-flag'></td>"; 
                                echo "  </tr>";                            

                                $finalid = $finalid + 1;

                            }   // end of while    
                                
                        echo "          </tbody>";
                        echo "      </table>";   
                        echo "  </div>  <!-- end of final div -->";     
                        echo "</section> <!-- End of FL -->";
                            
                    }; // end of if else                     
                ?> 
                <!-- end of final -->

                </div> <!-- end of KNOCKOUT STAGES -->

                <div id="TOP-SCORER" class="tabcontent">

                    <section id='top-scorer'>

                        <div id='confirm-save'>
                            <input type='checkbox' id='confirm-chkbox' name='confirm-chkbox' checked>
                            <label for="confirm-chkbox">Select your top scorer and number of goals</label>
                        </div>

                        <div id='chkbox-error' style="display:none;">
                            Click the Checkbox to confirm that you want to save your Top Scorer
                        </div>

                        <div id='confirm-btn'>
                            <button type='button' id='save-btn' class='predictions-btn'>Save Predictions</button>
                        </div>

                        <div style="text-align: center; padding:15px" id='confirm-predictions'>
                            <p>Nothing saved yet</p>
                        </div>

                    </section> <!-- end of TOP SCORER section -->

                </div>  <!-- end of TOP SCORER -->

                <div id="UPDATE-PREDICTIONS" class="tabcontent">

                    <section id='update-predictions'>

                        <div id='confirm-save'>
                            <input type='checkbox' id='confirm-chkbox' name='confirm-chkbox' checked>
                            <label for="confirm-chkbox">Check to confirm that you want to update your predictions</label>
                        </div>

                        <div id='chkbox-error' style="display:none;">
                            Click the Checkbox to confirm that you want to save your predictions
                        </div>

                        <div id='confirm-btn'>
                            <button type='button' id='update-btn' class='predictions-btn'>Update Predictions</button>
                        </div>

                        <div style="text-align: center; padding:15px" id='confirm-predictions'>
                            <p>No updates made</p>
                        </div>

                    </section> <!-- end of UPDATE PREDICTIONS section -->

                </div>  <!-- end of UPDATE PREDICTIONS -->
                
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

            /** 
                pass the php session variable, $userid, to a javascript variable 
                this can then be used in the FETCH POST
            */ 
            var userID = "<?=$userid?>";

            // Change the display of the content tab from none to flex to display content
            // Hide the Knockout stage and the Update Predictions stage
            document.getElementById("KNOCKOUT-STAGE").style.display = "none";
            document.getElementById("TOP-SCORER").style.display = "none";
            document.getElementById("UPDATE-PREDICTIONS").style.display = "none";
          
            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                if (event.target.matches('#update-btn')) {

                    if (!document.getElementById("confirm-chkbox").checked) {
                        document.getElementById("chkbox-error").style.display = "block";
                    } else {
                        
                        // get the the results from the group tables 
                        fixtureids  = document.querySelectorAll('.fixno');            
                        stages      = document.querySelectorAll('.stage');            
                        hometeamids = document.querySelectorAll('.homeid, .q-homeid, .s-homeid, .f-homeid');            
                        homescores  = document.querySelectorAll('.homescore') ;
                        awayscores  = document.querySelectorAll('.awayscore');
                        awayteamids = document.querySelectorAll('.awayid, .q-awayid, .s-awayid, .f-awayid');

                        // initialise the array to hold the predictions 
                        // UserID FixtureID HomeScore AwayScore HomeTeam AwayTeam ResultID Points Stage
                        let predictions = [];
                        // initialise the object to hold each prediction
                        let prediction = {};
                
                        // Create the array of objects that will be used to create the league table
                        for (let f = 0; f < fixtureids.length; f++) {
                            
                            prediction = {  UserID     : userID, 
                                            FixtureID  : fixtureids[f].textContent, 
                                            HomeScore  : homescores[f].value, 
                                            AwayScore  : awayscores[f].value, 
                                            HomeTeamID : hometeamids[f].textContent, 
                                            AwayTeamID : awayteamids[f].textContent, 
                                            ResultID   : 0, 
                                            Points     : 0, 
                                            Stage      : stages[f].textContent                                        
                                        };

                            // home win ID - 1, away win ID - 2, draw ID - 3 
                            if (homescores[f].value > awayscores[f].value) {
                                prediction.ResultID = 1;
                                prediction.Points = 3;                           
                            } else if (homescores[f].value < awayscores[f].value) {
                                prediction.ResultID = 2;
                                prediction.Points = 3;                           
                            } else if (homescores[f].value == awayscores[f].value) {
                                prediction.ResultID = 3;
                                prediction.Points = 1;                           
                            };

                            // add the prediction object to the Predictions Array                                                                
                            predictions.push(prediction);

                        }; // end of FOR loop

                        console.log(predictions);
                    
                        // now process the predictions array and save result to predictions table
                        // console.log(JSON.stringify(predictions));

                        fetch('https://www.9habu.com/wc2022/php/update-predictions.php', {
                                
                                method: 'POST',
                                mode: "same-origin",
                                credentials: "same-origin",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                    },
                                body: JSON.stringify(predictions),

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

                                document.getElementById("confirm-predictions").innerHTML = data;

                            }).catch(function (error) {
                                // There was an error
                                console.warn("Error : ", error);
                            });

                        };

                    return;

                }; // end of click event for UPDATE-PREDICTIONS button 
                
                if (event.target.matches('#confirm-chkbox')) {
                    // hide any error messgae thats displayed
                    document.getElementById("chkbox-error").style.display = "none";
                    return;                
                }

                // event listeners for the tab links
                if (event.target.matches('.tablinks')) {

                    displayStage(event, event.target.name);
                    event.target.className += " active";

                }

                /**
                 *  dont need to do this as the quarter finals, semi final and final have aready been predicted
                 */
                // event listeners for the tab links
                if (event.target.matches('#knockout-stage')) {

                    document.getElementById("confirm-predictions").innerHTML = "<p></p>";

                    // QUARTER FINALS - WINNERS AND RUNNERS UP FROM EACH GROUP
                    let winnergroupA   = document.getElementById("TableA-pos1").innerHTML;
                    let winnergroupAid = document.getElementById("TableA-pos1").nextElementSibling.innerHTML;
                    let winnergroupArk = document.getElementById("TableA-pos1").nextElementSibling.nextElementSibling.innerHTML;

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
                    document.getElementById("winnerAflag").innerHTML = "<img src='../img/teams/" + winnergroupA.trim() + ".png'>";
                    document.getElementById("winnerA").innerHTML = winnergroupA;
                    document.getElementById("winnerA").nextElementSibling.innerHTML = winnergroupAid;
                    document.getElementById("winnerA").nextElementSibling.nextElementSibling.innerHTML = winnergroupArk;

                    document.getElementById("runnerupBflag").innerHTML = "<img src='../img/teams/" + runnerupgroupB.trim() + ".png'>";
                    document.getElementById("runnerupB").innerHTML = runnerupgroupB;
                    document.getElementById("runnerupB").previousElementSibling.innerHTML = runnerupgroupBid;
                    document.getElementById("runnerupB").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupBrk;

                    // Quarter Final 2
                    document.getElementById("winnerBflag").innerHTML = "<img src='../img/teams/" + winnergroupB.trim() + ".png'>";
                    document.getElementById("winnerB").innerHTML = winnergroupB;
                    document.getElementById("winnerB").nextElementSibling.innerHTML = winnergroupBid;
                    document.getElementById("winnerB").nextElementSibling.nextElementSibling.innerHTML = winnergroupBrk;

                    document.getElementById("runnerupAflag").innerHTML = "<img src='../img/teams/" + runnerupgroupA.trim() + ".png'>";
                    document.getElementById("runnerupA").innerHTML = runnerupgroupA;
                    document.getElementById("runnerupA").previousElementSibling.innerHTML = runnerupgroupAid;
                    document.getElementById("runnerupA").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupArk;

                    // Quarter Final 3
                    document.getElementById("winnerCflag").innerHTML = "<img src='../img/teams/" + winnergroupC.trim() + ".png'>";
                    document.getElementById("winnerC").innerHTML = winnergroupC;
                    document.getElementById("winnerC").nextElementSibling.innerHTML = winnergroupCid;
                    document.getElementById("winnerC").nextElementSibling.nextElementSibling.innerHTML = winnergroupCrk;

                    document.getElementById("runnerupDflag").innerHTML = "<img src='../img/teams/" + runnerupgroupD.trim() + ".png'>";
                    document.getElementById("runnerupD").innerHTML = runnerupgroupD;
                    document.getElementById("runnerupD").previousElementSibling.innerHTML = runnerupgroupDid;
                    document.getElementById("runnerupD").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupDrk;

                    // Quarter Final 4
                    document.getElementById("winnerDflag").innerHTML = "<img src='../img/teams/" + winnergroupD.trim() + ".png'>";
                    document.getElementById("winnerD").innerHTML = winnergroupD;
                    document.getElementById("winnerD").nextElementSibling.innerHTML = winnergroupDid;
                    document.getElementById("winnerD").nextElementSibling.nextElementSibling.innerHTML = winnergroupDrk;

                    document.getElementById("runnerupCflag").innerHTML = "<img src='../img/teams/" + runnerupgroupC.trim() + ".png'>";
                    document.getElementById("runnerupC").innerHTML = runnerupgroupC;
                    document.getElementById("runnerupC").previousElementSibling.innerHTML = runnerupgroupCid;
                    document.getElementById("runnerupC").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupCrk;

                    document.getElementById('winnerQF1flag').innerHTML = "<img src='../img/teams/" + document.getElementById('winnerQF1').innerHTML.trim() + ".png'>";
                    document.getElementById('winnerQF2flag').innerHTML = "<img src='../img/teams/" + document.getElementById('winnerQF2').innerHTML.trim() + ".png'>";
                    document.getElementById('winnerQF3flag').innerHTML = "<img src='../img/teams/" + document.getElementById('winnerQF3').innerHTML.trim() + ".png'>";
                    document.getElementById('winnerQF4flag').innerHTML = "<img src='../img/teams/" + document.getElementById('winnerQF4').innerHTML.trim() + ".png'>";

                    document.getElementById('winnerSF1flag').innerHTML = "<img src='../img/teams/" + document.getElementById('winnerSF1').innerHTML.trim() + ".png'>";
                    document.getElementById('winnerSF2flag').innerHTML = "<img src='../img/teams/" + document.getElementById('winnerSF2').innerHTML.trim() + ".png'>";
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

                    // call the function to update the league tables
                    updateLeagueTables(event);

            }, false);   // end of CHANGE event listener

            // document.addEventListener('change', updateLeagueTables(event));


        </script>

    </body>

</html>