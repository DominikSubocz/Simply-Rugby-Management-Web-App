<?php

session_start();
require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/events.php");
require("classes/utils.php");

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

Components::pageHeader("All players", ["style"], ["mobile-nav"]);

$gameName = $squad = $oppisition = $start = $end = $location = $result = $score = "";
$gameNameErr = $squadErr = $oppisitionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = "";


$sessionName = $coachName = $trainingSquad = $trainingLocation = "";
$sessionNameErr = $coachNameErr = $trainingSquadErr = $trainingStartErr = $trainingEndErr = $trainingLocationErr = "";

$coachSql = "SELECT first_name, last_name FROM simplyrugby.coaches";

$conn = Connection::connect();

$stmt = $conn->prepare($coachSql);
$stmt->execute();
$coaches = $stmt->fetchAll();

$stmt = $conn->prepare(SQL::$getSquads);
$stmt->execute();
$squads = $stmt->fetchAll();




if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if ($_POST['elementForVar1HiddenField'] == 0) {

    // Game name validation

    if (empty($_POST["gameName"])) {
      $gameNameErr = "Name of the game is required";
    } else {
        $gameName = test_input($_POST["gameName"]);
    }

    // Squad validation

    if (empty($_POST["squad"])){
      $squadErr = "Squad is required";

    } else {
        $squad = test_input($_POST["squad"]);
    }


    // Opposition team validation

    if (empty($_POST["oppisition"])) {
      $oppisitionErr = "Opposition's name is required";
    } else {
        $oppisition = test_input($_POST["oppisition"]);
    }

    // Date validation

    if (empty($_POST["start"])) {
      $startErr = "Start date is required";
    } else {
        $start = test_input($_POST["start"]);

        
        $sqlStart = date('Y-m-d H:i:sa', strtotime($start));
    }

    if (empty($_POST["end"])) {
      $endErr = "End date is required";
    } else {
        $end = test_input($_POST["end"]);

        $sqlEnd = date('Y-m-d H:i:sa', strtotime($end));

    }

    // Location validation

    if (empty($_POST["location"])) {
      $locationErr = "Location is required";
    } else {
        $location = test_input($_POST["location"]);
    }

    // Kickoff time validation

    if (empty($_POST["kickoff"])) {
      $kickoffErr = "Kickoff time is required";
    } else {
        $kickoff = test_input($_POST["kickoff"]);
    }

    if (empty($gameNameErr) && empty($squadErr) && empty($oppisitionErr) && empty($startErr)  && empty($endErr)  && empty($locationErr) && empty($kickoffErr)){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getGame);
      $stmt->execute([$gameName, $start, $end]);
      $game = $stmt->fetch();

      if($game){
        var_dump("Game already exists");
      } else {
        $stmt = $conn->prepare(SQL::$getSquad);
        $stmt->execute([$squad]);
        $squadExists = $stmt->fetch();
        $squadId = $squadExists['squad_id'];
        
  
        if(!$squad){
          var_dump("ERROR: Squad doesn't exist");
        } else {
          $stmt = $conn->prepare(SQL::$createGame);
          $stmt->execute([$squadId, $gameName, $oppisition, $sqlStart, $sqlEnd, $location, $kickoff, $result, $score]);
          $gameId = $conn->lastInsertId();

          $stmt = $conn->prepare(SQL::$createGameHalf);
          $result1 = $stmt->execute([$gameId, 1, $squad, $oppisition]);
          $result2 = $stmt->execute([$gameId, 2, $squad, $oppisition]);

          var_dump($result1);
          var_dump($result2);

        }
      }
      



    }
  } else {

    // Session name validation

    if (empty($_POST["sessionName"])) {
      $sessionNameErr = "Name of the session is required";
    } else {
        $sessionName = test_input($_POST["sessionName"]);
    }

        // Coach name validation


    if (empty($_POST["coachName"])) {
      $coachNameErr = "Coach name is required";
    } else {
        $coachName = test_input($_POST["coachName"]);
        $coachNameParts = explode(" ", $coachName);

        // Extract the first and last names
        $coachFirstName = $coachNameParts[0];
        $coachLastName = end($coachNameParts);
    }

    if (empty($_POST["trainingSquad"])) {
      $trainingSquadErr = "Squad is required";

    } else {
        $trainingSquad = test_input($_POST["trainingSquad"]);
    }

    if (empty($_POST["trainingStart"])) {
      $trainingStartErr = "Start date is required";
    } else {
        $trainingStart = test_input($_POST["trainingStart"]);
        
        $sqlTrainingStart = date('Y-m-d H:i:sa', strtotime($trainingStart));


    }

    if (empty($_POST["trainingEnd"])) {
      $trainingEndErr = "End date is required";
    } else {
        $trainingEnd = test_input($_POST["trainingEnd"]);

        $sqlTrainingEnd = date('Y-m-d H:i:sa', strtotime($trainingEnd));


    }

    // Location validation

    if (empty($_POST["trainingLocation"])) {
      $trainingLocationErr = "Location is required";
    } else {
        $trainingLocation = test_input($_POST["trainingLocation"]);
    }


    if (empty($sessionNameErr) && empty($coachNameErr) && empty($trainingSquadErr)  && empty($trainingStartErr)  && empty($trainingEndErr)  && empty($trainingLocationErr)){
      
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getSession);
      $stmt->execute([$sessionName, $trainingStart, $trainingEnd]);
      $session = $stmt->fetch();

      if($session){
        var_dump("ERROR: Game already exists");
      } else {
        $stmt = $conn->prepare(SQL::$getCoach);
        $stmt->execute([$coachFirstName, $coachLastName]);
        $coach = $stmt->fetch();

        if(!$coach){
          var_dump("ERROR: Coach doesn't exist");
        } else {

          $coachId = $coach['coach_id'];

          $stmt = $conn->prepare(SQL::$getSquad);
          $stmt->execute([$trainingSquad]);
          $squadExists = $stmt->fetch();

          if(!$squadExists){
            var_dump("ERROR: Squad doesn't exist");

          } else {
            $squadId = $squadExists['squad_id'];

            var_dump($squadId);

            $stmt = $conn->prepare(SQL::$createSession);
            $stmt->execute([$coachId, $squadId, $sessionName, $sqlTrainingStart, $sqlTrainingEnd, $trainingLocation]);
            $sessionId = $conn->lastInsertId();


            $stmt = $conn->prepare(SQL::$createTrainingDetails);
            $stmt->execute([$sessionId, $coachId, $squadId]);
          } 

          
        }
      }
    }

  }



  // Training session name validation


  





}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<main class="content-wrapper contact-content">

    <div class="form-container">
        <form
        method="POST"
        action="<?php echo $_SERVER["PHP_SELF"]; ?>"
        class="form">
    
        <div id="radio-container">
            <label class="radio" >Game
            <input type="radio" id="radio-one" checked="checked" name="radio" onclick="radioChecked()">
            <span class="checkmark"></span>
            </label>
            <label class="radio" >Training Session
            <input type="radio" id="radio-two" name="radio" onclick="radioChecked()">
            <span class="checkmark"></span>
            </label>
        </div>

        <div id="game-form">
            <label for="gameName"><span class="required">*</span>Game name:</label><br>
            <input type="text" name="gameName" value="<?php echo $gameName;?>">
            <p class="alert alert-danger"><?php echo $gameNameErr;?></p><br>
    
            <label for="squad">Squad number:</label><br>
            <select name="squad">
            <?php
            foreach($squads as $squad){
                ?>
                <option value="<?php echo $squad["squad_name"]; ?>">
                <?php echo $squad["squad_name"]; ?>
                </option>
                <?php
            }
            ?>
            </select>
            <p class="alert alert-danger"><?php echo $squadErr;?></p><br>
    
            <label for="oppisition"><span class="required">*</span>Opposition team name:</label><br>
            <input type="text" name="oppisition" value="<?php echo $oppisition;?>">
            <p class="alert alert-danger"><?php echo $oppisitionErr;?></p><br>
    
            <label for="start"><span class="required">*</span>Start Date:</label><br>
            <input type="datetime-local" id="start" name="start" >
            <p class="alert alert-danger"><?php echo $startErr;?></p><br>
    
            <label for="end"><span class="required">*</span>End Date:</label><br>
            <input type="datetime-local" id="end" name="end" >
            <p class="alert alert-danger"><?php echo $endErr;?></p><br>
    
            <label for="location"><span class="required">*</span>Location:</label><br>
            <input type="text" name="location" value="<?php echo $location;?>">
            <p class="alert alert-danger"><?php echo $locationErr;?></p><br>
    
            <label for="kickoff"><span class="required">*</span>Kickoff Time:</label><br>
            <input type="time" id="kickoff" name="kickoff">
            <p class="alert alert-danger"><?php echo $kickoffErr;?></p><br>
    
            <label for="result">Result:</label><br>
            <input type="text" name="result" value="<?php echo $result;?>">
            <p class="alert alert-danger"><?php echo $resultErr;?></p><br>
    
            <label for="score">Score:</label><br>
            <input type="text" name="score" value="<?php echo $score;?>">
            <p class="alert alert-danger"><?php echo $scoreErr;?></p><br>
        </div>
    
        <div id="training-form">
            <input type="hidden" id="elementForVar1HiddenField" name="elementForVar1HiddenField" value="0" />
    
            <label for="sessionName">Training session name:</label><br>
            <input type="text" name="sessionName" value="<?php echo $sessionName;?>">
            <p class="alert alert-danger"><?php echo $sessionNameErr;?></p><br>
    
            <label for="coachName">Coach:</label><br>
            <select name="coachName">
            <?php
            foreach($coaches as $coach){
                ?>
                <option value="<?php echo $coach["first_name"] . ' ' . $coach["last_name"]; ?>">
                <?php echo $coach["first_name"] . ' ' . $coach["last_name"]; ?>
                </option>
                <?php
            }
            ?>
            </select>
            <p class="alert alert-danger"><?php echo $coachNameErr;?></p><br>
            <br>

            
            <label for="trainingSquad">Squad number:</label><br>
            <select name="trainingSquad">
            <?php
            foreach($squads as $squad){
                ?>
                <option value="<?php echo $squad["squad_name"]; ?>">
                <?php echo $squad["squad_name"]; ?>
                </option>
                <?php
            }
            ?>
            </select>
            <p class="alert alert-danger"><?php echo $trainingSquadErr;?></p><br>
            <br>
    
    
            <label for="trainingStart">Start Date:</label><br>
            <input type="datetime-local" id="trainingStart" name="trainingStart"  >
            <p class="alert alert-danger"><?php echo $trainingStartErr;?></p><br>
    
            <label for="trainingEnd">End Date:</label><br>
            <input type="datetime-local" id="trainingEnd" name="trainingEnd"  >
            <p class="alert alert-danger"><?php echo $trainingEndErr;?></p><br>
    
    
            <label for="trainingLocation">Location:</label><br>
            <input type="text" name="trainingLocation" value="<?php echo $trainingLocation;?>">
            <p class="alert alert-danger"><?php echo $trainingLocationErr;?></p><br>
        </div>
    
    
    
        <input type="submit" name="submit" value="Submit">
    
    
        </form>
    </div>
</main>

<script>

  const gForm = document.getElementById("game-form");
  const tForm = document.getElementById("training-form");


function radioChecked(){
  if (document.getElementById("radio-two").checked){
    gForm.style.display = "none";
    tForm.style.display = "block";
    document.getElementById('elementForVar1HiddenField').value = 1;

  } else {
      gForm.style.display = "block";
      tForm.style.display = "none";
      document.getElementById('elementForVar1HiddenField').value = 0;
    }
}

radioChecked();



</script>