<?php
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";
         
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);

    // Check connection
    if (!$conn) {
        die("Unable to connect to database : " . mysqli_connect_error()) . "<br>";
    } else {
        echo "Connected successfully" . "<br>";
    }

    // Prepare 
    $insertQry = "INSERT INTO Rounds (Code, Description) VALUES (?, ?)";

    $insertStatement = mysqli_prepare($conn, $insertQry);

    // Bind params
    mysqli_stmt_bind_param($insertStatement, "ss", $code, $description);
 
    echo "Prepare and Bind completed" . "<br>";

    $code = "GS";
    $description = "Group Stage";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "LS";
    $description = "Last Sixteen";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "QF";
    $description = "Quarter Final";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "SF";
    $description = "Semi Final";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "FI";
    $description = "Final";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "PL";
    $description = "Play Off";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    mysqli_close();

?>