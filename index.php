<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta http-equiv="cache-control" content="no-cache">        <!-- tells browser not to cache -->
        <meta http-equiv="expires"       content="0">               <!-- says that the cache expires 'now' -->
        <meta http-equiv="pragma"        content="no-cache">        <!-- says not to use cached stuff, if there is any -->

        <title>World Cup 2022 Predictor</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="css/styles.css">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"> </script>                

    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                
                <div id="logo">
                    <img src='img/logo.png' alt='World Cup Fortune Teller logo'>
                </div>

                <div id="header-text">
                    <h1>World Cup 2022 Predictions</h1> 
                </div>
          
                <div id="profile" class="dropdown">

                    <div class="bar1"></div>
                    <div class="bar2"></div>
                    <div class="bar3">
                        <div class="dropdown-content">
                            <a href="php/login.php">Login</a>
                            <a href="php/sign-up.php">Register</a>
                        </div>
                    </div>

                </div>

            </header>

            <div class="card" id="latest-results">
                <h2 class="card-title">Latest Results</h2>
                <?php include 'php/latest-results.html';?>
            </div>
            
            <div class="card" id="top-ten-users">
                <h2 class="card-title">Top Ten Users</h2>
                <?php include 'php/top-ten-users.html';?>
            </div>

            <div class="card" id="golden-boot">
                <h2 class="card-title">Golden Boot</h2>
                <?php include 'php/top-goal-scorers.html';?>
            </div>

            <div class="card" id="upcoming-fixtures">
                <h2 class="card-title">Upcoming Fixtures</h2>
                <?php include 'php/upcoming-fixtures.html';?>
            </div>

            <div class="card" id="competition-stats">
                <h2 class="card-title">Competiton Statistics</h2>
                <div id="goal-stats">
                    <?php include 'php/competition-stats.html';?>
                </div>

            </div>
            
            <div class="card" id="competition-rules">
                <h2 class="card-title">Competition Rules</h2>

                <div id="rules">
                    Predictions must be completed before the start of the first match on November 20th 2022.
                    <button id='display-all-rules-btn' name='display-all-rules-btn' class='transparent-btn-blue'>Full Competition Rules</button>
                </div> 

            </div>

            <footer id="social-media">
                <p>&copy; <script>document.write(new Date().getFullYear());</script> World Cup 2022 Predictor</p>
                <p>All Rights Reserved &mdash; Designed by Mark Boomer</p>
            </footer>
            
        </main>

        <script type="text/javascript">

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                // event listeners for the competition rules button
                if (event.target.matches('#display-all-rules-btn')) {

                    window.location.href="competition-rules.html";

                }

            }, false);   // end of CLICK event listener
                

        </script>

    </body>

</html>