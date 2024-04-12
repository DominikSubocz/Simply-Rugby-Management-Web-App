<?php
/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/player.php");


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

  Components::blankPageHeader("Delete player", ["style"], ["mobile-nav"]); ///< Doesn't render anything it's just for keeping stylesheets on, etc.

  
  /**
  * Redirects the user back to the player-list.php page if the "id" parameter is not set in the GET request or is not numeric.
  */
  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
      header("Location: " . Utils::$projectFilePath . "/player-list.php");
    }
    
  
  
    $player = Player::getplayer($_GET["id"]); ///< Get details of player
    $playerId = $player['player_id']; ///< Get ID of that player
  
    $pageTitle = "Player Deletion";
  
  if (!empty($player)) {
    $pageTitle = $player["first_name"];
  }
  
  
  /**
   * Try to delete an player by its ID. If successful, redirect to the player list page.
   * If player is used elsewhere, error will be thrown.
   *
   * @param int $coachId The ID of the player to delete
   */  
  try{
    Player::deletePlayer($playerId);
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
  
  }
   catch(PDOException $e) {
    echo "<div class='alert alert-danger my-3'>
    <p>Error: Cannot delete player, because it is present in another table!</p>
          <a href='player-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
          </div>";
  }
}
?>

