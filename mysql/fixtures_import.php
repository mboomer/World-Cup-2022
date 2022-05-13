<?php

    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";
         
    echo (date('l jS \of F Y h:i:s A') . "<br><br>");

    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br");
    } else {
        echo ("Connection successful" . "<br><br>");
    }

    //prepare the sql statement
    $stmt = $conn->prepare("INSERT INTO Fixtures (FixtureNo, GroupID, RoundID, VenueID, HomeTeamID, AwayTeamID, DatePlayed, TimePlayed, HomeScore, AwayScore, ResultID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // bind the paramaters to the sql statement
    $stmt->bind_param('iiiiiissiii', $fixtureno, $groupid, $roundid, $venueid, $hometeamid, $awayteamid, $dateplayed, $timeplayed, $homescore, $awayscore, $resultid);

    // ---------------------------------
    //         FIXTURES - MATCH DAY 1
    // ---------------------------------
    $fixtureno = 1;

    $roundid = 1;                   // Group Stage 

    $groupid = 1;                   // Group A

    $venueid = 1;                   // Old Trafford
    $hometeamid = 1;                // England
    $awayteamid = 3;                // Austria
    $dateplayed = "2022/07/06";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
                        
    // Next Fixture
    ++$fixtureno;

    $groupid = 1;                   // Group A

    $venueid = 2;                   // St. Marys
    $hometeamid = 2;                // Norway
    $awayteamid = 4;                // Northern Ireland
    $dateplayed = "2022/07/07";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
                        
    // Next Fixture
    ++$fixtureno;

    $groupid = 2;                   // Group B

    $venueid = 3;                   // Stadium MK
    $hometeamid = 6;                // Spain
    $awayteamid = 8;                // Finland
    $dateplayed = "2022/07/08";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 2;                   // Group B

    $venueid = 4;                   // Brentford Community Stadium
    $hometeamid = 5;                // Germany
    $awayteamid = 7;                // Denmark
    $dateplayed = "2022/07/08";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 3;                   // Group C

    $venueid = 5;                   // Leigh Sports Village
    $hometeamid = 12;                // Russia
    $awayteamid = 11;                // Switzerland
    $dateplayed = "2022/07/09";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 3;                   // Group C

    $venueid = 6;                   // Bramall Lane
    $hometeamid = 9;                // Netherlands
    $awayteamid = 10;               // Sweden
    $dateplayed = "2022/07/09";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 4;                   // Group D

    $venueid = 7;                   // Manchester City Academy Stadium
    $hometeamid = 15;                // Belgium
    $awayteamid = 16;                // Iceland
    $dateplayed = "2022/07/10";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 4;                   // Group D

    $venueid = 8;                   // New York Stadium
    $hometeamid = 13;                // France
    $awayteamid = 14;                // Italy
    $dateplayed = "2022/07/10";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // ---------------------------------
    //         FIXTURES - MATCH DAY 2
    // ---------------------------------

    // Next Fixture
    ++$fixtureno;

    $groupid = 1;                   // Group A

    $venueid = 2;                   // St Marys
    $hometeamid = 3;               // Austria
    $awayteamid = 4;               // Northern Ireland
    $dateplayed = "2022/07/11";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 1;                   // Group A

    $venueid = 10;                 // Brighton & Hove Community Stadium
    $hometeamid = 1;               // England
    $awayteamid = 2;               // Norway
    $dateplayed = "2022/07/11";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 2;                  // Group B

    $venueid = 3;                  // Stadium MK
    $hometeamid = 7;               // Denmark
    $awayteamid = 8;               // Finland
    $dateplayed = "2022/07/12";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 2;                  // Group B

    $venueid = 4;                  // Brentford Community Stadium - 4
    $hometeamid = 5;               // Germany
    $awayteamid = 6;               // Spain
    $dateplayed = "2022/07/12";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 3;                  // Group C

    $venueid = 6;                  // Bramall Lane
    $hometeamid = 10;               // Sweden
    $awayteamid = 11;               // Switzerland
    $dateplayed = "2022/07/13";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 3    ;                  // Group C

    $venueid = 5;                  // Leigh Sports Village
    $hometeamid = 9;               // Netherlands
    $awayteamid = 12;               // Russia
    $dateplayed = "2022/07/13";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 4    ;              // Group D

    $venueid = 7;                  // Manchester City Academy Stadium
    $hometeamid = 14;               // Netherlands
    $awayteamid = 16;               // Russia
    $dateplayed = "2022/07/14";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 4    ;              // Group D

    $venueid = 8;                  // New York Stadium
    $hometeamid = 13;               // Netherlands
    $awayteamid = 15;               // Russia
    $dateplayed = "2022/07/14";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // ---------------------------------
    //         FIXTURES - MATCH DAY 3
    // ---------------------------------

    // Next Fixture
    ++$fixtureno;

    $groupid = 1;                   // Group A

    $venueid = 2;                   // St Marys
    $hometeamid = 4;               // Northern Ireland
    $awayteamid = 1;               // England
    $dateplayed = "2022/07/15";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 1;                   // Group A

    $venueid = 10;                 // Brighton & Hove Community Stadium
    $hometeamid = 3;               // Austria
    $awayteamid = 2;               // Norway
    $dateplayed = "2022/07/15";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 2;                  // Group B

    $venueid = 3;                  // Stadium MK
    $hometeamid = 8;               // Finland
    $awayteamid = 5;               // Germany
    $dateplayed = "2022/07/16";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 2;                  // Group B

    $venueid = 4;                  // Brentford Community Stadium - 4
    $hometeamid = 6;               // Denmark
    $awayteamid = 7;               // Spain
    $dateplayed = "2022/07/16";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 3;                  // Group C

    $venueid = 6;                  // Bramall Lane
    $hometeamid = 11;               // Switzerland
    $awayteamid = 9;               // Netherlands 
    $dateplayed = "2022/07/17";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 3    ;                  // Group C

    $venueid = 5;                  // Leigh Sports Village
    $hometeamid = 10;               // Sweden
    $awayteamid = 12;               // Russia
    $dateplayed = "2022/07/17";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 4    ;              // Group D

    $venueid = 7;                  // Manchester City Academy Stadium
    $hometeamid = 16;               // Iceland
    $awayteamid = 13;               // France
    $dateplayed = "2022/07/18";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 4    ;              // Group D

    $venueid = 8;                  // New York Stadium
    $hometeamid = 14;               // Italy
    $awayteamid = 15;               // Belgium
    $dateplayed = "2022/07/18";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // ---------------------------------
    //         FIXTURES - QUARTER FINALS
    // ---------------------------------

    // Next Fixture
    ++$fixtureno;

    $groupid = 8;                  // Quarter Finals

    $venueid = 0;                  // 
    $hometeamid = 0;               // Winner Group A
    $awayteamid = 0;               // Runner Up Group B
    $dateplayed = "2022/07/20";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 8;                  // Quarter Finals

    $venueid = 0;                  // 
    $hometeamid = 0;               // Winner Group B
    $awayteamid = 0;               // Runner Up Group A
    $dateplayed = "2022/07/20";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 8;                  // Quarter Finals

    $venueid = 0;                  // 
    $hometeamid = 0;               // Winner Group C
    $awayteamid = 0;               // Runner Up Group D
    $dateplayed = "2022/07/20";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 8;                  // Quarter Finals

    $venueid = 0;                  // 
    $hometeamid = 0;               // Winner Group D
    $awayteamid = 0;               // Runner Up Group C
    $dateplayed = "2022/07/20";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // ---------------------------------
    //         FIXTURES - SEMI FINALS
    // ---------------------------------

    // Next Fixture
    ++$fixtureno;

    $groupid = 9;                  // Semi Finals

    $venueid = 0;                  // 
    $hometeamid = 0;               // Winner QF 1 
    $awayteamid = 0;               // Winner QF 3
    $dateplayed = "2022/07/26";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Next Fixture
    ++$fixtureno;

    $groupid = 9;                  // Quarter Finals

    $venueid = 0;                  // 
    $hometeamid = 0;               // Winner QF 2
    $awayteamid = 0;               // Winner QF 4
    $dateplayed = "2022/07/27";
    $timeplayed = "20:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // ---------------------------------
    //         FIXTURES - FINAL
    // ---------------------------------

    // Next Fixture
    ++$fixtureno;

    $groupid = 10;                  // Finals

    $venueid = 0;                  // 
    $hometeamid = 0;               // Winner SF 1 
    $awayteamid = 0;               // Winner SF 2
    $dateplayed = "2022/07/31";
    $timeplayed = "17:00";
    $homescore = NULL;
    $awayscore = NULL;
    $resultid = NULL;
    
    if ($stmt->execute()) {
            echo ("New record created - " . $fixtureno . " - " . $dateplayed . "-" . $timeplayed . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // Close the connection as soon as it's no longer needed
    $conn->close();

    echo ("<br>" . date('l jS \of F Y h:i:s A') . "<br>");

?>