<?php

    // checks if session exists
    session_start();

    // $_SESSION["worldcup"]  = true;
    // $_SESSION["loggedin"]  = true;
    // $_SESSION["userid"]    = $userid;                            
    // $_SESSION["username"]  = $username;                            
    // $_SESSION["useremail"] = $email;

    // If logged in store the session variables from session 
    if ( isset($_SESSION['userid']) ) {
        $userid      = $_SESSION["userid"];    
        $username    = $_SESSION["username"]    ; 
        $predictions = $_SESSION["predictions"];    
    }; 

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // GET success/failed code from the URL
        $error_code = $_GET['reset'];
        
        // Set the error message to be displayed
        if ($error_code == "failed") {
            $error_msg = "The password reset request failed.<br>Please try again.";
        } else if ($error_code == "pwdempty") {
            $error_msg = "Please enter your email address";
        } else if ($error_code == "success") {
            $error_msg = "Please check your email for the password reset link";
        }
    } 

    // URL to POST the reset request to
    $post_url  = "../inc/reset-request.php";

?>
 <!DOCTYPE html>
<html lang="en">

    <head>

        <title>World Cup 2022 Predictor - Reset Your Password</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width initial-scale=1">
        <meta name="description" content="Reset a forgotten password by entering your user name and email address. You will receive an email, with a link to click on, that will let you create a new password.">

        <script src="https://kit.fontawesome.com/130d5316ba.js" crossorigin="anonymous"></script>

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

                #container {
                    grid-template-areas:
                            "header"
                            "wrapper"
                            "footer";
                }

        </style>
    
    </head>

    <body id="body-top">

        <header>        
            <?php
                $menuitems = array("Home", "Login"); 
                include "../include/header1.inc.php"; 
            ?>
        </header>

        <div id="login-container">
        
            <div id="wrapper" class="centered">

                <h2>Reset Your Password</h2>
                <p>Enter your email address and click the "Reset Password" button.<br> You will receive an email with instructions to reset your password.</p> 
                
                <?php
                    if ($error_code == "success") {
                        echo "<span class='help-block-success'>" . $error_msg . "</span>";
                    } else if ($error_code == "failed") {
                        echo "<span class='help-block-failure'>" . $error_msg . "</span>";
                    } else if ($error_code == "pwdempty") {
                        echo "<span class='help-block-failure'>" . $error_msg . "</span>";
                    }
                ?>

                <form action="<?php echo $post_url; ?>" method="POST">
                
                    <div class="input-group">
                        <input type="text" id="username" name="username" placeholder="Enter your username" >
                    </div>    

                    <div class="input-group">
                        <input type="text" id="emailaddress" name="emailaddress" placeholder="Enter you email address" >
                    </div>    

                    <div class="button-group">

                        <div>
                            <!-- <button type="submit" id="reset-request-btn" name="reset-request-submit" class="transparent-btn-blue">Send Reset Password Email</button> -->
                            <input type="submit" id="reset-request-btn" name="reset-request-submit" class="transparent-btn-blue" value="Reset Password">
                        </div>

                    </div>

                    <p style="margin: 10px;">Already created an account? <a href="login.php">Log In</a></p>

                </form>

            </div>  <!--  end of form wrapper div -->  

        </div>  <!--  end of container div -->
            
        <footer id="footer">        
            <?php include "../include/footer.inc.php"; ?>
        </footer>

        <script type="text/javascript" src="../js/header1.js"></script>;

        <script type="text/javascript">
            
            // set focus to meal-filter
            document.getElementById("username").focus();

        </script>
        
    </body>

</html>
