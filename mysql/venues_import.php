<?php

    // Include config file
    require_once "../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $DBusername);
    define('DB_PASS', $DBpassword);

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        exit("Error: " . $e->getMessage());
    };

    $recordcount = 0;

// dislay starting debug timestamp
// echo (date('l jS \of F Y h:i:s A') . "<br><br>");
    
    // Prepare 
    $sql = "INSERT INTO Venues (City, Stadium) VALUES (:City, :Stadium)";

    //prepare the sql statement
    $query = $dbh -> prepare($sql);

    // bind the paramaters to the sql statement
    $query->bindParam(':City',    $city,    PDO::PARAM_STR);
    $query->bindParam(':Stadium', $stadium, PDO::PARAM_STR);

    $city = "Lusail";
    $stadium = "Lusail Iconic Stadium";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $city = "Al Khor";
    $stadium = "Al Bayt Stadium";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $city = "Doha";
    $stadium = "Al Thumama Stadium";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $city = "Al Rayyan";
    $stadium = "Khalifa International Stadium";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $city = "Al Rayyan";
    $stadium = "Education City Stadium";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $city = "Al Wakrah";
    $stadium = "Ahmad Bin Ali Stadium";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $city = "Al Wakrah";
    $stadium = "Al Janoub Stadium";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $city = "Doha";
    $stadium = "Stadium 974";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $stadium . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    // Close the connection as soon as it's no longer needed
    $dbh = null;

// return the closing debug timestamp and the number of records imported
echo ( date('l jS \of F Y h:i:s A') . "<br>");
echo "Total Venues Imported : " . $recordcount;

?>