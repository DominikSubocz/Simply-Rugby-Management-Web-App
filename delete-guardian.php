<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/guardian.php");

session_start();

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

Components::blankPageHeader("Delete guardian", ["style"], ["mobile-nav"]);

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/guardian-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $guardian = Guardian::getGuardianById($_GET["id"]);
  $guardianId = $guardian['guardian_id'];

  $pageTitle = "Guardian Deleted Successfuly";


try{
  Guardian::deleteGuardian($guardianId);
  header("Location: " . Utils::$projectFilePath . "/guardian-list.php");

}
 catch(PDOException $e) {
  echo "<div class='alert alert-danger my-3'>
  <p>Error: Cannot delete guardian, because it is present in another table!</p>
        <a href='guardian-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
        </div>";
}
?>