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
 * Redirects to the timetable page if the 'id' parameter is not set or is not numeric.
 */
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/timetable.php");
} 

$game = Events::getGame($_GET["id"]); ///< Get game details by ID

$pageTitle = "Game not found"; ///< Default title

/**
 * Set the page title to display the details of the game if the game array is not empty.
 *
 * @param array $game The game array containing the game details.
 */
if(!empty($game)){
    $pageTitle = $game["name"] . "'s Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]); ///< Render page header
?>



<main class="content-wrapper profile-list-content my-5">
<table class="table" id="customDataTable">
  <thead>
    <tr>
      <th class="game-name-label">Game Name</th>
      <th class="squad-label">Home Team</th>
      <th class="opposition-label">Opposition Team</th>
      <th class="start-date-label">Start Date</th>
      <th class="end-date-label">End Date</th>
      <th class="location-label">Location</th>
      <th class="kickoff-label">Kickoff Time</th>
      <th class="result-label">Result</th>
      <th class="score-label">Score</th>
    </tr>
  </thead>
  <tbody>

    <?php

        Components::singleGame($game); ///< Render single game card
    ?>

  </tbody>
</table>
</main>

<?php

    Components::pageFooter(); ///< Render page footer

?>