<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/events.php");
require("classes/connection.php");
require("classes/sql.php");

/**
 * Redirects to the timetable page if the 'id' parameter is not set in the GET request or if it is not a numeric value.
 */
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/timetable.php");
} 

$session = Events::getSession($_GET["id"]); ///< Get session's details based on ID number.

$pageTitle = "Session not found"; ///< Default page title

/**
 * Sets a page title based on the session name.
 * 
 * @param array $session An array containing session information.
 */
if(!empty($session)){
    $pageTitle = $session["name"] . "Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]); ///< Render page header
?>

<main class="content-wrapper profile-list-content my-5">

<table class="table" id="customDataTable">
  <thead>
    <tr>
      <th class="session-name-label">Session Name</th>
      <th class="coach-label">Coach Organising</th>
      <th class="squad-label">Squad Participating</th>
      <th class="start-date-label">Start Date</th>
      <th class="end-date-label">End Date</th>
      <th class="location-label">Location</th>
    </tr>
  </thead>
  <tbody>

    <?php

    Components::singleSession($session); ///< Render single session
    ?>

  </tbody>
</table>
</main>

<?php

    Components::pageFooter(); ///< Render page footer

?>
