<!DOCTYPE html>
<html lang="en">
    <head>
        <title>World Cup 2022 Predictor - Competition Rules</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Learn how points are allocated for each correct score and correct result for each game and how bonus points are awarded in the knockout stages">
        
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">

    </head>
    
    <body>
        
        <main id="rules-container">

            <header>
                <?php 
                    $menuitems = array("Home");
                    include '../include/header1.inc.php';
                ?>
            </header>
            
            <div class="card" id="competition-rules">
                <h2 class="card-title">Competition Rules</h2>

                <div id="rules">

                    <div class="rules-heading">Submitting Your Predictions</div>
                    <div class="rules-content">
                        All predictions must be completed before the start of the first match on November 20th 2022.<br>
                        Once the competiton starts, no changes will be allowed to your predictions.
                    </div>    

                    <div class="rules-heading">Home Team -v- Away Team</div>
                    <div class="rules-content">
                        <p>For each game the Home team will be deemed, as is traditional, to be the team listed first.</p>
                        <p><img class="matches" src="../img/last-16-match-1.png"></p>
                    </div>    

                    <div class="rules-heading">Available Points</div>
                    <div class="rules-content">
                        The number of points available for predicting every game correctly is 252.<br>
                    </div>    

                    <div class="rules-heading">Predicting the correct result / correct score</div>

                    <div class="rules-content">
                        For each match you will be awarded points, for predicting the correct result (H/A/D) or predicting the correct score.<br><br>
                        1 Point for predicting the correct result, i.e. a home win (H), an away win (A), a draw (D).<br>
                        2 Points for predicting the correct score, e.g. 2-1, 1-2, 2-2.<br><br>
                        In the knockout stages, you will still be awarded points, for predicting the correct result (H/A/D) or predicting the correct score, 
                        even if, you do not manage to correctly predict the correct home team and the correct away team for the match.
                        These points are awarded as a way to allow everyone to maintain an interest in the later stages of the tournament even if their predictions do not exactly match the actual outcomes.<br>
                    </div>    
                    
                    <div class="rules-heading">Knockout Stages - Bonus Points</div>

                    <div class="rules-content">
                        <p>For each match in the knockout stages, bonus points are awarded for predicting the correct teams. For example, 
                        based on your predictions in the group stages, you predict Netherlands would win group A and the USA would be runners up in Group B.
                        If both teams qualify as you predicted, then you would get bonus points (see below) for correctly predicting the correct home team (Netherlands) and the correct away team (USA).</p><br> 
                        <p><img class="matches" src="../img/bonus-points.png"></p><br>
                        <p>However, If the first match turned to be</p><br>  
                        <p><img class="matches" src="../img/no-bonus-points.png"></p><br>
                        <p>You would get no bonus points. Even though you predicted the correct teams in this match, you did not correctly predict the correct "home" team or the "correct" away team.</p> 
                    </div>

                    <div class="rules-heading">Round Of 16 - Bonus Points</div>

                    <div class="rules-content">
                        1 Bonus Point for predicting the correct home team<br>
                        1 Bonus Point for predicting the correct away team<br>
                        So maximum points available for each game in the Last 16 is 5. 
                    </div>

                    <div class="rules-heading">Quarter Finals - Bonus Points</div>

                    <div class="rules-content">
                        2 Bonus Point for predicting the correct home team<br>
                        2 Bonus Point for predicting the correct away team<br>
                        So maximum points available for each game in the Quarter Finals is 7. 
                    </div>

                    <div class="rules-heading">Semi Finals - Bonus Points</div>

                    <div class="rules-content">
                        3 Bonus Points for predicting the correct home team<br>
                        3 Bonus Points for predicting the correct away team<br>
                        So maximum points available for each game in the Semi Finals is 9. 
                    </div>

                    <div class="rules-heading">3rd Place Playoff / Final - Bonus Points</div>

                    <div class="rules-content">
                        4 Points for predicting the correct home team<br>
                        4 Points for predicting the correct away team<br>
                        So maximum points available for each game in the Finals is 11. 
                    </div>

                    <div class="rules-heading">Tie-Breaker Situation</div>

                    <div class="rules-content">
                        If two or more players end up with the same number of points, the following will be used to decide the winner…each will be applied in turn until a winner is selected.<br>
                        <ol>
                            <li>The player who has correctly predicted the top goal scorer in the competition.</li>
                            <li>The player who has correctly predicted the number of goals that the top goal scorer would score.</li>
                            <li>The player whose prediction for the number of goals that top goal scorer would score, is closest to number of goals the top goal scorer actually scores.</li>
                            <li>The player who has predicted the most totally correct results, i.e. in each game has predicted the correct result, correct score, correct home team and correct away team.</li>
                            <li>If players are still tied, the winner will be the player who has been awarded the most points for the Final game of the competition.</li>
                            <li>If there is still a draw after this the winner will be decided by the toss of a coin.</li>
                        </ol> 
                    </div>

                    <div class="rules-heading">Settling Disputes</div>

                    <div class="rules-content">
                        In all disputes I will have the final say.
                    </div>
                </div> 

            </div>

            <footer id="footer">
                <?php include '../include/footer.inc.php';?>
            </footer>

        </main>        

        <script type="text/javascript" src="../js/header1.js"></script>
        
    </body>

</html>