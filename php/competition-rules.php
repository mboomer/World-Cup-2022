<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta http-equiv="cache-control" content="no-cache">        <!-- tells browser not to cache -->
        <meta http-equiv="expires"       content="0">               <!-- says that the cache expires 'now' -->
        <meta http-equiv="pragma"        content="no-cache">        <!-- says not to use cached stuff, if there is any -->

        <title>World Cup 2022 Predictor - Competition Rules</title>
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">

        <style type="text/css">

            #rules-container {
                width: 98%;
                margin: 0 auto;
            }
            #rules-container header {
                margin-top: 5px;
                margin-bottom: 5px;
            }

        </style>

    </head>
    
    <body>
        
        <div id="rules-container">

            <header>                
                <?php include '../include/header1.inc.php';?>
            </header>
            
            <div class="card" id="competition-rules">
                <h2 class="card-title">Competition Rules</h2>

                <div id="rules">

                    <div class="rules-heading">Predictions - How points are awarded</div>

                    <div class="rules-content">
                        All predictions must be completed before the start of the first match on November 20th 2022.<br>
                        <br>
                        1 Point for predicting the correct result, i.e. a home win (H), an away win (A), a draw (D)<br>
                        2 Points for predicting the correct score, e.g. 2-1, 1-2, 2-2
                    </div>    

                    <div class="rules-heading">Round Of 16 - Bonus Points</div>

                    <div class="rules-content">
                        1 Bonus Point for predicting the correct home team<br>
                        1 Bonue Point for predicting the correct away team<br>
                    </div>

                    <div class="rules-heading">Quarter Finals - Bonus Points</div>

                    <div class="rules-content">
                        1 Bonus Point for predicting the correct home team<br>
                        1 Bonus Point for predicting the correct away team<br>
                    </div>

                    <div class="rules-heading">Semi Finals - Bonus Points</div>

                    <div class="rules-content">
                        2 Bonus Points for predicting the correct home team<br>
                        2 Bonus Points for predicting the correct away team<br>
                    </div>

                    <div class="rules-heading">3rd Place Playoff / Final - Bonus Points</div>

                    <div class="rules-content">
                        3 Points for predicting the correct home team<br>
                        3 Points for predicting the correct away team<br>
                    </div>

                    <div class="rules-heading">Tie-Breaker Situation</div>

                    <div class="rules-content">
                        If two or more players end up with the same number of points, the following will be used to decide the winner…each will be applied in turn until a winner is selected.<br>
                        <ol>
                            <li>The player who has predicted the top goal scorer in the competition and also predicted the correct number of goals</li>
                            <li>The player who has predicted the top goal scorer in the competition and is closest to the correct number of goals scored</li>
                            <li>The player with the goal scorer who has scored the most goals.</li>
                            <li>The player who has predicted the most totally correct results, i.e. correct result, correct score, correct home team and correct away team.</li>
                            <li>If there is still a draw after this it should be decided by the toss of a coin.</li>
                        </ol> 
                    </div>


                </div> 

            </div>

            <footer id="footer">
                <?php include '../include/footer.inc.php';?>
            </footer>

        </div>        
            
    </body>

</html>