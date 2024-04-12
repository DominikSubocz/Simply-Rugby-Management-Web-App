<?php

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/junior.php");

/// This must come first when we need access to the current session
session_start();

/**
 * Check if the user is logged in by verifying the presence of the 'loggedIn' key in the session.
 * If the user is not logged in, redirect to the login page.
 * 
 * If the user is logged in check priveledge level, and proceed.
 */
if(!isset($_SESSION["loggedIn"])){
  
  header("Location: " . Utils::$projectFilePath . "/login.php");

} else{

/**
 * Check if the user role is not Admin or Coach, then redirect to logout page.
 */
  if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

  Components::blankPageHeader("Delete junior", ["style"], ["mobile-nav"]); ///< Doesn't render anything it's just for keeping stylesheets on, etc.

  /**
   * Redirects the user back to the junior-list.php page if the "id" parameter is not set in the GET request or is not numeric.
   */
  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
      header("Location: " . Utils::$projectFilePath . "/junior-list.php");
    }
    
  
  
    $junior = Junior::getJunior($_GET["id"]); ///< Get details of junior
    $juniorId = $junior['junior_id']; ///< Get ID of that junior
  
    $pageTitle = "Junior Deletion";
  
  /**
   * Try to delete an junior by its ID. If successful, redirect to the junior list page.
   * If an exception of type PDOException is caught, display an error message and a link to go back to the junior list page.
   *
   * @param int $juniorId The ID of the junior to delete
   */

  try{
    Junior::deleteJunior($juniorId);
    header("Location: " . Utils::$projectFilePath . "/junior-list.php");
  }  catch(PDOException $e) {
        echo "<div class='alert alert-danger my-3'>
        <p>Error: Cannot delete junior, because it is present in another table!</p>
        <a href='junior-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
        </div>";
  }
}


?>

