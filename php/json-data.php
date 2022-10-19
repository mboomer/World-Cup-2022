<!DOCTYPE html>
<html lang="en">
    <head>
        <title>World Cup 2022 Predictor - How to complete your predictions</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Advice on completing your predictions for the Qatar 2022 World Cup. How to get your winners and runners-up in each group through to the knockout stages">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

        <link rel="stylesheet" href="../css/styles.css">
        <link rel="stylesheet" href="../css/styles-predictions.css">

    </head>
    
    <body>
        
        <main id="json-container">

            <header>
                <?php 
                    $menuitems = array("Home", "Rules", "Login", "Register");
                    include '../include/header1.inc.php';
                ?>
            </header>

            <!-- Tab links -->
            <div id="tabs" class="tab">
              <button id="fixtures-tab"     name="json-fixtures"     class="tablinks">Fixtures</button>
              <button id="results-tab"      name="json-results"      class="tablinks ">Results</button>
              <button id="goals-tab"        name="json-goals-scored" class="tablinks ">Goals Scored</button>
              <button id="groups-tab"       name="json-groups"       class="tablinks ">Group Stages</button>
              <button id="result-codes-tab" name="json-result-codes" class="tablinks ">Result Codes</button>
              <button id="rounds-tab"       name="json-rounds"       class="tablinks ">Rounds</button>
              <button id="teams-tab"        name="json-teams"        class="tablinks ">Teams</button>
              <button id="team-stats-tab"   name="json-team-stats"   class="tablinks ">Team Statistics</button>
              <button id="venues-tab"       name="json-venues"       class="tablinks ">Venues</button>
            </div>

            <div id="display-json-data">
                <h3>Your JSON data will be displayed here</h3>
            </div>

            <footer id="footer">
                <?php include '../include/footer.inc.php';?>
            </footer>

        </main>        
        
        <script type="text/javascript" src="../js/header1.js"></script>

        <script type="text/javascript">

            // **********************************************************************************************************
            // Display the content of the selected tab and highlight the tab
            // **********************************************************************************************************
            function displayStage(evt, tabname) {

                // Declare all variables
                var i, tabcontent, tablinks;

                // Get all elements with class="tabcontent" and hide them
                tabcontent = document.getElementsByClassName("tabcontent");                
            
                for (i = 0; i < tabcontent.length; i++) {
                    tabcontent[i].style.display = "none";
                }

                // Get all elements with class="tablinks" and remove the class "active"
                tablinks = document.getElementsByClassName("tablinks");
                                
                for (i = 0; i < tablinks.length; i++) {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

            };

            // ==================================================================
            // add CLICK event listener for the DOM
            // ==================================================================
            document.addEventListener('click', function (event) {

                // event listeners for the tab links
                if (event.target.matches('.tablinks')) {

                    displayStage(event, event.target.name);
                    event.target.className += " active";

                }

                if (event.target.matches('.tablinks')) {

                        console.log(event.target.name);

                        fetch('https://www.worldcup2022predictor.com/inc/' + event.target.name + '.php', {
                                
                                method: 'POST',
                                mode: "same-origin",
                                credentials: "same-origin",
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                    },
                                body: JSON.stringify('{"fixtures":"Qatar World Cup"}'),

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

                                document.getElementById("display-json-data").innerHTML = data;

                            }).catch(function (error) {
                                // There was an error
                                console.warn("Error : ", error);
                            });

                    return;

                }; // end of click event for SAVE-PREDICTIONS button 


            }, false);   // end of CLICK event listener

        </script>

    </body>

</html>