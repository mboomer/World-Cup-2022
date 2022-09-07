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

    // initialise the no of records imported
    $recordcount = 0;

// dislay starting debug timestamp
// echo (date('l jS \of F Y h:i:s A') . "<br><br>");

    //prepare the sql statement
    $sql = "INSERT INTO Results (Code, Description) VALUES (:Code, :Description)";

    //prepare the sql statement
    $query = $dbh -> prepare($sql);

    // bind the paramaters to the sql statement
    $query->bindParam(':Code',        $code,        PDO::PARAM_STR);
    $query->bindParam(':Description', $description, PDO::PARAM_STR);

    $code = "H";
    $description = "Home Win";
        
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    }

    // increment the recordcount
    ++$recordcount;

    ++
    $code = "A";
    $description = "Away Win";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    }

    // increment the recordcount
    ++$recordcount;
        
    $code = "D";
    $description = "Draw";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    }

    // increment the recordcount
    ++$recordcount;
      
    $code = "E";
    $description = "Extra Time";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
    }

    // increment the recordcount
    ++$recordcount;
       
    $code = "P";
    $description = "Penalities";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    }

    // increment the recordcount
    ++$recordcount;
        
    $code = "NP";
    $description = "Not Played Yet";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    }

    // increment the recordcount
    ++$recordcount;

    // Close the connection as soon as it's no longer needed
    $dbh = null;

// return the closing debug timestamp and the number of records imported
echo ( date('l jS \of F Y h:i:s A') . "<br>");
echo "Total Results Imported : " . $recordcount;

?>