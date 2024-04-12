<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/coach.php");
require("classes/connection.php");
require("classes/sql.php");


/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

/**
 * Check if the user role is not Admin or Coach, and redirect to logout page if true.
 */
if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Redirects back to the coach list page if the 'id' parameter is not set in the GET request or if it is not a numeric value.
 */
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/coach-list.php");
} 

$coach = Coach::getCoach($_GET["id"]); ///< Get coach's details based on ID number.

Components::pageHeader("List of Addresses", ["style"], ["mobile-nav"]); ///< Render page header

Components::singleCoach($coach); ///< Render coach's profile

Components::pageFooter(); ///< Render footer

?>
