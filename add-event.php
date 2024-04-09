<?php


session_start();
require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/events.php");
require("classes/utils.php");

/// Redirect to logout page if user role is neither Admin nor Coach
if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Render page header with specified styles and navigation options
 */
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

/**
 * Variables for storing game details such as game name, squad, opposition, start time, end time, location, result, and score.
 * Also includes variables for storing any corresponding error messages.
 */
$gameName = $squad = $opposition = $start = $end = $location = $result = $score = "";
$gameNameErr = $squadErr = $oppositionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = "";

$sessionName = $coachName = $trainingSquad = $trainingLocation = "";
$sessionNameErr = $coachNameErr = $trainingSquadErr = $trainingStartErr = $trainingEndErr = $trainingLocationErr = "";

/// Retrieve coach names
$coachSql = "SELECT first_name, last_name FROM simplyrugby.coaches";

/// Establish database connection
$conn = Connection::connect();

/// Retrieve coaches' names from the database
$stmt = $conn->prepare($coachSql);
$stmt->execute();
$coaches = $stmt->fetchAll();

/// Retrieve squads from the database
$stmt = $conn->prepare(SQL::$getSquads);
$stmt->execute();
$squads = $stmt->fetchAll();


/**
 * Processes form data submitted via POST method to create a new game or training session.
 * 
 * For game creation:
 * - Validates and sanitizes input fields for game details such as name, squad, opposition, start/end dates, location, kickoff time, and score.
 * - Checks if the game already exists in the database.
 * - If the squad does not exist, throws an error.
 * - Inserts the new game details into the database.
 * 
 * For session creation:
 * - Validates and sanitizes input fields for session details such as name, coach name, training squad, start/end dates, and location.
 * - Checks if the session already exists in the database.
 * - If the coach or squad does not exist,
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  /// Validate game details if value for hidden field is 0.
  /// It is 0 by default, or if user has picked game from radio options)
  
  if ($_POST['elementForVar1HiddenField'] == 0) {

    /// Game name validation

    if (empty($_POST["gameName"])) {
      $gameNameErr = "Name of the game is required"; ///< Display error message
    } else {
        $gameName = test_input($_POST["gameName"]); ///< Sanitize game name input
    }

    /// Squad validation

    if (empty($_POST["squad"])){
      $squadErr = "Squad is required"; ///< Display error message

    } else {
        $squad = test_input($_POST["squad"]); ///< Sanitize squad name input
    }


    /// Opposition team validation

    if (empty($_POST["opposition"])) {
      $oppositionErr = "Opposition's name is required"; ///< Display error message
    } else {
        $opposition = test_input($_POST["opposition"]); ///< Sanitize oppisition name input
    }

    /// Date validation

    if (empty($_POST["start"])) {
      $startErr = "Start date is required"; ///< Display error message
    } else {
        $start = test_input($_POST["start"]);

        
        $sqlStart = date('Y-m-d H:i:s', strtotime($start)); ///< Format start date for SQL
    }

    if (empty($_POST["end"])) {
      $endErr = "End date is required"; ///< Display error message
    } else {
        $end = test_input($_POST["end"]);

        $sqlEnd = date('Y-m-d H:i:s', strtotime($end)); ///< Format end date for SQL

    }

    /// Location validation

    if (empty($_POST["location"])) {
      $locationErr = "Location is required"; ///< Display error message
    } else {
        $location = test_input($_POST["location"]); ///< Sanitize location input
    }

    /// Kickoff time validation

    if (empty($_POST["kickoff"])) {
      $kickoffErr = "Kickoff time is required"; ///< Display error message
    } else {
        $kickoff = test_input($_POST["kickoff"]); ///< Sanitize game name input
    }

    if (empty($_POST["score"])) {
      $score = 0; ///< Set score to 0 if not provided
    } else {
        $score = test_input($_POST["score"]); ///< Sanitize score input
    }

    if (empty($gameNameErr) && empty($squadErr) && empty($oppisitionErr) && empty($startErr)  && empty($endErr)  && empty($locationErr) && empty($kickoffErr)){
      $conn = Connection::connect(); ///< Connect to database

      /**
       * Check if a game with the given name already exists within the specified time frame.
       */

      $stmt = $conn->prepare(SQL::$getGame);
      $stmt->execute([$gameName, $start, $end]);
      $game = $stmt->fetch();

      if($game){

        ///Probably easy way, but I plan to rework it in future version.

        var_dump("Game already exists"); ///< Display error message
      } else {


        /**
         * Get the squad information from the database.
         */
        $stmt = $conn->prepare(SQL::$getSquad);
        $stmt->execute([$squad]);
        $squadExists = $stmt->fetch();
        $squadId = $squadExists['squad_id'];
        

  
        if(!$squad){
          /**
           * 
           * I changed way of selecting squad so there's no way this will run.
           * 
           * I'll fix it in future update
           * 
           */
          var_dump("ERROR: Squad doesn't exist"); ///< Display error message
        } else {

          /**
           * Creates a new game record & two game half records in the database.
           *
           */
          $stmt = $conn->prepare(SQL::$createGame);
          $stmt->execute([$squadId, $gameName, $oppisition, $sqlStart, $sqlEnd, $location, $kickoff, $result, $score]);
          $gameId = $conn->lastInsertId();

          $stmt = $conn->prepare(SQL::$createGameHalf);
          $result1 = $stmt->execute([$gameId, 1, $squad, $oppisition]);
          $result2 = $stmt->execute([$gameId, 2, $squad, $oppisition]);

        }
      }
      



    }
  } else {

    /**
     * 
     * Training session validation
     * 
     * Validate training session details if value of hidden field is not 0
     * Only if user picks session option from the radio input
     */

    if (empty($_POST["sessionName"])) {
      $sessionNameErr = "Name of the session is required";  ///< Display error message
    } else {
        $sessionName = test_input($_POST["sessionName"]); ///< Sanitize session name input
    }

        /// Coach name validation


    if (empty($_POST["coachName"])) {
      $coachNameErr = "Coach name is required"; ///< Display error message
    } else {
        $coachName = test_input($_POST["coachName"]);
        $coachNameParts = explode(" ", $coachName); ///< Split coach name into first and last name

        /// Extract the first and last names
        $coachFirstName = $coachNameParts[0];
        $coachLastName = end($coachNameParts);
    }

    if (empty($_POST["trainingSquad"])) {
      $trainingSquadErr = "Squad is required";  ///< Display error message

    } else {
        $trainingSquad = test_input($_POST["trainingSquad"]); ///< Sanitize squad input
    }

    if (empty($_POST["trainingStart"])) {
      $trainingStartErr = "Start date is required"; ///< Display error message
    } else {
        $trainingStart = test_input($_POST["trainingStart"]); ///< Sanitize training start date
        
        $sqlTrainingStart = date('Y-m-d H:i:s', strtotime($trainingStart)); ///< Format start date for SQL


    }

    if (empty($_POST["trainingEnd"])) {
      $trainingEndErr = "End date is required"; ///< Display error message
    } else {
        $trainingEnd = test_input($_POST["trainingEnd"]); ///< Sanitize training end date

        $sqlTrainingEnd = date('Y-m-d H:i:s', strtotime($trainingEnd)); ///< Format end date for SQL


    }

    /// Location validation

    if (empty($_POST["trainingLocation"])) {
      $trainingLocationErr = "Location is required"; ///< Display error message
    } else {
        $trainingLocation = test_input($_POST["trainingLocation"]); ///< Sanitize location input
    }



    /**
     * Checks if all the error messages are empty, and proceed with SQL querries.
     */
    if (empty($sessionNameErr) && empty($coachNameErr) && empty($trainingSquadErr)  && empty($trainingStartErr)  && empty($trainingEndErr)  && empty($trainingLocationErr)){
      
      $conn = Connection::connect(); ///< Connect to database


      /**
       * Check if a session already exists in the database based on session name, training start, and training end dates.
       * If the session already exists, it outputs an error message.
       */
      $stmt = $conn->prepare(SQL::$getSession);
      $stmt->execute([$sessionName, $trainingStart, $trainingEnd]);
      $session = $stmt->fetch();

      if($session){
        /// Will be improved in future updates.
        var_dump("ERROR: Session already exists"); ///< Display error 
      } else {



        /**
         * Checks if a coach exists in the database, based on the provided first and last name.
         * If the coach does not exist, an error message is displayed.
         */
        $stmt = $conn->prepare(SQL::$getCoach);
        $stmt->execute([$coachFirstName, $coachLastName]);
        $coach = $stmt->fetch();

        if(!$coach){
          /// Will be improved in future updates.
          var_dump("ERROR: Coach doesn't exist"); ///< Display error 
        } else {

          $coachId = $coach['coach_id']; ///< Get id of coach


          /**
           * Check if a squad exists in the database based on the provided training squad.
           */
          $stmt = $conn->prepare(SQL::$getSquad);
          $stmt->execute([$trainingSquad]);
          $squadExists = $stmt->fetch();

          if(!$squadExists){
            /// Will be improved in future updates.

            var_dump("ERROR: Squad doesn't exist"); ///< Display error 

          } else {
            $squadId = $squadExists['squad_id']; ///< Get id of squad

            /**
             * Creates a new session and training details in the database.
             */
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
}
?>

<main class="content-wrapper contact-content">

<!--  

  On submit form will be validated using JavaScript.

  Further form validation will be carried out using PHP.

-->
    <div class="form-container">
        <form
        method="POST"
        action="<?php echo $_SERVER["PHP_SELF"]; ?>"
        class="form"
        onsubmit="return validateForm()">
    
        <div id="radio-container">
            <label class="radio" >Game
            <input type="radio" id="radio-one" checked="checked" name="radio" onclick="radioChecked()"> <!-- This function will check which radio input is checked -->
            <span class="checkmark"></span>
            </label>
            <label class="radio" >Training Session
            <input type="radio" id="radio-two" name="radio" onclick="radioChecked()">
            <span class="checkmark"></span>
            </label>
        </div>

        <div id="game-form">
            <label for="gameName"><span class="required">*</span>Game name:</label><br>
            <input type="text" name="gameName" value="<?php echo $gameName;?>">  <!-- Empty by default, but will be set after you fill it and once you submit -->
            <p class="alert alert-danger"><?php echo $gameNameErr;?></p><br> <!-- Error variable -->
    

            <!-- Generates a dropdown list of squad numbers based on the provided array of squads. -->
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
            <input type="text" name="oppisition" value="<?php echo $opposition;?>">
            <p class="alert alert-danger"><?php echo $oppositionErr;?></p><br>
    
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

        <!-- 
          Hidden input that is used to determine which section should not be validated because it's hidden.

          This will change depending on the radio option picked by user.
        -->
            <input type="hidden" id="elementForVar1HiddenField" name="elementForVar1HiddenField" value="0" /> 
    
            <label for="sessionName"><span class="required">*</span>Training session name:</label><br>
            <input type="text" name="sessionName" value="<?php echo $sessionName;?>">
            <p class="alert alert-danger"><?php echo $sessionNameErr;?></p><br>
    
          <!-- Generates a dropdown list of coach numbers based on the provided array of coaches-->

            <label for="coachName"><span class="required">*</span>Coach:</label><br>
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

            <!-- Generates a dropdown list of squad numbers based on the provided array of squads. -->
            <label for="trainingSquad"><span class="required">*</span>Squad number:</label><br>
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
    
    
            <label for="trainingStart"><span class="required">*</span>Start Date:</label><br>
            <input type="datetime-local" id="trainingStart" name="trainingStart"  >
            <p class="alert alert-danger"><?php echo $trainingStartErr;?></p><br>
    
            <label for="trainingEnd"><span class="required">*</span>End Date:</label><br>
            <input type="datetime-local" id="trainingEnd" name="trainingEnd"  >
            <p class="alert alert-danger"><?php echo $trainingEndErr;?></p><br>
    
    
            <label for="trainingLocation"><span class="required">*</span>Location:</label><br>
            <input type="text" name="trainingLocation" value="<?php echo $trainingLocation;?>">
            <p class="alert alert-danger"><?php echo $trainingLocationErr;?></p><br>
        </div>
    
    
    
        <input type="submit" name="submit" onclick="return validateForm()"value="Submit">
    
    
        </form>
    </div>
</main>

<script>

  const gForm = document.getElementById("game-form"); ///< ID of div containing form to add a game
  const tForm = document.getElementById("training-form"); ///< ID of div containing form to add a training session


/**
 * Function to handle radio button checked event and update form elements accordingly.
 */
function radioChecked(){
  if (document.getElementById("radio-two").checked){
    gForm.style.display = "none";
    tForm.style.display = "block";
    document.getElementById('elementForVar1HiddenField').value = 1; ///< Game form won't be validated

  } else {
      gForm.style.display = "block";
      tForm.style.display = "none";
      document.getElementById('elementForVar1HiddenField').value = 0; ///< Session form won't be validated
    }
}

radioChecked(); 

/**
 * Validates the form fields based on specific conditions and displays alerts for missing or incorrect inputs.
 * 
 * @return boolean - Returns false if any required field is empty or incorrect, otherwise returns true.
 */
function validateForm() {
  let hiddenInput = document.getElementById('elementForVar1HiddenField');
  let gameNameInput = document.forms[0]["gameName"].value.trim(); ///< Session's name
  let oppositionInput = document.forms[0]["oppisition"].value.trim(); ///< Opposition name
  let startInput = document.forms[0]["start"].value.trim(); ///< Start date
  let endInput = document.forms[0]["end"].value.trim(); ///< End date
  let locationInput = document.forms[0]["location"].value.trim(); ///< location
  let kickoffInput = document.forms[0]["kickoff"].value.trim(); ///< kickoff time

  let sessionNameInput = document.forms[0]["sessionName"].value.trim(); ///< Session name
  let sessionStartInput = document.forms[0]["trainingStart"].value.trim(); ///<
  let sessionEndInput = document.forms[0]["trainingEnd"].value.trim(); ///<
  let sessionLocationInput = document.forms[0]["trainingLocation"].value.trim(); ///<

  /// Validate game if hidden input is set to 0
  if(hiddenInput.value == 0){
    if (gameNameInput == "") {
      alert("Name of the game must be filled out"); ///< Display alert
      return false;
    }

    if (oppositionInput == "") {
      alert("Opposition name must be filled out");
      return false;
    }

    
    if (startInput == "") {
      alert("Start date must be filled out");
      return false;
    }

    if (endInput == "") {
      alert("End date must be filled out");
      return false;
    }

    if (locationInput == "") {
      alert("Location of the game must be filled out");
      return false;
    }

    if (kickoffInput == "") {
      alert("Kickoff time must be filled out");
      return false;
    }
  } 
  
  /// If hidden element's value is not 0 validate Session form.
  else {
    if (sessionNameInput == "") {
      alert("Name of the training session must be filled out");
      return false;
    }

    if (sessionStartInput == "") {
      alert("Start date must be filled out");
      return false;
    }

    if (sessionEndInput == "") {
      alert("End date must be filled out");
      return false;
    }

    if (sessionLocationInput == "") {
      alert("Location of training session be filled out");
      return false;
    }
  }


}


</script>