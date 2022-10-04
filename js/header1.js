    let Menu = document.querySelector("#dropdown-content");
    let PredictionsLink = document.getElementById("predictions-href");

    // ==================================================================
    // add CLICK event listeners for the DOM
    // ==================================================================
    document.addEventListener('click', function (event) {

        // event listener for the hamburger icon
        // hide the Menu if it is displayed
        if (event.target.matches('#hb-icon, #bar1, #bar2, #bar3')) {

            if (Menu.style.display != "block") {
                Menu.style.display = "block";
            } else {
                Menu.style.display = "none";
            }
        } else {
            Menu.style.display = "none";
        }

        // event listener for the home link
        if (event.target.matches('#home-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href="../";
        }

        // event listener for the competition rules link
        if (event.target.matches('#rules-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href="competition-rules.php";
        }

        // event listener for the advice on how to enter predictions link
        if (event.target.matches('#advice-href')) {
            document.querySelector("#dropdown-content").style.display = "none";
            window.location.href="advice.php";
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

                if (Predictions == 1) {
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
