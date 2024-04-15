<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/player.php");

/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

  /**
   * Redirects the user to the player-list.php page if the "id" parameter is not set in the GET request or is not numeric.
   */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
  header("Location: " . Utils::$projectFilePath . "/player-list.php");
}

$player = Player::getplayer($_GET["id"]); ///< Get player's details based on their ID number

$pageTitle = "player not found"; ///< Default title

/**
 * Check if the player array is not empty and set the page title to the player's first name.
 */
if (!empty($player)) {
  $pageTitle = $player["first_name"];
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]); ///< Render page header
Components::singleplayer($player); ///< Render card for single player
Components::pageFooter(); ///< Render page footer

?>
