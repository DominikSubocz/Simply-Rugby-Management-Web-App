<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");

/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");

$output = ""; ///< Store output of register

/**
 * If the register form is submitted, it calls the register method of the User class.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require("classes/user.php");

    if(isset($_POST["registerSubmit"])){
        $output = User::register(); ///< Any errors will be returned if any input field is not valid
    }
}

Components::pageHeader("Register", ["style"], ["mobile-nav"]); ///< Render page header

?>

<main class="content-wrapper loginRegister-content my-5">


    <h2>Register a new account</h2>
    <form method="POST" action="" class="form">
        <label class="col-sm-2 col-form-label-sm" >Username</label>
        <input
            type="text"
            name="username"
            value="<?php

            /**
             * Echoes escaped "username" if $output is true and "registerSubmit" and "username" keys are set in $_POST.
             */
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
        <input id="password-field" type="password" class=" password-field" name="passwordOne" oninput="checkPasswordCriteria()"> 

        <div id="criteria-box" class="py-2 password-criteria-card">
            <div class="px-2">
                <h3>Your password needs to be: </h3>
            </div>
            <div>
                <ul>
                <li id="password-length-box"><i id="length-mark" class="fa fa-times" aria-hidden="true"></i>Password must be at least 12 characters long.</li>
                <li id="password-match-box"><i id="match-mark" class="fa fa-times" aria-hidden="true"></i>Passwords must match.</li>
                </ul>
            </div>
        </div>

        

        <label class="col-sm-2 col-form-label-sm">Password (retype)</label>
        <input id="password-field-two" class=" password-field" type="password"oninput="checkPasswordCriteria()" name="passwordTwo">

        <input class="btn btn-dark" type="submit" name="registerSubmit" onclick="return validateRegister()" value="Register account">

        <!-- Only output if there is an error in the registration form -->
        <?php if ($output && isset($_POST["registerSubmit"])) { echo $output; } ?>
    </form>

</main>

<script>

/**
 * Check the criteria of the password and update icons accordingly
 */
function checkPasswordCriteria(){
    let password = document.forms[0]["passwordOne"].value.trim();
    let password2 = document.forms[0]["passwordTwo"].value.trim();

    var lengthLi = document.getElementById("password-length-box");
    var matchLi = document.getElementById("password-match-box");

    var mark = document.getElementById("length-mark");
    var mark2 = document.getElementById("match-mark");

    if(password.length > 12){
        lengthLi.classList.remove("wrong");
        mark.classList.remove("fa-times");
        mark.classList.add("fa-check");
        lengthLi.classList.add("correct");

    } else {
        lengthLi.classList.remove("correct");
        lengthLi.classList.add("wrong");
        mark.classList.remove("fa-check");
        mark.classList.add("fa-times");

    }

    if (password === '' || password !== password2) {
        matchLi.classList.remove("correct");
        matchLi.classList.add("wrong");
        mark2.classList.remove("fa-check");
        mark2.classList.add("fa-times");

    } else {
        matchLi.classList.remove("wrong");
        matchLi.classList.add("correct");
        mark2.classList.remove("fa-times");
        mark2.classList.add("fa-check");
    }
} 

checkPasswordCriteria();

/**
 * Validates a form with multiple input fields.
 */
function validateRegister(){

    let username = document.forms[0]["username"].value.trim();
    let email = document.forms[0]["email"].value.trim();
    let password = document.forms[0]["passwordOne"].value.trim();
    let password2 = document.forms[0]["passwordTwo"].value.trim();

    if (username === "") {
        alert("Username must be filled out");
        return false;
    }

    if (email === "") {
        alert("Email must be filled out");
        return false;
    }

    if (password === "") {
        alert("Password must be filled out");
        return false;
    }

    if (password2 === "") {
        alert("Password Two must be filled out");
        return false;
    }



}

</script>
<?php

Components::pageFooter(); ///< Render page footer

?>
