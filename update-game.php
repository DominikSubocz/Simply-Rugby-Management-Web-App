<?php

session_start();

require("classes/components.php");
require("classes/utils.php");
require("classes/events.php");
require("classes/connection.php");
require("classes/sql.php");

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
} 

$game = Events::getGame($_GET["id"]);
$pageTitle = "Game not found";

if(!empty($game)){
    $pageTitle = $game["name"] . "'s Details";
}

$conn = Connection::Connect();

$stmt = $conn->prepare(SQL::$getSquads);
$stmt->execute();
$squads = $stmt->fetchAll();


$gameId = Utils::escape($game["game_id"]);
$squadId = Utils::escape($game["squad_id"]);
$gameName = Utils::escape($game["name"]);
$oppositionName = Utils::escape($game["opposition_team"]);
$gameStartPlaceholder = Utils::escape($game["start"]);
$gameEndPlaceholder = Utils::escape($game["end"]);

$gameLocation = Utils::escape($game["location"]);
$gameKickoff = Utils::escape($game["kickoff_time"]);
$gameResult = Utils::escape($game["result"]);
$gameScore = Utils::escape($game["score"]);

$squad = $name = $opposition = $start = $end = $location = $kickoff = $result = $score = "";
$home = "";

$squadErr = $nameErr = $oppositionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = $homeErr = "";

$homeScore1 = $homeScore2 = $homeComment1 = $homeComment2 = $oppositionScore1 = $oppositionScore2 = $oppositionComment1 = $oppositionComment2 = "";

///Game halves error messages
$scoreHome1Err = $commentHome1Err = $scoreOpposition1Err = $commentOpposition1Err = "";
$scoreHome2Err = $commentHome2Err = $scoreOpposition2Err = $commentOpposition2Err = "";


$gameHalves = Events::getGameHalves($gameId);

foreach($gameHalves as $gameHalf){
    $gameHalfNumber = Utils::escape($gameHalf["half_number"]);
    $homeTeam = Utils::escape($gameHalf["home_team"]);
}

$homeScorePlaceholder1 = Utils::escape($gameHalves[0]["home_score"]);
$homeScorePlaceholder2 = Utils::escape($gameHalves[1]["home_score"]);

$homeCommentPlaceholder1 = Utils::escape($gameHalves[0]["home_comment"]);
$homeCommentPlaceholder2 = Utils::escape($gameHalves[1]["home_comment"]);

$oppositionScorePlaceholder1 = Utils::escape($gameHalves[0]["opposition_score"]);
$oppositionScorePlaceholder2 = Utils::escape($gameHalves[1]["opposition_score"]);

$oppositionCommentPlaceholder1 = Utils::escape($gameHalves[0]["opposition_comment"]);
$oppositionCommentPlaceholder2 = Utils::escape($gameHalves[1]["opposition_comment"]);

