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
                    $menuitems = array("Home");
                    include '../include/header1.inc.php';
                ?>
            </header>
            
            <div class="card" id="competition-rules">
                <h2 class="card-title">Advice on how to complete your predictions</h2>

                <div id="rules">

                    <div class="rules-heading">Group Stage</div>
                    <div class="rules-content">
                        Enter the score for each game in each group.<br>
                        You can specify either a home win, an away win or a draw.<br>
                        As you enter each result, the positions of the team in the group league table will adjust to show you how the result affects the league positions.<br>
                        The winner and runner-up in each group will qualify for the last 16 stage.<br>
                        Adjust your scores to ensure that the teams you want as group winner and group runner up are in the desired positions.<br>
                        Once you complete all games in groups A,B,C,D,E use the navigation bar to display the games for Groups E, F, G and H.
                    </div>    

                    <div class="rules-heading">Last 16 Stage</div>
                    <div class="rules-content">
                        The winner and runner up from each group will be filled in automatically for you in the correct position in the Last 16 stage.<br>
                        If you want to change the teams that go through to the Last 16 Stage, you should go back to the group stage and adjust your scores again to make sure your desired teams are in the positions in the league table<br> 
                        Enter the score for each game.<br>
                        In the knockout stages you must enter either a home win or an away win, you cannot enter a draw.<br>
                        If a game goes to extra time or penalties, it is the final score after extra/penaliies that will count.
                    </div>    


                    <div class="rules-heading">Quarter Finals</div>
                    <div class="rules-content">
                        Enter the score for each game.<br>
                        The winner from each of the last 16 games will be filled in automatically for you in the correct position in the Quarter Final stage as you enter your scores.<br>
                        You must enter either a home win or an away win, you cannot enter a draw.<br>
                        If a game goes to extra time or penalties, it is the final score after extra/penaliies that will count.<br>  
                    </div>    

                    <div class="rules-heading">Semi Finals</div>

                    <div class="rules-content">
                        Enter the score for each game.<br>
                        The winner from each of the Quarter Finals will be filled in automatically for you in the correct position in the Semi Final stage.<br>
                        You must enter either a home win or an away win, you cannot enter a draw.<br>
                        If a game goes to extra time or penalties, it is the final score after extra/penaliies that will count.<br>  
                    </div>    

                    <div class="rules-heading">Final / 3rd Place Play-Off</div>

                    <div class="rules-content">
                        Enter the score for each game.<br>
                        The <strong>winner</strong> from each of the Semi Finals will be filled in automatically for you in the correct position in the Final game.<br>
                        The <strong>loser</strong> from each of the Semi Finals will be filled in automatically for you in the the correct position in the 3rd Place Play-Off game.<br>
                        You must enter either a home win or an away win, you cannot enter a draw.<br>
                        If a game goes to extra time or penalties, it is the final score after extra/penaliies that will count.<br>  
                    </div>

                    <div class="rules-heading">Top Scorer / Goals Scored</div>

                    <div class="rules-content">
                        Once you are happy with the scores in each of stages use the navigation bar to select the Top Goal Scorer.<br>
                        Enter the name of the player who you think will be the top scorer in the competition.<br>
                        Enter the number of goals that you think the player you selected will score.<br>
                        To help with your selections you can click on the country flags to see the players in each squad and the number of goals each player has scored for their country.<br>
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
                        As the tournament progresses you can view how closely your predictions match the actual results by logging in and selecting Results/Predictions from the navigation bar.<br>
                        The table on the left, will show the results of each game as it is played, the table on the right will show how accurate your prediction for each game was.<br>
                        The table on the right will also show the points that you earned for predicting the correct result and correct score.<br>
                        The table will also show any bonus points earned for predicting the correct teams in the correct position in the knockout stages.<br>
                        You will only be awarded bonus points if you have predicted the correct home team for each game and the correct away team for each game.<br>
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