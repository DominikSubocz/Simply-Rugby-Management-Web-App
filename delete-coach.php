<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/connection.php");
require("classes/sql.php");
require("classes/coach.php");

/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
} else {
/// Redirect to logout page if user role is neither Admin nor Coach

  if($_SESSION["user_role"] != "Admin") {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }
  
  Components::blankPageHeader("Delete coach", ["style"], ["mobile-nav"]); ///< Doesn't render anything it's just for keeping stylesheets on, etc.
  
  /**
   * Redirects the user back to the coach-list.php page if the "id" parameter is not set in the GET request or is not numeric.
   */
  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
      header("Location: " . Utils::$projectFilePath . "/coach-list.php");
    }
    
    $coach = Coach::getCoach($_GET["id"]); ///< Get details of coach
    $coachId = $coach['coach_id']; ///< Get ID of that coach
  
    $pageTitle = "Coach Deletion";
  
  
  /**
   * Try to delete an coach by its ID. If successful, redirect to the coach list page.
   * If coach is used elsewhere, error will be thrown.
   *
   * @param int $coachId The ID of the coach to delete
   */
  try{
    Coach::deleteCoach($coachId);
    header("Location: " . Utils::$projectFilePath . "/coach-list.php");
  
  }
   catch(PDOException $e) {
    echo "<div class='alert alert-danger my-3'>
    <p>Error: Cannot delete coach, because it is present in another table!</p>
          <a href='coach-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
          </div>";
  }
}


?>