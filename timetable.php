<?php

session_start();
require("classes/components.php");

Components::pageHeader("All Books", ["style"], ["mobile-nav"]);

$gameName = $squad = $oppisition = $location = $result = $score = "";

$gameNameErr = $squadErr = $oppisitionErr = $startErr = $endErr = $locationErr = $kickoffErr = $resultErr = $scoreErr = "";

$sessionName = $coachName = "";

$sessionNameErr = $coachNameErr = "";

?>
<main class="content-wrapper contact-content">

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
    <label for="guardianName">Game name:</label><br>
    <input type="text" name="gameName" value="<?php echo $gameName;?>">
    <p class="error"><?php echo $gameNameErr;?></p><br>

    <label for="guardianName">Squad Playing:</label><br>
    <input type="text" name="squad" value="<?php echo $squad;?>">
    <p class="error"><?php echo $squadErr;?></p><br>

    <label for="guardianName">Opposition team name:</label><br>
    <input type="text" name="oppisition" value="<?php echo $oppisition;?>">
    <p class="error"><?php echo $oppisitionErr;?></p><br>

    <label for="guardianName">Start Date:</label><br>
    <input type="date" id="start" name="start">
    <p class="error"><?php echo $startErr;?></p><br>

    <label for="guardianName">End Date:</label><br>
    <input type="date" id="end" name="end">
    <p class="error"><?php echo $endErr;?></p><br>

    <label for="guardianName">Location:</label><br>
    <input type="text" name="location" value="<?php echo $location;?>">
    <p class="error"><?php echo $locationErr;?></p><br>

    <label for="guardianName">Kickoff Time:</label><br>
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
    <input type="text" name="squad" value="<?php echo $squad;?>">
    <p class="error"><?php echo $squadErr;?></p><br>


    <label for="guardianName">Start Date:</label><br>
    <input type="date" id="start" name="start">
    <p class="error"><?php echo $startErr;?></p><br>

    <label for="guardianName">End Date:</label><br>
    <input type="date" id="end" name="end">
    <p class="error"><?php echo $endErr;?></p><br>


    <label for="guardianName">Location:</label><br>
    <input type="text" name="location" value="<?php echo $location;?>">
    <p class="error"><?php echo $locationErr;?></p><br>
  </div>
  


  <input type="submit" name="submit" value="Submit">  


</form>



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

