<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/coach.php");

session_start();

if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

if($_SESSION["user_role"] != "Admin") {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

Components::blankPageHeader("Delete coach", ["style"], ["mobile-nav"]);

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/coach-list.php");
  }
  
  $coach = Coach::getCoach($_GET["id"]);
  $coachId = $coach['coach_id'];

  $pageTitle = "Coach Deletion";


try{
  Coach::deleteCoach($coachId);
  header("Location: " . Utils::$projectFilePath . "/coach-list.php");

}
 catch(PDOException $e) {
  echo "<div class='alert alert-danger my-3'>
  <p>Error: Cannot delete coach, because it is present in another table!</p>
        <a href='doctor-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
        </div>";
}
?>