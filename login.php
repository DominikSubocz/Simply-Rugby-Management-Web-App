<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");

/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");

/// Redirect user from this page if they're already logged in
if (isset($_SESSION["loggedIn"])) {
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
}

$output = "";

/// Detect if this page has received a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("classes/user.php");

    if(isset($_POST["loginSubmit"])){
        $output = User::login();
    }

}

Components::pageHeader("Login", ["style"], ["mobile-nav"]);

?>

<main class="content-wrapper loginRegister-content my-5">

    <h2>Log in to an existing account</h2>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form">
        <label class="col-sm-2 col-form-label-sm">Username</label>
        <input
            type="text"
            name="username"
            value="<?php


            /**
             * Check if $output is true and if the "loginSubmit" and "username" keys are set in the $_POST array.
             * If conditions are met, echo the escaped value of the "username" key using the Utils::escape method.
             *
             */
            if ($output && isset($_POST["loginSubmit"]) && isset($_POST["username"])) {
                echo Utils::escape($_POST["username"]);
            }

            ?>"
        >

        <label class="col-sm-2 col-form-label-sm">Password</label>
        <input type="password" name="password">

        <input class="btn btn-dark" type="submit" name="loginSubmit" value="Log in">

        <!-- Only output if there is an error in the registration form -->
        <?php if ($output && isset($_POST["loginSubmit"])) { echo $output; } ?>
        <a class="btn btn-secondary" href="register.php"> Don't have an account? Click this link to register!</a>

    </form>


</main>

<?php

Components::pageFooter();

?>
