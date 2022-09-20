<!DOCTYPE html>
<html lang="en">
    <head>
        
        <title>Qatar World Cup 2022 Predictor</title>

        <meta charset="utf-8">
        <meta http-equiv="cache-control" content="no-cache, must-revalidate" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="A fun game, earn points by predicting the correct score and result of each game in the 2022 World Cup in Qatar from the group stages through to the Final. You can play individually or as part of a team">

        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="css/styles.css">

    </head>
    
    <body>
        
        <main id="container">
            
            <header>
                <?php
                    $menuitems = array("Login", "Register");
                    include 'include/header.inc.php';
                ?>
            </header>

            <div class="card" id="latest-results">
                <h2 class="card-title">Latest Results</h2>
                <?php include 'static/latest-results.html';?>
            </div>
            
            <div class="card" id="top-ten-users">
                <h2 class="card-title">Top Ten Users</h2>
                <?php include 'static/top-ten-users.html';?>
            </div>

            <div class="card" id="golden-boot">
                <h2 class="card-title">Golden Boot</h2>
                <?php include 'static/top-goal-scorers.html';?>
            </div>

            <div class="card" id="upcoming-fixtures">
                <h2 class="card-title">Upcoming Fixtures</h2>
                <?php include 'static/upcoming-fixtures.html';?>
            </div>

            <div class="card" id="competition-stats">
                <h2 class="card-title">Competiton Statistics</h2>
                <div id="goal-stats">
                    <?php include 'static/competition-stats.html';?>
                </div>

            </div>
            
            <div class="card" id="competition-rules">
                <h2 class="card-title">Competition Rules & Advice</h2>

                <div id="rules">
                    Predictions must be completed before the start of the first match on November 20th 2022.
                    <button id='display-all-rules-btn' name='display-all-rules-btn' class='transparent-btn-blue'>Full Competition Rules</button>
                    <button id='display-advice-btn' name='display-advice-btn' class='transparent-btn-blue'>How to complete predictions</button>
                </div> 

            </div>

            <footer id="footer">
                    <?php include 'include/footer.inc.php';?>
            </footer>
            
        <!-- ********************************************************************************** -->
        <!-- Cookie banner not displayed - it is displayed by JS if required on page load       -->
        <!-- ********************************************************************************** -->
        <div class="cookie-banner" style="display: none">
            <p>
                This website does not use cookies to track how you interact with the website. The website does not share information with third parties or advertisers. 
                <br>Some cookies may be necessary for the site to work as designed. Please click "Accept Cookies" to continue.
            </p>
            <button id="accept-cookies-btn">Accept</button>
            <button id="reject-cookies-btn">Reject</button>
        </div>
        <!-- ********************************************************************************** --> 

        </main>

        <script type="text/javascript" src="js/header.js"></script>

        <script type="text/javascript">

            // =================================================================================================================
            // if localStorage cookieBannerDisplayed=False, then display the cookie banner                                      //
            // =================================================================================================================
            if (localStorage.getItem("cookieBannerDisplayed") != "True") {
                  document.querySelector(".cookie-banner").style.display = "flex";
            };

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                // =================================================================================================================
                // event listener for the close-banner btn                                                        //
                // =================================================================================================================
                if (event.target.matches('#accept-cookies-btn')) {
                    // remove the cookie banner and set cookieBannerDisplayed=True
                    document.querySelector(".cookie-banner").style.display = "none";
                    localStorage.setItem("cookieBannerDisplayed", "True")
                }

                if (event.target.matches('#reject-cookies-btn')) {
                    // remove the cookie banner but set cookieBannerDisplayed=False - so it displays again the next time
                    document.querySelector(".cookie-banner").style.display = "none";
                    localStorage.setItem("cookieBannerDisplayed", "False")
                }

                // event listener for the competition rules button
                if (event.target.matches('#display-all-rules-btn')) {

                    window.location.href="php/competition-rules.php";

                }

                // event listener for the advice button
                if (event.target.matches('#display-advice-btn')) {

                    window.location.href="php/advice.php";

                }

            }, false);   // end of CLICK event listener
                
        </script>

    </body>

</html>