<?php

session_start();

require("classes/components.php");
require("classes/utils.php");
require("classes/events.php");
require("classes/connection.php");
require("classes/sql.php");

if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/book-list.php");
} 

$game = Events::getGame($_GET["id"]);

$pageTitle = "Game not found";

if(!empty($game)){
    $pageTitle = $game["name"] . "'s Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);
Components::singleGame($game);
Components::pageFooter();