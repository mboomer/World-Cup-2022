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
    $insertQry = "INSERT INTO GroupStage (Code, Description) VALUES (?, ?)";

    $insertStatement = mysqli_prepare($conn, $insertQry);

    // Bind params
    mysqli_stmt_bind_param($insertStatement, "ss", $code, $description);
 
    echo "Prepare and Bind completed" . "<br>";

    $code = "A";
    $description = "Group A";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "B";
    $description = "Group B";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "C";
    $description = "Group C";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "D";
    $description = "Group D";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "E";
    $description = "Group E";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "F";
    $description = "Group F";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "L";
    $description = "Last 16";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "Q";
    $description = "Quarter Final";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "S";
    $description = "Semi Final";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "N";
    $description = "Final";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    mysqli_close();

?>