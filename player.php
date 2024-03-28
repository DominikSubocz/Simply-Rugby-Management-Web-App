<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/player.php");

session_start();

/*
  Attempt to get the id from the URL parameter.
  If it isn't set or it isn't a number, redirect
  to player list page.
*/
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
  header("Location: " . Utils::$projectFilePath . "/player-list.php");
}

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

$player = player::getplayer($_GET["id"]);

// Set the document title to the title and author of the player if it exists
$pageTitle = "player not found";

if (!empty($player)) {
  $pageTitle = $player["first_name"];
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);
Components::singleplayer($player);
Components::pageFooter();

?>
