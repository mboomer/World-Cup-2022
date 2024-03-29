<!DOCTYPE html>
<html lang="en">
    <head>
        <title>World Cup 2022 Predictor - How to complete your predictions</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Advice on completing your predictions for the Qatar 2022 World Cup. How to get your winners and runners-up in each group through to the knockout stages">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">

    </head>
    
    <body>
        
        <main id="rules-container">

            <header>
                <?php 
                    $menuitems = array("Home", "Rules", "Login", "Register");
                    include '../include/header1.inc.php';
                ?>
            </header>
            
            <div class="card" id="competition-rules">
                <h2 class="card-title">Advice on how to complete your predictions</h2>

                <div id="rules">

                    <div class="rules-heading">Create An Account To Get Started</div>
                    <div class="rules-content">
                        From the Home Page, click on the "hamburger" icon top right, this is the icon with 3 horizontal black lines. Select "Register" to create an account.<br><br>

                        <p><img style="width:50%" class="advice-matches" src="../img/login-register.png" alt="Image showing which icon to click on to login or resister a new account"></p>

                        To register a new account, enter the following information;<br>
                        
                        <ol>
                            <li>Username - must be at least 8 characters long and include only letters and/or numbers</li>
                            <li>Email Address</li>
                            <li>Password - should be at least 12 characters - must include a capital letter, a number, and a special character, e.g !£$%</li>
                            <li>Password - repeat the password</li>
                            <li>Click "Create Account"</li>
                        </ol> 

                        Once the account has been created you can login and start entering your predictions.
                        
                    </div>    

                    <div class="rules-heading">Auto-Fill Predictions</div>
                    <div class="rules-content">
                        If you do not want to fill in the results for each match yourself you can use the option "Auto-Fill Predictions" to fill in your predictions.
                        Using a combination of the FIFA Ranking and the difference between the ranking of the teams in each match, the algorithm will assign a random score for every match. 
                        The algorithm will complete the predictions in the following order;<br>
                        
                        <ol>
                            <li>Group Stages</li>
                            <li>Round of Last 16</li>
                            <li>Quarter Finals</li>
                            <li>Semi Finals</li>
                            <li>3rd Place Play-off & Final</li>
                        </ol> 
                          
                        <strong>NOTE : </strong>After using this option you <strong>should</strong> review the predictions starting with the Group Stages.<br><br> 
                        Make any adjustments to the predictions, i.e. score and result, that you require and these changes will then be <strong>correctly</strong> reflected in the knockout and finals stages.<br><br>
                    </div>    

                    <div class="rules-heading">FIFA Rankings</div>
                    <div class="rules-content">
                        To help with decisions between teams that you are unfamilar with, each match displays the teams FIFA world ranking.<br><br>
                        <p><img class="advice-matches" src="../img/advice1.png" alt="Shows the FIFA Team Ranking and the Winner and runner-up in the league table"></p>
                        As you enter each score, the positions of the team in the associated group league table, will adjust automatically to show you how the result affects the league positions.<br>
                        The winner and runner-up in each from each group will qualify for the last 16 stage.<br><br>
                        Adjust the scores in each game to ensure that the teams, you believe will progress as group winner and group runner-up, are in the desired positions.<br>
                        Once you complete all games in groups A,B,C,D,E use the navigation bar to display the games for Groups E, F, G and H.
                    </div>    

                    <div class="rules-heading">Group Tie Breakers</div>
                    <div class="rules-content">
                        If, after entering your predicted scores, two teams are tied on points, the following will be used to decide their position in the table.<br>
                        <ol>
                            <li>Points</li>
                            <li>Goal Difference</li>
                            <li>Goals Scored For</li>
                            <li>Goals Scored Against</li>
                            <li>If still tied the final decision is made based on how the two tied teams faired against each other</li>
                        </ol>
                        <strong>Note : </strong>This is not identical to how the actual competition tie breakers are decided. The official competition applies fair play, red cards etc. 
                        However, for the purpose of this website I believe the above rules are adequate.<br>
                        If after applying all the above, the teams you want to progress are still not in the desired positions, you can adjust your scores to get the desired outcome.                     
                    </div>    

                    <div class="rules-heading">Group Stages</div>
                    <div class="rules-content">
                        Enter the score for each game in each group. The score you enter will determine whether the result will be a home win (H), an away win (A) or a draw (D).<br><br>
                        As you enter each score, the positions of the team in the associated group league table, will adjust automatically to show you how the result affects the league positions.
                        The winner and runner-up from each group will qualify for the last 16 stage.<br><br>
                        Adjust your scores to ensure that the teams you want as group winner and group runner-up are in the desired positions.<br>
                        Once you complete all games in groups A,B,C,D,E use the navigation bar to display the games for Groups E, F, G and H.
                    </div>    

                    <div class="rules-heading">KNOCKOUT STAGES - NO DRAWS - EXTRA TIME - PENALTIES</div>
                    <div class="rules-content">
                        In the knockout stages you must enter, either, a home win (H) or an away win (A). If you leave a game marked as a draw (D) in any of the knockout stages, 
                        you will NOT be allowed to save or update your predictions when you try to do so. A message will be displayed to advise you to go back and check your predictions.<br><br>
                        If a game is decided after extra time, it is the final score after extra time, that will count.<br>
                        For example, a game finishes 0-0 after 90 minutes, and after extra time finishes 1-2. The final score for the game will be 1-2 and an away win (A).<br><br>
                        If a game is decided after extra time and penalties, it is the final score after penalties that will count.<br>
                        For example, a game finishes 0-0 after 90 minutes, after extra time the score is 1-1 and goes to penalties.
                        The home team scores 4 penalties and the away team scores 3 penalites. The final result for the game will be 5-4 and a home win (H).<br><br>
                    </div>    

                    <div class="rules-heading">Last 16 Stage</div>
                    <div class="rules-content">
                        The winner and runner-up from each group will be filled in automatically for you in the correct position in the Last 16 stage.<br>
                        If you want to change the teams that go through to the Last 16 Stage, you should go back to the group stage and adjust your scores 
                        again to make sure your predicted group winner and group runner-up are in the desired positions in the group league tables.<br> 
                    </div>    

                    <div class="rules-heading">Quarter Finals</div>
                    <div class="rules-content">
                        Enter the score for each game.<br>
                        The winner from each of the Last 16 games will be filled in automatically for you in the correct position in the Quarter Final stage as you enter your scores.<br>
                        If you want to change the teams that go through to the Quarter Final Stage, adjust your scores in the Last 16 games to make sure your prefered winners
                        go through to the Quarter Finals.<br> 
                    </div>    

                    <div class="rules-heading">Semi Finals</div>

                    <div class="rules-content">
                        Enter the score for each game.<br>
                        The winner from each of the Quarter Finals will be filled in automatically for you in the correct position in the Semi Final Stage.<br>
                        If you want to change the teams that go through to the Semi Final Stage, adjust your scores in the Quarter Final games to make sure your prefered winners
                        go through to the Semi Finals.<br> 
                    </div>    

                    <div class="rules-heading">Final / 3rd Place Play-Off</div>

                    <div class="rules-content">
                        Enter the score for each game.<br>
                        The <strong>winner</strong> from each of the Semi Finals will be filled in automatically for you in the correct position in the Final game.<br>
                        The <strong>loser</strong> from each of the Semi Finals will be filled in automatically for you in the the correct position in the 3rd Place Play-Off game.<br>
                    </div>

                    <div class="rules-heading">Top Scorer / Goals Scored</div>

                    <div class="rules-content">
                        Once you are happy with the scores in each of stages use the navigation bar to select the Top Goal Scorer.<br>
                        Enter the name of the player who you think will be the top scorer in the competition and enter the number of goals that you think the player you selected will score.<br>
                        To help with your selections there is a Wikipedia page for each country, you can click on the country flags to see the players in each squad and the number of goals each player has scored for their country.<br>
                        It is likely, but not a certainity, that the top scorer will be a player from a team that progresses to the later stages of the competition.<br> 
                    </div>

                    <div class="rules-heading">Save / Update Your Predictions</div>

                    <div class="rules-content">
                        Once you have entered your predictions for each game and selected your top scorer and the number of goals, use the navigation bar again to select Save/Update your predictions.<br>
                        Once you have saved your predictions you can adjust them any time up to the start of the first game.<br>
                        Once the tournament starts you will not be allowed to make any changes to your predictions or your selections for Top Goal Scorer.<br>
                    </div>

                    <div class="rules-heading">Results / Predictions</div>

                    <div class="rules-content">
                        As the tournament progresses you can view how closely your predictions match the actual results by logging in and selecting "Results/Predictions" from the navigation bar.<br><br>
                        <p><img class="advice-matches" src="../img/advice2.png" alt="The results of each game as it is played and table on the right showing prediction for each game"></p><br>
                        If you have predicted the correct result, one green tick is displayed in the result column.<br> 
                        If you have predicted both the correct result and the correct score then 2 green ticks will be displayed in the Result column.<br>
                        If you haven't predicted the correct result then a red X will be displayed.<br><br>
                        <p><img src="../img/scores-result.png" alt="Green ticks displayed when prediction is correct, red X displayed if prediction is incorrect"></p>

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