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
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
}
  

/// Redirect to logout page if user role is neither Admin nor Coach

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Redirects to the timetable page if the 'id' parameter is not set in the GET request or if it is not a numeric value.
 */
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/timetable.php");
} 

$game = Events::getGame($_GET["id"]); ///< Get game's details based on the ID number
$pageTitle = "Game not found"; ///< Default title

/**
 * Set the page title to display the details of a game if the game array is not empty.
 *
 * @param array $game An array containing information about the game.
 */
if(!empty($game)){
    $pageTitle = $game["name"] . "'s Details";
}

$conn = Connection::Connect();

$stmt = $conn->prepare(SQL::$getSquads);
$stmt->execute();
$squads = $stmt->fetchAll();


/**
 * Escape and assign values from the $game array to respective variables for security purposes.
 *
 * @param array $game An array containing information about the game.
 */
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

/**
 * Variables to store information related to a sports squad match.
 *
 * @var string $squad: The squad name
 * @var string $name: The name of the match
 * @var string $opposition: The opposing team
 * @var \DateTime $start: The start date of the match
 * @var \DateTime  $end: The end date of the match
 * @var string $location: The location of the match
 * @var \DateTime  $kickoff: The kickoff time of the match
 * @var string $result: The result of the match
 * @var string $score: The score of the match
 * @var string $home: The home team
 *
 * Error variables for each corresponding field to handle validation errors:
 * @var string $squadErr - Error message for squad validation
 * @var string $nameErr - Error message for game's name validation
 * @var string $oppositionErr - Error message for opposition team's name validation
 * @var string $startErr - Error message for start date validation
 * @var string $endErr - Error message for end date validation
 */
$squad = $name = $opposition = $start = $end = $location = $kickoff = $result = $score = "";
$home = "";

$squadErr = $nameErr = $oppositionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = $homeErr = "";

$homeScore1 = $homeScore2 = $homeComment1 = $homeComment2 = $oppositionScore1 = $oppositionScore2 = $oppositionComment1 = $oppositionComment2 = "";

$scoreHome1Err = $commentHome1Err = $scoreOpposition1Err = $commentOpposition1Err = "";
$scoreHome2Err = $commentHome2Err = $scoreOpposition2Err = $commentOpposition2Err = "";


$gameHalves = Events::getGameHalves($gameId); ///< Get all game halves (2) for a specific game

/**
 * Iterates over an array of game halves and retrieves the half number and home team for each game half.
 *
 * @param array $gameHalves An array containing game halves data.
 */
foreach($gameHalves as $gameHalf){
    $gameHalfNumber = Utils::escape($gameHalf["half_number"]);
    $homeTeam = Utils::escape($gameHalf["home_team"]);
}

