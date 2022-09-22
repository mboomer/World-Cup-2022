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
                        For predicting the top goal scorer in the competition - an additional 5 points.<br>
                        For predicting the number of goals scored by the top goal scorer - an additional 5 points.<br>
                        So the maximum points possible is 262. 
                    </div>    

                    <div class="rules-heading">Predicting the correct score/correct result</div>

                    <div class="rules-content">
                        1 Point for predicting the correct result, i.e. a home win (H), an away win (A), a draw (D)<br>
                        2 Points for predicting the correct score, e.g. 2-1, 1-2, 2-2
                    </div>    

                    <div class="rules-heading">Knockout Stages - Correct Result / Score</div>

                    <div class="rules-content">
                        For each match in the knockout stages, you will still be awarded points, for predicting the correct result (H/A/D) or predicting the correct score.<br>
                        These points are awarded, even if, as below, you do not manage to correctly predict the correct home team and the correct away team for the match.<br>
                        These points are awarded as a way to allow everyone to maintain an interest in the later stages of the tournament even if their predictions do not match the actual outcomes.<br>
                    </div>
                    
                    <div class="rules-heading">Knockout Stages - Bonus Points</div>

                    <div class="rules-content">
                        <p>For each match in the knockout stages, bonus points are awarded for predicting the correct teams. For example, 
                        based on your predictions in the group stages, you predict Netherlands would win group A and the USA would be runners up in Group B.
                        If both teams qualify as you predicted, then you would get bonus points (see below) for correctly predicting the correct home team (Netherlands) and the correct away team (USA).</p><br> 
                        <p><img class="matches" src="../img/bonus-points.png"></p><br>
                        <p>However, If the first match turned to be</p><br>  
                        <p><img class="matches" src="../img/no-bonus-points.png"></p><br>
                        <p>You would get no bonus points. Even though You predicted the correct teams in this match, you did not correctly predict the correct "home" team or the "correct" away team.</p> 
                    </div>

                    <div class="rules-heading">Round Of 16 - Bonus Points</div>

                    <div class="rules-content">
                        1 Bonus Point for predicting the correct home team<br>
                        1 Bonus Point for predicting the correct away team<br>
                    </div>

                    <div class="rules-heading">Quarter Finals - Bonus Points</div>

                    <div class="rules-content">
                        2 Bonus Point for predicting the correct home team<br>
                        2 Bonus Point for predicting the correct away team<br>
                    </div>

                    <div class="rules-heading">Semi Finals - Bonus Points</div>

                    <div class="rules-content">
                        3 Bonus Points for predicting the correct home team<br>
                        3 Bonus Points for predicting the correct away team<br>
                    </div>

                    <div class="rules-heading">3rd Place Playoff / Final - Bonus Points</div>

                    <div class="rules-content">
                        4 Points for predicting the correct home team<br>
                        4 Points for predicting the correct away team<br>
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

        </main>        

        <script type="text/javascript" src="../js/header1.js"></script>
        
    </body>

</html>