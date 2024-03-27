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

$gameLocation = Utils::escape($game["location"]);
$gameKickoff = Utils::escape($game["kickoff_time"]);
$gameResult = Utils::escape($game["result"]);
$gameScore = Utils::escape($game["score"]);

$squad = $name = $opposition = $start = $end = $location = $kickoff = $result = $score = "";
$home = "";

$squadErr = $nameErr = $oppositionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = "";

$home1 = $home2 = $homeScore1 = $homeScore2 = $homeComment1 = $homeComment2 = $oppositionScore1 = $oppositionScore2 = $oppositionComment1 = $oppositionComment2 = "";

//Game halves error messages
$home1Err = $home2Err = "";
$scoreHome1Err = $commentHome1Err = $scoreOpposition1Err = $commentOpposition1Err = "";
$scoreHome2Err = $commentHome2Err = $scoreOpposition2Err = $commentOpposition2Err = "";


$gameHalves = Events::getGameHalves($gameId);

foreach($gameHalves as $gameHalf){
    $gameHalfNumber = Utils::escape($gameHalf["half_number"]);
}

$gameHalfId1 = Utils::escape($gameHalves[0]["game_half_id"]);
$gameHalfId2 = Utils::escape($gameHalves[1]["game_half_id"]);



Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    // Validate squad
    if (empty($_POST["squad"])) {
        $squadErr = "Name is required";
    } else {
        $squad = test_input($_POST["squad"]);
    }

    // Validate opposition
    if (empty($_POST["opposition"])) {
        $oppositionErr = "Name is required";
    } else {
        $opposition = test_input($_POST["opposition"]);
    }

    if (empty($_POST["start"])) {
        $startErr = "Name is required";
    } else {
        $start = test_input($_POST["start"]);
        
        $sqlStart = date('Y-m-d H:i:sa', strtotime($start));

    }

    if (empty($_POST["end"])) {
        $endErr = "Name is required";
    } else {
        $end = test_input($_POST["end"]);

        $sqlEnd = date('Y-m-d H:i:sa', strtotime($end));

    }

    if (empty($_POST["location"])) {
        $locationErr = "Name is required";
    } else {
        $location = test_input($_POST["location"]);
    }

    if (empty($_POST["kickoff"])) {
        $kickoffErr = "Name is required";
    } else {
        $kickoff = test_input($_POST["kickoff"]);
    }

    if (empty($_POST["result"])) {
        $resultErr = "Name is required";
    } else {
        $result = test_input($_POST["result"]);
    }

    if (empty($_POST["score"])) {
        $scoreErr = "Score is required";
    } else {
        $score = test_input($_POST["score"]);
    }

    // Game Halves Validation

    if (empty($_POST["home_team_1"])) {
        $home1Err = "Score is required";
    } else {
        $home1 = test_input($_POST["home_team_1"]);
    } 

    if (empty($_POST["home_score_1"])) {
        $scoreHome1Err = "Score is required";
    } else {
        $homeScore1 = test_input($_POST["home_score_1"]);
    } 

    if (empty($_POST["home_comment_1"])) {
        $commentHome1Err = "Score is required";
    } else {
        $homeComment1 = test_input($_POST["home_comment_1"]);
    } 

    if (empty($_POST["opposition_score_1"])) {
        $scoreOpposition1Err = "Score is required";
    } else {
        $oppositionScore1 = test_input($_POST["opposition_score_1"]);
    } 

    if (empty($_POST["opposition_comment_1"])) {
        $commentOpposition1Err = "Score is required";
    } else {
        $oppositionComment1 = test_input($_POST["opposition_comment_1"]);
    } 


    if (empty($_POST["home_team_2"])) {
        $home2Err = "Score is required";
    } else {
        $home2 = test_input($_POST["home_team_2"]);
    } 

    
    if (empty($_POST["home_score_2"])) {
        $scoreHome2Err = "Score is required";
    } else {
        $homeScore2 = test_input($_POST["home_score_2"]);
    } 

    if (empty($_POST["home_comment_2"])) {
        $commentHome2Err = "Score is required";
    } else {
        $homeComment2 = test_input($_POST["home_comment_2"]);
    } 

    if (empty($_POST["opposition_score_2"])) {
        $scoreOpposition2Err = "Score is required";
    } else {
        $oppositionScore2 = test_input($_POST["opposition_score_2"]);
    } 

    if (empty($_POST["opposition_comment_2"])) {
        $commentOpposition2Err = "Score is required";
    } else {
        $oppositionComment2 = test_input($_POST["opposition_comment_2"]);
    } 

    if (empty($nameErr) && empty($squadErr) && empty($startErr) && empty($endErr) && empty($locationErr) && empty($kickoffErr) && empty($resultErr) && empty($scoreErr) && empty($home1Err) && empty($scoreHome1Err) && empty($commentHome1Err) && empty($scoreOpposition1Err) && empty($commentOpposition1Err) && empty($home2Err) && empty($scoreHome2Err) && empty($commentHome2Err) && empty($scoreOpposition2Err) && empty($commentOpposition2Err)) {

        Events::updateGame($squad, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId);

        Events::updateGameHalf($gameHalfId1, $home1, $homeScore1, $homeComment1, $opposition, $oppositionScore1, $oppositionComment1);

        Events::updateGameHalf($gameHalfId2, $home2, $homeScore2, $homeComment2, $opposition, $oppositionScore2, $oppositionComment2);

        var_dump($gameHalfId2);
    }
    }


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
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $game["game_id"];?>">


  
  <div id="basic-game-details">
      <label for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $gameName;?>" value="<?php echo $name;?>">
      <p class="error"><?php echo $nameErr;?></p><br>

      <label for="squad">Squad Number:</label><br>
      <input type="text" name="squad" placeholder="<?php echo $squadId;?>" value="<?php echo $squad;?>">
      <p class="error"><?php echo $squadErr;?></p><br>

      <label for="opposition">Opposition Team:</label><br>
      <input type="text" name="opposition" placeholder="<?php echo $oppositionName;?>" value="<?php echo $opposition;?>">
      <p class="error"><?php echo $oppositionErr;?></p><br>

      <label for="start">Start Date:</label><br>
      <input type="datetime-local" name="start" placeholder="<?php echo $start;?>" value="<?php echo $start;?>">
      <p class="error"><?php echo $startErr;?></p><br>

      <label for="end">End Date:</label><br>
      <input type="datetime-local" name="end" placeholder="<?php echo $end;?>" value="<?php echo $end;?>">
      <p class="error"><?php echo $endErr;?></p><br>

      <label for="location">Game Location:</label><br>
      <input type="text" name="location" placeholder="<?php echo $gameLocation;?>" value="<?php echo $location;?>">
      <p class="error"><?php echo $locationErr;?></p><br>

      <label for="kickoff">Kickoff Time:</label><br>
      <input type="time" name="kickoff" placeholder="<?php echo $gameKickoff;?>" value="<?php echo $kickoff;?>">
      <p class="error"><?php echo $kickoffErr;?></p><br>

      <label for="result">Final Result:</label><br>
      <input type="text" name="result" placeholder="<?php echo $gameResult;?>" value="<?php echo $result;?>">
      <p class="error"><?php echo $resultErr;?></p><br>

      <label for="score">Final Score:</label><br>
      <input type="text" name="score" placeholder="<?php echo $gameScore;?>" value="<?php echo $score;?>">
      <p class="error"><?php echo $scoreErr;?></p><br>

      <input type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="game-half-form">
      <?php foreach ($gameHalves as $gameHalf): ?>
        <div class="game-half">
            <h3>Game Half <?php echo $gameHalf["half_number"]; ?></h3>
            <!-- Home team bit -->
            <label for="home_team_<?php echo $gameHalf["half_number"]; ?>">Home Team:</label><br>
            <input type="text" name="home_team_<?php echo $gameHalf["half_number"]; ?>" value="<?php if ($gameHalf["half_number"] == 1){echo $home1;}else{echo $home2;}?>"><br>
      
            <?php if ($gameHalf["half_number"] == 1){
                ?>
                <p class="error"><?php echo $home1Err;?></p><br>
                <?php
            } else {
                ?>
                <p class="error"><?php echo $home2Err;?></p><br>
                <?php
            }?>
            <label for="home_score_<?php echo $gameHalf["half_number"]; ?>">Home Score:</label><br>
            <input type="text" name="home_score_<?php echo $gameHalf["half_number"]; ?>" value="<?php if ($gameHalf["half_number"] == 1){echo $homeScore1;}else{echo $homeScore2;}?>"><br>
            <?php if ($gameHalf["half_number"] == 1){
                ?>
                <p class="error"><?php echo $scoreHome1Err;?></p><br>
                <?php
            } else {
                ?>
                <p class="error"><?php echo $scoreHome2Err;?></p><br>
                <?php
            }?>
            <label for="home_comment_<?php echo $gameHalf["half_number"]; ?>">Home Comment:</label><br>
            <input type="text" name="home_comment_<?php echo $gameHalf["half_number"]; ?>" value="<?php if ($gameHalf["half_number"] == 1){echo $homeComment1;}else{echo $homeComment2;}?>"><br>
            <?php if ($gameHalf["half_number"] == 1){
                ?>
                <p class="error"><?php echo $commentHome1Err;?></p><br>
                <?php
            } else {
                ?>
                <p class="error"><?php echo $commentHome2Err;?></p><br>
                <?php
            }?>
            <!-- Opposition team bit -->
            <label for="opposition_score_<?php echo $gameHalf["half_number"]; ?>">Opposition Score:</label><br>
            <input type="text" name="opposition_score_<?php echo $gameHalf["half_number"]; ?>" value="<?php if ($gameHalf["half_number"] == 1){echo $oppositionScore1;}else{echo $oppositionScore2;}?>"><br>
            <?php if ($gameHalf["half_number"] == 1){
                ?>
                <p class="error"><?php echo $scoreOpposition1Err;?></p><br>
                <?php
            } else {
                ?>
                <p class="error"><?php echo $scoreOpposition2Err;?></p><br>
                <?php
            }?>
            <label for="opposition_comment_<?php echo $gameHalf["half_number"]; ?>">Opposition Comment:</label><br>
            <input type="text" name="opposition_comment_<?php echo $gameHalf["half_number"]; ?>" value="<?php if ($gameHalf["half_number"] == 1){echo $oppositionComment1;}else{echo $oppositionComment2;}?>"><br>
            <?php if ($gameHalf["half_number"] == 1){
                ?>
                <p class="error"><?php echo $commentOpposition1Err;?></p><br>
                <?php
            } else {
                ?>
                <p class="error"><?php echo $commentOpposition2Err;?></p><br>
                <?php
            }?>
      
        </div>
      <?php endforeach; ?>

      <input type="button" value="Previous" onclick="prevTab()">

  </div>
  <input type="submit" name="submit" value="Submit">  


</form>

<script>

    var currentTab = 0;
    const basicDetails = document.getElementById("basic-game-details");
    const halfDetails = document.getElementById("game-half-form");

    showTab();

    function nextTab(){
        currentTab += 1;
        showTab();
    }

    function prevTab(){
        currentTab -= 1;
        showTab();
    }

    function showTab(){
        if ( currentTab == 0){
            basicDetails.style.display = "block";
            halfDetails.style.display = "none";

        }

        else{
            basicDetails.style.display = "none";
            halfDetails.style.display = "block";

        }
    }


</script>

