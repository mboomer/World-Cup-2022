<?php

    echo "  <div id='logo'>";
    echo "      <img src='img/flags/Qatar.png' alt='Qatar Country Flag'> ";
    echo "  </div>";

    echo "  <div id='qatar-flag-l'>";
    echo "      <img src='img/flags/fifa-world-cup.png' alt='FIFA World Cup Trophy'>";
    echo "  </div>";

    echo "  <div id='header-text'>";
    echo "      <h1>World Cup 2022 Predictor</h1>"; 
    echo "  </div>";

    echo "  <div id='qatar-flag-r'>";
    echo "      <img src='img/flags/fifa-world-cup.png' alt='FIFA World Cup Trophy'>";
    echo "  </div>";

    echo "  <div id='hb-icon' class='dropdown'>";
    echo "      <div id='bar1'></div>";
    echo "      <div id='bar2'></div>";
    echo "      <div id='bar3'>";
    echo "          <div id='dropdown-content'>";

    foreach ($menuitems as $menuitems) {
    
        if ($menuitems === "Home") {
            echo "              <a id='home-href' href='#'>Home</a>";
        }; 
        
        if ($menuitems === "Login") {
            echo "              <a id='login-href' href='#'>Login</a>";
        }; 
        
        if ($menuitems === "Register") {
            echo "              <a id='signup-href' href='#'>Register</a>";
        }; 
        
        if ($menuitems === "Profile") {
            echo "              <a id='profile.href' href='#'>User Profile</a>";
        };
        
        if ($menuitems === "Predictions") {
            echo "              <a id='predictions-href' href='#'>Predictions</a>";
        }; 
        
        if ($menuitems === "Logout") {
            echo "              <a id='logout-href' href='#'>logout</a>";
        }; 

    };

    echo "          </div>";
    echo "      </div>";
    echo "  </div>";

?>