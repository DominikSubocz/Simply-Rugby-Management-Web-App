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

    if(isset($_POST["registerSubmit"])){
        $output = User::register();
    }
}

Components::pageHeader("Register", ["style"], ["mobile-nav"]);

?>

<main class="content-wrapper loginRegister-content">


    <h2>Register a new account</h2>



    <form method="POST" action="" class="form">
        <label class="col-sm-2 col-form-label-sm" >Username</label>
        <input
            type="text"
            name="username"
            value="<?php

            if ($output && isset($_POST["registerSubmit"]) && isset($_POST["username"])) {
                echo Utils::escape($_POST["username"]);
            }

            ?>"
        >

        <label class="col-sm-2 col-form-label-sm">Email address</label>
        <input
            type="email"
            name="email"
            value="<?php

            if ($output && isset($_POST["registerSubmit"]) && isset($_POST["email"])) {
                echo Utils::escape($_POST["email"]);
            }

            ?>"
        >

        <label class="col-sm-2 col-form-label-sm">Password</label>
        <input id="password-field" type="password" name="passwordOne">

        <div class="card py-2 border-2 password-criteria-card">
            <div class="px-2">
                <h3>Your password needs to be: </h3>
            </div>
            <div>
                <ul>
                <li><i class="fa fa-check" aria-hidden="true"></i>Password must be at least 12 characters long.</li>
                <li><i class="fa fa-check" aria-hidden="true"></i>Passwords must match.</li>
                </ul>
            </div>
        </div>

        

        <label class="col-sm-2 col-form-label-sm">Password (retype)</label>
        <input type="password" name="passwordTwo">

        <input class="button" type="submit" name="registerSubmit" value="Register account">

        <!-- Only output if there is an error in the registration form -->
        <?php if ($output && isset($_POST["registerSubmit"])) { echo $output; } ?>
    </form>

</main>

<?php

Components::pageFooter();

?>
