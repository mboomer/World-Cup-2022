    let menu = document.querySelector("#dropdown-content");

    // ==================================================================
    // add CLICK event listeners for the DOM
    // ==================================================================
    document.addEventListener('click', function (event) {

        // event listener for the hamburger icon
        if (event.target.matches('#hb-icon, #bar1, #bar2, #bar3')) {

            if (menu.style.display != "block") {
                menu.style.display = "block";
            } else {
                menu.style.display = "none";
            }
        } else {
            menu.style.display = "none";
        }

        // event listener for the home link
        if (event.target.matches('#home-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href="../";
        }

        // event listener for the login link
        if (event.target.matches('#login-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href = "php/login.php";
        }

        // event listener for the Register link
        if (event.target.matches('#signup-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href = "php/sign-up.php";
        }

        // event listener for the User Profile link
        if (event.target.matches('#profile-href')) {

            console.log("User Profile CLicked");
            
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href = "php/user-profile.php";
        }

        // event listener for the Predictions link
        if (event.target.matches('#predictions-href')) {
            document.querySelector("#dropdown-content").style.display = "none";

                // pass php session variable to JS variable
                PredictionsLink = "<?=$predictions?>";                                             

                if (PredictionsLink == 1) {
                    window.location.href = "php/saved-predictions.php";
                } else {
                    window.location.href = "php/predictions.php";
                }

        }

        // event listener for the Logout link
        if (event.target.matches('#logout-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href="inc/logout.php";
        }

    }, false);   // end of CLICK event listener
