<?php

session_start();
require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/events.php");
require("classes/utils.php");

Components::pageHeader("All Books", ["style"], ["mobile-nav"]);

$gameName = $squad = $oppisition = $start = $end = $location = $result = $score = "";
$gameNameErr = $squadErr = $oppisitionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = "";


$sessionName = $coachName = $trainingSquad = $trainingLocation = "";
$sessionNameErr = $coachNameErr = $trainingSquadErr = $trainingStartErr = $trainingEndErr = $trainingLocationErr = "";

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
        if (!preg_match("/^\d+$/", $squad)) {
            $squadErr = "Only digits allowed";
        }
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

        $stmt = $conn->prepare(SQL::$getSquadName);
        $stmt->execute([$squad]);
        $squadResults = $stmt->fetch();
        $squadName = $squadResults['squad_name'];
  
        if(!$squad){
          var_dump("ERROR: Squad doesn't exist");
        } else {
          $stmt = $conn->prepare(SQL::$createGame);
          $stmt->execute([$squadId, $gameName, $oppisition, $sqlStart, $sqlEnd, $location, $kickoff, $result, $score]);
          $gameId = $conn->lastInsertId();

          $stmt = $conn->prepare(SQL::$createGameHalf);
          $stmt->execute([$gameId, 1, $squadName, $oppisition]);
          $stmt->execute([$gameId, 2, $squadName, $oppisition]);

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
        if (!preg_match("/^\d+$/", $trainingSquad)) {
            $trainingSquadErr = "Only digits allowed";
        }
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

<div class="timetable-container">
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
        <label for="guardianName"><span class="required">*</span>Game name:</label><br>
        <input type="text" name="gameName" value="<?php echo $gameName;?>">
        <p class="error"><?php echo $gameNameErr;?></p><br>
  
        <label for="guardianName"><span class="required">*</span>Squad Playing:</label><br>
        <input type="text" name="squad" value="<?php echo $squad;?>">
        <p class="error"><?php echo $squadErr;?></p><br>
  
        <label for="guardianName"><span class="required">*</span>Opposition team name:</label><br>
        <input type="text" name="oppisition" value="<?php echo $oppisition;?>">
        <p class="error"><?php echo $oppisitionErr;?></p><br>
  
        <label for="guardianName"><span class="required">*</span>Start Date:</label><br>
        <input type="datetime-local" id="start" name="start" >
        <p class="error"><?php echo $startErr;?></p><br>
  
        <label for="guardianName"><span class="required">*</span>End Date:</label><br>
        <input type="datetime-local" id="end" name="end" >
        <p class="error"><?php echo $endErr;?></p><br>
  
        <label for="guardianName"><span class="required">*</span>Location:</label><br>
        <input type="text" name="location" value="<?php echo $location;?>">
        <p class="error"><?php echo $locationErr;?></p><br>
  
        <label for="guardianName"><span class="required">*</span>Kickoff Time:</label><br>
        <input type="time" id="kickoff" name="kickoff">
        <p class="error"><?php echo $kickoffErr;?></p><br>
  
        <label for="guardianName">Result:</label><br>
        <input type="text" name="result" value="<?php echo $result;?>">
        <p class="error"><?php echo $resultErr;?></p><br>
  
        <label for="guardianName">Score:</label><br>
        <input type="text" name="score" value="<?php echo $score;?>">
        <p class="error"><?php echo $scoreErr;?></p><br>
      </div>
  
      <div id="training-form">
        <input type="hidden" id="elementForVar1HiddenField" name="elementForVar1HiddenField" value="0" />
  
        <label for="guardianName">Training session name:</label><br>
        <input type="text" name="sessionName" value="<?php echo $sessionName;?>">
        <p class="error"><?php echo $sessionNameErr;?></p><br>
  
  
        <label for="guardianName">Coach name:</label><br>
        <input type="text" name="coachName" value="<?php echo $coachName;?>">
        <p class="error"><?php echo $coachNameErr;?></p><br>
  
        <label for="guardianName">Squad name:</label><br>
        <input type="text" name="trainingSquad" value="<?php echo $trainingSquad;?>" >
        <p class="error"><?php echo $trainingSquadErr;?></p><br>
  
  
        <label for="guardianName">Start Date:</label><br>
        <input type="datetime-local" id="trainingStart" name="trainingStart"  >
        <p class="error"><?php echo $trainingStartErr;?></p><br>
  
        <label for="guardianName">End Date:</label><br>
        <input type="datetime-local" id="trainingEnd" name="trainingEnd"  >
        <p class="error"><?php echo $trainingEndErr;?></p><br>
  
  
        <label for="guardianName">Location:</label><br>
        <input type="text" name="trainingLocation" value="<?php echo $trainingLocation;?>">
        <p class="error"><?php echo $trainingLocationErr;?></p><br>
      </div>
  
  
  
      <input type="submit" name="submit" value="Submit">
  
  
    </form>
  </div>
  
  <div class="calendar-container">
    <table>
      <tr>

        <th>Name</th>
        <th>Type</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Location</th>


      </tr>
      <?php

        $events = Events::getAllEvents();
        Components::allEvents($events);

        ?>

    </table>
  </div>


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
</main>

