    let menu = document.querySelector("#dropdown-content");

    // ==================================================================
    // add CLICK event listeners for the DOM
    // ==================================================================
    document.addEventListener('click', function (event) {

        // event listener for the hamburger icon
        // hide the menu if it is displayed
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
            window.location.href = "login.php";
        }

        // event listener for the Register link
        if (event.target.matches('#signup-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href = "sign-up.php";
        }

        // event listener for the User Profile link
        if (event.target.matches('#profile-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href = "user-profile.php";
        }

        // event listener for the Predictions link
        if (event.target.matches('#predictions-href')) {
            document.querySelector("#dropdown-content").style.display = "none";

                if (PredictionsLink == 1) {
                    window.location.href = "saved-predictions.php";
                } else {
                    window.location.href = "predictions.php";
                }

        }

        // event listener for the Logout link
        if (event.target.matches('#logout-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href="../inc/logout.php";
        }

    }, false);   // end of CLICK event listener
