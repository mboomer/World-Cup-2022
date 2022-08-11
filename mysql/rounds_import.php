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

// dislay starting debug timestamp
echo (date('l jS \of F Y h:i:s A') . "<br><br>");
    
    // Prepare 
    $sql = "INSERT INTO Rounds (Code, Description) VALUES (:Code, :Description)";

    //prepare the sql statement
    $query = $dbh -> prepare($sql);

    // bind the paramaters to the sql statement
    $query->bindParam(':Code',        $code,        PDO::PARAM_STR);
    $query->bindParam(':Description', $description, PDO::PARAM_STR);

    $code = "GS";
    $description = "Group Stage";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "LS";
    $description = "Last Sixteen";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "QF";
    $description = "Quarter Final";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "SF";
    $description = "Semi Final";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "FI";
    $description = "Final";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "PL";
    $description = "Play Off";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    // Close the connection as soon as it's no longer needed
    $dbh = null;

// display closing debug timestamp
echo ("<br>" . date('l jS \of F Y h:i:s A') . "<br>");

?>