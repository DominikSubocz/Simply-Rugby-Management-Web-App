<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/member.php");

session_start();

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/member-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $member = Member::getMember($_GET["id"]);
  $memberId = $member['member_id'];

  $pageTitle = "Junior Deleted Successfuly";


Member::deleteMember($memberId);

header("Location: " . Utils::$projectFilePath . "/member-list.php");
?>

