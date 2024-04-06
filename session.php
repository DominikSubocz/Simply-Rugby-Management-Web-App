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

$session = Events::getSession($_GET["id"]);

$pageTitle = "Session not found";

if(!empty($session)){
    $pageTitle = $session["name"] . "Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);
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

    Components::singleSession($session);
    ?>

  </tbody>
</table>
</main>

<?php

    Components::pageFooter();

?>
