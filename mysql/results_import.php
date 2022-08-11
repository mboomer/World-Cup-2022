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

    //prepare the sql statement
    $sql = "INSERT INTO Results (Code, Description) VALUES (:Code, :Description)";

    //prepare the sql statement
    $query = $dbh -> prepare($sql);

    // bind the paramaters to the sql statement
    $query->bindParam(':Code',        $code,        PDO::PARAM_STR);
    $query->bindParam(':Description', $description, PDO::PARAM_STR);

    $code = "H";
    $description = "Home Win";
        
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }

    $code = "A";
    $description = "Away Win";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }
        
    $code = "D";
    $description = "Draw";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }
        
    $code = "E";
    $description = "Extra Time";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }
        
    $code = "P";
    $description = "Penalities";
    
    if ( $query -> execute() === TRUE ) {
        echo "New record " . $description . " created successfully" . "<br>";
    } else {
        echo "Failed to created record - " . $description . "<br>";
    }
        
    $code = "NP";
    $description = "Not Played Yet";
    
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