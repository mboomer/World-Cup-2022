<?php

    // checks if session exists
    session_start();

    // if ( isset($_SESSION['session']) ) {
    //     header("location: ../weekly_plan.php");    
    // } else {
    //     // Initialise error messages
    //     $error_msg   = "";
    //     $error_name  = "";
    //     $error_email = "";
    // }

    $post_url  = "../inc/validate-registration.php";

    // default to not displaying an error message block
    $error_code = "nodisplay";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // GET error code from the URL
        $error_code = $_GET['error'];
        // GET error name from the URL
        $error_name = $_GET['name'];
        // GET error email from the URL
        $error_email = $_GET['email'];
        
        // Set the error message to be displayed
        if ($error_code == "accessdenied") {
            $error_msg = "Invalid Access Detected";
        } else if ($error_code == "incomplete") {
            $error_msg = "Please complete all fields";
        } else if ($error_code == "invaliduseremail") {
            $error_msg = "Invalid username and email";
        } else if ($error_code == "passwordmatch") {
            $error_msg = "Passwords dont match";
        } else if ($error_code == "dbconnecterror") {
            $error_msg = "Database connection failed";
        } else if ($error_code == "invalidemail") {
            $error_msg = "Invalid email entered";
        } else if ($error_code == "invalidname") {
            $error_msg = "Username should only contain<br>letters and numbers";
        } else if ($error_code == "sqlexecerror") {
            $error_msg = "Error executing select statement";
        } else if ($error_code == "userexists") {
            $error_msg = "User Name already exists<br>Try a different user name";
        } else if ($error_code == "insertsqlexecerror") {
            $error_msg = "Error inserting record in database ";
        } else if ($error_code == "inserterror") {
            $error_msg = "Failed to insert user : ".$error_name;
        } else if ($error_code == "success") {
            $error_msg = "New account created successfully";
        }
    } 

?>
 <!DOCTYPE html>
<html lang="en">
    <head>

        <title>World Cup 2022 Predictor - Create A New User Account</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width initial-scale=1">
        <meta name="description" content="To play the World Cup Predictor you have to create a user account, create the account with a username and your email address.">

        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

         <link rel="stylesheet" href="../css/styles.css"> 
         <link rel="stylesheet" href="../css/styles-login.css"> 
        
        <style type="text/css">

            /* ********************************************** MEDIA RULES *******************************   */

            /* ******************************************************************************************   */
            /* apply to any device that has a screen width of 576px or higher                               */
            /* ******************************************************************************************   */
            @media screen and (min-width: 576px) {
            }
            /* ******************************************************************************************   */
            /* apply to any device that has a screen width of 768px or higher                               */
            /* ******************************************************************************************   */
            @media screen and (min-width: 768px) {
            }
            /* ******************************************************************************************   */
            /* apply to any device that has a screen width of 992px or higher                               */
            /* ******************************************************************************************   */
            @media screen and (min-width: 992px) {
            }
            /* ******************************************************************************************   */
            /* apply to any device that has a screen width of 1200px or higher                              */
            /* ******************************************************************************************   */
            @media screen and (min-width: 1200px) {
            }
        </style>
    
    </head>

    <body id="body-top">

        <div id="login-container">
            
            <header>
                <?php 
                    $menuitems = array("Home");
                    include '../include/header1.inc.php';
                ?>
            </header>

            <div id="wrapper" class="centered">

                <h2>Create New Account</h2>
                
                <?php
                    if ($error_code == "success") {
                        echo "<span class='help-block-success'>" . $error_msg . "</span>";
                    } else if (!empty($error_code)) {
                        echo "<span class='help-block-failure'>" . $error_msg . "</span>";
                    }
                ?>

                <form action="<?php echo $post_url; ?>" method="POST">
                
                    <div class="input-group">
                        <input type="text" id="username" name="username" placeholder="Username" value="">
                    </div>    

                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email address" value="">
                    </div>    

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password">
                    </div>

                    <div class="input-group">
                        <input type="password" name="repeat-password" placeholder="Repeat Password">
                    </div>

                    <div class="button-group">

                        <div>
                            <input id="create-account-btn" name="create-account-btn" type="submit" class="transparent-btn-blue" value="Create Account">
                        </div>

                    </div>

                    <p style="margin: 10px;">Already created an account? <a href="login.php">Log In</a></p>

                </form>

            </div>  <!--  end of form wrapper div -->  

            <footer id="footer">        
                <?php include "../include/footer.inc.php"; ?>
            </footer>

        </div>  <!--  end of login-container div -->

        <script type="text/javascript" src="../js/header1.js"></script>

        <script type="text/javascript">
            
            // set focus to meal-filter
            document.getElementById("username").focus();

        </script>
        
    </body>
</html>
