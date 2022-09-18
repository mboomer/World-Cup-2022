<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    };

    // initialise the no of records imported
    $recordcount = 0;

// dislay starting debug timestamp
// echo (date('l jS \of F Y h:i:s A') . "<br><br>");
    
    // Prepare 
    $sql = "INSERT 
                INTO 
                    Fixtures (FixtureNo, GroupID, RoundID, VenueID, HomeTeamID, AwayTeamID, DatePlayed, TimePlayed, HomeScore, AwayScore, ResultID) 
            VALUES (:FixtureNo, :GroupID, :RoundID, :VenueID, :HomeTeamID, :AwayTeamID, :DatePlayed, :TimePlayed, :HomeScore, :AwayScore, :ResultID)";

    //prepare the sql statement
    $query = $dbh -> prepare($sql);

    // bind the paramaters to the sql statement
    $query->bindParam(':FixtureNo',  $fixtureno,  PDO::PARAM_INT);
    $query->bindParam(':GroupID',    $groupid,    PDO::PARAM_INT);
    $query->bindParam(':RoundID',    $roundid,    PDO::PARAM_INT);
    $query->bindParam(':VenueID',    $venueid,    PDO::PARAM_INT);
    $query->bindParam(':HomeTeamID', $hometeamid, PDO::PARAM_INT);
    $query->bindParam(':AwayTeamID', $awayteamid, PDO::PARAM_INT);
    $query->bindParam(':DatePlayed', $dateplayed, PDO::PARAM_STR);
    $query->bindParam(':TimePlayed', $timeplayed, PDO::PARAM_STR);
    $query->bindParam(':HomeScore',  $homescore,  PDO::PARAM_INT);
    $query->bindParam(':AwayScore',  $awayscore,  PDO::PARAM_INT);
    $query->bindParam(':ResultID',   $resultid,   PDO::PARAM_INT);


    // ---------------------------------
    // Initialize the fixture number
    // ---------------------------------
    $fixtureno = 1;

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 1
    // ----------------------------------------------

    $roundid   = 1;                 // Group Stage 
    $groupid   = 1;                 // Group A
    $venueid   = 2;                 // Al Bayt Stadium

    $hometeamid = 1;                // Sengal 
    $awayteamid = 2;                // Netherlands
    $dateplayed = "2022/11/20";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 2
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 2;                 // Group B
    $venueid   = 4;                 // Khalifa International Stadium 

    $hometeamid = 5;                // England
    $awayteamid = 6;                // IR Iran
    $dateplayed = "2022/11/21";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 3
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 1;                 // Group A
    $venueid   = 2;                 // Al Bayt Stadium

    $hometeamid = 3;                // Senegal
    $awayteamid = 4;                // Netherlands
    $dateplayed = "2022/11/21";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 4
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 2;                 // Group B
    $venueid   = 6;                 // Ahmad Bin Ali Stadiun

    $hometeamid = 7;                // USA
    $awayteamid = 8;                // Wales
    $dateplayed = "2022/11/21";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 2
    // ----------------------------------------------

    // Next Fixture - 5
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 3;                 // Group C
    $venueid   = 8;                 // Stadium 974

    $hometeamid = 9;                // Argentina 
    $awayteamid = 10;                // SAudi Arabia
    $dateplayed = "2022/11/22";
    $timeplayed = "10:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 6
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 4;                 // Group D
    $venueid   = 5;                 // Education City Stadium 

    $hometeamid = 14;                // Denmark
    $awayteamid = 15;                // Tunisia
    $dateplayed = "2022/11/22";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture = 7
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 3;                 // Group C
    $venueid   = 8;                 // Stadium 974

    $hometeamid = 11;                // Mexico 
    $awayteamid = 12;                // Poland
    $dateplayed = "2022/11/22";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 8
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 4;                 // Group D
    $venueid   = 7;                 // Al Janoub Stadiun

    $hometeamid = 13;                // France
    $awayteamid = 16;                // Australia
    $dateplayed = "2022/11/22";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 3
    // ----------------------------------------------

    // Next Fixture - 9
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 6;                 // Group F
    $venueid   = 2;                 // Al Bayt Stadium

    $hometeamid = 23;               // Morocco
    $awayteamid = 24;               // Croatia
    $dateplayed = "2022/11/23";
    $timeplayed = "10:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 10
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 5;                 // Group E
    $venueid   = 4;                 // Khalifa International Stadium 

    $hometeamid = 18;                // Germany
    $awayteamid = 19;                // Japan
    $dateplayed = "2022/11/23";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 11
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 5;                 // Group E
    $venueid   = 3;                 // Al Thumama Stadium

    $hometeamid = 17;                // Spain 
    $awayteamid = 20;                // Costa Rica
    $dateplayed = "2022/11/23";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 12
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 6;                 // Group F
    $venueid   = 6;                 // Ahman Bin ALi Stadiun

    $hometeamid = 21;                // Belgium
    $awayteamid = 22;                // Canada
    $dateplayed = "2022/11/23";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 4
    // ----------------------------------------------

    // Next Fixture - 13
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 7;                 // Group G
    $venueid   = 7;                 // Al Januob Stadium

    $hometeamid = 27;               // Switzerland
    $awayteamid = 28;               // Cameroon
    $dateplayed = "2022/11/24";
    $timeplayed = "10:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 14
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 8;                 // Group H
    $venueid   = 5;                 // Eductaion Stadium 

    $hometeamid = 31;                // Uruguay
    $awayteamid = 32;                // Korea Republic
    $dateplayed = "2022/11/24";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 15
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 8;                 // Group H
    $venueid   = 8;                 // Stadium 974

    $hometeamid = 29;                // Portugal 
    $awayteamid = 30;                // Ghana
    $dateplayed = "2022/11/24";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
 
    // Next Fixture - 16
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 7;                 // Group G
    $venueid   = 1;                 // Lusail Stadiun

    $hometeamid = 25;                // Brazil
    $awayteamid = 26;                // Serbia
    $dateplayed = "2022/11/24";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 5
    // ----------------------------------------------

    // Next Fixture - 17
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 2;                 // Group B
    $venueid   = 6;                 // Ahmad Bin Ali Stadium

    $hometeamid = 8;                // Wales
    $awayteamid = 6;                // IR Iran
    $dateplayed = "2022/11/25";
    $timeplayed = "10:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 18
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 1;                 // Group A
    $venueid   = 3;                 // Al Thumoma Stadium 

    $hometeamid = 1;                // Qatar
    $awayteamid = 3;                // Senegal
    $dateplayed = "2022/11/25";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 19
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 1;                 // Group A
    $venueid   = 4;                 // Khalifi International Stadium

    $hometeamid = 4;                // Netherlands 
    $awayteamid = 2;                // Ecuador
    $dateplayed = "2022/11/25";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 20
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 2;                 // Group B
    $venueid   = 2;                 // Al Bayt Stadiun

    $hometeamid = 5;                // England
    $awayteamid = 7;                // USA
    $dateplayed = "2022/11/25";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 6
    // ----------------------------------------------

    // Next Fixture - 21
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 4;                 // Group D
    $venueid   = 7;                 // Al Janoub Stadium

    $hometeamid = 15;                // Tunisia
    $awayteamid = 16;                // Australia
    $dateplayed = "2022/11/26";
    $timeplayed = "10:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 22
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 3;                 // Group C
    $venueid   = 5;                 // Education City Stadium 

    $hometeamid = 12;                // Poland
    $awayteamid = 10;                // Saudi Arabia
    $dateplayed = "2022/11/26";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 23
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 4;                 // Group D
    $venueid   = 8;                 // Stadium 974

    $hometeamid = 13;                // France
    $awayteamid = 14;                // Denmark
    $dateplayed = "2022/11/26";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 24
    ++$fixtureno; 

    $roundid   = 1;                 // Group Stage 
    $groupid   = 3;                 // Group C
    $venueid   = 1;                 // Lusain Stadiun

    $hometeamid = 9;                // Argentina
    $awayteamid = 11;                // Mexico
    $dateplayed = "2022/11/26";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 7
    // ----------------------------------------------

    // Next Fixture - 25
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 5;                 // Group E
    $venueid   = 6;                 // Ahmad Bin Ali Stadium

    $hometeamid = 19;                // Japan
    $awayteamid = 20;                // Costa Rica
    $dateplayed = "2022/11/27";
    $timeplayed = "10:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 26
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 6;                 // Group F
    $venueid   = 3;                 // Al Thumama Stadium 

    $hometeamid = 21;                // Belgium
    $awayteamid = 23;                // Morocco
    $dateplayed = "2022/11/27";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 27
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 6;                 // Group F
    $venueid   = 4;                 // Khalifa Stadium

    $hometeamid = 24;                // Croatia
    $awayteamid = 22;                // Canada
    $dateplayed = "2022/11/27";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 28
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 5;                 // Group E
    $venueid   = 2;                 // Al Bayt Stadiun

    $hometeamid = 17;               // Spain
    $awayteamid = 18;               // Germany
    $dateplayed = "2022/11/27";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 8
    // ----------------------------------------------
 
    // Next Fixture - 29
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 7;                 // Group G
    $venueid   = 7;                 // Al Janoub Stadium

    $hometeamid = 28;                // Cameroon
    $awayteamid = 26;                // Serbia
    $dateplayed = "2022/11/28";
    $timeplayed = "10:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 30
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 8;                 // Group H
    $venueid   = 5;                 // Education City Stadium 

    $hometeamid = 32;                // Korea Republic
    $awayteamid = 30;                // Ghana
    $dateplayed = "2022/11/28";
    $timeplayed = "13:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 31
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 7;                 // Group G
    $venueid   = 8;                 // Stadium 974

    $hometeamid = 25;                // Brazil
    $awayteamid = 27;                // Switzerland
    $dateplayed = "2022/11/28";
    $timeplayed = "16:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 32
    ++$fixtureno; 

    $roundid   = 1;                 // Group Stage 
    $groupid   = 8;                 // Group H
    $venueid   = 1;                 // Lusail Stadiun

    $hometeamid = 29;               // Portugal
    $awayteamid = 31;               // Uruguay
    $dateplayed = "2022/11/28";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 9
    // ----------------------------------------------
 
    // Next Fixture - 33
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 1;                 // Group A
    $venueid   = 2;                 // Al Bayt Stadium

    $hometeamid = 4;                // Netherlands
    $awayteamid = 1;                // Qatar
    $dateplayed = "2022/11/29";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 34
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 1;                 // Group A
    $venueid   = 4;                 // Khalifa Stadium 

    $hometeamid = 2;                // Ecuador
    $awayteamid = 3;                // Senegal
    $dateplayed = "2022/11/29";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 35
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 2;                 // Group B
    $venueid   = 6;                 // Ahmad Bin Ali Stadium

    $hometeamid = 8;                // Wales
    $awayteamid = 5;                // England
    $dateplayed = "2022/11/29";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 36
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 2;                 // Group B
    $venueid   = 3;                 // Al Thumama Stadiun

    $hometeamid = 6;                // IR Iran
    $awayteamid = 7;                // USA
    $dateplayed = "2022/11/29";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 10
    // ----------------------------------------------

    // Next Fixture - 37
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 4;                 // Group D
    $venueid   = 7;                 // Al Janoub Stadium

    $hometeamid = 16;               // Australia
    $awayteamid = 14;               // Denmark
    $dateplayed = "2022/11/30";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 38
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 4;                 // Group D
    $venueid   = 5;                 // Education City Stadium 

    $hometeamid = 15;                // Tunisia
    $awayteamid = 13;                // France
    $dateplayed = "2022/11/30";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 39
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 3;                 // Group C
    $venueid   = 8;                 // Stadium 974

    $hometeamid = 12;               // Poland
    $awayteamid = 9;                // Argentina
    $dateplayed = "2022/11/30";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 40
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 3;                 // Group C
    $venueid   = 1;                 // Lusail Stadiun

    $hometeamid = 10;                // Saudia Arabia
    $awayteamid = 11;                // Mexico
    $dateplayed = "2022/11/30";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 11
    // ----------------------------------------------

    // Next Fixture - 41
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 6;                 // Group F
    $venueid   = 6;                 // Ahmad Bin Ali Stadium

    $hometeamid = 24;               // Croatia
    $awayteamid = 21;               // Belgium
    $dateplayed = "2022/12/01";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 42
    ++$fixtureno; 

    $roundid   = 1;                 // Group Stage 
    $groupid   = 6;                 // Group F
    $venueid   = 3;                 // Al Thumama Stadium 

    $hometeamid = 22;                // Canada
    $awayteamid = 23;                // Morocco
    $dateplayed = "2022/12/01";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 43
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 5;                 // Group E
    $venueid   = 4;                 // KHalifa Stadium

    $hometeamid = 19;               // Japan
    $awayteamid = 17;               // Spain
    $dateplayed = "2022/12/01";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 44
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 5;                 // Group E
    $venueid   = 2;                 // Al Bayt Stadiun

    $hometeamid = 20;               // Costa Rica
    $awayteamid = 18;               // Germany
    $dateplayed = "2022/12/01";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ----------------------------------------------
    //  FIXTURES - GROUP STAGE - MATCH DAY 12
    // ----------------------------------------------

    // Next Fixture - 45
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 8;                 // Group H
    $venueid   = 7;                 // Al Janoub Stadium

    $hometeamid = 30;               // Ghana
    $awayteamid = 31;               // Uruguay
    $dateplayed = "2022/12/02";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }
                        
    // Next Fixture - 46
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 8;                 // Group H
    $venueid   = 3;                 // Al Thumama Stadium 

    $hometeamid = 32;                // Korean Republic
    $awayteamid = 29;                // Portugal
    $dateplayed = "2022/12/02";
    $timeplayed = "15:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 47
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 7;                 // Group G
    $venueid   = 8;                 // Stadium 974

    $hometeamid = 26;               // Serbia
    $awayteamid = 27;               // Switzerland
    $dateplayed = "2022/12/02";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 48
    ++$fixtureno;

    $roundid   = 1;                 // Group Stage 
    $groupid   = 7;                 // Group G
    $venueid   = 1;                 // Lusail Stadiun

    $hometeamid = 28;               // Cameroon
    $awayteamid = 25;               // Brazil
    $dateplayed = "2022/12/02";
    $timeplayed = "19:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ---------------------------------
    //  FIXTURES - LAST 16
    // ---------------------------------

    // Next Fixture - 49
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 4;                  // Khalifa Stadium

    $hometeamid = 33;              // Winner Group A
    $awayteamid = 36;              // Runner Up Group B
    $dateplayed = "2022/12/03";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 50
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 6;                  // Ahmad Bin Ali Stadium

    $hometeamid = 37;              // Winner Group C
    $awayteamid = 40;              // Runner Up Group D
    $dateplayed = "2022/12/03";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 51
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 3;                  // Al Thumama Stadium

    $hometeamid = 39;              // Winner Group D
    $awayteamid = 38;              // Runner Up Group C
    $dateplayed = "2022/12/04";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 52
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 2;                  // Al Bayt Stadium

    $hometeamid = 35;              // Winner Group B
    $awayteamid = 34;              // Runner Up Group A
    $dateplayed = "2022/12/04";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 53
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 7;                  // Al Janoub Stadium

    $hometeamid = 41;              // Winner Group E
    $awayteamid = 44;              // Runner Up Group F
    $dateplayed = "2022/12/05";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 54
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 8;                  // Stadium 974

    $hometeamid = 45;              // Winner Group G
    $awayteamid = 48;              // Runner Up Group H
    $dateplayed = "2022/12/05";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 55
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 5;                  // Education City Stadium

    $hometeamid = 43;              // Winner Group F
    $awayteamid = 42;              // Runner Up Group E
    $dateplayed = "2022/12/06";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 56
    ++$fixtureno;

    $roundid = 2;                  // Last 16 
    $groupid = 9;                  // Last 16
    $venueid = 1;                  // Lusail Stadium

    $hometeamid = 47;              // Winner Group H
    $awayteamid = 46;              // Runner Up Group G
    $dateplayed = "2022/12/06";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ---------------------------------
    //  FIXTURES - QUARTER FINALS
    // --------------------------------
    // For some reason the QF match at 22:00 is listed as the fixture no before the match at 18:00 
    // ---------------------------------

    // Next Fixture - 57
    ++$fixtureno;

    $roundid = 3;                  // Quarter Final QF 
    $groupid = 10;                 // Quarter Finals
    $venueid = 1;                  // Lusail Stadium

    $hometeamid = 49;              // Winner Match 49
    $awayteamid = 50;              // Winner Match 50
    $dateplayed = "2022/12/09";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 58
    ++$fixtureno;

    $roundid = 3;                  // Quarter Final QF 
    $groupid = 10;                 // Quarter Finals
    $venueid = 5;                  // Education City Stadium

    $hometeamid = 53;              // Winner Match 53
    $awayteamid = 54;              // Winner Match 54
    $dateplayed = "2022/12/09";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 59
    ++$fixtureno;

    $roundid = 3;                  // Quarter Final QF 
    $groupid = 10;                 // Quarter Finals
    $venueid = 2;                  // Al Bayt Stadium

    $hometeamid = 51;              // Winner Match 51
    $awayteamid = 52;              // Winner Match 52
    $dateplayed = "2022/12/10";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 60
    ++$fixtureno;

    $roundid = 3;                  // Quarter Final QF 
    $groupid = 10;                 // Quarter Finals
    $venueid = 3;                  // Al Thumama Stadium

    $hometeamid = 55;              // Winner Match 55
    $awayteamid = 56;              // Winner Match 56
    $dateplayed = "2022/12/10";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ---------------------------------
    //  FIXTURES - SEMI FINALS
    // ---------------------------------

    // Next Fixture - 61
    ++$fixtureno;

    $roundid = 4;                  // Semi Final SF 
    $groupid = 11;                 // Semi Finals
    $venueid = 1;                  // Lusail Stadium 

    $hometeamid = 57;              // Winner QF 1 
    $awayteamid = 58;              // Winner QF 2
    $dateplayed = "2022/12/13";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Next Fixture - 62
    ++$fixtureno;

    $roundid = 4;                  // Semi Final SF 
    $groupid = 11;                 // Semi Finals
    $venueid = 2;                  // Al Bayt Stadium 

    $hometeamid = 59;              // Winner QF 3 
    $awayteamid = 60;              // Winner QF 4
    $dateplayed = "2022/12/14";
    $timeplayed = "22:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ---------------------------------
    //   FIXTURES - 3RD PLACE PLAY-OFF
    // ---------------------------------

    // Next Fixture - 63
    ++$fixtureno;

    $roundid = 6;                  // Play Off
    $groupid = 12;                 // 3rd Place Play Off
    $venueid = 4;                  // Khalifa Stadium 

    $hometeamid = 62;              // Losers SF1 
    $awayteamid = 64;              // Losers SF2
    $dateplayed = "2022/12/17";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // ---------------------------------
    //         FIXTURES - FINAL
    // ---------------------------------

    // Next Fixture - 64
    ++$fixtureno;

    $roundid = 5;                  // Final FI 
    $groupid = 13;                 // Final
    $venueid = 1;                  // Lusail Stadium 

    $hometeamid = 61;              // Winner QF 1 
    $awayteamid = 63;              // Winner QF 2
    $dateplayed = "2022/12/18";
    $timeplayed = "18:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = 6;
    
    if ( $query -> execute() === FALSE ) {
        echo ("Error: " . $query . "<br>" . " Fixture No. : " . $fixtureno . "<br>");
        exit;
    }

    // Close the connection as soon as it's no longer needed
    $dbh = null;

// display closing debug timestamp
echo ( date('l jS \of F Y h:i:s A') . "<br>" );
echo "Total Fixtures Imported : " . $fixtureno;

?>