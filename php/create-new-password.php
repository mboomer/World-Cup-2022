<?php

    $selector   = $_GET['selector'];
    $validator  = $_GET['validator'];
    $user       = $_GET['usr'];
    $error_code = $_GET['error'];
    
    /**
    * cannot call this page directly, must be called from either the reset URL with the correct parameters 
    * or returned to here with an error message from validate-new-password
    */
    if (empty($error_code) && empty($selector) && empty($validator) && empty($user)) {
        header("Location: ../index.php");
        exit;
    }

    // there will not be an error message if we are sent to this page from the reset URL 
    // check that we have valid selector and validator
    if (empty($error_code)) {

        if ( empty($selector) || empty($validator) ) {            
            header("Location: ../index.php");
            exit;
        } else {
            if (ctype_xdigit($selector) === false || ctype_xdigit($validator) === false) {
                header("Location: ../index.php");
                exit;
            }
        }
    }

    // Set the error message to be displayed
    if ($error_code == "pwdempty") {
        $error_msg = "You cannot submit a blank password";
    } else if ($error_code == "pwdnotmatch") {
        $error_msg = "Passwords do not match...please try again";
    } else if ($error_code == "invalid") {
        $error_msg = "A valid reset request has not been found.<br>Please click on the reset link in your email and try again.";
    } else if ($error_code == "invalid-request") {
        $error_msg = "A valid reset request has not been found.<br>Please submit a new reset request from the login page.";
    } else if ($error_code == "expired") {
        $error_msg = "Your password reset request has expired. Please re-submit a new reset request";
    } else if ($error_code == "userpwfail") {
        $error_msg = "No Update to the your password was possible.<br>Please make a new reset request from the login page.";
    } else if ($error_code == "deletefail") {
        $error_msg = "Failed to delete reset request.<br>You should still be able to login.<br>Please contact support if you experience any issues.";
    } else if ($error_code == "success") {
        $error_msg = "Your password has been reset.<br>Please return to login page to login in.";
    }

    // URL the form is submitted to
    $post_url  = "../inc/validate-new-password.php";

?>

 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Create New Password</title>
    
         <!-- sets initial scale to 100% -->
        <meta name="viewport" content="width=device-width initial-scale=1">
        
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

        <header>        
            <?php include "../include/header1.inc.php"; ?>
        </header>

        <div id="login-container">
        
            <div id="wrapper" class="centered">

                <h2>Reset Password</h2>
                
                <?php
                    if ($error_code == "success") {
                        echo "<span class='help-block-success'>" . $error_msg . "</span>";
                    } else if ($error_code != "") {
                        echo "<span class='help-block-failure'>" . $error_msg . "</span>";
                    } 
                ?>
                
                <form action="<?php echo $post_url; ?>" method="POST">
                
                    <input type="hidden" name="selector"  value="<?php echo $selector;?>">
                    <input type="hidden" name="validator" value="<?php echo $validator;?>">
                    <input type="hidden" name="username"  value="<?php echo $user;?>">
                    
                    <div>
                        <?php echo 'User Name : ' . htmlspecialchars($user); ?>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" name="password" placeholder="Enter New Password">
                    </div>

                    <div class="input-group">
                        <input type="password" id="repeat-password" name="repeat-password" placeholder="Repeat New Password">
                    </div>

                    <div class="button-group">

                        <div>
                            <input id="reset-password-submit-btn" name="reset-password-submit" type="submit" class="transparent-btn-blue" value="Reset Password">
                        </div>

                    </div>

                    <p style="margin: 10px;">Already created an account? <a href="login.php">Log In</a></p>

                </form>

            </div>  <!--  end of form wrapper div -->  

        </div>  <!--  end of container div -->

        <footer id="footer">        
            <?php include "../include/footer.inc.php"; ?>
        </footer>

        <script type="text/javascript">
            
            // set focus to meal-filter
            document.getElementById("password").focus();

        </script>
        
    </body>
</html>
