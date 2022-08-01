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
<!--                
                <div id="login-register">
                    <a class="transparent-btn-blue" href="https://9habu.com/wc2022/php/login.php">Login</a>
                    <a class="transparent-btn-blue" href="https://9habu.com/wc2022/php/sign-up.php">Register</a>
                </div>
-->            
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

            <div class="card" id="venues">
                <h2 class="card-title">Statistics</h2>
            </div>
            
            <div class="card" id="about">
                <h2 class="card-title">Competition Rules</h2>
            </div>

            <footer id="social-media">
                <p>&copy; <script>document.write(new Date().getFullYear());</script> World Cup 2022 Predictor</p>
                <p>All Rights Reserved &mdash; Designed by Mark Boomer</p>
            </footer>
            
        </main>
    
    </body>

</html>