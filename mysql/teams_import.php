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
    $stmt = $conn->prepare("INSERT INTO Teams (GroupID, Code, Team, Ranking) VALUES (?, ?, ?, ?)");

    // bind the paramaters to the sql statement
    $stmt->bind_param('issi', $groupid, $code, $team, $ranking);

    // ------------------------
    //         GROUP A
    // ------------------------
    $groupid = 1;
    $code = "ENG";
    $team = "England";
    $ranking = 8;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $groupid = 1;
    $code = "NOR";
    $team = "Norway";
    $ranking = 12;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $groupid = 1;
    $code = "AUS";
    $team = "Austria";
    $ranking = 21;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $groupid = 1;
    $code = "NIR";
    $team = "Northern Ireland";
    $ranking = 48;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    // ------------------------
    //         GROUP B
    // ------------------------
    $groupid = 2;

    $code = "GER";
    $team = "Germany";
    $ranking = 3;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "SPN";
    $team = "Spain";
    $ranking = 10;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "DEN";
    $team = "Denmark";
    $ranking = 15;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "FIN";
    $team = "Finland";
    $ranking = 25;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    // ------------------------
    //         GROUP C
    // ------------------------
    $groupid = 3;

    $code = "NER";
    $team = "Netherlands";
    $ranking = 4;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "SWE";
    $team = "Sweden";
    $ranking = 2;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "SWZ";
    $team = "Switzerland";
    $ranking = 20;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "POR";
    $team = "Portugal";
    $ranking = 29;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    // ------------------------
    //         GROUP D
    // ------------------------
    $groupid = 4;

    $code = "FRA";
    $team = "France";
    $ranking = 5;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "ITL";
    $team = "Italy";
    $ranking = 14;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "BEL";
    $team = "Belgium";
    $ranking = 19;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "ICE";
    $team = "Iceland";
    $ranking = 16;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    // -------------------------------------------
    //    QUARTER FINALS - dummy team entries  
    // -------------------------------------------
    $groupid = 8;

    $code = "GAW";
    $team = "Winner GrpA";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "GAR";
    $team = "Runnerup GrpA";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "GBW";
    $team = "Winner GrpB";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "GBR";
    $team = "Runnerup GrpB";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "GCW";
    $team = "Winner GrpC";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "GCR";
    $team = "Runnerup GrpC";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    $code = "GDW";
    $team = "Winner GrpD";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "GDR";
    $team = "Runnerup GrpD";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }

    // -------------------------------------------
    //    SEMI FINALS - dummy team entries  
    // -------------------------------------------
    $groupid = 9;

    $code = "Q1W";
    $team = "Winner QF1";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "Q2W";
    $team = "Winner QF2";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    

    $code = "Q3W";
    $team = "Winner QF3";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "Q4W";
    $team = "Winner QF4";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    // -------------------------------------------
    //    FINALS - dummy team entries  
    // -------------------------------------------
    $groupid = 10;

    $code = "S1W";
    $team = "Winner SF1";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "S2W";
    $team = "Winner SF2";
    $ranking = 0;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    

    // Close the connection as soon as it's no longer needed
    $conn->close();


echo ("<br>" . date('l jS \of F Y h:i:s A') . "<br>");

?>