<?php

// This must come first when we need access to the current session
session_start();

require("classes/components.php");

/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");

// Redirect user from this page if they're already logged in
if (isset($_SESSION["loggedIn"])) {
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
}

$output = "";

// Detect if this page has received a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("classes/user.php");

    if(isset($_POST["loginSubmit"])){
        $output = User::login();
    }

}

Components::pageHeader("Login", ["style"], ["mobile-nav"]);

?>

<main class="content-wrapper loginRegister-content">

    <h2>Log in to an existing account</h2>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form">
        <label class="col-sm-2 col-form-label-sm">Username</label>
        <input
            type="text"
            name="username"
            value="<?php

            /**
             * If there is an error, then the login form was submitted and the username
             * exists, so we can preserve the username in the form.
             *
             * We need to check if the username is set since the previous form
             * submission may have omitted it.
             */
            if ($output && isset($_POST["loginSubmit"]) && isset($_POST["username"])) {
                echo Utils::escape($_POST["username"]);
            }

            ?>"
        >

        <label class="col-sm-2 col-form-label-sm">Password</label>
        <input type="password" name="password">

        <input class="button" type="submit" name="loginSubmit" value="Log in">

        <!-- Only output if there is an error in the registration form -->
        <?php if ($output && isset($_POST["loginSubmit"])) { echo $output; } ?>
    </form>

    <a href="register.php"> Don't have an account? Click this link to register!</a>

</main>

<?php

Components::pageFooter();

?>
