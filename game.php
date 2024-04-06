<?php

session_start();

require("classes/components.php");
require("classes/utils.php");
require("classes/events.php");
require("classes/connection.php");
require("classes/sql.php");

if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
} 

$game = Events::getGame($_GET["id"]);

$pageTitle = "Game not found";

if(!empty($game)){
    $pageTitle = $game["name"] . "'s Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);
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

        Components::singleGame($game);
    ?>

  </tbody>
</table>
</main>

<?php

    Components::pageFooter();

?>