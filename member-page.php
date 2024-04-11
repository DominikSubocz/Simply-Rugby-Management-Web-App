<?php

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/member.php");

/// This must come first when we need access to the current session
session_start();

/**
 * Check if the user is not logged in and redirect to the login page if not.
 */
if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}


/**
 * Check if the "id" parameter is set in the $_GET superglobal and if it is a numeric value.
 * If not, redirect to the junior-list.php page.
 */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
  header("Location: " . Utils::$projectFilePath . "/junior-list.php");
}


$member = Member::getMember($_GET["id"]); ///< Get member's details by their ID

$pageTitle = "player not found"; ///< Default title

/**
 * Check if the $member array is not empty and set the $pageTitle to the value of the "first_name" key in the $member array.
 */
if (!empty($member)) {
  $pageTitle = $member["first_name"];
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]); ///< Render page header
Components::singleMember($member); ///< Render single card of this member
Components::pageFooter(); ///< Render page footer

?>
