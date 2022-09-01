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
    
    // checks if session exists
    session_start();

    // $_SESSION["worldcup"]  = true;
    // $_SESSION["loggedin"]  = true;
    // $_SESSION["userid"]    = $userid;                            
    // $_SESSION["username"]  = $username;                            
    // $_SESSION["useremail"] = $email;

    // If logged in store the userid from session 
    if ( isset($_SESSION['userid']) ) {
        $userid      = $_SESSION["userid"];    
        $username    = $_SESSION["username"]    ; 
        $predictions = $_SESSION["predictions"];    
    }; 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Saved Predictions</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles-predictions.css">
        
        <script>

            /** 
             * set true to enable the display of the UPDATE-PREDICTIONS TAB 
             * can only be true if LastSixteenOK, QuarterFinalsOK, SemiFinalsOK, FinalsOK  are set true
            */
            let AllowPredictionsUpdate;

            /** set true if each of the fixtures in the stage are set as a win */
            let LastSixteenOK;
            let QuarterFinalsOK;
            let SemiFinalsOK;
            let PlayoffOK;
            let FinalOK;
            
            /** set true if each of the Top Goal Scorer and the Number of goals have been entered */
            let TopScorerOK = false;

            /* will be set true when the first fixture has started  */
            let TournamentStarted = false;
            
            // **********************************************************************************************************
            // Helper function needed to buld the predictions table  
            // needed as the predictions table needs rebulit after the saved predictions are updated
            // **********************************************************************************************************
            function buildPredictionsTable() {

                var userID = "<?=htmlspecialchars($userid)?>";

                fetch('https://www.9habu.com/wc2022/inc/build-results-predictions.php', {
                        
                        method: 'POST',
                        mode: "same-origin",
                        credentials: "same-origin",
                        headers: {
                            'Content-Type': 'text/html',
                            'Accept': 'text/html'
                            },
                        body: userID,

                    }).then(function (response) {

                        // If the response is successful, get the JSON
                        if (response.ok) {
                            return response.text();
                        };

                        // Otherwise, throw an error
                        return response.text().then(function (msg) {
                            // console.log(response.json());
                            throw msg;
                        });

                    }).then(function (data) {

                        // console.log(data);
                        document.getElementById("predictions").innerHTML = data;

                    }).catch(function (error) {
                        // There was an error
                        console.warn("Error : ", error);
                    });

            };  // end of buildPredictionsTable

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
                
                if (event.target.matches('#confirm-chkbox')) {
                    // dont complete this change event
                    return;                
                };

                // set TopScorerOK true only botht he playere and the number of goals have been entered
                if ( (event.target.matches('#scorer-input')) || (event.target.matches('#goals-input')) ) {

                    if ( (document.getElementById("scorer-input").value > "") && (document.getElementById("goals-input").value > 0) ) {
                        TopScorerOK = true;
                    } else {
                        TopScorerOK = false;
                    }

                    return;                
                };
                
                if (event.target.matches('[data-stage="LS"]')) {

                    // will be set to false if any predictions are set as a draw
                    LastSixteenOK = true;

                    let LS = document.querySelector('#LS');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeIDs    = LS.querySelectorAll('.homeid');            
                    homeRanks  = LS.querySelectorAll('.h-rank');            
                    homeTeams  = LS.querySelectorAll('.home');            
                    homeScores = LS.querySelectorAll('.homescore');
                    awayScores = LS.querySelectorAll('.awayscore');
                    awayTeams  = LS.querySelectorAll('.away');
                    awayIDs    = LS.querySelectorAll('.awayid');            
                    awayRanks  = LS.querySelectorAll('.a-rank');           

                    // Last 16 Match 49 
                    if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('winner49').innerHTML = homeTeams[0].innerHTML;
                        document.getElementById('winner49flag').innerHTML = "<img src='../img/teams/" + homeTeams[0].innerHTML.trim() + ".png' alt='" + homeTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner49').nextElementSibling.innerHTML = homeIDs[0].innerHTML;
                        document.getElementById('winner49').nextElementSibling.nextElementSibling.innerHTML = homeRanks[0].innerHTML;
                    } else if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('winner49').innerHTML = awayTeams[0].innerHTML;
                        document.getElementById('winner49flag').innerHTML = "<img src='../img/teams/" + awayTeams[0].innerHTML.trim() + ".png' alt='" + awayTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner49').nextElementSibling.innerHTML = awayIDs[0].innerHTML;
                        document.getElementById('winner49').nextElementSibling.nextElementSibling.innerHTML = awayRanks[0].innerHTML;
                    } else if (homeScores[0].value == awayScores[0].value) {
                        LastSixteenOK = false;
                    };
                        
                    // Last 16 Match 50 
                    if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('winner50').innerHTML = homeTeams[1].innerHTML;
                        document.getElementById('winner50flag').innerHTML = "<img src='../img/teams/" + homeTeams[1].innerHTML.trim() + ".png' alt='" + homeTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner50').previousElementSibling.innerHTML = homeIDs[1].innerHTML;
                        document.getElementById('winner50').previousElementSibling.previousElementSibling.innerHTML = homeRanks[1].innerHTML;
                    } else if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('winner50').innerHTML = awayTeams[1].innerHTML;
                        document.getElementById('winner50flag').innerHTML = "<img src='../img/teams/" + awayTeams[1].innerHTML.trim() + ".png' alt='" + awayTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner50').previousElementSibling.innerHTML = awayIDs[1].innerHTML;
                        document.getElementById('winner50').previousElementSibling.previousElementSibling.innerHTML = awayRanks[1].innerHTML;
                    } else if (homeScores[1].value == awayScores[1].value) {
                        LastSixteenOK = false;
                    };
 
                    // Last 16 Match 53
                    if (homeScores[4].value > awayScores[4].value) {
                        document.getElementById('winner53').innerHTML = homeTeams[4].innerHTML;
                        document.getElementById('winner53flag').innerHTML = "<img src='../img/teams/" + homeTeams[4].innerHTML.trim() + ".png' alt='" + homeTeams[4].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner53').nextElementSibling.innerText = homeIDs[4].innerHTML;
                        document.getElementById('winner53').nextElementSibling.nextElementSibling.innerText = homeRanks[4].innerHTML;
                    } else if (homeScores[4].value < awayScores[4].value) {
                        document.getElementById('winner53').innerHTML = awayTeams[4].innerHTML;
                        document.getElementById('winner53flag').innerHTML = "<img src='../img/teams/" + awayTeams[4].innerHTML.trim() + ".png' alt='" + awayTeams[4].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner53').nextElementSibling.innerText = awayIDs[4].innerHTML;
                        document.getElementById('winner53').nextElementSibling.nextElementSibling.innerText = awayRanks[4].innerHTML;
                    } else if (homeScores[4].value == awayScores[4].value) {
                        LastSixteenOK = false;
                    };
 
                    // Last 16 Match 54
                    if (homeScores[5].value > awayScores[5].value) {
                        document.getElementById('winner54').innerHTML = homeTeams[5].innerHTML;
                        document.getElementById('winner54flag').innerHTML = "<img src='../img/teams/" + homeTeams[5].innerHTML.trim() + ".png' alt='" + homeTeams[5].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner54').previousElementSibling.innerText = homeIDs[5].innerHTML;
                        document.getElementById('winner54').previousElementSibling.previousElementSibling.innerText = homeRanks[5].innerHTML;
                    } else if (homeScores[5].value < awayScores[5].value) {
                        document.getElementById('winner54').innerHTML = awayTeams[5].innerHTML;
                        document.getElementById('winner54flag').innerHTML = "<img src='../img/teams/" + awayTeams[5].innerHTML.trim() + ".png' alt='" + awayTeams[5].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner54').previousElementSibling.innerText = awayIDs[5].innerHTML;
                        document.getElementById('winner54').previousElementSibling.previousElementSibling.innerText = awayRanks[5].innerHTML;
                    } else if (homeScores[5].value == awayScores[5].value) {
                        LastSixteenOK = false;
                    };
                    
                    // Last 16 Match 55
                    if (homeScores[2].value > awayScores[2].value) {
                        document.getElementById('winner51').innerHTML = homeTeams[2].innerHTML;
                        document.getElementById('winner51flag').innerHTML = "<img src='../img/teams/" + homeTeams[2].innerHTML.trim() + ".png' alt='" + homeTeams[2].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner51').nextElementSibling.innerHTML = homeIDs[2].innerHTML;
                        document.getElementById('winner51').nextElementSibling.nextElementSibling.innerHTML = homeRanks[2].innerHTML;
                    } else if (homeScores[2].value < awayScores[2].value) {
                        document.getElementById('winner51').innerHTML = awayTeams[2].innerHTML;
                        document.getElementById('winner51flag').innerHTML = "<img src='../img/teams/" + awayTeams[2].innerHTML.trim() + ".png' alt='" + awayTeams[2].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner51').nextElementSibling.innerHTML = awayIDs[2].innerHTML;
                        document.getElementById('winner51').nextElementSibling.nextElementSibling.innerHTML = awayRanks[2].innerHTML;
                    } else if (homeScores[2].value == awayScores[2].value) {
                        LastSixteenOK = false;
                    };
                        
                    // Last 16 Match 56
                    if (homeScores[3].value > awayScores[3].value) {
                        document.getElementById('winner52').innerHTML = homeTeams[3].innerHTML;
                        document.getElementById('winner52flag').innerHTML = "<img src='../img/teams/" + homeTeams[3].innerHTML.trim() + ".png' alt='" + homeTeams[3].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner52').previousElementSibling.innerHTML = homeIDs[3].innerHTML;
                        document.getElementById('winner52').previousElementSibling.previousElementSibling.innerHTML = homeRanks[3].innerHTML;
                    } else if (homeScores[3].value < awayScores[3].value) {
                        document.getElementById('winner52').innerHTML = awayTeams[3].innerHTML;
                        document.getElementById('winner52flag').innerHTML = "<img src='../img/teams/" + awayTeams[3].innerHTML.trim() + ".png' alt='" + awayTeams[3].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner52').previousElementSibling.innerHTML = awayIDs[3].innerHTML;
                        document.getElementById('winner52').previousElementSibling.previousElementSibling.innerHTML = awayRanks[3].innerHTML;
                    } else if (homeScores[3].value == awayScores[3].value) {
                        LastSixteenOK = false;
                    };
 
                    // Last 16 Match 57
                    if (homeScores[6].value > awayScores[6].value) {
                        document.getElementById('winner55').innerHTML = homeTeams[6].innerHTML;
                        document.getElementById('winner55flag').innerHTML = "<img src='../img/teams/" + homeTeams[6].innerHTML.trim() + ".png' alt='" + homeTeams[6].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner55').nextElementSibling.innerText = homeIDs[6].innerHTML;
                        document.getElementById('winner55').nextElementSibling.nextElementSibling.innerText = homeRanks[6].innerHTML;
                    } else if (homeScores[6].value < awayScores[6].value) {
                        document.getElementById('winner55').innerHTML = awayTeams[6].innerHTML;
                        document.getElementById('winner55flag').innerHTML = "<img src='../img/teams/" + awayTeams[6].innerHTML.trim() + ".png' alt='" + awayTeams[6].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner55').nextElementSibling.innerText = awayIDs[6].innerHTML;
                        document.getElementById('winner55').nextElementSibling.nextElementSibling.innerText = awayRanks[6].innerHTML;
                    } else if (homeScores[6].value == awayScores[6].value) {
                        LastSixteenOK = false;
                    };
 
                    // Last 16 Match 58
                   if (homeScores[7].value > awayScores[7].value) {
                        document.getElementById('winner56').innerHTML = homeTeams[7].innerHTML;
                        document.getElementById('winner56flag').innerHTML = "<img src='../img/teams/" + homeTeams[7].innerHTML.trim() + ".png' alt='" + homeTeams[7].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner56').previousElementSibling.innerText = homeIDs[7].innerHTML;
                        document.getElementById('winner56').previousElementSibling.previousElementSibling.innerText = homeRanks[7].innerHTML;
                    } else if (homeScores[3].value < awayScores[7].value) {
                        document.getElementById('winner56').innerHTML = awayTeams[7].innerHTML;
                        document.getElementById('winner56flag').innerHTML = "<img src='../img/teams/" + awayTeams[7].innerHTML.trim() + ".png' alt='" + awayTeams[7].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner56').previousElementSibling.innerText = awayIDs[7].innerHTML;
                        document.getElementById('winner56').previousElementSibling.previousElementSibling.innerText = awayRanks[7].innerHTML;
                    } else if (homeScores[3].value == awayScores[7].value) {
                        LastSixteenOK = false;
                    };
                    
                    return;
                };

                if (event.target.matches('[data-stage="QF"]')) {

                    // will be set to false if any predictions are set as a draw
                    QuarterFinalsOK = true;

                    let QF = document.querySelector('#QF');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeIDs    = QF.querySelectorAll('.homeid');            
                    homeRanks  = QF.querySelectorAll('.h-rank');            
                    homeTeams  = QF.querySelectorAll('.home');            
                    homeScores = QF.querySelectorAll('.homescore');
                    awayScores = QF.querySelectorAll('.awayscore');
                    awayTeams  = QF.querySelectorAll('.away');
                    awayIDs    = QF.querySelectorAll('.awayid');            
                    awayRanks  = QF.querySelectorAll('.a-rank');           

                    if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('winner57').innerHTML = homeTeams[0].innerHTML;
                        document.getElementById('winner57flag').innerHTML = "<img src='../img/teams/" + homeTeams[0].innerHTML.trim() + ".png' alt='" + homeTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner57').nextElementSibling.innerHTML = homeIDs[0].innerHTML;
                        document.getElementById('winner57').nextElementSibling.nextElementSibling.innerHTML = homeRanks[0].innerHTML;
                    } else if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('winner57').innerHTML = awayTeams[0].innerHTML;
                        document.getElementById('winner57flag').innerHTML = "<img src='../img/teams/" + awayTeams[0].innerHTML.trim() + ".png' alt='" + awayTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner57').nextElementSibling.innerHTML = awayIDs[0].innerHTML;
                        document.getElementById('winner57').nextElementSibling.nextElementSibling.innerHTML = awayRanks[0].innerHTML;
                    } else if (homeScores[0].value == awayScores[0].value) {
                        QuarterFinalsOK = false;
                    };
                        
                    if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('winner58').innerHTML = homeTeams[1].innerHTML;
                        document.getElementById('winner58flag').innerHTML = "<img src='../img/teams/" + homeTeams[1].innerHTML.trim() + ".png' alt='" + homeTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner58').previousElementSibling.innerHTML = homeIDs[1].innerHTML;
                        document.getElementById('winner58').previousElementSibling.previousElementSibling.innerHTML = homeRanks[1].innerHTML;
                    } else if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('winner58').innerHTML = awayTeams[1].innerHTML;
                        document.getElementById('winner58flag').innerHTML = "<img src='../img/teams/" + awayTeams[1].innerHTML.trim() + ".png' alt='" + awayTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner58').previousElementSibling.innerHTML = awayIDs[1].innerHTML;
                        document.getElementById('winner58').previousElementSibling.previousElementSibling.innerHTML = awayRanks[1].innerHTML;
                    } else if (homeScores[1].value == awayScores[1].value) {
                        QuarterFinalsOK = false;
                    };
 
                    if (homeScores[2].value > awayScores[2].value) {
                        document.getElementById('winner59').innerHTML = homeTeams[2].innerHTML;
                        document.getElementById('winner59flag').innerHTML = "<img src='../img/teams/" + homeTeams[2].innerHTML.trim() + ".png' alt='" + homeTeams[2].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner59').nextElementSibling.innerText = homeIDs[2].innerHTML;
                        document.getElementById('winner59').nextElementSibling.nextElementSibling.innerText = homeRanks[2].innerHTML;
                    } else if (homeScores[2].value < awayScores[2].value) {
                        document.getElementById('winner59').innerHTML = awayTeams[2].innerHTML;
                        document.getElementById('winner59flag').innerHTML = "<img src='../img/teams/" + awayTeams[2].innerHTML.trim() + ".png' alt='" + awayTeams[2].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner59').nextElementSibling.innerText = awayIDs[2].innerHTML;
                        document.getElementById('winner59').nextElementSibling.nextElementSibling.innerText = awayRanks[2].innerHTML;
                    } else if (homeScores[2].value == awayScores[2].value) {
                        QuarterFinalsOK = false;
                    };
 
                    if (homeScores[3].value > awayScores[3].value) {
                        document.getElementById('winner60').innerHTML = homeTeams[3].innerHTML;
                        document.getElementById('winner60flag').innerHTML = "<img src='../img/teams/" + homeTeams[3].innerHTML.trim() + ".png' alt='" + homeTeams[3].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner60').previousElementSibling.innerText = homeIDs[3].innerHTML;
                        document.getElementById('winner60').previousElementSibling.previousElementSibling.innerText = homeRanks[3].innerHTML;
                    } else if (homeScores[3].value < awayScores[3].value) {
                        document.getElementById('winner60').innerHTML = awayTeams[3].innerHTML;
                        document.getElementById('winner60flag').innerHTML = "<img src='../img/teams/" + awayTeams[3].innerHTML.trim() + ".png' alt='" + awayTeams[3].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner60').previousElementSibling.innerText = awayIDs[3].innerHTML;
                        document.getElementById('winner60').previousElementSibling.previousElementSibling.innerText = awayRanks[3].innerHTML;
                    } else if (homeScores[3].value == awayScores[3].value) {
                        QuarterFinalsOK = false;
                    };
                    
                    return;
                };

                if (event.target.matches('[data-stage="SF"]')) {

                    // will be set to false if any predictions are set as a draw
                    SemiFinalsOK = true;
                    
                    let SF = document.querySelector('#SF');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeIDs    = SF.querySelectorAll('.homeid');            
                    homeRanks  = SF.querySelectorAll('.h-rank');            
                    homeTeams  = SF.querySelectorAll('.home');            
                    homeScores = SF.querySelectorAll('.homescore');
                    awayScores = SF.querySelectorAll('.awayscore');
                    awayTeams  = SF.querySelectorAll('.away');
                    awayIDs    = SF.querySelectorAll('.awayid');            
                    awayRanks  = SF.querySelectorAll('.a-rank');            

                    // PLAYOFF POSITIONS                    
                    if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('loser61').innerHTML = homeTeams[0].innerHTML;
                        document.getElementById('loser61flag').innerHTML = "<img src='../img/teams/" + homeTeams[0].innerHTML.trim() + ".png' alt='" + homeTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('loser61').nextElementSibling.innerHTML = homeIDs[0].innerHTML;
                        document.getElementById('loser61').nextElementSibling.nextElementSibling.innerHTML = homeRanks[0].innerHTML;
                    } else if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('loser61').innerHTML = awayTeams[0].innerHTML;
                        document.getElementById('loser61flag').innerHTML = "<img src='../img/teams/" + awayTeams[0].innerHTML.trim() + ".png' alt='" + awayTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('loser61').nextElementSibling.innerHTML = awayIDs[0].innerHTML;
                        document.getElementById('loser61').nextElementSibling.nextElementSibling.innerHTML = awayRanks[0].innerHTML;
                    } else if (homeScores[0].value == awayScores[0].value) {
                        SemiFinalsOK = false;
                    };
                        
                    if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('loser62').innerHTML = homeTeams[1].innerHTML;
                        document.getElementById('loser62flag').innerHTML = "<img src='../img/teams/" + homeTeams[1].innerHTML.trim() + ".png' alt='" + homeTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('loser62').previousElementSibling.innerHTML = homeIDs[1].innerHTML;
                        document.getElementById('loser62').previousElementSibling.previousElementSibling.innerHTML = homeRanks[1].innerHTML;
                    } else if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('loser62').innerHTML = awayTeams[1].innerHTML;
                        document.getElementById('loser62flag').innerHTML = "<img src='../img/teams/" + awayTeams[1].innerHTML.trim() + ".png' alt='" + awayTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('loser62').previousElementSibling.innerHTML = awayIDs[1].innerHTML;
                        document.getElementById('loser62').previousElementSibling.previousElementSibling.innerHTML = awayRanks[1].innerHTML;
                    } else if (homeScores[1].value == awayScores[1].value) {
                        SemiFinalsOK = false;
                    };

                    // FINAL POSITIONS
                    if (homeScores[0].value > awayScores[0].value) {
                        document.getElementById('winner61').innerHTML = homeTeams[0].innerHTML;
                        document.getElementById('winner61flag').innerHTML = "<img src='../img/teams/" + homeTeams[0].innerHTML.trim() + ".png' alt='" + homeTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner61').nextElementSibling.innerHTML = homeIDs[0].innerHTML;
                        document.getElementById('winner61').nextElementSibling.nextElementSibling.innerHTML = homeRanks[0].innerHTML;
                    } else if (homeScores[0].value < awayScores[0].value) {
                        document.getElementById('winner61').innerHTML = awayTeams[0].innerHTML;
                        document.getElementById('winner61flag').innerHTML = "<img src='../img/teams/" + awayTeams[0].innerHTML.trim() + ".png' alt='" + awayTeams[0].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner61').nextElementSibling.innerHTML = awayIDs[0].innerHTML;
                        document.getElementById('winner61').nextElementSibling.nextElementSibling.innerHTML = awayRanks[0].innerHTML;
                    } else if (homeScores[0].value == awayScores[0].value) {
                        SemiFinalsOK = false;
                    };
                        
                    if (homeScores[1].value > awayScores[1].value) {
                        document.getElementById('winner62').innerHTML = homeTeams[1].innerHTML;
                        document.getElementById('winner62flag').innerHTML = "<img src='../img/teams/" + homeTeams[1].innerHTML.trim() + ".png' alt='" + homeTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner62').previousElementSibling.innerHTML = homeIDs[1].innerHTML;
                        document.getElementById('winner62').previousElementSibling.previousElementSibling.innerHTML = homeRanks[1].innerHTML;
                    } else if (homeScores[1].value < awayScores[1].value) {
                        document.getElementById('winner62').innerHTML = awayTeams[1].innerHTML;
                        document.getElementById('winner62flag').innerHTML = "<img src='../img/teams/" + awayTeams[1].innerHTML.trim() + ".png' alt='" + awayTeams[1].innerHTML.trim() + " team flag'>";
                        document.getElementById('winner62').previousElementSibling.innerHTML = awayIDs[1].innerHTML;
                        document.getElementById('winner62').previousElementSibling.previousElementSibling.innerHTML = awayRanks[1].innerHTML;
                    } else if (homeScores[1].value == awayScores[1].value) {
                        SemiFinalsOK = false;
                    };
                   
                    return;

                };

                if (event.target.matches('[data-stage="PL"]')) {

                    // will be set to false if any predictions are set as a draw
                    PlayoffOK = true;

                    let PL = document.querySelector('#PL');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeTeams  = PL.querySelectorAll('.home');            
                    homeScores = PL.querySelectorAll('.homescore');
                    awayScores = PL.querySelectorAll('.awayscore');
                    awayTeams  = PL.querySelectorAll('.away');

                    if (homeScores[0].value == awayScores[0].value) {
                        PlayoffOK = false;
                    }

                    return;

                };

                if (event.target.matches('[data-stage="FL"]')) {

                    // will be set to false if any predictions are set as a draw
                    FinalOK = true;

                    let FL = document.querySelector('#FL');
                    
                    // get the teams and the scores for the Quarter Finals
                    homeTeams  = FL.querySelectorAll('.home');            
                    homeScores = FL.querySelectorAll('.homescore');
                    awayScores = FL.querySelectorAll('.awayscore');
                    awayTeams  = FL.querySelectorAll('.away');

                    if (homeScores[0].value == awayScores[0].value) {
                        FinalOK = false;
                    }

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
                    currentTableName = "Group A";

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
                    currentTableName = "Group B";

                } else if (event.target.matches('[data-table="TableC"]')) {

                    SectC = document.querySelector('#SectionC');
                    
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
                    currentTableName = "Group C";        

                } else if (event.target.matches('[data-table="TableD"]')) {
                    
                    SectD = document.querySelector('#SectionD');
                    
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
                    currentTableName = "Group D";

                } else if (event.target.matches('[data-table="TableE"]')) {
                    
                    SectE = document.querySelector('#SectionE');
                    
                    // get the teams and the scores for SectionE
                    teamIds    = SectE.querySelectorAll('.homeid');
                    teamRks    = SectE.querySelectorAll('.h-rank');
                    homeTeams  = SectE.querySelectorAll('.home');            
                    homeScores = SectE.querySelectorAll('.homescore');
                    awayScores = SectE.querySelectorAll('.awayscore');
                    awayTeams  = SectE.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableE");
                    currentTableID   = currentTable.id;
                    currentTableName = "Group E";

                } else if (event.target.matches('[data-table="TableF"]')) {
                    
                    SectF = document.querySelector('#SectionF');
                    
                    // get the teams and the scores for SectionF
                    teamIds    = SectF.querySelectorAll('.homeid');
                    teamRks    = SectF.querySelectorAll('.h-rank');
                    homeTeams  = SectF.querySelectorAll('.home');            
                    homeScores = SectF.querySelectorAll('.homescore');
                    awayScores = SectF.querySelectorAll('.awayscore');
                    awayTeams  = SectF.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableF");
                    currentTableID   = currentTable.id;
                    currentTableName = "Group F";

                } else if (event.target.matches('[data-table="TableG"]')) {
                    
                    SectG = document.querySelector('#SectionG');
                    
                    // get the teams and the scores for SectionG
                    teamIds    = SectG.querySelectorAll('.homeid');
                    teamRks    = SectG.querySelectorAll('.h-rank');
                    homeTeams  = SectG.querySelectorAll('.home');            
                    homeScores = SectG.querySelectorAll('.homescore');
                    awayScores = SectG.querySelectorAll('.awayscore');
                    awayTeams  = SectG.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableG");
                    currentTableID   = currentTable.id;
                    currentTableName = "Group G";

                } else if (event.target.matches('[data-table="TableH"]')) {
                    
                    SectH = document.querySelector('#SectionH');
                    
                    // get the teams and the scores for SectionH
                    teamIds    = SectH.querySelectorAll('.homeid');
                    teamRks    = SectH.querySelectorAll('.h-rank');
                    homeTeams  = SectH.querySelectorAll('.home');            
                    homeScores = SectH.querySelectorAll('.homescore');
                    awayScores = SectH.querySelectorAll('.awayscore');
                    awayTeams  = SectH.querySelectorAll('.away');

                    // get the ID of the table to update
                    currentTable     = document.getElementById("TableH");
                    currentTableID   = currentTable.id;
                    currentTableName = "Group H";

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
                            <th colspan="11"> ${currentTableName} </th>
                        </tr>
                        <tr>
                            <th>Pos</th><th colspan='2'>Team</th><th class='hidden'></th><th class='hidden'></th><th>P</th><th>W</th><th>D</th><th>L</th><th>F</th><th>A</th><th>GD</th><th>Pts</th>
                        </tr>
                    </thead>
                    <tbody>`;

                teams.forEach(function (team, index) {

                    updatedTable += `<tr>
                            <td class='pos'>  ${index+1}  </td>
                            <td class='home-flag'><img src="../img/teams/${team.Team}.png" alt="${team.Team} team flag"></td>
                            <td id='${currentTableID}-pos${index+1}' class='team'> ${team.Team} </td>
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
                <?php include "../include/header4.inc.php"; ?>
            </header>

            <!-- Tab links -->
            <div id="tabs" class="tab">
              <button id="groups-abcd-tab"          name="GROUPS-ABCD"          class="tablinks active">Groups A,B,C,D</button>
              <button id="groups-efgh-tab"          name="GROUPS-EFGH"          class="tablinks ">Groups E,F,G,H</button>
              <button id="knockout-stage-tab"       name="KNOCKOUT-STAGE"       class="tablinks ">Knockout Stage</button>
              <button id="finals-stage-tab"         name="FINALS-STAGE"         class="tablinks ">Finals Stage</button>
              <button id="top-scorer-tab"           name="TOP-SCORER"           class="tablinks ">Top Goal Scorer</button>
              <button id="update-predictions-tab"   name="UPDATE-PREDICTIONS"   class="tablinks ">Update Predictions</button>
              <button id="results-predictions-tab"  name="RESULTS-PREDICTIONS"  class="tablinks ">Results/Predictions</button>
            </div>

            <section id="tournament">

                <div id="GROUPS-ABCD" class="tabcontent">

                    <?php

                        /* query to get the resultid of the first fixture
                           if this is anything other than 6 (Not Played Yet) then the tournament has started
                           and you can no longer save predictions */

                        $qry =   "SELECT \n" 
                                . "  	ResultID \n"
                                . "  FROM  \n"
                                . "  	Fixtures fx \n"
                                . "  WHERE \n"
                                . "  	fx.FixtureNo = :FixtureNo \n";

                        // prepare the query for the database connection
                        $query = $dbh -> prepare($qry);

                        /** bind the parameters */
                        $query->bindParam(':FixtureNo', $fixtureno, PDO::PARAM_INT);
                        
                        /* assign the values to the place holders */ 
                        $fixtureno = 1;  

                        // execute the sql query
                        $query -> execute();
                                                        
                        // get all rows
                        $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                        if ($query->rowCount() == 0) {
                            echo "<div>Fixture No. 1 not returned</div>";
                        } else {
                            // loop through the rows - there just be 1 row
                            foreach($rows as $key => $row) {
                                $fixture1resultid = $row -> ResultID;
                            }
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
                                    . "         fx.GroupID = :GroupID AND pred.UserID = :UserID \n"
                                    . "  ORDER BY \n"
                                    . "  	  fx.FixtureNo \n";

                                // prepare the query for the database connection
                                $query = $dbh -> prepare($qry);

                                /** bind the parameters */
                                $query->bindParam(':GroupID', $groupid, PDO::PARAM_INT);
                                $query->bindParam(':UserID',  $userid,  PDO::PARAM_INT);
                                
                                /** assign the values to the place holders - 
                                $groupid already has a value 
                                $userid already has a value from sesssion 
                                */

                                // execute the sql query
                                $query -> execute();
                                                                
                                // get all rows
                                $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() == 0) {
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
                                    echo "                  <th>No</th><th class='hidden'><th class='hidden'></th><th colspan='2'>HOME</th><th>Rk</th><th colspan='2'>SCORE</th><th>Rk</th>";
                                    echo "                  <th class='hidden'></th> <th colspan='2'>AWAY</th>";
                                    echo "              </tr>";
                                    echo "          </thead>";
                                    echo "          <tbody>";
                                  
                                    // loop through the rows
                                    foreach ($rows as $key => $row) {

                                            $userid    = $row -> userid;
                                            $fixno     = $row -> fixtureno;
                                            $homeid    = $row -> homeid;
                                            $hometeam  = $row -> hometeam;
                                            $homescore = $row -> homescore;
                                            $homerank  = $row -> homerank;
                                            $awayrank  = $row -> awayrank;
                                            $awayscore = $row -> awayscore;
                                            $awayteam  = $row -> awayteam;
                                            $awayid    = $row -> awayid;
                                            $grpdesc   = $row -> groupdesc;
                                            $rndcode   = $row -> roundcode;

                                                echo "  <tr>";
                                                echo "      <td class='fixno'>" . $fixno . "</td>";
                                                echo "      <td class='stage hidden'>" . $rndcode . "</td>";                       
                                                echo "      <td class='homeid hidden'>" . $homeid . "</td>";        
                                                echo "      <td class='home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>";      
                                                echo "      <td class='home'>" . $hometeam . "</td>";
                                                echo "      <td class='h-rank'>" . $homerank . "</td>";
                                                echo "      <td><input class='homescore' data-table='" . $tablename . "' value=" . $homescore . " type='number' min=0 placeholder=0></td>";
                                                echo "      <td><input class='awayscore' data-table='" . $tablename . "' value=" . $awayscore . " type='number' min=0 placeholder=0></td>";
                                                echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                                echo "      <td class='awayid hidden'>" . $awayid . "</td>";        
                                                echo "      <td class='away'>" . $awayteam . "</td>";
                                                echo "      <td class='away-flag'><img src='../img/teams/" . $awayteam . ".png'alt='" . $awayteam . " team flag'></td>";      
                                                echo "  </tr>";
                                    }

                                    echo "          </tbody>";
                                    echo "      </table>";   
                                    echo "  </div>  <!-- end of group " . $groupid .  "div -->";     

                                // Start SQL QRY FOR THE TABLES
                                $qry =   "SELECT \n" 
                                        . "  	ID,  \n"
                                        . "  	Ranking,  \n"
                                        . "  	Team  \n"
                                        . "  FROM  \n"
                                        . "  	Teams \n"
                                        . "  WHERE  \n"
                                        . "  	GroupID = :GroupID \n"
                                        . "  ORDER BY \n"
                                        . "  	Team ASC \n";

                                $rowno = 0;     // Initialise row counter to identify league position

                                // prepare the query for the database connection
                                $query = $dbh -> prepare($qry);

                                /** bind the parameters */
                                $query->bindParam(':GroupID', $groupid, PDO::PARAM_INT);
                                
                                /** assign the values to the place holders - 
                                $groupid already has a value 
                                */

                                // execute the sql query
                                $query -> execute();
                                                                
                                // get all rows
                                $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() == 0) {
                                    echo "<div>NO RESULTS RETURNED</div>";
                                    } else {
                                        echo "  <div id='" . $tablename . "'>"; 
                                        echo "      <table>";
                                        echo "          <thead class='blueheader'>";
                                        echo "              <tr>";
                                        echo "                  <th colspan='11'>" . $groupdesc .  "</th>";
                                        echo "              </tr>";
                                        echo "              <tr>";
                                        echo "                  <th>Pos</th><th colspan='2'>Team</th><th class='hidden'></th><th class='hidden'></th>";
                                        echo "                  <th>P</th><th>W</th><th>D</th><th>L</th><th>F</th><th>A</th><th>GD</th><th>Pts</th>";
                                        echo "              </tr>";
                                        echo "          </thead>";
                                        echo "          <tbody>";

                                        $rowno = 1;         

                                        // loop through the rows
                                        foreach ($rows as $key => $row) {
                                        
                                            echo "       <tr>";
                                            echo "           <td class='pos'>" . $rowno . "</td><td class='home-flag'><img src='../img/teams/" . $row -> Team . ".png' alt='" . $row -> Team . " team flag'></td>";
                                            echo "           <td id=" . $tablename . "-pos" . $rowno . " class='team'>" . $row -> Team . "</td>";
                                            echo "           <td class='hidden team-id'>" . $row -> ID . "</td> <td class='hidden team-rk'>" . $row -> Ranking . "</td>";
                                            echo "           <td class='cols'>0</td> <td class='cols'>0</td><td class='cols'>0</td><td class='cols'>0</td><td class='cols'>0</td>";
                                            echo "           <td class='cols'>0</td> <td class='cols'>0</td><td class='cols'>0</td>";
                                            echo "       </tr>";

                                            $rowno = $rowno + 1;    // increment row counter
                                        }
                                        echo "          </tbody>";
                                        echo "      </table> <!-- end of " . $tablename . " DIV -->"; 

                                    } // end of nested else for Table        
                                    
                                    // create an event and sispatch it to update the table
                                    echo "<script>";
                                    echo "  var event = new Event('updateTables');";
                                    echo "  tbl = document.querySelector('[data-table=" . $tablename . "]');";
                                    echo "  tbl.addEventListener('updateTables', updateLeagueTables);";
                                    echo "  tbl.dispatchEvent(event);";
                                    echo "</script>";

                                    echo "</section> <!-- end of " . $sectionname . " div -->";                         

                                } // end of else

                        }   // end of Groups foreach    

                    ?>

                </div> <!-- end of GROUPS ABCD -->

                <div id="GROUPS-EFGH" class="tabcontent">

                    <?php

                        // as the group values start at 5, need to pad the arrays to have correct number of items 
                        $groupids     = array(5, 6, 7, 8);
                        $groupnames   = array("", "", "", "", "", "GroupE",   "GroupF",   "GroupG",   "GroupH"); 
                        $groupdescs   = array("", "", "", "", "", "Group E",  "Group F",  "Group G",   "Group H"); 
                        $sectionnames = array("", "", "", "", "", "SectionE", "SectionF", "SectionG", "SectionH"); 
                        $tablenames   = array("", "", "", "", "", "TableE",   "TableF",   "TableG",   "TableH");

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
                                    . "         fx.GroupID = :GroupID AND pred.UserID = :UserID \n"
                                    . "  ORDER BY \n"
                                    . "  	  fx.FixtureNo \n";

                                // prepare the query for the database connection
                                $query = $dbh -> prepare($qry);

                                /** bind the parameters */
                                $query->bindParam(':GroupID', $groupid, PDO::PARAM_INT);
                                $query->bindParam(':UserID',  $userid,  PDO::PARAM_INT);
                                
                                /** assign the values to the place holders - 
                                $groupid already has a value 
                                $userid already has a value from sesssion 
                                */

                                // execute the sql query
                                $query -> execute();
                                                                
                                // get all rows
                                $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() == 0) {
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
                                  
                                    // loop through the rows
                                    foreach ($rows as $key => $row) {

                                            $userid    = $row -> userid;
                                            $fixno     = $row -> fixtureno;
                                            $homeid    = $row -> homeid;
                                            $hometeam  = $row -> hometeam;
                                            $homescore = $row -> homescore;
                                            $homerank  = $row -> homerank;
                                            $awayrank  = $row -> awayrank;
                                            $awayscore = $row -> awayscore;
                                            $awayteam  = $row -> awayteam;
                                            $awayid    = $row -> awayid;
                                            $grpdesc   = $row -> groupdesc;
                                            $rndcode   = $row -> roundcode;

                                            echo "  <tr>";
                                            echo "      <td class='fixno'>" . $fixno . "</td>";
                                            echo "      <td class='stage hidden'>" . $rndcode . "</td>";                      // hidden cell for code of the tournament stage 
                                            echo "      <td class='homeid hidden'>" . $homeid . "</td>";        // hidden cell for ID of home team
                                            echo "      <td class='home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>";      
                                            echo "      <td class='home'>" . $hometeam . "</td>";
                                            echo "      <td class='h-rank'>" . $homerank . "</td>";
                                            echo "      <td><input class='homescore' data-table='" . $tablename . "' value=" . $homescore . " type='number' min=0 placeholder=0></td>";
                                            echo "      <td><input class='awayscore' data-table='" . $tablename . "' value=" . $awayscore . " type='number' min=0 placeholder=0></td>";
                                            echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                            echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                                            echo "      <td class='away'>" . $awayteam . "</td>";
                                            echo "      <td class='away-flag'><img src='../img/teams/" . $awayteam . ".png'alt='" . $awayteam . " team flag'></td>";      
                                            echo "  </tr>";
                                    }

                                    echo "          </tbody>";
                                    echo "      </table>";   
                                    echo "  </div>  <!-- end of group " . $groupid .  "div -->";     

                                // Start SQL QRY FOR THE TABLES
                                $qry =   "SELECT \n" 
                                        . "  	ID,  \n"
                                        . "  	Ranking,  \n"
                                        . "  	Team  \n"
                                        . "  FROM  \n"
                                        . "  	Teams \n"
                                        . "  WHERE  \n"
                                        . "  	GroupID = :GroupID \n"
                                        . "  ORDER BY \n"
                                        . "  	Team ASC \n";

                                $rowno = 0;     // Initialise row counter to identify league position

                                // prepare the query for the database connection
                                $query = $dbh -> prepare($qry);

                                /** bind the parameters */
                                $query->bindParam(':GroupID', $groupid, PDO::PARAM_INT);
                                
                                /** assign the values to the place holders - 
                                $groupid already has a value 
                                */

                                // execute the sql query
                                $query -> execute();
                                                                
                                // get all rows
                                $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() == 0) {
                                    echo "<div>NO RESULTS RETURNED</div>";
                                    } else {
                                        echo "  <div id='" . $tablename . "'>"; 
                                        echo "      <table>";
                                        echo "          <thead class='blueheader'>";
                                        echo "              <tr>";
                                        echo "                  <th colspan='11'>" . $groupdesc .  "</th>";
                                        echo "              </tr>";
                                        echo "              <tr>";
                                        echo "                  <th>Pos</th><th colspan='2'>Team</th><th class='hidden'></th><th class='hidden'></th>";
                                        echo "                  <th>P</th><th>W</th><th>D</th><th>L</th><th>F</th><th>A</th><th>GD</th><th>Pts</th>";
                                        echo "              </tr>";
                                        echo "          </thead>";
                                        echo "          <tbody>";

                                        $rowno = 1;         

                                        // loop through the rows
                                        foreach ($rows as $key => $row) {
                                        
                                            echo "       <tr>";
                                            echo "           <td class='pos'>" . $rowno . "</td><td class='home-flag'><img src='../img/teams/" . $row -> Team . ".png' alt='" . $row -> Team . " team flag'></td>";
                                            echo "           <td id=" . $tablename . "-pos" . $rowno . " class='team'>" . $row -> Team . "</td>";
                                            echo "           <td class='hidden team-id'>" . $row -> ID . "</td> <td class='hidden team-rk'>" . $row -> Ranking . "</td>";
                                            echo "           <td class='cols'>0</td> <td class='cols'>0</td><td class='cols'>0</td><td class='cols'>0</td><td class='cols'>0</td>";
                                            echo "           <td class='cols'>0</td> <td class='cols'>0</td><td class='cols'>0</td>";
                                            echo "       </tr>";

                                            $rowno = $rowno + 1;    // increment row counter
                                        }
                                        echo "          </tbody>";
                                        echo "      </table> <!-- end of " . $tablename . " DIV -->"; 

                                    } // end of nested else for Table        
                                    
                                    // create an event and dispatch it to update the table
                                    echo "<script>";
                                    echo "  var event = new Event('updateTables');";
                                    echo "  tbl = document.querySelector('[data-table=" . $tablename . "]');";
                                    echo "  tbl.addEventListener('updateTables', updateLeagueTables);";
                                    echo "  tbl.dispatchEvent(event);";
                                    echo "</script>";

                                    echo "</section> <!-- end of " . $sectionname . " div -->";                         

                                } // end of else

                        }   // end of Groups foreach    

                    ?>

                </div> <!-- end of GROUPS EFGH -->

                <div id="KNOCKOUT-STAGE" class="tabcontent">
                    
                    <section id='LS'>
                        <div id='Last16'>

                            <table>
                                <thead class='greenheader'>
                                    <tr>
                                        <th colspan='9'>Last 16</th>
                                    </tr>
                                    <tr>
                                        <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th><th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    . "         fx.GroupID = 9 AND pred.UserID = :UserID \n"
                                    . "  ORDER BY \n"
                                    . "  	  fx.FixtureNo \n";

                                    // prepare the query for the database connection
                                    $query = $dbh -> prepare($qry);

                                    /** bind the parameters */
                                    $query->bindParam(':UserID', $userid, PDO::PARAM_INT);
                                    
                                    /** assign the values to the place holders - 
                                    $userid already has a value from session value 
                                    */

                                    // execute the sql query
                                    $query -> execute();
                                                                    
                                    // get all rows
                                    $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() == 0) {
                                        echo "<div>NO RESULTS RETURNED</div>";
                                    } else {    
                                        
                                        $last16id = 1;

                                        $winners   = array("", "winnerA",   "winnerB",   "winnerC",   "winnerD",   "winnerE",   "winnerF",   "winnerG",   "winnerH"); 
                                        $runnersup = array("", "runnerupB", "runnerupA", "runnerupD", "runnerupC", "runnerupE", "runnerupF", "runnerupG", "runnerupH"); 
                                        
                                        // loop through the rows
                                        foreach ($rows as $key => $row) {

                                            $winner     = $winners[$last16id];
                                            $runnerup   = $runnersup[$last16id];

                                            $userid    = $row -> userid;
                                            $fixno     = $row -> fixtureno;
                                            $homeid    = $row -> homeid;
                                            $hometeam  = $row -> hometeam;
                                            $homescore = $row -> homescore;
                                            $homerank  = $row -> homerank;
                                            $awayrank  = $row -> awayrank;
                                            $awayscore = $row -> awayscore;
                                            $awayteam  = $row -> awayteam;
                                            $awayid    = $row -> awayid;
                                            $grpdesc   = $row -> groupdesc;
                                            $rndcode   = $row -> roundcode;

                                            echo "  <tr id='match" . $fixno . "'>";
                                            echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                            echo "      <td class='hidden stage'>LS</td>"; 
                                            echo "      <td id='" . $winner . "flag' class='home-flag'></td>"; 
                                            echo "      <td id='". $winner . "' class='home'>". $hometeam . "</td>"; 
                                            echo "      <td class='hidden homeid'>" . $homeid . "</td>"; 
                                            echo "      <td class='h-rank'>" . $homerank . "</td>";
                                            echo "      <td><input class='homescore' data-stage='LS' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                            echo "      <td><input class='awayscore' data-stage='LS' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                            echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                            echo "      <td class='hidden awayid'>" . $awayid . "</td>";
                                            echo "      <td id='" . $runnerup . "' class='away'>". $awayteam . "</td>";
                                            echo "      <td id='" . $runnerup . "flag' class='away-flag'></td>"; 
                                            echo "  </tr>";                            

                                            // there are 8 matches in the last 16 round
                                            $last16id = $last16id + 1;

                                        }   // end of while    
                                            
                                    }; // end of if else                     
                                    ?>  

                                </tbody>
                            </table> 
                        </div>  <!-- end of Last 16 div -->     
                    </section> <!-- End of LS -->
                            
                    <section id='QF'>
                        <div id='QuarterFinal'>

                            <table>
                                <thead class='greenheader'>
                                    <tr>
                                        <th colspan='9'>QUARTER FINALS</th>
                                    </tr>
                                    <tr>
                                        <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th><th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    . "         fx.GroupID = 10 AND pred.UserID = :UserID \n"
                                    . "  ORDER BY \n"
                                    . "  	  fx.FixtureNo \n";

                                    // prepare the query for the database connection
                                    $query = $dbh -> prepare($qry);

                                    /** bind the parameters */
                                    $query->bindParam(':UserID', $userid, PDO::PARAM_INT);
                                    
                                    /** assign the values to the place holders - 
                                    $userid already has a value from session variable 
                                    */

                                    // execute the sql query
                                    $query -> execute();
                                                                    
                                    // get all rows
                                    $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() == 0) {
                                        echo "<div>NO RESULTS RETURNED</div>";
                                    } else {    

                                        $quarterfinalid = 1;

                                        $homewinners = array("", "winner49", "winner53",  "winner51", "winner55"); 
                                        $awaywinners = array("", "winner50", "winner54",  "winner52", "winner56"); 
                                        
                                        // loop through the rows
                                        foreach ($rows as $key => $row) {

                                            $homewinner = $homewinners[$quarterfinalid];
                                            $awaywinner = $awaywinners[$quarterfinalid];

                                            $userid    = $row -> userid;
                                            $fixno     = $row -> fixtureno;
                                            $homeid    = $row -> homeid;
                                            $hometeam  = $row -> hometeam;
                                            $homescore = $row -> homescore;
                                            $homerank  = $row -> homerank;
                                            $awayrank  = $row -> awayrank;
                                            $awayscore = $row -> awayscore;
                                            $awayteam  = $row -> awayteam;
                                            $awayid    = $row -> awayid;
                                            $grpdesc   = $row -> groupdesc;
                                            $rndcode   = $row -> roundcode;

                                            echo "  <tr id='match" . $fixno . "'>";
                                            echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                            echo "      <td class='hidden stage'>QF</td>"; 
                                            echo "      <td id='" . $homewinner . "flag' class='home-flag'></td>"; 
                                            echo "      <td id='". $homewinner . "' class='home'>". $hometeam . "</td>"; 
                                            echo "      <td class='hidden homeid'>" . $homeid . "</td>"; 
                                            echo "      <td class='h-rank'>" . $homerank . "</td>";
                                            echo "      <td><input class='homescore' data-stage='QF' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                            echo "      <td><input class='awayscore' data-stage='QF' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                            echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                            echo "      <td class='hidden awayid'>" . $awayid . "</td>";
                                            echo "      <td id='" . $awaywinner . "' class='away'>". $awayteam . "</td>";
                                            echo "      <td id='" . $awaywinner . "flag' class='away-flag'></td>"; 
                                            echo "  </tr>";                            

                                            // there are 4 quarter finals
                                            $quarterfinalid = $quarterfinalid + 1;

                                            }   // end of while    
                                                
                                        }; // end of if else                     
                                        ?>  
    
                                </tbody>
                            </table>   
                        
                        </div>  <!-- end of quarter final div -->     
                    </section> <!-- End of QF -->
                                        
                    <section id='SF'>
                        <div id='SemiFinal'>

                            <table>
                                <thead class='greenheader'>
                                    <tr>
                                        <th colspan='9'>SEMI FINALS</th>
                                    </tr>
                                    <tr>
                                        <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th><th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    . "         fx.GroupID = 11 AND pred.UserID = :UserID \n"
                                    . "  ORDER BY \n"
                                    . "  	  fx.FixtureNo \n";

                                    // prepare the query for the database connection
                                    $query = $dbh -> prepare($qry);

                                    /** bind the parameters */
                                    $query->bindParam(':UserID', $userid, PDO::PARAM_INT);
                                    
                                    /** assign the values to the place holders - 
                                    $userid already has a value from session variable 
                                    */

                                    // execute the sql query
                                    $query -> execute();
                                                                    
                                    // get all rows
                                    $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() == 0) {
                                        echo "<div>NO RESULTS RETURNED</div>";
                                    } else {    

                                        $semifinalid = 1;

                                        $homewinners = array("", "winner57", "winner59"); 
                                        $awaywinners = array("", "winner58", "winner60"); 

                                        foreach ($rows as $key => $row) {

                                            $homewinner = $homewinners[$semifinalid];
                                            $awaywinner = $awaywinners[$semifinalid];
                                            
                                            $userid    = $row -> userid;
                                            $fixno     = $row -> fixtureno;
                                            $homeid    = $row -> homeid;
                                            $hometeam  = $row -> hometeam;
                                            $homescore = $row -> homescore;
                                            $homerank  = $row -> homerank;
                                            $awayrank  = $row -> awayrank;
                                            $awayscore = $row -> awayscore;
                                            $awayteam  = $row -> awayteam;
                                            $awayid    = $row -> awayid;
                                            $grpdesc   = $row -> groupdesc;
                                            $rndcode   = $row -> roundcode;

                                            echo "  <tr id='match" . $fixno . "'>";
                                            echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                            echo "      <td class='hidden stage'>SF</td>"; 
                                            echo "      <td id='" . $homewinner . "flag' class='home-flag'></td>"; 
                                            echo "      <td id='". $homewinner . "' class='home'>". $hometeam . "</td>"; 
                                            echo "      <td class='hidden homeid'>" . $homeid . "</td>"; 
                                            echo "      <td class='h-rank'>" . $homerank . "</td>";
                                            echo "      <td><input class='homescore' data-stage='SF' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                            echo "      <td><input class='awayscore' data-stage='SF' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                            echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                            echo "      <td class='hidden awayid'>" . $awayid . "</td>";
                                            echo "      <td id='" . $awaywinner . "' class='away'>". $awayteam . "</td>";
                                            echo "      <td id='" . $awaywinner . "flag' class='away-flag'></td>"; 
                                            echo "  </tr>";                            

                                            // there are 2 semi finals
                                            $semifinalid = $semifinalid + 1;
                                            
                                        }   // end of while    
                                            
                                    }; // end of if else                     
                                    ?> 
                                </tbody>
                            </table>   
                        </div>  <!-- end of semi final div -->     
                    </section> <!-- End of SF -->                    
                
                </div> <!-- end of KNOCKOUT STAGES -->

                <div id="FINALS-STAGE" class="tabcontent">

                    <section id='PL'>
                        <div id='Playoff'>

                                <table>
                                    <thead class='blueheader'>
                                        <tr>
                                            <th colspan='9'>3rd Place Play-Off</th>
                                        </tr>
                                        <tr>
                                            <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th><th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>
                                        </tr>
                                    </thead>
                                <tbody>
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
                                . "         fx.GroupID = :GroupID AND pred.UserID = :UserID \n"
                                . "  ORDER BY \n"
                                . "  	  fx.FixtureNo \n";

                                    // prepare the query for the database connection
                                    $query = $dbh -> prepare($qry);

                                    /** bind the parameters */
                                    $query->bindParam(':GroupID', $groupid, PDO::PARAM_INT);
                                    $query->bindParam(':UserID',  $userid,  PDO::PARAM_INT);
                                    
                                    /** assign the values to the place holders - $userid already has a value from session variable */
                                    $groupid = 12;

                                    // execute the sql query
                                    $query -> execute();
                                                                    
                                    // get all rows
                                    $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() == 0) {
                                        echo "<div>NO RESULTS RETURNED</div>";
                                    } else {    
                                    
                                        $playoffid = 1;

                                        $homewinners = array("", "loser61"); 
                                        $awaywinners = array("", "loser62"); 

                                        foreach ($rows as $key => $row) {

                                            $homewinner = $homewinners[$playoffid];
                                            $awaywinner = $awaywinners[$playoffid];

                                            $userid    = $row -> userid;
                                            $fixno     = $row -> fixtureno;
                                            $homeid    = $row -> homeid;
                                            $hometeam  = $row -> hometeam;
                                            $homescore = $row -> homescore;
                                            $homerank  = $row -> homerank;
                                            $awayrank  = $row -> awayrank;
                                            $awayscore = $row -> awayscore;
                                            $awayteam  = $row -> awayteam;
                                            $awayid    = $row -> awayid;
                                            $grpdesc   = $row -> groupdesc;
                                            $rndcode   = $row -> roundcode;

                                            echo "  <tr id='match" . $fixno . "'>";
                                            echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                            echo "      <td class='hidden stage'>PL</td>"; 
                                            echo "      <td id='" . $homewinner . "flag' class='home-flag'></td>"; 
                                            echo "      <td id='". $homewinner . "' class='home'>". $hometeam . "</td>"; 
                                            echo "      <td class='hidden homeid'>" . $homeid . "</td>"; 
                                            echo "      <td class='h-rank'>" . $homerank . "</td>";
                                            echo "      <td><input class='homescore' data-stage='PL' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                            echo "      <td><input class='awayscore' data-stage='PL' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                            echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                            echo "      <td class='hidden awayid'>" . $awayid . "</td>";
                                            echo "      <td id='" . $awaywinner . "' class='away'>". $awayteam . "</td>";
                                            echo "      <td id='" . $awaywinner . "flag' class='away-flag'></td>"; 
                                            echo "  </tr>";                            

                                            $playoffid = $playoffid + 1;

                                        }   // end of while    
                                            
                                    }; // end of if else                     
                                    ?> 
                                </tbody>
                            </table>   
                        </div>  <!-- end of Playoff div -->     
                    </section> <!-- End of PL -->

                    <section id='FL'>
                        <div id='Final'>

                            <table>
                                <thead class='greenheader'>
                                    <tr>
                                        <th colspan='9'>FINAL</th>
                                    </tr>
                                    <tr>
                                        <th>No</th><th colspan='2'>HOME</th> <th class='hidden'></th> <th class='hidden'></th> <th>Rk</th> <th colspan='2'>SCORE</th><th>Rk</th> <th class='hidden'></th> <th colspan='2'>AWAY</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                        . "         fx.GroupID = :GroupID AND pred.UserID = :UserID \n"
                                        . "  ORDER BY \n"
                                        . "  	  fx.FixtureNo \n";

                                            // prepare the query for the database connection
                                            $query = $dbh -> prepare($qry);

                                            /** bind the parameters */
                                            $query->bindParam(':GroupID', $groupid, PDO::PARAM_INT);
                                            $query->bindParam(':UserID',  $userid,  PDO::PARAM_INT);
                                            
                                            /** assign the values to the place holders - $userid already has a value from session variable */
                                            $groupid = 13;

                                            // execute the sql query
                                            $query -> execute();
                                                                            
                                            // get all rows
                                            $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                            if ($query->rowCount() == 0) {
                                                echo "<div>NO RESULTS RETURNED</div>";
                                            } else {    
                                            
                                                $finalid = 1;

                                                $homewinners = array("", "winner61"); 
                                                $awaywinners = array("", "winner62"); 

                                                foreach ($rows as $key => $row) {

                                                    $homewinner = $homewinners[$finalid];
                                                    $awaywinner = $awaywinners[$finalid];

                                                    $userid    = $row -> userid;
                                                    $fixno     = $row -> fixtureno;
                                                    $homeid    = $row -> homeid;
                                                    $hometeam  = $row -> hometeam;
                                                    $homescore = $row -> homescore;
                                                    $homerank  = $row -> homerank;
                                                    $awayrank  = $row -> awayrank;
                                                    $awayscore = $row -> awayscore;
                                                    $awayteam  = $row -> awayteam;
                                                    $awayid    = $row -> awayid;
                                                    $grpdesc   = $row -> groupdesc;
                                                    $rndcode   = $row -> roundcode;

                                                    echo "  <tr id='match" . $fixno . "'>";
                                                    echo "      <td class='fixno'>" . $fixno . "</td>"; 
                                                    echo "      <td class='hidden stage'>FI</td>"; 
                                                    echo "      <td id='" . $homewinner . "flag' class='home-flag'></td>"; 
                                                    echo "      <td id='". $homewinner . "' class='home'>". $hometeam . "</td>"; 
                                                    echo "      <td class='hidden homeid'>" . $homeid . "</td>"; 
                                                    echo "      <td class='h-rank'>" . $homerank . "</td>";
                                                    echo "      <td><input class='homescore' data-stage='FL' type='number' min=0 placeholder=0 value='" . $homescore . "'></td>"; 
                                                    echo "      <td><input class='awayscore' data-stage='FL' type='number' min=0 placeholder=0 value='" . $awayscore . "'></td>";
                                                    echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                                    echo "      <td class='hidden awayid'>" . $awayid . "</td>";
                                                    echo "      <td id='" . $awaywinner . "' class='away'>". $awayteam . "</td>";
                                                    echo "      <td id='" . $awaywinner . "flag' class='away-flag'></td>"; 
                                                    echo "  </tr>";                            

                                                    $finalid = $finalid + 1;

                                                }   // end of while    
                                                    
                                            }; // end of if else                     
                                            ?> 
                                </tbody>
                            </table>   
                        </div>  <!-- end of final div -->     
                    </section> <!-- End of FL -->
                    
                </div> <!-- end of FINALS STAGES -->

                <div id="TOP-SCORER" class="tabcontent">

                    <?php
                        $qry =   "SELECT \n" 
                                . "  	ID,  \n"
                                . "     GroupID, \n"
                                . "     Team, \n"
                                . "     Ranking, \n"
                                . "     WikipediaLink \n"
                                . "  FROM  \n"
                                . "  	Teams \n"
                                . "  ORDER BY \n"
                                . "  	GroupID \n";

                        // prepare the query for the database connection
                        $query = $dbh -> prepare($qry);

                        /** bind the parameters 
                        $query->bindParam(':UserID', $userid, PDO::PARAM_INT);
                        */

                        /** assign the values to the place holders - 
                        $userid already has a value from session variable 
                        */

                        // execute the sql query
                        $query -> execute();
                                                        
                        // get all rows
                        $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                        if ($query->rowCount() == 0) {
                            echo "<div>NO RESULTS RETURNED</div>";
                        } else {

                            echo "<section id='team-flags'>";
                                                
                            foreach ($rows as $key => $row) {
                                
                                if ($row -> WikipediaLink > "") {
                                    echo "<a target='_blank' href='" . $row -> WikipediaLink . "'><img src='../img/flags/" . $row -> Team . ".png' alt='" . $row -> Team . " team flag'></a>";
                                };

                            }

                            echo "</section>";
                        }
                    ?>

                    <section id='top-goal-scorer'>

                        <div id='top-scorer-instructions'>
                            <p>Click on the flags above to see the squads, players and the top goal scorers for each squad.</p><br>
                            <p>Select the player you think will be the top scorer in the competition and the number of goals you think they will score.</p><br>
                            <p>In the event of a tie on points these selections will be used as a tie-breaker.</p><br>
                        </div>

                        <div id='top-scorer-selections'>

                            <?php
                                $qry =   "SELECT \n" 
                                        . "  	TopScorer,  \n"
                                        . "     GoalsScored \n"
                                        . "  FROM  \n"
                                        . "  	Users \n"
                                        . "  WHERE \n"
                                        . "  	ID = :UserID \n";

                                // prepare the query for the database connection
                                $query = $dbh -> prepare($qry);

                                /** bind the parameters */ 
                                $query->bindParam(':UserID', $userid, PDO::PARAM_INT);

                                /** assign the values to the place holders - 
                                $userid already has a value from session variable 
                                */

                                // execute the sql query
                                $query -> execute();
                                                                
                                // get all rows
                                $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                if ($query->rowCount() == 0) {
                                    echo "<div>NO RESULTS RETURNED</div>";
                                } else {

                                    echo "<table>";
                                    echo "    <thead class='greenheader'>";
                                    echo "        <tr class='playerheader'>";
                                    echo "            <th class='col-scorer'>Top Scorer</th> <th>Goals Scored</th>"; 
                                    echo "        </tr>";
                                    echo "    </thead>";
                                    echo "    <tbody>";
                                                        
                                    foreach ($rows as $key => $row) {
                                        
                                        // top scorer has been saved previously, so set flag to true
                                        echo "<script>TopScorerOK = true</script>";

                                        echo "      <tr>";
                                        echo "          <td id='scorer'>";
                                        echo "              <input id='scorer-input' type='text' placeholder='  Player who is top goal scorer' value='" . $row -> TopScorer . "'>";
                                        echo "          </td>"; 
                                        echo "          <td id='goals'>";
                                        echo "              <input id='goals-input' type='number' min=0 placeholder=0 value='" . $row -> GoalsScored . "'>";
                                        echo "          </td>";
                                        echo "      </tr>";
                                    }

                                    echo "  </tbody>";
                                    echo "</table>";        
                                }
                            ?>

                        </div> <!-- end of TOP SCORER SELECTIONS div -->

                    </section> <!-- end of TOP SCORER section -->

                </div>  <!-- end of TOP SCORER -->

                <div id="UPDATE-PREDICTIONS" class="tabcontent">

                    <section id='update-predictions'>

                        <div id='confirm-save'>
                            <input type='checkbox' id='confirm-chkbox' name='confirm-chkbox'>
                            <label for="confirm-chkbox">Check to confirm that you want to update your predictions</label>
                        </div>

                        <div id='chkbox-error'>
                            Click the Checkbox to confirm that you want to save your predictions
                        </div>

                        <div id='confirm-btn'>
                            <button type='button' id='update-btn' class='predictions-btn'>Update Predictions</button>
                        </div>

                        <div id='confirm-predictions'>
                            <p>No updates made</p>
                        </div>

                    </section> <!-- end of UPDATE PREDICTIONS section -->

                </div>  <!-- end of UPDATE PREDICTIONS -->
                
                <div id="RESULTS-PREDICTIONS" class="tabcontent">
                    
                    <section id="results-predictions">

                        <div id="results">

                            <div id='results-tbl'>
                                <table>
                                    <thead class='greenheader'>
                                        <tr>
                                            <th class='tbl-header' colspan='10'>FIXTURES / RESULTS</th>
                                        </tr>
                                        <tr>
                                            <th>No</th><th class='hidden'><th class='hidden'></th><th colspan='2'>HOME</th> <th>Rk</th><th colspan='2'>SCORE</th>
                                            <th>Rk</th><th class='hidden'></th><th colspan='2'>AWAY</th><th class='res-header'>Res</th>
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

                                    // prepare the query for the database connection
                                    $query = $dbh -> prepare($qry);

                                    /** bind the parameters 
                                    $query->bindParam(':UserID', $userid, PDO::PARAM_INT);
                                    */

                                    /** assign the values to the place holders - 
                                    $userid already has a value from session variable 
                                    */

                                    // execute the sql query
                                    $query -> execute();
                                                                    
                                    // get all rows
                                    $rows = $query -> fetchAll(PDO::FETCH_OBJ);

                                    if ($query->rowCount() == 0) {
                                        echo "<div>NO RESULTS RETURNED</div>";
                                    } else {

                                        // create the arrays to hold the arrays for each result
                                        // create an array for each result and push it to the results array
                                        $results = array();
                                        $res     = array();

                                        foreach ($rows as $key => $row) {

                                                $fixno      = $row -> fixtureno;
                                                $homeid     = $row -> homeid;
                                                $hometeam   = $row -> hometeam;
                                                $homerank   = $row -> homerank;
                                                $homescore  = $row -> homescore;
                                                $awayscore  = $row -> awayscore;
                                                $awayrank   = $row -> awayrank;
                                                $awayteam   = $row -> awayteam;
                                                $awayid     = $row -> awayid;
                                                $grpdesc    = $row -> groupdesc;
                                                $rndcode    = $row -> roundcode;
                                                $resultcode = $row -> resultcode;

                                                $res = array(
                                                            "fixtureno"     => $fixno,
                                                            "hometeamid"    => $homeid,
                                                            "homescore"     => $homescore,
                                                            "awayscore"     => $awayscore,
                                                            "awayteamid"    => $awayid,
                                                            "resultcode"    => $resultcode,
                                                            "stage"         => $rndcode
                                                            );

                                                array_push($results, $res);

                                                // colorize the stages to identify the LS, QF, SF, PL and FI
                                                if ($rndcode === "LS") {
                                                    echo "  <tr class='ls-color'>";
                                                } else if ($rndcode === "QF") {
                                                    echo "  <tr class='qf-color'>";
                                                } else if ($rndcode === "SF") {
                                                    echo "  <tr class='sf-color'>";
                                                } else if ($rndcode === "PL") {
                                                    echo "  <tr class='pl-color'>";
                                                } else if ($rndcode === "FI") {
                                                    echo "  <tr class='fi-color'>";
                                                } else {
                                                    echo "  <tr>";
                                                }

                                                echo "      <td class='predno'>" . $fixno . "</td>";
                                                echo "      <td class='stage hidden'>" . $rndcode . "</td>";                                // hidden cell for code of the tournament stage 
                                                echo "      <td class='homeid hidden'>" . $homeid . "</td>";                                // hidden cell for ID of home team
                                                echo "      <td class='results-home-flag'><img src='../img/teams/" . $hometeam . ".png' alt='" . $hometeam . " team flag'></td>";      
                                                echo "      <td class='home'>" . $hometeam . "</td>";
                                                echo "      <td class='h-rank'>" . $homerank . "</td>";
                                                echo "      <td class='pos'>" . $homescore . "</td>";
                                                echo "      <td class='pos'>" . $awayscore . "</td>";
                                                echo "      <td class='a-rank'>" . $awayrank . "</td>";
                                                echo "      <td class='awayid hidden'>" . $awayid . "</td>";        // hidden cell for ID of away team
                                                echo "      <td class='away'>" . $awayteam . "</td>";
                                                echo "      <td class='results-away-flag'><img src='../img/teams/" . $awayteam . ".png' alt='" . $awayteam . " team flag'></td>";      
                                                echo "      <td class='res'>" . $resultcode . "</td>";
                                                echo "  </tr>";
                                        
                                        }   // end of foreach loop
                                    }; // end of if else
                                    ?>  <!-- end of the results php -->

                                    </tbody>
                                </table>   
                            </div>  <!-- end of results-tbl div -->     
                        </div> <!-- end of results -->

                        <div id="predictions">

                            <!-- call the function to build predictions content -->
                            <script>buildPredictionsTable();</script>

                        </div> <!-- end of predictions section -->

                    </section> <!-- end of results-predictions section -->

                </div>  <!-- end of RESULTS / PREDICTIONS -->

            </section> <!-- end of Tournament -->

            <footer id="footer">        
                <?php include "../include/footer.inc.php"; ?>
            </footer>

        </main>
    
        <script type="text/javascript" >

            /* pass the php session variable, $userid, to a javascript variable 
                this can then be used in the FETCH POST */ 
            var userID = "<?=$userid?>";

            /* pass the php session variable, $fixture1resultid, to a javascript variable - this can then be used to stop updating predictions */ 
            var Fixture1ResultID = "<?=$fixture1resultid?>";

            // Change the display of the content tab from none to flex to display content
            // Hide the Groups EFGH, Knockout stage and the Update Predictions stage
            document.getElementById("GROUPS-EFGH").style.display = "none";
            document.getElementById("KNOCKOUT-STAGE").style.display = "none";
            document.getElementById("FINALS-STAGE").style.display = "none";
            document.getElementById("TOP-SCORER").style.display = "none";
            document.getElementById("UPDATE-PREDICTIONS").style.display = "none";
            document.getElementById("RESULTS-PREDICTIONS").style.display = "none";
          
            // **********************************************************************************************************
            // Timeout function to wait 3 seconds before clearing the update message
            // **********************************************************************************************************
            function clearConfirmationMessage() {
                document.getElementById("confirm-predictions").style.display = "none";
            }
            
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
                if (tabname == "GROUPS-ABCD") {
                    document.getElementById(tabname).style.display = "grid";
                }
                if (tabname == "GROUPS-EFGH") {
                    document.getElementById(tabname).style.display = "grid";
                }
                else if (tabname == "KNOCKOUT-STAGE") {
                    document.getElementById(tabname).style.display = "grid";
                } 
                else if (tabname == "FINALS-STAGE") {
                    document.getElementById(tabname).style.display = "grid";
                } 
                else if (tabname == "TOP-SCORER") {
                    document.getElementById(tabname).style.display = "grid";
                } 
                else if (tabname == "RESULTS-PREDICTIONS") {
                    document.getElementById(tabname).style.display = "block";
                } 
                else if (tabname == "UPDATE-PREDICTIONS") {

                    // if the AllowPredictionsUpdate flag is FALSE then one or more scores in the knockout stages are set as a draw
                    // dont allow an update unless the scores are set correctly as a win for one or other of the teams 

                    AllowPredictionsUpdate = LastSixteenOK && QuarterFinalsOK && SemiFinalsOK && PlayoffOK && FinalOK;

                   // console.log(AllowPredictionsUpdate + " " + LastSixteenOK + " " + QuarterFinalsOK + " " + SemiFinalsOK + " " + PlayoffOK + " " + FinalOK);

                    /* anything other than 6 (NPY) means the first game has started */
                    if (Fixture1ResultID != 6) {
                        TournamentStarted = true;
                    }  

                    if (TournamentStarted === true) {
                        document.getElementById(tabname).style.display = "block";
                        document.getElementById("confirm-predictions").innerHTML  = "The tournament has now begun.<br>";
                        document.getElementById("confirm-predictions").innerHTML += "In accordance with the rules no updates to your predictions can now be accepted.<br>";
                        document.getElementById("confirm-btn").style.display = "none";
                        document.getElementById("confirm-save").style.display = "none";
                    } else if (TopScorerOK === false) {
                        document.getElementById(tabname).style.display = "block";
                        document.getElementById("confirm-predictions").style.display = "block";
                        document.getElementById("confirm-predictions").innerHTML  = "You haven't selected a Top Goal Scorer and the number of goals scored.<br>";
                        document.getElementById("confirm-predictions").innerHTML += "Select the player you think will be the top scorer in the tournament<br>";
                        document.getElementById("confirm-predictions").innerHTML += "and enter the number of goals you think they will score.";
                        document.getElementById("confirm-btn").style.display = "none";
                        document.getElementById("confirm-save").style.display = "none";
                    } else if (AllowPredictionsUpdate === false) {
                        document.getElementById(tabname).style.display = "block";
                        document.getElementById("confirm-predictions").style.display = "block";
                        document.getElementById("confirm-predictions").innerHTML  = "Please review your predictions in the Knockout stages.<br>";
                        document.getElementById("confirm-predictions").innerHTML += "One or more of the games are predicted to be a draw.<br>";
                        document.getElementById("confirm-predictions").innerHTML += "Every game in the knockout stages must be set as either a home win or an away win.";
                        document.getElementById("confirm-btn").style.display = "none";
                        document.getElementById("confirm-save").style.display = "none";
                    } else {
                        document.getElementById(tabname).style.display = "block";
                        document.getElementById("confirm-predictions").innerText = "";
                        document.getElementById("confirm-predictions").style.display = "none";
                        document.getElementById("confirm-btn").style.display = "grid";
                        document.getElementById("confirm-save").style.display = "block";
                    }
                }                    

            };  // end of DisplayStage function definition

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                if (event.target.matches('#update-btn')) {

                    if (!document.getElementById("confirm-chkbox").checked) {
                        document.getElementById("chkbox-error").style.display = "block";
                    } else {
                        
                        document.getElementById("confirm-predictions").style.display = "block";
                        document.getElementById("confirm-predictions").innerHTML = "Updating Predictions...please wait";
                        
                        // get the pedictions for who will be top scorer and the number of goals scored
                        topgoalscorer = document.getElementById('scorer-input').value; 
                        nogoalsscored = document.getElementById('goals-input').value; 
                        
                        // get the the results from the group tables 
                        fixtureids  = document.querySelectorAll('.fixno');            
                        stages      = document.querySelectorAll('.stage');            
                        hometeamids = document.querySelectorAll('.homeid');            
                        homescores  = document.querySelectorAll('.homescore') ;
                        awayscores  = document.querySelectorAll('.awayscore');
                        awayteamids = document.querySelectorAll('.awayid');

                        // initialise the array to hold the predictions 
                        // UserID FixtureID HomeScore AwayScore HomeTeam AwayTeam ResultID Points Stage
                        let predictions = [];
                        // initialise the object to hold each prediction
                        let prediction = {};
                
                        /**
                         * push the top goal scorer to the first element in the array
                         * use dummy values to fill the other array values 
                        */

                        prediction = {  UserID     : userID, 
                                        FixtureID  : 99, 
                                        HomeScore  : topgoalscorer, 
                                        AwayScore  : 0, 
                                        HomeTeamID : nogoalsscored, 
                                        AwayTeamID : 0, 
                                        ResultID   : 0, 
                                        Points     : 0, 
                                        Stage      : ''                                        
                                    };

                        // add the top goal scorer prediction object to the Predictions Array                                                                
                        predictions.push(prediction);
                        
                        // add the array of objects that will be used to create the league table
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

                        // now process the predictions array and save result to predictions table
                        // console.log(JSON.stringify(predictions));

                        fetch('https://www.9habu.com/wc2022/inc/update-predictions.php', {
                                
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
                                    throw msg;
                                });

                            }).then(function (data) {

                                document.getElementById("confirm-predictions").innerHTML = data;
                                setTimeout(clearConfirmationMessage, 3000);
                                // document.getElementById("confirm-predictions").innerHTML = data;
                                
                                // call the function to re-build the predictions content
                                buildPredictionsTable();

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
                 *  The last16, quarter finals, semi final, playoff and final have aready been predicted
                 *  but update in case the groups have been updated and this may affect the last16, quarter finals, semi final, playoff and final
                 */
                // event listeners for the tab links
                if (event.target.matches('#knockout-stage-tab')) {

                    AllowPredictionsUpdate = true;
                    LastSixteenOK = true;
                    QuarterFinalsOK = true;
                    SemiFinalsOK = true;
                    PlayoffOK = true;
                    FinalOK = true;

                    document.getElementById("confirm-predictions").innerHTML = "<p></p>";

                    // GROUP STAGE WINNERS FROM GROUPS A,B,C,D
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

                    // GROUP STAGE WINNERS FROM GROUPS E,F,G,H
                    let winnergroupE   = document.getElementById("TableE-pos1").innerHTML;
                    let winnergroupEid = document.getElementById("TableE-pos1").nextElementSibling.innerHTML;
                    let winnergroupErk = document.getElementById("TableE-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    let runnerupgroupE   = document.getElementById("TableE-pos2").innerHTML;
                    let runnerupgroupEid = document.getElementById("TableE-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupErk = document.getElementById("TableE-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    let winnergroupF    = document.getElementById("TableF-pos1").innerHTML;
                    let winnergroupFid  = document.getElementById("TableF-pos1").nextElementSibling.innerHTML;
                    let winnergroupFrk  = document.getElementById("TableF-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    let runnerupgroupF   = document.getElementById("TableF-pos2").innerHTML;
                    let runnerupgroupFid = document.getElementById("TableF-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupFrk = document.getElementById("TableF-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    let winnergroupG    = document.getElementById("TableG-pos1").innerHTML;
                    let winnergroupGid  = document.getElementById("TableG-pos1").nextElementSibling.innerHTML;
                    let winnergroupGrk  = document.getElementById("TableG-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    let runnerupgroupG   = document.getElementById("TableG-pos2").innerHTML;
                    let runnerupgroupGid = document.getElementById("TableG-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupGrk = document.getElementById("TableG-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    let winnergroupH    = document.getElementById("TableH-pos1").innerHTML;
                    let winnergroupHid  = document.getElementById("TableH-pos1").nextElementSibling.innerHTML;
                    let winnergroupHrk  = document.getElementById("TableH-pos1").nextElementSibling.nextElementSibling.innerHTML;

                    let runnerupgroupH   = document.getElementById("TableH-pos2").innerHTML;
                    let runnerupgroupHid = document.getElementById("TableH-pos2").nextElementSibling.innerHTML;
                    let runnerupgroupHrk = document.getElementById("TableH-pos2").nextElementSibling.nextElementSibling.innerHTML;

                    // UPDATE LAST SIXTEEN MATCH 49
                    document.getElementById("winnerAflag").innerHTML = "<img src='../img/teams/" + winnergroupA.trim() + ".png' alt='" + winnergroupA.trim() + " team flag'>";
                    document.getElementById("winnerA").innerHTML = winnergroupA;
                    document.getElementById("winnerA").nextElementSibling.innerHTML = winnergroupAid;
                    document.getElementById("winnerA").nextElementSibling.nextElementSibling.innerHTML = winnergroupArk;

                    document.getElementById("runnerupBflag").innerHTML = "<img src='../img/teams/" + runnerupgroupB.trim() + ".png' alt='" + runnerupgroupB.trim() + " team flag'>";
                    document.getElementById("runnerupB").innerHTML = runnerupgroupB;
                    document.getElementById("runnerupB").previousElementSibling.innerHTML = runnerupgroupBid;
                    document.getElementById("runnerupB").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupBrk;

                    // UPDATE LAST SIXTEEN MATCH 50
                    document.getElementById("winnerBflag").innerHTML = "<img src='../img/teams/" + winnergroupB.trim() + ".png' alt='" + winnergroupB.trim() + " team flag'>";
                    document.getElementById("winnerB").innerHTML = winnergroupB;
                    document.getElementById("winnerB").nextElementSibling.innerHTML = winnergroupBid;
                    document.getElementById("winnerB").nextElementSibling.nextElementSibling.innerHTML = winnergroupBrk;

                    document.getElementById("runnerupAflag").innerHTML = "<img src='../img/teams/" + runnerupgroupA.trim() + ".png' alt='" + runnerupgroupA.trim() + " team flag'>";
                    document.getElementById("runnerupA").innerHTML = runnerupgroupA;
                    document.getElementById("runnerupA").previousElementSibling.innerHTML = runnerupgroupAid;
                    document.getElementById("runnerupA").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupArk;

                    // UPDATE LAST SIXTEEN MATCH 51
                    document.getElementById("winnerCflag").innerHTML = "<img src='../img/teams/" + winnergroupC.trim() + ".png' alt='" + winnergroupC.trim() + " team flag'>";
                    document.getElementById("winnerC").innerHTML = winnergroupC;
                    document.getElementById("winnerC").nextElementSibling.innerHTML = winnergroupCid;
                    document.getElementById("winnerC").nextElementSibling.nextElementSibling.innerHTML = winnergroupCrk;

                    document.getElementById("runnerupDflag").innerHTML = "<img src=../img/teams/" + runnerupgroupD.trim() + ".png alt='" + runnerupgroupD.trim() + " team flag'>";
                    document.getElementById("runnerupD").innerHTML = runnerupgroupD;
                    document.getElementById("runnerupD").previousElementSibling.innerHTML = runnerupgroupDid;
                    document.getElementById("runnerupD").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupDrk;

                    // UPDATE LAST SIXTEEN MATCH 52
                    document.getElementById("winnerDflag").innerHTML = "<img src='../img/teams/" + winnergroupD.trim() + ".png' alt='" + winnergroupD.trim() + " team flag'>";
                    document.getElementById("winnerD").innerHTML = winnergroupD;
                    document.getElementById("winnerD").nextElementSibling.innerHTML = winnergroupDid;
                    document.getElementById("winnerD").nextElementSibling.nextElementSibling.innerHTML = winnergroupDrk;

                    document.getElementById("runnerupCflag").innerHTML = "<img src='../img/teams/" + runnerupgroupC.trim() + ".png' alt='" + runnerupgroupC.trim() + " team flag'>";
                    document.getElementById("runnerupC").innerHTML = runnerupgroupC;
                    document.getElementById("runnerupC").previousElementSibling.innerHTML = runnerupgroupCid;
                    document.getElementById("runnerupC").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupCrk;
                
                    // UPDATE LAST SIXTEEN MATCH 53
                    document.getElementById("winnerEflag").innerHTML = "<img src='../img/teams/" + winnergroupE.trim() + ".png' alt='" + winnergroupE.trim() + " team flag'>";
                    document.getElementById("winnerE").innerHTML = winnergroupE;
                    document.getElementById("winnerE").nextElementSibling.innerHTML = winnergroupEid;
                    document.getElementById("winnerE").nextElementSibling.nextElementSibling.innerHTML = winnergroupErk;

                    document.getElementById("runnerupFflag").innerHTML = "<img src='../img/teams/" + runnerupgroupF.trim() + ".png' alt='" + runnerupgroupF.trim() + " team flag'>";
                    document.getElementById("runnerupF").innerHTML = runnerupgroupF;
                    document.getElementById("runnerupF").previousElementSibling.innerHTML = runnerupgroupFid;
                    document.getElementById("runnerupF").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupFrk;

                    // UPDATE LAST SIXTEEN MATCH 54
                    document.getElementById("winnerGflag").innerHTML = "<img src='../img/teams/" + winnergroupG.trim() + ".png' alt='" + winnergroupG.trim() + " team flag'>";
                    document.getElementById("winnerG").innerHTML = winnergroupG;
                    document.getElementById("winnerG").nextElementSibling.innerHTML = winnergroupGid;
                    document.getElementById("winnerG").nextElementSibling.nextElementSibling.innerHTML = winnergroupGrk;

                    document.getElementById("runnerupHflag").innerHTML = "<img src='../img/teams/" + runnerupgroupH.trim() + ".png' alt='" + runnerupgroupH.trim() + " team flag'>";
                    document.getElementById("runnerupH").innerHTML = runnerupgroupH;
                    document.getElementById("runnerupH").previousElementSibling.innerHTML = runnerupgroupHid;
                    document.getElementById("runnerupH").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupHrk;

                    // UPDATE LAST SIXTEEN MATCH 55
                    document.getElementById("winnerFflag").innerHTML = "<img src='../img/teams/" + winnergroupF.trim() + ".png' alt='" + winnergroupF.trim() + " team flag'>";
                    document.getElementById("winnerF").innerHTML = winnergroupF;
                    document.getElementById("winnerF").nextElementSibling.innerHTML = winnergroupFid;
                    document.getElementById("winnerF").nextElementSibling.nextElementSibling.innerHTML = winnergroupFrk;

                    document.getElementById("runnerupEflag").innerHTML = "<img src='../img/teams/" + runnerupgroupE.trim() + ".png' alt='" + runnerupgroupE.trim() + " team flag'>";
                    document.getElementById("runnerupE").innerHTML = runnerupgroupE;
                    document.getElementById("runnerupE").previousElementSibling.innerHTML = runnerupgroupEid;
                    document.getElementById("runnerupE").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupErk;

                    // UPDATE LAST SIXTEEN MATCH 56
                    document.getElementById("winnerHflag").innerHTML = "<img src='../img/teams/" + winnergroupH.trim() + ".png' alt='" + winnergroupH.trim() + " team flag'>";
                    document.getElementById("winnerH").innerHTML = winnergroupH;
                    document.getElementById("winnerH").nextElementSibling.innerHTML = winnergroupHid;
                    document.getElementById("winnerH").nextElementSibling.nextElementSibling.innerHTML = winnergroupHrk;

                    document.getElementById("runnerupGflag").innerHTML = "<img src='../img/teams/" + runnerupgroupG.trim() + ".png' alt='" + runnerupgroupG.trim() + " team flag'>";
                    document.getElementById("runnerupG").innerHTML = runnerupgroupG;
                    document.getElementById("runnerupG").previousElementSibling.innerHTML = runnerupgroupGid;
                    document.getElementById("runnerupG").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupGrk;

                    // UPDATE QUARTER FINAL MATCH 57
                    document.getElementById("winnerAflag").innerHTML = "<img src='../img/teams/" + winnergroupA.trim() + ".png' alt='" + winnergroupA.trim() + " team flag'>";
                    document.getElementById("winnerA").innerHTML = winnergroupA;
                    document.getElementById("winnerA").nextElementSibling.innerHTML = winnergroupAid;
                    document.getElementById("winnerA").nextElementSibling.nextElementSibling.innerHTML = winnergroupArk;

                    document.getElementById("runnerupBflag").innerHTML = "<img src='../img/teams/" + runnerupgroupB.trim() + ".png' alt='" + runnerupgroupB.trim() + " team flag'>";
                    document.getElementById("runnerupB").innerHTML = runnerupgroupB;
                    document.getElementById("runnerupB").previousElementSibling.innerHTML = runnerupgroupBid;
                    document.getElementById("runnerupB").previousElementSibling.previousElementSibling.innerHTML = runnerupgroupBrk;

                    // define the match variables
                    let match;

                    let matchHome;
                    let matchHSc;
                    let matchHRk;
                    let matchHID;
                    
                    let matchAID;
                    let matchARk;
                    let matchASc;
                    let matchAway;

                    // WINNERS / RUNNERS UP - LAST16 MATCH 49
                    match = document.getElementById("match49");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner49flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner49").innerHTML = matchHome;
                        document.getElementById("winner49").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("winner49").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner49flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner49").innerHTML = matchAway;
                        document.getElementById("winner49").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("winner49").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };

                    // WINNERS / RUNNERS UP - LAST16 MATCH 50
                    match = document.getElementById("match50");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner50flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner50").innerHTML = matchHome;
                        document.getElementById("winner50").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("winner50").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner50flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner50").innerHTML = matchAway;
                        document.getElementById("winner50").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("winner50").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };

                    // WINNERS / RUNNERS UP - LAST16 MATCH 51
                    match = document.getElementById("match51");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner51flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner51").innerHTML = matchHome;
                        document.getElementById("winner51").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("winner51").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner51flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner51").innerHTML = matchAway;
                        document.getElementById("winner51").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("winner51").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };

                    // WINNERS / RUNNERS UP - LAST16 MATCH 52
                    match = document.getElementById("match52");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner52flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner52").innerHTML = matchHome;
                        document.getElementById("winner52").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("winner52").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner52flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner52").innerHTML = matchAway;
                        document.getElementById("winner52").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("winner52").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };                
                    
                    // WINNERS / RUNNERS UP - LAST16 MATCH 53
                    match = document.getElementById("match53");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner53flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner53").innerHTML = matchHome;
                        document.getElementById("winner53").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("winner53").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner53flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner53").innerHTML = matchAway;
                        document.getElementById("winner53").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("winner53").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };

                    // WINNERS / RUNNERS UP - LAST16 MATCH 54
                    match = document.getElementById("match54");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner54flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner54").innerHTML = matchHome;
                        document.getElementById("winner54").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("winner54").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner54flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner54").innerHTML = matchAway;
                        document.getElementById("winner54").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("winner54").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };                
                    
                    // WINNERS / RUNNERS UP - LAST16 MATCH 55
                    match = document.getElementById("match55");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner55flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner55").innerHTML = matchHome;
                        document.getElementById("winner55").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("winner55").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner55flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner55").innerHTML = matchAway;
                        document.getElementById("winner55").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("winner55").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };

                    // WINNERS / RUNNERS UP - LAST16 MATCH 56
                    match = document.getElementById("match56");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner56flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner56").innerHTML = matchHome;
                        document.getElementById("winner56").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("winner56").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner56flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner56").innerHTML = matchAway;
                        document.getElementById("winner56").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("winner56").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else {
                        LastSixteenOK = false;
                    };  

                    // WINNERS / RUNNERS UP - QUARETR FINAL MATCH 57
                    match = document.getElementById("match57");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner57flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner57").innerHTML = matchHome;
                        document.getElementById("winner57").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("winner57").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner57flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner57").innerHTML = matchAway;
                        document.getElementById("winner57").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("winner57").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else {
                        QuarterFinalsOK = false;
                    };

                    // WINNERS / RUNNERS UP - QUARTER FINAL MATCH 58
                    match = document.getElementById("match58");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner58flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner58").innerHTML = matchHome;
                        document.getElementById("winner58").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("winner58").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner58flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner58").innerHTML = matchAway;
                        document.getElementById("winner58").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("winner58").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else {
                        QuarterFinalsOK = false;
                    };

                    // WINNERS / RUNNERS UP - QUARTER FINAL MATCH 59
                    match = document.getElementById("match59");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner59flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner59").innerHTML = matchHome;
                        document.getElementById("winner59").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("winner59").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner59flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner59").innerHTML = matchAway;
                        document.getElementById("winner59").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("winner59").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else {
                        QuarterFinalsOK = false;
                    };

                    // WINNERS / RUNNERS UP - QUARTER FINAL MATCH 60
                    match = document.getElementById("match60");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner60flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner60").innerHTML = matchHome;
                        document.getElementById("winner60").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("winner60").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner60flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner60").innerHTML = matchAway;
                        document.getElementById("winner60").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("winner60").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else {
                        QuarterFinalsOK = false;
                    };

                }  // end of knockout-stage-tab click event

                // event listeners for the tab links
                if (event.target.matches('#finals-stage-tab')) {

                    // WINNERS / RUNNERS UP - SEMI FINAL MATCH 61
                    match = document.getElementById("match61");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("loser61flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("loser61").innerHTML = matchAway;
                        document.getElementById("loser61").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("loser61").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("loser61flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("loser61").innerHTML = matchHome;
                        document.getElementById("loser61").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("loser61").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else {
                        SemiFinalsOK = false;
                    };

                    // WINNERS / RUNNERS UP - SEMI FINAL MATCH 62
                    match = document.getElementById("match62");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("loser62flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("loser62").innerHTML = matchAway;
                        document.getElementById("loser62").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("loser62").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("loser62flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("loser62").innerHTML = matchHome;
                        document.getElementById("loser62").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("loser62").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else {
                        SemiFinalsOK = false;
                    };

                    // WINNERS / RUNNERS UP - SEMI FINAL MATCH 61
                    match = document.getElementById("match61");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner61flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner61").innerHTML = matchHome;
                        document.getElementById("winner61").nextElementSibling.innerHTML = matchHID;
                        document.getElementById("winner61").nextElementSibling.nextElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner61flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner61").innerHTML = matchAway;
                        document.getElementById("winner61").nextElementSibling.innerHTML = matchAID;
                        document.getElementById("winner61").nextElementSibling.nextElementSibling.innerHTML = matchARk;
                    } else {
                        PlayoffOK = false;
                    };

                    // WINNERS / RUNNERS UP - SEMI FINAL MATCH 62
                    match = document.getElementById("match62");

                    matchHome = match.querySelector('.home').innerHTML;
                    matchHSc  = match.querySelector('.homescore').value;
                    matchHRk  = match.querySelector('.h-rank').innerHTML;
                    matchHID  = match.querySelector('.homeid').innerHTML;
                    
                    matchAID  = match.querySelector('.awayid').innerHTML;
                    matchARk  = match.querySelector('.a-rank').innerHTML;
                    matchASc  = match.querySelector('.awayscore').value;
                    matchAway = match.querySelector('.away').innerHTML;

                    if ( matchHSc > matchASc) {
                        document.getElementById("winner62flag").innerHTML = "<img src='../img/teams/" + matchHome.trim() + ".png' alt='" + matchHome.trim() + " team flag'>";
                        document.getElementById("winner62").innerHTML = matchHome;
                        document.getElementById("winner62").previousElementSibling.innerHTML = matchHID;
                        document.getElementById("winner62").previousElementSibling.previousElementSibling.innerHTML = matchHRk;
                    } else if ( matchHSc < matchASc) {
                        document.getElementById("winner62flag").innerHTML = "<img src='../img/teams/" + matchAway.trim() + ".png' alt='" + matchAway.trim() + " team flag'>";
                        document.getElementById("winner62").innerHTML = matchAway;
                        document.getElementById("winner62").previousElementSibling.innerHTML = matchAID;
                        document.getElementById("winner62").previousElementSibling.previousElementSibling.innerHTML = matchARk;
                    } else {
                        FinalOK = false;
                    };

                }  // end of finals-stage-tab click event

            }, false);   // end of CLICK event listener


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

        </script>

    </body>

</html>