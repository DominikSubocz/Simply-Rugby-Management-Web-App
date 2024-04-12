<?php

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/junior.php");

/// This must come first when we need access to the current session
session_start();

/**
 * Check if the user is logged in by verifying the presence of the 'loggedIn' key in the session.
 * If the user is not logged in, redirect to the login page.
 */
if(!isset($_SESSION["loggedIn"])){
  header("Location: " . Utils::$projectFilePath . "/login.php");
}

/**
 * Redirects the user to the junior-list.php page if the "id" parameter is not set in the GET request or is not numeric.
 */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
  header("Location: " . Utils::$projectFilePath . "/junior-list.php");
}



$junior = Junior::getJunior($_GET["id"]); ///< Get Junior details by ID number




$pageTitle = "Junior not found"; ///< Default title

/**
 * Check if the $junior array is not empty and set the $pageTitle to the value of the "first_name" key in the $junior array.
 * 
 * @param array $junior 
 */
if (!empty($junior)) {
  $pageTitle = $junior["first_name"];
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]); ///< Render page header
Components::singleJunior($junior); ///< Render single Junior card
Components::pageFooter(); ///< Render page footer

?>
