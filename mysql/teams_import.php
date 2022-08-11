<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    };

// echo out starting debug datestamp
echo (date('l jS \of F Y h:i:s A') . "<br><br>");

    // define the SQL INSERT Statement
    $sql = "INSERT INTO Teams (GroupID, Code, Team, Ranking, WikipediaLink) VALUES (:GroupID, :Code, :Team, :Ranking, :WikiLink)";

    //prepare the sql statement
    $query = $dbh -> prepare($sql);

    // bind the paramaters to the sql statement
    $query->bindParam(':GroupID',  $groupid,  PDO::PARAM_INT);
    $query->bindParam(':Code',     $code,     PDO::PARAM_STR);
    $query->bindParam(':Team',     $teamname, PDO::PARAM_STR);
    $query->bindParam(':Ranking',  $ranking,  PDO::PARAM_INT);
    $query->bindParam(':WikiLink', $wikilink, PDO::PARAM_STR);


    // ------------------------
    //    GROUP A  ID = 1
    // ------------------------
    $groupid = 1;
    // ------------------------

    $code     = "QTR";
    $teamname = "Qatar";
    $ranking  = 49;
    $wikilink = "https://en.wikipedia.org/wiki/Qatar_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "ECU";
    $teamname = "Ecuador";
    $ranking  = 44;
    $wikilink = "https://en.wikipedia.org/wiki/Ecuador_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
            
    $code     = "SEN";
    $teamname = "Senegal";
    $ranking  = 18;
    $wikilink = "https://en.wikipedia.org/wiki/Senegal_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "NET";
    $teamname = "Netherlands";
    $ranking  = 8;
    $wikilink = "https://en.wikipedia.org/wiki/Netherlands_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // ------------------------
    //    GROUP B  ID = 2
    // ------------------------
    $groupid = 2;
    // ------------------------

    $code     = "ENG";
    $teamname = "England";
    $ranking  = 5;
    $wikilink = "https://en.wikipedia.org/wiki/England_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "IRA";
    $teamname = "IR Iran";
    $ranking  = 23;
    $wikilink = "https://en.wikipedia.org/wiki/Iran_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
            
    $code     = "USA";
    $teamname = "United States";
    $ranking  = 14;
    $wikilink = "https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/United_States_men's_national_soccer_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "WAL";
    $teamname = "Wales";
    $ranking  = 19;
    $wikilink = "https://en.wikipedia.org/wiki/Wales_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // ------------------------
    //    GROUP C  ID = 3
    // ------------------------
    $groupid = 3;
    // ------------------------

    $code     = "ARG";
    $teamname = "Argentina";
    $ranking  = 3;
    $wikilink = "https://en.wikipedia.org/wiki/Argentina_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "SAR";
    $teamname = "Saudi Arabia";
    $ranking  = 53;
    $wikilink = "https://en.wikipedia.org/wiki/Saudi_Arabia_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
            
    $code     = "MEX";
    $teamname = "Mexico";
    $ranking  = 12;
    $wikilink = "https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/Mexico_national_soccer_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "POL";
    $teamname = "Poland";
    $ranking  = 26;
    $wikilink = "https://en.wikipedia.org/wiki/Poland_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // ------------------------
    //    GROUP D  ID = 4
    // ------------------------
    $groupid = 4;
    // ------------------------

    $code     = "FRA";
    $teamname = "France";
    $ranking  = 4;
    $wikilink = "https://en.wikipedia.org/wiki/France_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code = "DEN";
    $teamname = "Denmark";
    $ranking = 10;
    $wikilink = "https://en.wikipedia.org/wiki/Denmark_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
            
    $code     = "TUN";
    $teamname = "Tunisia";
    $ranking  = 30;
    $wikilink = "https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/Tunisia_national_soccer_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "AUS";
    $teamname = "Australia";
    $ranking  = 39;
    $wikilink = "https://en.wikipedia.org/wiki/Australia_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // ------------------------
    //    GROUP E  ID = 5
    // ------------------------
    $groupid = 5;
    // ------------------------

    $code     = "SPN";
    $teamname = "Spain";
    $ranking  = 6;
    $wikilink = "https://en.wikipedia.org/wiki/Spain_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "GER";
    $teamname = "Germany";
    $ranking  = 11;
    $wikilink = "https://en.wikipedia.org/wiki/Germany_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }        
    
    $code     = "JPN";
    $teamname = "Japan";
    $ranking  = 24;
    $wikilink = "https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/Japan_national_soccer_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "COS";
    $teamname = "Costa Rica";
    $ranking  = 34;
    $wikilink = "https://en.wikipedia.org/wiki/Costa_Rica_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // ------------------------
    //    GROUP F  ID = 6
    // ------------------------
    $groupid = 6;
    // ------------------------

    $code     = "BEL";
    $teamname = "Belgium";
    $ranking  = 1;
    $wikilink = "https://en.wikipedia.org/wiki/Belgium_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "CAN";
    $teamname = "Canada";
    $ranking  = 43;
    $wikilink = "https://en.wikipedia.org/wiki/Canada_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    
    $code     = "MOR";
    $teamname = "Morocco";
    $ranking  = 22;
    $wikilink = "https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/Morocco_national_soccer_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "CRO";
    $teamname = "Croatia";
    $ranking  = 15;
    $wikilink = "https://en.wikipedia.org/wiki/Croatia_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // ------------------------
    //    GROUP G  ID = 7
    // ------------------------
    $groupid = 7;
    // ------------------------

    $code     = "BRA";
    $teamname = "Brazil";
    $ranking  = 1;
    $wikilink = "https://en.wikipedia.org/wiki/Brazil_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "SER";
    $teamname = "Serbia";
    $ranking  = 25;
    $wikilink = "https://en.wikipedia.org/wiki/Serbia_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
            
    $code     = "SWZ";
    $teamname = "Switzerland";
    $ranking  = 16;
    $wikilink = "https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/Switzerland_national_soccer_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "CAM";
    $teamname = "Cameroon";
    $ranking  = 38;
    $wikilink = "https://en.wikipedia.org/wiki/Cameroon_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // ------------------------
    //    GROUP H  ID = 8
    // ------------------------
    $groupid = 8;
    // ------------------------

    $code     = "POR";
    $teamname = "Portugal";
    $ranking  = 9;
    $wikilink = "https://en.wikipedia.org/wiki/Portugal_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "GHA";
    $teamname = "Ghana";
    $ranking  = 60;
    $wikilink = "https://en.wikipedia.org/wiki/Ghana_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
        
    $code     = "URU";
    $teamname = "Uruguay";
    $ranking  = 13;
    $wikilink = "https://en.wikipedia.org/wiki/https://en.wikipedia.org/wiki/Uruguay_national_soccer_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code     = "KOR";
    $teamname = "Korea Republic";
    $ranking  = 28;
    $wikilink = "https://en.wikipedia.org/wiki/South_Korea_national_football_team#Current_squad";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // -------------------------------------------
    //    LAST 16 - dummy team entries  
    // -------------------------------------------
    $groupid = 9;
    // ------------------------

    $code = "GAW";
    $teamname = "Winner GrpA";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GAR";
    $teamname = "Runnerup GrpA";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GBW";
    $teamname = "Winner GrpB";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GBR";
    $teamname = "Runnerup GrpB";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GCW";
    $teamname = "Winner GrpC";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GCR";
    $teamname = "Runnerup GrpC";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "GDW";
    $teamname = "Winner GrpD";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GDR";
    $teamname = "Runnerup GrpD";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "GEW";
    $teamname = "Winner GrpE";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GER";
    $teamname = "Runnerup GrpE";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GFW";
    $teamname = "Winner GrpF";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GFR";
    $teamname = "Runnerup GrpF";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GGW";
    $teamname = "Winner GrpG";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GGR";
    $teamname = "Runnerup GrpG";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "GHW";
    $teamname = "Winner GrpH";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "GHR";
    $teamname = "Runnerup GrpH";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // -------------------------------------------
    //    QUARTER FINALS - dummy team entries  
    // -------------------------------------------
    $groupid = 10;
    // -------------------------------------------

    $code = "F49";
    $teamname = "Winner Match 49";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "F50";
    $teamname = "Winner Match 50";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "F51";
    $teamname = "Winner Match 51";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "F52";
    $teamname = "Winner Match 52";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "F53";
    $teamname = "Winner Match 53";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "F54";
    $teamname = "Winner Match 54";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "F55";
    $teamname = "Winner Match 55";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "F56";
    $teamname = "Winner Match 56";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    // -------------------------------------------
    //    SEMI FINALS - dummy team entries  
    // -------------------------------------------
    $groupid = 11;
    // -------------------------------------------

    $code = "Q1W";
    $teamname = "Winner QF1";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "Q2W";
    $teamname = "Winner QF2";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "Q3W";
    $teamname = "Winner QF3";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "Q4W";
    $teamname = "Winner QF4";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    // -------------------------------------------
    //    FINAL - dummy team entries  
    // -------------------------------------------
    $groupid = 12;
    // -------------------------------------------

    $code = "S1W";
    $teamname = "Winner SF1";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
        echo ("New record created - " . $teamname . "<br>");
    } else {
        echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "S1L";
    $teamname = "Loser SF1";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
        echo ("New record created - " . $teamname . "<br>");
    } else {
        echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

    $code = "S2W";
    $teamname = "Winner SF2";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }
    
    $code = "S2L";
    $teamname = "Loser SF2";
    $ranking = 0;
    $wikilink = "";

    if ( $query -> execute() === TRUE ) {
            echo ("New record created - " . $teamname . "<br>");
    } else {
            echo ("Error: " . $code . "-" . $teamname . "<br>");
    }

// Close the connection as soon as it's no longer needed
$dbh = null;

// echo out ending debug datestamp
echo ("<br>" . date('l jS \of F Y h:i:s A') . "<br>");

?>