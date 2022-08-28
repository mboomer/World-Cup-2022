<?php

    // if you dont get here from password reset form, then return to login 
    if (empty($_POST["reset-request-submit"])) {
        header("Location: login.php");
        exit();
    }

    // if there is no password entered, return to reset-password with merror message 
    if ( empty($_POST["emailaddress"]) ) {
        header("Location: reset-password.php?reset=pwdempty");
        exit();
    }    
    
    // Include config file
    require_once "../../../.php/inc/db.worldcup.inc.php";

    // DB credentials as constants
    define('DB_HOST', $servername);
    define('DB_NAME', $db);
    define('DB_USER', $username);
    define('DB_PASS', $password);

    // extract the username from the POST data
    $postuser = $_POST["username"];
    // extract the email address from the POST data
    $postemail = $_POST["emailaddress"];

    $selector = bin2hex(random_bytes(8));

    $token = random_bytes(32);

    $url = "https://www.9habu.com/wc2022/php/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token) . "&usr=" . $postuser ;

    // token will expire in 60 munutes 
    $expires = date("U") + 3600;

    // Try and establish the database connection.
    try {
        $dbh = new PDO("mysql:host=" . DB_HOST . "; dbname=" . DB_NAME, DB_USER, DB_PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        echo("Error: " . $e->getMessage());
        exit("Error: " . $e->getMessage());
    };

    // delete any existing tokens for this user email address
    $qry = "DELETE FROM PasswordReset WHERE UserName = :UserName AND UserEmail = :UserEmail";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query -> bindParam(':UserName',  $username,  PDO::PARAM_STR);
    $query -> bindParam(':UserEmail', $useremail, PDO::PARAM_STR);
    
    /** assign the values to the place holders */
    $username  = $postuser;
    $useremail = $postemail;

    /** execute the query and check if it fails */
    $query -> execute();
                                    
    if ($query -> rowCount() > 0) {    
        // $count = $query -> rowCount();
        // echo $count . " rows were affected.";
    } else {
        // echo "No affected rows.";
    }

    // create a token in the database for this email address
    $qry = "INSERT INTO PasswordReset (UserName, UserEmail, Selector, Token, Expires) VALUES (:UserName, :UserEmail, :Selector, :Token, :Expires)";

    // prepare the query for the database connection
    $query = $dbh -> prepare($qry);

    /** bind the parameters */
    $query->bindParam(':UserName',  $dbuser,     PDO::PARAM_STR);
    $query->bindParam(':UserEmail', $dbemail,    PDO::PARAM_STR);
    $query->bindParam(':Selector',  $dbselector, PDO::PARAM_STR);
    $query->bindParam(':Token',     $dbtoken,    PDO::PARAM_STR);
    $query->bindParam(':Expires',   $dbexpires,  PDO::PARAM_STR);

    // hash the password token
    $hashedtoken = password_hash($token, PASSWORD_DEFAULT);

    /** assign the values to the place holders */
    $dbuser     = $postuser;
    $dbemail    = $postemail;
    $dbselector = $selector;
    $dbtoken    = $hashedtoken;
    $dbexpires  = $expires;

    /** execute the query and check if it fails - if it does, return to the reset password page */
    if ($query -> execute() === FALSE) {    
        header("Location: ../php/reset-password.php?reset=failed");
        exit;            
    }; 

    $headers  = "From: Qatar World Cup Predictor <mark.boomer@9habu.com> \r\n";
    $headers .= "Reply-To: mark.boomer@9habu.com \r\n";
    $headers .= "Content-Type: text/html \r\n";

    $to        = $postemail;
    $subject   = "We have received a request to reset the password for user : " . $postuser;

    $message =  "<html>";
    $message .= "   <head>";
    $message .= "       <style>";
    $message .= "       .greenheader {";
    $message .= "           background-color: green;";
    $message .= "           color: white;";
    $message .= "           font-size: 1.5em;";
    $message .= "       }";
    $message .= "       .blueheader {";
    $message .= "           background-color: navy;";
    $message .= "           color: white;";
    $message .= "       }";
    $message .= "       tbody {";
    $message .= "           background-color: white;";
    $message .= "           color: black;";
    $message .= "       }";
    $message .= "       table {";
    $message .= "           font-size: 1em;";
    $message .= "           width: 50%;";
    $message .= "           padding: 2px;";
    $message .= "           text-align: center;";    
    $message .= "           border: 1px dotted black;";
    $message .= "           margin: auto auto;";
    $message .= "       }";
    $message .= "       th, td {";
    $message .= "           padding: 10px;";
    $message .= "           border-left: 1px dotted black;";
    $message .= "           border-right: 1px dotted black;";
    $message .= "           border-bottom: 1px dotted black;";
    $message .= "       }";
    $message .= "       .reset-btn {"; 
    $message .= "           padding: 5px 10px;"; 
    $message .= "           margin: 10px;";
    $message .= "           color: navy; ";
    $message .= "           border: 1px solid #00F;"; 
    $message .= "           background-color: aliceblue;"; 
    $message .= "           text-decoration: none; ";
    $message .= "           font-size: 14px; ";
    $message .= "           border-radius: 2px;"; 
    $message .= "           transition: background-color 300ms ease;"; 
    $message .= "           cursor: pointer; ";
    $message .= "       }";
    $message .= "       .reset-btn:hover {"; 
    $message .= "           box-shadow: 5px 5px 5px lightblue;";
    $message .= "           border: 1px solid black; ";
    $message .= "           color: #000; ";
    $message .= "       }";
    $message .= "       </style>";
    $message .= "   </head>";
    $message .= "   <body>";
    $message .= "     <table>";
    $message .= "        <thead class='greenheader'>";
    $message .= "            <tr>";
    $message .= "                <th>We have received a request to reset your password.<br></th>";
    $message .= "            </tr>";
    $message .= "        </thead>";
    $message .= "        <tbody>";
    $message .= "            <tr>";
    $message .= "                <td>If you are aware of this request, please click on the button below to reset your password.</td>";
    $message .= "            </tr>";
    $message .= "            <tr>";
    $message .= "                <th>";
    $message .= "                    <a  class='reset-btn' href='" . $url . "'>Click to reset password</a>";
    $message .= "                </th>";
    $message .= "            <tr>";
    $message .= "                <td>If clicking the button above does not work, please copy and paste the link below into your web browser.</td>";
    $message .= "            </tr>";
    $message .= "            <tr>";
    $message .= "                <th>";
    $message .= "                    <a href='" . $url . "'>" . $url ."</a>";
    $message .= "                </th>";
    $message .= "            </tr>"; 
    $message .= "            <tr>";
    $message .= "                <td>The link is valid for 30 minutes from the time this email was sent. <br>After this time you will need to make a new request.</td>";
    $message .= "            </tr>";
    $message .= "            <tr>";
    $message .= "                <td>";
    $message .= "                    If you didn't request this email, you need take no action. <br>Simply ignore this message and the link above will expire within 30 minutes.";
    $message .= "                </td>";
    $message .= "            </tr>";
    $message .= "        </tbody>";
    $message .= "     </table>";  
    $message .= "   </body>";
    $message .= "</html>";

    mail($to, $subject, $message , $headers);

    header("Location: ../php/reset-password.php?reset=success");

?>
