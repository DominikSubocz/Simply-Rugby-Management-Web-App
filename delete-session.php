<?php
/// This must come first when we need access to the current session
session_start();

require ("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require ("classes/utils.php");
require ("classes/connection.php");
require ("classes/sql.php");
require ("classes/events.php");


/**
 * Check if the user is logged in; if not, redirect to login page
 */
if (!isset($_SESSION["loggedIn"])) {

  header("Location: " . Utils::$projectFilePath . "/login.php");

} else {
  /// Redirect to logout page if user role is neither Admin nor Coach

  if (($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

  Components::blankPageHeader("Delete session", ["style"], ["mobile-nav"]); ///< Doesn't render anything it's just for keeping stylesheets on, etc.

  /**
   * Redirects the user back to the timetable.php page if the "id" parameter is not set in the GET request or is not numeric.
   */
  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/timetable.php");
  }



  $session = Events::getSession($_GET["id"]); ///< Get details of training session
  $sessionId = $session['session_id']; ///< Get ID of that session

  $pageTitle = "Training Session Deletion";



  /**
   * Try to delete an session by its ID. If successful, redirect to the session list page.
   * If session is used elsewhere, error will be thrown.
   *
   * @param int $sessionId The ID of the session to delete
   */


  try {
    Events::deleteSession($sessionId);
    header("Location: " . Utils::$projectFilePath . "/timetable.php");

  } catch (PDOException $e) {
    echo "<div class='alert alert-danger my-3'>
    <p>Error: Cannot delete training session, because it is used in another table!</p>
          <a href='timetable.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
          </div>";
  }
}
?>