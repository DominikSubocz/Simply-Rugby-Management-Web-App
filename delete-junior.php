<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/junior.php");

session_start();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/junior-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $junior = Junior::getJunior($_GET["id"]);
  $juniorId = $junior['junior_id'];

  $pageTitle = "Junior Deleted Successfuly";


Junior::deleteJunior($juniorId);

header("Location: " . Utils::$projectFilePath . "/junior-list.php");
?>

