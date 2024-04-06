<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/events.php");

session_start();

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

Components::blankPageHeader("Delete game", ["style"], ["mobile-nav"]);

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/timetable.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $game = Events::getGame($_GET["id"]);
  $gameId = $game['game_id'];

  $pageTitle = "Game Deleted Successfuly";


try{
  Events::deleteGame($gameId);
  header("Location: " . Utils::$projectFilePath . "/timetable.php");

}
 catch(PDOException $e) {
  echo "<div class='alert alert-danger my-3'>
  <p>Error: Cannot delete address, because it is used in another table!</p>
        <a href='timetable.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
        </div>";
}
?>

