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
    $stmt = $conn->prepare("INSERT INTO Results (Code, Description) VALUES (?, ?)");

    // bind the paramaters to the sql statement
    $stmt->bind_param('ss', $code, $description);

    $code = "H";
    $description = "Home Win";
    
    if ($stmt->execute()) {
            echo ("New record created - " . $description . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "A";
    $description = "Away Win";
    
    if ($stmt->execute()) {
            echo ("New record created - " . $description . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "D";
    $description = "Draw";
    
    if ($stmt->execute()) {
            echo ("New record created - " . $description . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "E";
    $description = "Extra Time";
    
    if ($stmt->execute()) {
            echo ("New record created - " . $description . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "P";
    $description = "Penalities";
    
    if ($stmt->execute()) {
            echo ("New record created - " . $description . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    $code = "NP";
    $description = "Not Played Yet";
    
    if ($stmt->execute()) {
            echo ("New record created - " . $description . "<br>");
    } else {
            echo ("Error: " . $stmt . "<br>" . $conn->error . "<br>");
    }
        
    // Close the connection as soon as it's no longer needed
    $conn->close();

    echo ("<br>" . date('l jS \of F Y h:i:s A') . "<br>");

?>