/**
 * Assigns escaped values from the gameHalves array to corresponding variables for further use.
 *
 * @param array $gameHalves An array containing game halves data.
 */
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



Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]); ///< Render page header

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $name = $gameName; ///< Set value to placeholder if left empty
    } else {
        $name = test_input($_POST["name"]); ///< Sanitize name
    }

    /// Validate squad
    if (empty($_POST["squad"])) {
        $squad = $homeTeam; ///< Set value to placeholder if left empty
    } else {
        $squad = test_input($_POST["squad"]); ///< Sanitize squad name
    }

    /// Validate opposition
    if (empty($_POST["opposition"])) {
        $opposition = $oppositionName; ///< Set value to placeholder if left empty
    } else {
        $opposition = test_input($_POST["opposition"]); ///< Sanitize opposition name
    }

    if (empty($_POST["start"])) {
        $start = $gameStartPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $start = test_input($_POST["start"]);
        
        $sqlStart = date('Y-m-d H:i:sa', strtotime($start)); ///< Converts the given start date to a formatted SQL datetime string.

    }

    if (empty($_POST["end"])) {
        $end = $gameEndPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $end = test_input($_POST["end"]);

        $sqlEnd = date('Y-m-d H:i:sa', strtotime($end)); ///< Converts the given end date to a formatted SQL datetime string.

    }

    if (empty($_POST["location"])) {
        $location = $gameLocation; ///< Set value to placeholder if left empty
    } else {
        $location = test_input($_POST["location"]); ///< Sanitize game's location
    }

    if (empty($_POST["kickoff"])) {
        $kickoff = $gameKickoff; ///< Set value to placeholder if left empty
    } else {
        $kickoff = test_input($_POST["kickoff"]); ///< Sanitize game's kickoff time
    }

    if (empty($_POST["result"])) {
        $result = $gameResult; ///< Set value to placeholder if left empty
    } else {
        $result = test_input($_POST["result"]); ///< Sanitize game's result
    }

    if (empty($_POST["score"])) {
        $score = $gameScore; ///< Set value to placeholder if left empty
    } else {
        $score = test_input($_POST["score"]); ///< Sanitize game's score
    }

    /// Game Halves Validation

    if (empty($_POST["home_score_1"])) {
        $scoreHome1 = $homeScorePlaceholder1; ///< Set value to placeholder if left empty
    } else {
        $homeScore1 = test_input($_POST["home_score_1"]); ///< Sanitize home score for half number 1
    } 

    if (empty($_POST["home_comment_1"])) {
        $commentHome1 = $homeCommentPlaceholder1; ///< Set value to placeholder if left empty
    } else {
        $homeComment1 = test_input($_POST["home_comment_1"]); ///< Sanitize home team's comment for half number 1
    } 

    if (empty($_POST["opposition_score_1"])) {
        $scoreOpposition1 = $oppositionScorePlaceholder1; ///< Set value to placeholder if left empty
    } else {
        $oppositionScore1 = test_input($_POST["opposition_score_1"]); ///< Sanitize opposition score for half number 1
    } 

    if (empty($_POST["opposition_comment_1"])) {
        $commentOpposition1 = $oppositionCommentPlaceholder1; ///< Set value to placeholder if left empty
    } else {
        $oppositionComment1 = test_input($_POST["opposition_comment_1"]); ///< Sanitize opposition team's comment for half number 1
    } 

    if (empty($_POST["home_score_2"])) {
        $scoreHome2E = $homeScorePlaceholder2; ///< Set value to placeholder if left empty
    } else {
        $homeScore2 = test_input($_POST["home_score_2"]); ///< Sanitize home score for half number 2
    } 

    if (empty($_POST["home_comment_2"])) {
        $commentHome2 = $homeCommentPlaceholder2; ///< Set value to placeholder if left empty
    } else {
        $homeComment2 = test_input($_POST["home_comment_2"]);  ///< Sanitize home team's comment for half number 2
    } 

    if (empty($_POST["opposition_score_2"])) {
        $scoreOpposition2 = $oppositionScorePlaceholder2; ///< Set value to placeholder if left empty
    } else {
        $oppositionScore2 = test_input($_POST["opposition_score_2"]); //< Sanitize opposition score for half number 2
    } 

    if (empty($_POST["opposition_comment_2"])) {
        $commentOpposition2 = $oppositionCommentPlaceholder2; ///< Set value to placeholder if left empty
    } else {
        $oppositionComment2 = test_input($_POST["opposition_comment_2"]); ///< Sanitize opposition team's comment for half number 2
    } 

    /**
     * Validates all the error messages and if there are no errors, updates the game details in the database.
     */
    if (empty($nameErr) && empty($squadErr) && empty($startErr) && empty($endErr) && empty($locationErr) && empty($kickoffErr) && empty($resultErr) && empty($scoreErr) && empty($homeErr) && empty($scoreHome1Err) && empty($commentHome1Err) && empty($scoreOpposition1Err) && empty($commentOpposition1Err) && empty($scoreHome2Err) && empty($commentHome2Err) && empty($scoreOpposition2Err) && empty($commentOpposition2Err)) {

        $stmt = $conn->prepare(SQL::$getSquad);
        $stmt->execute([$squad]);
        $squadExists = $stmt->fetch();
        $squadId = $squadExists['squad_id'];

        /**
         * Update a game with the provided details.
         */
        Events::updateGame($squadId, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId);

        /**
         * Update the game half details with the provided information.
         */
        Events::updateGameHalf($gameHalfId1, $squad, $homeScore1, $homeComment1, $opposition, $oppositionScore1, $oppositionComment1);

        /**
         * Update the game half details with the provided information.
         */
        Events::updateGameHalf($gameHalfId2, $squad, $homeScore2, $homeComment2, $opposition, $oppositionScore2, $oppositionComment2);

        header("Location: " . Utils::$projectFilePath . "/timetable.php"); ///< Redirect back to timetabe to see changes
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

        <!-- Populate dropdown with values from database -->
        <label for="squad">Home Team:</label><br>
            <select name="squad">
            <?php
            /**
             * Loops through an array of squads and creates an <option> element for each squad.
             */
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
                <!-- Generates HTML code for displaying a form input field for home score based on the game half number. -->
                <h3>Game Half <?php echo $gameHalf["half_number"]; ?></h3>
                <label class="col-sm-2 col-form-label-sm"for="home_score_<?php echo $gameHalf["half_number"]; ?>">Home Score:</label><br>
                <input type="text" name="home_score_<?php echo $gameHalf["half_number"]; ?>" placeholder="<?php if($gameHalf["half_number"] == 1){echo $homeScorePlaceholder1;} else{ echo $homeScorePlaceholder2;}?>" value="<?php if ($gameHalf["half_number"] == 1){echo $homeScore1;}else{echo $homeScore2;}?>"><br>
                <!--
                 * Display an alert message based on the half number of the game.
                 *
                 * If the half number is 1, display the $scoreHome1Err message in a red alert box.
                 * If the half number is not 1, display the $scoreHome2Err message in a red alert box.
                -->
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




        /**
         * Show the tab based on the currentTab value.
         */
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

        showTab();


        /**
         * Increases the current tab index by 1 and displays the next tab.
         */
        function nextTab(){
            currentTab += 1;
            showTab();
        }

        /**
         * Decrements the current tab index by 1 and displays the updated tab.
         */
        function prevTab(){
            currentTab -= 1;
            showTab();
        }


    </script>

</main>