$gameHalfId1 = Utils::escape($gameHalves[0]["game_half_id"]);
$gameHalfId2 = Utils::escape($gameHalves[1]["game_half_id"]);



Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $name = $gameName;
    } else {
        $name = test_input($_POST["name"]);
    }

    /// Validate squad
    if (empty($_POST["squad"])) {
        $squad = $homeTeam;
    } else {
        $squad = test_input($_POST["squad"]);
    }

    /// Validate opposition
    if (empty($_POST["opposition"])) {
        $opposition = $oppositionName;
    } else {
        $opposition = test_input($_POST["opposition"]);
    }

    if (empty($_POST["start"])) {
        $start = $gameStartPlaceholder;
    } else {
        $start = test_input($_POST["start"]);
        
        $sqlStart = date('Y-m-d H:i:sa', strtotime($start));

    }

    if (empty($_POST["end"])) {
        $end = $gameEndPlaceholder;
    } else {
        $end = test_input($_POST["end"]);

        $sqlEnd = date('Y-m-d H:i:sa', strtotime($end));

    }

    if (empty($_POST["location"])) {
        $location = $gameLocation;
    } else {
        $location = test_input($_POST["location"]);
    }

    if (empty($_POST["kickoff"])) {
        $kickoff = $gameKickoff;
    } else {
        $kickoff = test_input($_POST["kickoff"]);
    }

    if (empty($_POST["result"])) {
        $result = $gameResult;
    } else {
        $result = test_input($_POST["result"]);
    }

    if (empty($_POST["score"])) {
        $score = $gameScore;
    } else {
        $score = test_input($_POST["score"]);
    }

    /// Game Halves Validation

    if (empty($_POST["home_score_1"])) {
        $scoreHome1 = $homeScorePlaceholder1;
    } else {
        $homeScore1 = test_input($_POST["home_score_1"]);
    } 

    if (empty($_POST["home_comment_1"])) {
        $commentHome1 = $homeCommentPlaceholder1;
    } else {
        $homeComment1 = test_input($_POST["home_comment_1"]);
    } 

    if (empty($_POST["opposition_score_1"])) {
        $scoreOpposition1 = $oppositionScorePlaceholder1;
    } else {
        $oppositionScore1 = test_input($_POST["opposition_score_1"]);
    } 

    if (empty($_POST["opposition_comment_1"])) {
        $commentOpposition1 = $oppositionCommentPlaceholder1;
    } else {
        $oppositionComment1 = test_input($_POST["opposition_comment_1"]);
    } 

    if (empty($_POST["home_score_2"])) {
        $scoreHome2E = $homeScorePlaceholder2;
    } else {
        $homeScore2 = test_input($_POST["home_score_2"]);
    } 

    if (empty($_POST["home_comment_2"])) {
        $commentHome2 = $homeCommentPlaceholder2;
    } else {
        $homeComment2 = test_input($_POST["home_comment_2"]);
    } 

    if (empty($_POST["opposition_score_2"])) {
        $scoreOpposition2 = $oppositionScorePlaceholder2;
    } else {
        $oppositionScore2 = test_input($_POST["opposition_score_2"]);
    } 

    if (empty($_POST["opposition_comment_2"])) {
        $commentOpposition2 = $oppositionCommentPlaceholder2;
    } else {
        $oppositionComment2 = test_input($_POST["opposition_comment_2"]);
    } 

    if (empty($nameErr) && empty($squadErr) && empty($startErr) && empty($endErr) && empty($locationErr) && empty($kickoffErr) && empty($resultErr) && empty($scoreErr) && empty($homeErr) && empty($scoreHome1Err) && empty($commentHome1Err) && empty($scoreOpposition1Err) && empty($commentOpposition1Err) && empty($scoreHome2Err) && empty($commentHome2Err) && empty($scoreOpposition2Err) && empty($commentOpposition2Err)) {

        $stmt = $conn->prepare(SQL::$getSquad);
        $stmt->execute([$squad]);
        $squadExists = $stmt->fetch();
        $squadId = $squadExists['squad_id'];

        Events::updateGame($squadId, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId);

        Events::updateGameHalf($gameHalfId1, $squad, $homeScore1, $homeComment1, $opposition, $oppositionScore1, $oppositionComment1);

        Events::updateGameHalf($gameHalfId2, $squad, $homeScore2, $homeComment2, $opposition, $oppositionScore2, $oppositionComment2);

        header("Location: " . Utils::$projectFilePath . "/timetable.php");
    }
    }


