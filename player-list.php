<?php

session_start();

require("classes/components.php");
require("classes/player.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

?>
<main class="content-wrapper profile-list-content my-5">


<div class="list-controls my-3 mx-auto">
  <h2 class="my-3">Player List</h2>
  <a class="btn btn-dark" href="add-player.php">Add Player</a>
</div>

<div class="player-list">
<div class="player-card column-headings ">
  <div class="id-container card-container">ID</div>
  <div class="firstN-container card-container">Name</div>
  <div class="sru-container card-container">SRU Number</div>
  <div class="dob-container card-container">Date of Birth</div>
  <div class="contactNo-container card-container">Contact Number</div>
  <div class="email-container card-container">Email Address</div>
  <div class="pfp-container card-container">Profile Picture</div>

</div>

  <?php

  // Get all players from the database and output list of players
  $players = player::getAllplayers();
  Components::allplayers($players);

  ?>
</div>
</main>

<?php

Components::pageFooter();

?>
