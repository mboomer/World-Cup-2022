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
    $insertQry = "INSERT INTO Venues (City, Stadium) VALUES (?, ?)";

    $insertStatement = mysqli_prepare($conn, $insertQry);

    // Bind params
    mysqli_stmt_bind_param($insertStatement, "ss", $city, $stadium);
 
    echo "Prepare and Bind completed" . "<br>";

    $city = "Trafford";
    $stadium = "Old Trafford";
    
    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    $city = "Southampton";
    $stadium = "St. Marys";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }


    $city = "Milton Keynes";
    $stadium = "Stadium MK";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    $city = "London";
    $stadium = "Brentford Community Stadium";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    $city = "Wigan & Leigh";
    $stadium = "Leigh Sports Village";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    $city = "Sheffield";
    $stadium = "Bramall Lane";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    $city = "Manchester";
    $stadium = "Manchester City Academy Stadium";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    $city = "Rotherham";
    $stadium = "New York Stadium";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    $city = "London";
    $stadium = "Wembley Stadium";

    if (mysqli_stmt_execute($insertStatement)) {
        echo "New record " . $stadium . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $stadium . "<br>";
    }

    mysqli_close();

?>