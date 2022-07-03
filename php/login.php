<?php

//    // checks if session exists
//    session_start();
//
//    if (isset($_SESSION['mariesmeals'])) {
//        header("location: weekly-plan.php");    
//    } else {
//        // Initialise error message and parameters
//        $error_msg  = "";
//        $error_name = "";
//    }

    $post_url  = "validate-login.php";

    // Processing form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        // GET error code from the URL
        $error_msg = $_GET['error'];
        // GET error name from the URL
        $error_name = $_GET['name'];
        
        // Set the error message to be displayed
        if ($error_msg == "accessdenied") {
            $error_msg = "Invalid Access Detected";
        } else if ($error_msg == "nousernopw") {
            $error_msg = "Please enter a username & password";
        } else if ($error_msg == "nousername") {
            $error_msg = "Please enter a username";
        } else if ($error_msg == "nopassword") {
            $error_msg = "Please enter a password";
        } else if ($error_msg == "dbconnecterror") {
            $error_msg = "Database connection failed";
        } else if ($error_msg == "sqlexecerror") {
            $error_msg = "Error retrieving login details";
        } else if ($error_msg == "invalidpassword") {
            $error_msg = "Password entered is incorrect";
        } else if ($error_msg == "invalidusername") {
            $error_msg = "Username entered is incorrect";
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        
        <title>User Login</title>
    
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
            <!--            <?php include "../inc/nav.level1.inc.php"; ?>-->
            
        </header>

        <div class="container">
            
            <div class="wrapper centered">

                <h2>Login to your account</h2>
                
                <span class="help-block" <?php echo (!empty($error_msg)) ? 'style="display:block;"' : ''; ?> ><?php echo $error_msg; ?></span>

                <form action="<?php echo $post_url; ?>" method="POST">

                    <div class="input-group">
                        <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $error_name; ?>">
                    </div>    

                    <div class="input-group">
                        <input type="password" name="password" placeholder="Password">
                    </div>

                    <div class="button-group">

                        <div>
                            <input id="login-btn" name="login-btn" type="submit" class="transparent-btn-blue" value="Login">
                        </div>

                        <div>
                            <input id="forgot-pw-btn" name="forgot-pw-btn" type="submit" class="transparent-btn-blue" formaction="retrieve-pw.php" value="Forgot Password?">
                        </div>

                    </div>

                    <p style="padding-top: 10px;">Don't have an account? <a href="sign-up.php">Sign up now</a></p>

                </form>

            </div>  <!--  end of form wrapper div -->  

        </div>  <!--  end of container div -->

        <!-- ------------------------------------------------------ -->
        <!-- INCLUDE THE PHP CODE FOR THE FOOTER                    -->
        <!-- ------------------------------------------------------ -->            
        <!--        <?php include "../inc/footer.inc.php"; ?>       -->
            
<!-- ------------------------------------------------------------------------------------------- -->        
<!-- Javascript                                                                                  -->        
<!-- ------------------------------------------------------------------------------------------- -->        

        <script type="text/javascript">
            
            // set focus to meal-filter
            document.getElementById("username").focus();

        </script>
        
    </body>
</html>