/**
 * 
 * Sanitizes input data to prevent SQL injection and cross-siste scripting (XSS) attacks.
 * 
 * @param data - Input data to be sanitized
 * @return data - String containing sanitized input data.
 * 
 */

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}?>
<main class="content-wrapper profile-list-content">

    <h2>Update Game Details</h2>
    <form 
        method="POST"
        action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $game["game_id"];?>">


    
    <div id="basic-game-details">
        <label class="col-sm-2 col-form-label-sm"for="name">Name:</label><br>
        <input type="text" name="name" placeholder="<?php echo $gameName;?>" value="<?php echo $name;?>">
        <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

        <label for="squad">Home Team:</label><br>
            <select name="squad">
            <?php
            foreach($squads as $squad){
                ?>
                <option value="<?php echo $squad["squad_name"]; ?>" <?php if($squad['squad_name'] == $homeTeam) {echo "selected";}?>>
                <?php echo $squad["squad_name"]; ?>
                </option>
                <?php
            }
            ?>
            </select>
            <p class="alert alert-danger"><?php echo $squadErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="opposition">Opposition Team:</label><br>
        <input type="text" name="opposition" placeholder="<?php echo $oppositionName;?>" value="<?php echo $opposition;?>">
        <p class="alert alert-danger"><?php echo $oppositionErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="start">Start Date:</label><br>
        <input type="datetime-local" name="start" placeholder="<?php echo $start;?>" value="<?php echo $start;?>">
        <p class="alert alert-danger"><?php echo $startErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="end">End Date:</label><br>
        <input type="datetime-local" name="end" placeholder="<?php echo $end;?>" value="<?php echo $end;?>">
        <p class="alert alert-danger"><?php echo $endErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="location">Game Location:</label><br>
        <input type="text" name="location" placeholder="<?php echo $gameLocation;?>" value="<?php echo $location;?>">
        <p class="alert alert-danger"><?php echo $locationErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="kickoff">Kickoff Time:</label><br>
        <input type="time" name="kickoff" placeholder="<?php echo $gameKickoff;?>" value="<?php echo $kickoff;?>">
        <p class="alert alert-danger"><?php echo $kickoffErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="result">Final Result:</label><br>
        <input type="text" name="result" placeholder="<?php echo $gameResult;?>" value="<?php echo $result;?>">
        <p class="alert alert-danger"><?php echo $resultErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="score">Final Score:</label><br>
        <input type="text" name="score" placeholder="<?php echo $gameScore;?>" value="<?php echo $score;?>">
        <p class="alert alert-danger"><?php echo $scoreErr;?></p><br>


        <input type="button" value="Next" onclick="nextTab()">
    </div>

    <div id="game-half-form">
        <?php foreach ($gameHalves as $gameHalf): ?>
            <div class="game-half">
                <h3>Game Half <?php echo $gameHalf["half_number"]; ?></h3>
                <label class="col-sm-2 col-form-label-sm"for="home_score_<?php echo $gameHalf["half_number"]; ?>">Home Score:</label><br>
                <input type="text" name="home_score_<?php echo $gameHalf["half_number"]; ?>" placeholder="<?php if($gameHalf["half_number"] == 1){echo $homeScorePlaceholder1;} else{ echo $homeScorePlaceholder2;}?>" value="<?php if ($gameHalf["half_number"] == 1){echo $homeScore1;}else{echo $homeScore2;}?>"><br>
                <?php if ($gameHalf["half_number"] == 1){
                    ?>
                    <p class="alert alert-danger"><?php echo $scoreHome1Err;?></p><br>
                    <?php
                } else {
                    ?>
                    <p class="alert alert-danger"><?php echo $scoreHome2Err;?></p><br>
                    <?php
                }?>
                <label class="col-sm-2 col-form-label-sm"for="home_comment_<?php echo $gameHalf["half_number"]; ?>">Home Comment:</label><br>
                <input type="text" name="home_comment_<?php echo $gameHalf["half_number"]; ?>" placeholder="<?php if($gameHalf["half_number"] == 1){echo $homeCommentPlaceholder1;} else{ echo $homeCommentPlaceholder2;}?>" value="<?php if ($gameHalf["half_number"] == 1){echo $homeComment1;}else{echo $homeComment2;}?>"><br>
                <?php if ($gameHalf["half_number"] == 1){
                    ?>
                    <p class="alert alert-danger"><?php echo $commentHome1Err;?></p><br>
                    <?php
                } else {
                    ?>
                    <p class="alert alert-danger"><?php echo $commentHome2Err;?></p><br>
                    <?php
                }?>
                <!-- Opposition team bit -->
                <label class="col-sm-2 col-form-label-sm"for="opposition_score_<?php echo $gameHalf["half_number"]; ?>">Opposition Score:</label><br>
                <input type="text" name="opposition_score_<?php echo $gameHalf["half_number"]; ?>" placeholder="<?php if($gameHalf["half_number"] == 1){echo $oppositionScorePlaceholder1;} else{ echo $oppositionScorePlaceholder2;}?>" value="<?php if ($gameHalf["half_number"] == 1){echo $oppositionScore1;}else{echo $oppositionScore2;}?>"><br>
                <?php if ($gameHalf["half_number"] == 1){
                    ?>
                    <p class="alert alert-danger"><?php echo $scoreOpposition1Err;?></p><br>
                    <?php
                } else {
                    ?>
                    <p class="alert alert-danger"><?php echo $scoreOpposition2Err;?></p><br>
                    <?php
                }?>
                <label class="col-sm-2 col-form-label-sm"for="opposition_comment_<?php echo $gameHalf["half_number"]; ?>">Opposition Comment:</label><br>
                <input type="text" name="opposition_comment_<?php echo $gameHalf["half_number"]; ?>" placeholder="<?php if($gameHalf["half_number"] == 1){echo $oppositionCommentPlaceholder1;} else{ echo $oppositionCommentPlaceholder2;}?>" value="<?php if ($gameHalf["half_number"] == 1){echo $oppositionComment1;}else{echo $oppositionComment2;}?>"><br>
                <?php if ($gameHalf["half_number"] == 1){
                    ?>
                    <p class="alert alert-danger"><?php echo $commentOpposition1Err;?></p><br>
                    <?php
                } else {
                    ?>
                    <p class="alert alert-danger"><?php echo $commentOpposition2Err;?></p><br>
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

</main>

