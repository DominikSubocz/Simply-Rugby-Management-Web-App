<?php

// This must come first when we need access to the current session
session_start();

require("classes/components.php");

/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");

$output = "";

// Detect if this page has received a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("classes/user.php");

    // Determine which form to work with using the submit button's name
    if (isset($_POST["loginSubmit"])) {
        $output = User::login();
    } elseif (isset($_POST["registerSubmit"])) {
        $output = User::register();
    }
}

Components::pageHeader("Login", ["style"], ["mobile-nav"]);

?>

<h2>Register a new account</h2>

<form method="POST" action="" class="form">
    <label>Username</label>
    <input
        type="text"
        name="username"
        value="<?php

        if ($output && isset($_POST["registerSubmit"]) && isset($_POST["username"])) {
            echo Utils::escape($_POST["username"]);
        }

        ?>"
    >

    <label>Email address</label>
    <input
        type="email"
        name="email"
        value="<?php

        if ($output && isset($_POST["registerSubmit"]) && isset($_POST["email"])) {
            echo Utils::escape($_POST["email"]);
        }

        ?>"
    >

    <label>Password</label>
    <input type="password" name="passwordOne">

    <label>Password (retype)</label>
    <input type="password" name="passwordTwo">

    <input class="button" type="submit" name="registerSubmit" value="Register account">

    <!-- Only output if there is an error in the registration form -->
    <?php if ($output && isset($_POST["registerSubmit"])) { echo $output; } ?>
</form>

<?php

Components::pageFooter();

?>
