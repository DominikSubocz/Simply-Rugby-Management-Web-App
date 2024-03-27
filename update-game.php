<?php

session_start();

require("classes/components.php");
require("classes/utils.php");
require("classes/events.php");
require("classes/connection.php");
require("classes/sql.php");

if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/book-list.php");
} 

$game = Events::getGame($_GET["id"]);

$pageTitle = "Game not found";

if(!empty($game)){
    $pageTitle = $game["name"] . "'s Details";
}


$gameId = Utils::escape($game["game_id"]);
$squadId = Utils::escape($game["squad_id"]);
$gameName = Utils::escape($game["name"]);
$oppositionName = Utils::escape($game["opposition_team"]);
$gameStart = Utils::escape($game["start"]);
$gameEnd = Utils::escape($game["end"]);
$gameLocation = Utils::escape($game["location"]);
$gameKickoff = Utils::escape($game["kickoff_time"]);
$gameResult = Utils::escape($game["result"]);
$gameScore = Utils::escape($game["score"]);

$squad = $name = $opposition = $start = $end = $location = $kickoff = $result = $score = "";
$home = $scoreHome = $commentHome = $scoreOpposition = $commentOpposition = "";

$squadErr = $nameErr = $oppositionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = "";
$homeErr = $scoreHomeErr = $commentHomeErr = $scoreOppositionErr = $commentOppositionErr = "";

$gameHalves = Events::getGameHalves($gameId);

foreach ($gameHalves as $gameHalf){

    $gameHalfId = Utils::escape($gameHalf["game_half_id"]);
    $gameHalfNumber = Utils::escape($gameHalf["half_number"]);
    $homeTeam = Utils::escape($gameHalf["home_team"]);
    $homeScore =  Utils::escape($gameHalf["home_score"]);
    $homeComment = Utils::escape($gameHalf["home_comment"]);
    $oppositionScore = Utils::escape($gameHalf["opposition_score"]);
    $oppositionComment = Utils::escape($gameHalf["opposition_comment"]);

}

$phpStartDate = strtotime( $gameStart );
$ukStartDate = date( 'd/m/Y H:i:sa', $phpStartDate );

$phpEndDate = strtotime( $gameEnd );
$ukEndDate = date( 'd/m/Y H:i:sa', $phpEndDate );


Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<h2>Update Game Details</h2>
<form 
    method="POST"
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $book["player_id"];?>">

  <p class="error"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $gameName;?>" value="<?php echo $name;?>">
      <p class="error"><?php echo $nameErr;?></p><br>

      <label for="sru">SRU Number:</label><br>
      <input type="text" name="sru" placeholder="<?php echo $squadId;?>" value="<?php echo $squad;?>">
      <p class="error"><?php echo $squadErr;?></p><br>

      <label for="dob">Date of Birth:</label><br>
      <input type="text" name="dob" placeholder="<?php echo $phpStartDate;?>" value="<?php echo $start;?>">
      <p class="error"><?php echo $startErr;?></p><br>

      <label for="dob">Date of Birth:</label><br>
      <input type="text" name="dob" placeholder="<?php echo $phpEndDate;?>" value="<?php echo $end;?>">
      <p class="error"><?php echo $endErr;?></p><br>

      <label for="contactNo">Contact Number:</label><br>
      <input type="text" name="contactNo" placeholder="<?php echo $gameLocation;?>" value="<?php echo $location;?>">
      <p class="error"><?php echo $locationErr;?></p><br>

      <label for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" placeholder="<?php echo $gameKickoff;?>" value="<?php echo $kickoff;?>">
      <p class="error"><?php echo $kickoffErr;?></p><br>

      <label for="healthIssues">Health Issues:</label><br>
      <input type="text" name="healthIssues" placeholder="<?php echo $gameResult;?>" value="<?php echo $result;?>">
      <p class="error"><?php echo $resultErr;?></p><br>

      <input type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form" class="add-form-section">



 </div>

 <div id="kin-details-form" class="add-form-section">
    <label for="kin">Next of Kin:</label><br>
        <input type="text" name="kin" placeholder="<?php echo $nextOfKinPlaceholder;?>" value="<?php echo $kin;?>">
        <p class="error"><?php echo $kinErr;?></p><br>

    <label for="kinContact">Contact Number:</label><br>
        <input type="text" name="kinContact" placeholder="<?php echo $kinContactNumberPlaceholder;?>" value="<?php echo $kinContact;?>">
        <p class="error"><?php echo $kinContactErr;?></p><br>   
        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>
 </div>

 <div id="doctor-details-form">
    <label for="doctorName">Doctor Name:</label><br>
        <input type="text" name="doctorName" placeholder="<?php echo $doctorFirstNamePlaceholder. ' '. $doctorLastNamePlaceholder;?>" value="<?php echo $doctorName;?>">
        <p class="error"><?php echo $doctorNameErr;?></p><br>

    <label for="doctorContact">Contact Number:</label><br>
        <input type="text" name="doctorContact" placeholder="<?php echo $doctorContactPlaceholder;?>" value="<?php echo $doctorContact;?>">
        <p class="error"><?php echo $doctorContactErr;?></p><br>   
        <input type="button" value="Previous" onclick="prevTab()">
 </div>

  <input type="submit" name="submit" value="Submit">  

</form>

