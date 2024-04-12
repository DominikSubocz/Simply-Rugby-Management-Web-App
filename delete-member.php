<?php
/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/member.php");



/**
 * Check if the user is logged in; if not, redirect to login page
 */

if(!isset($_SESSION["loggedIn"])){
  
  header("Location: " . Utils::$projectFilePath . "/login.php");

} else {

/// Redirect to logout page if user role is neither Admin nor Coach

  if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }
  
  /**
   * Redirects the user back to the member-list.php page if the "id" parameter is not set in the GET request or is not numeric.
   */
  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
      header("Location: " . Utils::$projectFilePath . "/member-list.php");
    }
    
  
  
    $member = Member::getMember($_GET["id"]); ///< Get details of member
    $memberId = $member['member_id']; ///< Get ID of that member
  
    $pageTitle = "Junior Deletion";
  
  
  
  /**
   * Try to delete an member by its ID. If successful, redirect to the member list page.
   * If member is used elsewhere, error will be thrown.
   *
   * @param int $memberId The ID of the member to delete
   */
  try{
    Member::deleteMember($memberId);
    header("Location: " . Utils::$projectFilePath . "/member-list.php");
  
  }
   catch(PDOException $e) {
    echo "<div class='alert alert-danger my-3'>
    <p>Error: Cannot delete member, because it is present in another table!</p>
          <a href='member-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
          </div>";
  }
}


?>

