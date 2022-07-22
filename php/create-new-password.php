<?php

    $selector  = $_GET['selector'];
    $validator = $_GET['validator'];
    $error_msg = $_GET['error'];
    
    // there will not be an error message if we are sent to this page from the reset URL 
    // so check that we have valid selector and validator
    if (empty($error_msg)) {

        if ( empty($selector) || empty($validator) ) {
            echo "Could not validate your request";
            exit;
        } else {
            if (ctype_xdigit($selector) == false && ctype_xdigit($validator) == false) {
                echo "Could not validate your request";
                exit;
            }
        }
    }

    // Set the error message to be displayed
    if ($error_msg == "pwdempty") {
        $error_msg = "You cannot submit a blank password";
    } else if ($error_msg == "pwdnotmatch") {
        $error_msg = "Passwords do not match...please try again";
    } 

    // URL the form is submitted to
    $post_url  = "validate-new-password.php";

?>

 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Create New Password</title>
    
         <!-- sets initial scale to 100% -->
        <meta name="viewport" content="width=device-width initial-scale=1">
        
        <script src="https://kit.fontawesome.com/130d5316ba.js" crossorigin="anonymous"></script>

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
        
            <!-- ------------------------------------------------------ -->
            <!-- INCLUDE THE PHP CODE FOR THE NAV MENU                  -->
            <!-- ------------------------------------------------------ -->            
            <!-- <?php include "../inc/nav.level1.inc.php"; ?>          -->
            
        </header>

        <div class="container">
        
            <div class="wrapper centered">

                <h2>Reset Password</h2>
                
                <span class="help-block" <?php echo (!empty($error_msg)) ? 'style="display:block;"' : ''; ?> ><?php echo $error_msg; ?></span>

                <form action="<?php echo $post_url; ?>" method="POST">
                
                    <input type="hidden" name="selector"  value="<?php echo $selector;?>">
                    <input type="hidden" name="validator" value="<?php echo $validator;?>">
                    
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

        <!-- ------------------------------------------------------ -->
        <!-- INCLUDE THE PHP CODE FOR THE FOOTER                    -->
        <!-- ------------------------------------------------------ -->            
        <!-- <?php include "../inc/footer.inc.php"; ?>              -->
            
<!-- ------------------------------------------------------------------------------------------- -->        
<!-- Javascript                                                                                  -->        
<!-- ------------------------------------------------------------------------------------------- -->        

        <script type="text/javascript">
            
            // set focus to meal-filter
            document.getElementById("password").focus();

        </script>
        
    </body>
</html>
