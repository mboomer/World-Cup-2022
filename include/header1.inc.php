<?php

    echo "  <div id='logo'>";
    echo "      <img src='../img/flags/Qatar.png' alt='Qatar Country Flag'> ";
    echo "  </div>";

    echo "  <div id='qatar-flag-l'>";
    echo "      <img src='../img/flags/fifa-world-cup.png' alt='FIFA World Cup Trophy'>";
    echo "  </div>";

    echo "  <div id='header-text'>";
    echo "      <h1>World Cup 2022 Predictor</h1>"; 
    echo "  </div>";

    echo "  <div id='qatar-flag-r'>";
    echo "      <img src='../img/flags/fifa-world-cup.png' alt='FIFA World Cup Trophy'>";
    echo "  </div>";

    if ($headeritems === "username") {
        echo "  <div id='username'>";
        echo "    User: $username";
        echo "  </div>";
    };

    echo "  <div id='hb-icon' class='dropdown'>";
    echo "      <div id='bar1'></div>";
    echo "      <div id='bar2'></div>";
    echo "      <div id='bar3'>";
    echo "          <div id='dropdown-content'>";

    foreach ($menuitems as $menuitem) {
    
        if ($menuitem === "Home") {
            echo "              <a id='home-href' href='#'>Home</a>";
        }; 
        
        if ($menuitem === "Rules") {
            echo "              <a id='rules-href' href='#'>Competition Rules</a>";
        }; 
        
        if ($menuitem === "Advice") {
            echo "              <a id='advice-href' href='#'>Advice</a>";
        }; 
        
        if ($menuitem === "Login") {
            echo "              <a id='login-href' href='#'>Login</a>";
        }; 
        
        if ($menuitem === "Register") {
            echo "              <a id='signup-href' href='#'>Register</a>";
        }; 
        
        if ($menuitem === "Profile") {
            echo "              <a id='profile-href' href='#'>User Profile</a>";
        };
        
        if ($menuitem === "Team") {
            echo "              <a id='team-href' href='#'>Your Team</a>";
        }; 
        
        if ($menuitem === "Predictions") {
            echo "              <a id='predictions-href' href='#'>Predictions</a>";
        }; 

        if ($menuitem === "Logout") {
            echo "              <a id='logout-href' href='#'>Logout</a>";
        }; 

    };

    echo "          </div>";
    echo "      </div>";
    echo "  </div>";

?>