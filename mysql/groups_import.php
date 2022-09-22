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

    echo (date('l jS \of F Y h:i:s A') . "<br><br>");

    // define the SQL INSERT Statement
    $sql = "INSERT INTO GroupStage (Code, Description) VALUES (:Code, :Description)";

    //prepare the sql statement
    $query = $dbh -> prepare($sql);

    // bind the paramaters to the sql statement
    $query->bindParam(':Code',        $code,        PDO::PARAM_STR);
    $query->bindParam(':Description', $description, PDO::PARAM_STR);

    $code = "A";
    $description = "Group A";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;
    
    $code = "B";
    $description = "Group B";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "C";
    $description = "Group C";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "D";
    $description = "Group D";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "E";
    $description = "Group E";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "F";
    $description = "Group F";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "G";
    $description = "Group G";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "H";
    $description = "Group H";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "L";
    $description = "Last 16";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "Q";
    $description = "Quarter Final";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "S";
    $description = "Semi Final";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "P";
    $description = "3rd Place Play-Off";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    $code = "N";
    $description = "Final";
    
    if ( $query -> execute() === FALSE ) {
        echo "Failed to created record - " . $description . "<br>";
        exit;
    } 

    // increment the recordcount
    ++$recordcount;

    // Close the connection as soon as it's no longer needed
    $dbh = null;

// display closing debug timestamp
echo ( date('l jS \of F Y h:i:s A') . "<br>");
echo "Total Groups Imported : " . $recordcount;

?>