<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // checks if session exists
    session_start();

    // If logged in store the userid from session 
    if ( isset($_SESSION['userid']) ) {
        $userid      = $_SESSION["userid"];    
        $predictions = $_SESSION["predictions"];    
    }; 

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta http-equiv="cache-control" content="no-cache">        <!-- tells browser not to cache -->
        <meta http-equiv="expires"       content="0">               <!-- says that the cache expires 'now' -->
        <meta http-equiv="pragma"        content="no-cache">        <!-- says not to use cached stuff, if there is any -->

        <title>User Profile</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles-user-profile.css">
                
    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <div id="logo">
                    <img src='../img/logo.png' alt='World Cup Fortune Teller logo'>
                </div>

                <div id="header-text">
                    <h1>User Profile</h1> 
                </div>
<!--                
                <div id="logout">
                    <a class="transparent-btn-blue" href="https://9habu.com/wc2022/php/logout.php">Logout</a>
                </div>
-->
                <div id="profile" class="dropdown">

                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3">
                        <div class="dropdown-content">
                            <a id="predictions-lnk" href="#">Predictions</a>
                            <a id="logout-lnk" href="logout.php">Logout</a>
                        </div>
                    </div>

                </div>
                
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
                    // $id = 2;

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
                                echo "              <tr>";
                                echo "              </tr>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>Login Name</td>";
                                echo "                  <td><input id='upd-user-name' type='text' value='" . $username  . "' placeholder='User Login Name'></td>";
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
                                echo "              <tr>";
                                echo "                  <th></th><th></th>";
                                echo "              </tr>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>First Name</td>";
                                echo "                  <td><input id='upd-first-name' type='text' value='" . $firstname  . "' placeholder='Enter First Name'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Last Name</td>";
                                echo "                  <td><input id='upd-last-name' type='text' value='" . $lastname . "' placeholder='Enter Last Name'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Email Address</td>";
                                echo "                  <td><input id='upd-email' type='text' value='" . $useremail . "' placeholder='Enter Email Address'></td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Contact Phone</td>";
                                echo "                  <td><input id='upd-phone' type='text' value='" . $phone . "' placeholder='Enter Contact Telephone Number'></td>";
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
                                echo "              <tr>";
                                echo "                  <th></th><th></th>";
                                echo "              </tr>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>Points Scored</td>";
                                echo "                  <td>" . $points  . " pts</td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Predicted Top Goal Scorer</td>";
                                echo "                  <td>" . $topscorer . "</td>";
                                echo "              </tr>";
                                echo "              <tr>";
                                echo "                  <td>Predicted Goals Scored</td>";
                                echo "                  <td>" . $goalsscored . "</td>";
                                echo "              </tr>";
                                echo "          </tbody>";
                                echo "      </table>";   

                            echo "</div>";

                            echo "<div class='card' id='team-details'>";
                                echo "   <h2 class='card-title'>Team Details</h2>";

                                echo "      <table id='team-details-tbl>";
                                echo "          <thead class='greenheader'>";
                                echo "              <tr>";
                                echo "                  <th></th><th></th>";
                                echo "              </tr>";
                                echo "          </thead>";
                                echo "          <tbody>";
                                echo "              <tr>";
                                echo "                  <td>Team Name</td>";
                                echo "                  <td><input id='upd-team-name' type='text' value='" . $teamname  . "' placeholder='Enter A Team Name'></td>";
                                echo "              </tr>";
                                echo "          </tbody>";
                                echo "      </table>";   

                            echo "</div>";
                            
                            echo "<div class='card' id='update-profile'>";
                                echo "   <h2 class='card-title'>Profile Created : " . date_format(date_create($createddate), 'd/m/Y') . "</h2>";

                                echo "   <div id='update-messages'>";
                                echo "   </div>";

                                echo "   <div>";
                                echo "      <button id='update-profile-btn' class='transparent-btn-blue'>Save Changes</button>";
                                echo "   </div>";

                            echo "</div>";
    
                       }; // end of results foreach 

                    };  // end of $query->rowCount() else

                ?>

            <footer id="social-media">
                <p>&copy; <script>document.write(new Date().getFullYear());</script> World Cup 2022 Predictor</p>
                <p>All Rights Reserved &mdash; Designed by Mark Boomer</p>
            </footer>
            
        </main>

        <script>

            document.getElementById("update-messages").style.display = "None";

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                if (event.target.matches('#predictions-lnk')) {

                    // pass php session variable to JS variable
                    PredictionsLink = "<?=$predictions?>";                                             

                    if (PredictionsLink == 1) {
                        window.location.href = "saved-predictions.php";
                    } else {
                        window.location.href = "predictions.php";
                    }

                };


                if (event.target.matches('#update-profile-btn')) {

                    document.getElementById("update-messages").style.display = "Flex";
                    document.getElementById("update-messages").innerText = "Saving Profile...please wait";
                        
                    UpdUserName  = document.getElementById('upd-user-name').value; 

                    // The hashed password is retrieved from the user record, and is passed here into a JS variable
                    UpdUserID    = "<?=$userid?>";                                             
                    UpdHashedPwd = "<?=$userpass?>";                                             

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

                    fetch('https://www.9habu.com/wc2022/php/update-user-profile.php', {
                            
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

            }, false);   // end of CLICK event listener

        </script>
    
    </body>

</html>