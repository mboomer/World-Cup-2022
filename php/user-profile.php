<?php

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

    // Include config file
    require_once "../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <title>world Cup 2022 Predictor - User Profile</title>
        
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Update your contact details, change your password or select a team name in order to play against your friends or colleagues">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles-user-profile.css">
                
    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <?php 
                    $headeritems = "username";
                    $menuitems = array("Predictions", "Team", "Logout");
                    include '../include/header1.inc.php';
                ?>
            </header>

            <?php

                    // Try and establish the database connection.
                    try {
                        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                    }
                    catch (PDOException $e) {
                        exit("Error: " . $e->getMessage());
                    };

                    $qry = "SELECT * FROM Users WHERE Users.ID = :ID";

                    // $qry = "SELECT \n" 
                    //  . "  	UserName	as username, \n"
                    //  . "  	UserEmail	as useremail, \n"
                    //  . "  	UserPass	as userpass, \n"
                    //  . "  	UserTeam	as userteam, \n"
                    //  . "  	CreatedDate as createddate, \n"
                    //  . "  	Predictions as predictions,  \n"
                    //  . "  	TopScorer	as topscorer, \n"
                    //  . "  	GoalsScored	as goalsscored, \n"
                    //  . "  	Points 		as points, \n"
                    //  . "  	FirstName 	as firstname, \n"
                    //  . "  	LastName 	as lastname, \n"
                    //  . "  	Phone 	    as phone \n"
                    //  . "FROM  \n"
                    //  . "  	Users \n"
                    //  . "WHERE \n"
                    //  . "  	Users.ID = :ID \n";

                    // prepare the query for the database connection
                    $query = $dbh -> prepare($qry);

                    /** bind the parameters */
                    $query->bindParam(':ID', $id, PDO::PARAM_INT);

                    /** assign the values to the place holders */ 
                    $id = $userid;

                    // execute the sql query
                    $query -> execute();
                                        
                    // get all rows, should only be one row returned
                    $results = $query -> fetchAll(PDO::FETCH_OBJ);

                    if ($query->rowCount() === 0) {
                        echo "<div>NO USER RETURNED</div>";
                        exit;
                    } else {

                        // loop through the results
                        foreach($results as $key => $result) {

                            $userid      = $result -> ID;
                            $username    = $result -> UserName;
                            $useremail   = $result -> UserEmail;
                            $userpass    = $result -> UserPass;
                            $userteam    = $result -> UserTeam;
                            $createddate = $result -> CreatedDate;
                            $predictions = $result -> Predictions;
                            $topscorer   = $result -> TopScorer;
                            $goalsscored = $result -> GoalsScored;
                            $points      = $result -> Points;
                            $firstname   = $result -> FirstName;
                            $lastname    = $result -> LastName;
                            $phone       = $result -> Phone;

                            echo "<div class='card' id='login-details'>";
                                echo "   <h2 class='card-title'>Login Details</h2>";

                                echo "      <table id='login-details-tbl>";
                                echo "          <thead class='greenheader'>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>Login Name</td>";
                                echo "                  <td><input id='upd-user-name' type='text' value='" . htmlspecialchars($username)  . "' placeholder='User Login Name'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <th class='profile-info' colspan='2'>";
                                echo "                      Leave the password fields blank to leave the password unchanged<br>";
                                echo "                      You will need to supply your existing password before entering a new one.";
                                echo "                  </th>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Existing Password</td>";
                                echo "                  <td><input id='upd-existing-pwd' type='password' placeholder='Existing Password'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>New Password</td>";
                                echo "                  <td><input id='upd-new-pwd' type='password' placeholder='New Password'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Repeat Password</td>";
                                echo "                  <td><input id='upd-repeat-pwd' type='password' placeholder='Re-Enter New Password'></td>";
                                echo "              </tr>";
                                echo "          </tbody>";
                                echo "      </table>";   

                            echo "</div>";
                            
                            echo "<div class='card' id='personal-detais'>";
                                echo "   <h2 class='card-title'>Personal Detais</h2>";

                                echo "      <table id='personal-details-tbl>";
                                echo "          <thead class='greenheader'>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>First Name</td>";
                                echo "                  <td><input id='upd-first-name' type='text' value='" . htmlspecialchars($firstname)  . "' placeholder='Enter First Name'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Last Name</td>";
                                echo "                  <td><input id='upd-last-name' type='text' value='" . htmlspecialchars($lastname) . "' placeholder='Enter Last Name'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Email Address</td>";
                                echo "                  <td><input id='upd-email' type='text' value='" . htmlspecialchars($useremail) . "' placeholder='Enter Email Address'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Contact Phone</td>";
                                echo "                  <td><input id='upd-phone' type='text' value='" . htmlspecialchars($phone) . "' placeholder='Enter Contact Telephone Number'></td>";
                                echo "              </tr>";
                                echo "          </tbody>";
                                echo "      </table>";   

                            echo "</div>";

                            echo "<div class='card' id='payment-details'>";
                                echo "   <h2 class='card-title'>Payment Details</h2>";
                            echo "</div>";

                            echo "<div class='card' id='competition-details'>";
                            echo "   <h2 class='card-title'>Competition</h2>";

                                echo "      <table id='competition-details-tbl>";
                                echo "          <thead class='greenheader'>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>Points Scored</td>";
                                echo "                  <td>" . htmlspecialchars($points)  . " pts</td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Predicted Top Goal Scorer</td>";
                                echo "                  <td>" . htmlspecialchars($topscorer) . "</td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Predicted Goals Scored</td>";
                                echo "                  <td>" . htmlspecialchars($goalsscored) . "</td>";
                                echo "              </tr>";
                                echo "          </tbody>";
                                echo "      </table>";   

                            echo "</div>";

                            echo "<div class='card' id='team-details'>";

                                echo "   <h2 class='card-title'>Team Details</h2>";

                                echo "      <table id='team-details-tbl'>";
                                echo "          <thead class='greenheader'>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>Team Name</td>";
                                echo "                  <td><input id='upd-team-name' type='text' value='" . htmlspecialchars($userteam)  . "' placeholder='Enter A Team Name'></td>";
                                echo "              </tr>";
                                echo "          </tbody>";
                                echo "      </table>";   
                                echo "      <div id='similar-names-tbl'>";
                                echo "      </div>";   

                            echo "</div>";
                            
                            echo "<div class='card' id='update-profile'>";
                                echo "   <h2 class='card-title'>Profile Created : " . date_format(date_create(htmlspecialchars($createddate)), 'd/m/Y') . "</h2>";

                                echo "   <div id='update-messages'>";
                                echo "   </div>";

                                echo "   <div>";
                                echo "      <button id='update-profile-btn' class='transparent-btn-blue'>Save Changes</button>";
                                echo "   </div>";

                            echo "</div>";
    
                       }; // end of results foreach 

                    };  // end of $query->rowCount() else

                ?>

            <footer id="footer">        
                <?php include "../include/footer.inc.php"; ?>
            </footer>
            
        </main>

        <script>

            /* hide any message that is displayed */
            document.getElementById("update-messages").style.display = "None";
            document.getElementById("similar-names-tbl").style.display = "None";

            /* pass the php Last activity session variable, to a javascript variable - this can then be used to check if the user has been inactive */ 
            var LastActivity = "<?=$_SESSION['last_activity']?>"; 

            /* pass the php predictions session variable to a javascript variable - this can then be used to direct the link to the correct predictions page */ 
            var Predictions = "<?=$predictions?>";

            console.log("Predictions - " + Predictions);

            // **********************************************************************************************************
            // Session inactivity - if no activity for 30 minutes then timeout the session and return to home page 
            // **********************************************************************************************************
            function CheckSession(pLastActive) {

                /* get the current time time stamp in seconds */
                let TimeNow = new Date().getTime() / 1000;

                // console.log("Last Activity : " + pLastActive + " Current Time " +  TimeNow);

                // has the user been inactive for more than 30 minutes (1800 secs) since last activity was recorded
                if ( TimeNow - pLastActive > 1800 ) { 
                    alert("Session Timed Out - Please log in again")
                    window.location.href = "../inc/logout.php"; 
                } else { 
                    // alert("Session Active")
                    // console.log("Last Activity Time : " + (new Date().getTime() / 1000) );
                    return TimeNow;                
                }
            }

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                // check that the session is still active
                // if it is active update LastActivity time 
                LastActivity = CheckSession(LastActivity);

                // select one of the possible displayed Team Names
                if (event.target.matches('[data-tm]')) {
                    document.getElementById("upd-team-name").value = event.target.dataset.tm;
                }

                if (event.target.matches('#update-profile-btn')) {

                    document.getElementById("update-messages").style.display = "Flex";
                    document.getElementById("update-messages").innerText = "Saving Profile...please wait";
                        
                    // The hashed password is retrieved from the user record, and is passed here into a JS variable
                    UpdUserID    = "<?=$userid?>";                                             
                    UpdHashedPwd = "<?=$userpass?>";                                             

                    UpdUserName  = document.getElementById('upd-user-name').value; 
                    UpdExistPwd  = document.getElementById('upd-existing-pwd').value; 
                    UpdNewPwd    = document.getElementById('upd-new-pwd').value; 
                    UpdRepeatPwd = document.getElementById('upd-repeat-pwd').value; 
                    UpdFirstName = document.getElementById('upd-first-name').value; 
                    UpdLastName  = document.getElementById('upd-last-name').value; 
                    UpdEmailAdd  = document.getElementById('upd-email').value; 
                    UpdPhoneNo   = document.getElementById('upd-phone').value; 
                    UpdTeamName  = document.getElementById('upd-team-name').value; 

                    // initialise the array to hold the user profile JSON object 
                    let profiles = [];
                    // initialise the JSON object to hold each profile
                    let profile = {};
            
                    profile = { 
                                UserID    : UpdUserID,
                                UserName  : UpdUserName, 
                                UserPass  : UpdExistPwd, 
                                HashedPwd : UpdHashedPwd,               
                                NewPwd    : UpdNewPwd, 
                                RepeatPwd : UpdRepeatPwd, 
                                FirstName : UpdFirstName, 
                                LastName  : UpdLastName, 
                                UserEmail : UpdEmailAdd, 
                                Phone     : UpdPhoneNo, 
                                UserTeam  : UpdTeamName 
                                };

                    // add the profile object to the Profiles Array                                                                
                    profiles.push(profile);

                    console.log(profiles);

                    fetch('https://www.worldcup2022predictor.com/inc/update-user-profile.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                                },
                            body: JSON.stringify(profiles),

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

                            document.getElementById("update-messages").innerHTML = data;

                        }).catch(function (error) {
                            document.getElementById("update-messages").innerHTML = error;
                            console.warn("Error : ", error);
                        });

                    return;

                }; // end of click event for update-profile-btn 

                // If a Team name is entered display the users for the team and the users in the team
                // if no team is entered display a message that no team name has been entered 
                if (event.target.matches('#team-href')) {
                    
                    if (document.getElementById("upd-team-name").value === "") {
                        document.getElementById("update-messages").style.display = "flex";
                        document.getElementById("update-messages").innerHTML = "You are not part of team yet.<br>Enter a new team name or select an existing Team name.";
                    } else {
                            window.location.href = 'https://www.9habu.com/wc2022/php/team-members.php?tm=' + document.getElementById("upd-team-name").value;
                    } // end of else team-href

                } // end of click event for team-href 

            }, false);   // end of CLICK event listener

            // ==================================================================
            // add KEYUP event listener for the Team Name Field 
            // ==================================================================
            document.addEventListener('keyup', function (event) {

                if (event.target.matches('#upd-team-name')) {

                    fetch('https://www.worldcup2022predictor.com/inc/similar-team-names.php', {
                            
                            method: 'POST',
                            mode: "same-origin",
                            credentials: "same-origin",
                            headers: {
                                'Content-Type': 'text/html',
                                'Accept': 'text/html'
                                },
                            body: (document.getElementById("upd-team-name").value),

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
                            document.getElementById("similar-names-tbl").style.display = "flex";
                            document.getElementById("similar-names-tbl").innerHTML = data;

                        }).catch(function (error) {
                            // There was an error
                            console.warn("Error : ", error);
                        });

                };

            }, false);   // end of KEYUP event listener

        </script>
    
        <script type="text/javascript" src="../js/header1.js"></script>

    </body>

</html>