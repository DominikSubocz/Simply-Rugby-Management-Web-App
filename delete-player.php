<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/player.php");

session_start();

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $player = Player::getplayer($_GET["id"]);
  $playerId = $player['player_id'];

  $pageTitle = "Player Deletion";

if (!empty($player)) {
  $pageTitle = $player["first_name"];
}

Player::deletePlayer($playerId);

header("Location: " . Utils::$projectFilePath . "/player-list.php");
?>

