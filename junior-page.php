<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/junior.php");

session_start();

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/*
  Attempt to get the id from the URL parameter.
  If it isn't set or it isn't a number, redirect
  to player list page.
*/
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
  header("Location: " . Utils::$projectFilePath . "/junior-list.php");
}

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

$junior = Junior::getJunior($_GET["id"]);



// Set the document title to the title and author of the player if it exists
$pageTitle = "player not found";

if (!empty($junior)) {
  $pageTitle = $junior["first_name"];
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);
Components::singleJunior($junior);
Components::pageFooter();

?>
