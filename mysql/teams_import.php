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
    $ranking = 6;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $groupid = 1;
    $code = "NOR";
    $team = "Norway";
    $ranking = 7;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $groupid = 1;
    $code = "AUS";
    $team = "Austria";
    $ranking = 16;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $groupid = 1;
    $code = "NIR";
    $team = "Northern Ireland";
    $ranking = 14;

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
    $ranking = 1;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "SPN";
    $team = "Spain";
    $ranking = 5;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "DEN";
    $team = "Denmark";
    $ranking = 8;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "FIN";
    $team = "Finland";
    $ranking = 15;

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
    $ranking = 2;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "SWE";
    $team = "Sweden";
    $ranking = 3;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "SWZ";
    $team = "Switzerland";
    $ranking = 11;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "RUS";
    $team = "Russia";
    $ranking = 13;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    // ------------------------
    //         GROUP D
    // ------------------------
    $groupid = 3;

    $code = "FRA";
    $team = "France";
    $ranking = 4;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "ITL";
    $team = "Italy";
    $ranking = 9;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "BEL";
    $team = "Belgium";
    $ranking = 10;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    $code = "ICE";
    $team = "Iceland";
    $ranking = 12;

    if ($stmt->execute()) {
            echo ("New record created - " . $team . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
    
    // Close the connection as soon as it's no longer needed
    $conn->close();

    echo ("<br>" . date('l jS \of F Y h:i:s A') . "<br>");

?>