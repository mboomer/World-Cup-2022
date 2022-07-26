<?php

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // GET success/failed code from the URL
        $error_msg = $_GET['reset'];
        
        // Set the error message to be displayed
        if ($error_msg == "failed") {
            $error_msg = "The password reset request failed.<br>Please try again.";
        } else if ($error_msg == "success") {
            $error_msg = "Please check you email for the password reset link";
        } else if ($error_msg == "pwdempty") {
            $error_msg = "Please enter your email address";
        } 
    } 

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

    $post_url  = "reset-request.php";


?>
 <!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Reset Your Password</title>
    
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

                <h2>Reset Your Password</h2>
                <p>You will receive an email with instructions on how to reset your password.</p> 

                <span class="help-block" <?php echo (!empty($error_msg)) ? 'style="display:block;"' : ''; ?> ><?php echo $error_msg; ?></span>

                <form action="<?php echo $post_url; ?>" method="POST">
                
                    <div class="input-group">
                        <input type="text" id="emailaddress" name="emailaddress" placeholder="Enter you email address" >
                    </div>    

                    <div class="button-group">

                        <div>
                            <!-- <button type="submit" id="reset-request-btn" name="reset-request-submit" class="transparent-btn-blue">Send Reset Password Email</button> -->
                            <input type="submit" id="reset-request-btn" name="reset-request-submit" class="transparent-btn-blue" value="Send Reset Password Email">
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
            document.getElementById("username").focus();

        </script>
        
    </body>
</html>
