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
require("classes/guardian.php");

/**
 * Check if the user is logged in; if not, redirect to login page
 */

 if(!isset($_SESSION["loggedIn"])){
  
  header("Location: " . Utils::$projectFilePath . "/login.php");

} else {
  if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }
  
  /**
  * Check if the user role is not "Admin" and redirect to logout page if true.
  */
  Components::blankPageHeader("Delete guardian", ["style"], ["mobile-nav"]); ///< Doesn't render anything it's just for keeping stylesheets on, etc.
  
  /**
   * Redirects the user back to the guardian-list.php page if the "id" parameter is not set in the GET request or is not numeric.
   */

  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
      header("Location: " . Utils::$projectFilePath . "/guardian-list.php");
    }
    
  
    $guardian = Guardian::getGuardianById($_GET["id"]);  ///< Get details of guardian
    $guardianId = $guardian['guardian_id']; ///< Get ID of that guardian
  
    $pageTitle = "Guardian Deletion";
  
  /**
   * Try to delete an guardian by its ID. If successful, redirect to the guardian list page.
   * If guardian is used elsewhere, error will be thrown.
   *
   * @param int $coachId The ID of the guardian to delete
   */
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
}

?>