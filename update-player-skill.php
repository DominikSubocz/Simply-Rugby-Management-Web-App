<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/player.php");

session_start();

/*
  Attempt to get the id from the URL parameter.
  If it isn't set or it isn't a number, redirect
  to player list page.
*/
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
  header("Location: " . Utils::$projectFilePath . "/player-list.php");
}

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

$player = Player::getplayer($_GET["id"]);

// Set the document title to the title and author of the player if it exists
$pageTitle = "player not found";

if (!empty($player)) {
  $pageTitle = "Update " . $player["first_name"] . "'s Skills";
}

$playerSkills = Player::getPlayerSkills($_GET["id"]);

Components::pageHeader("$pageTitle", ["style"], ["mobile-nav"]);

foreach($playerSkills as $playerSkill){
  $skillLevel = Utils::escape($playerSkill["skill_level"]);

}

foreach($playerSkills as $playerSkill){

}

$errorMessages = [
    'standard' => 'standardErr',
    'spin' => 'spinErr',
    'pop' => 'popErr',
    'front' => 'frontErr',
    'rear' => 'rearErr',
    'side' => 'sideErr',
    'scrabble' => 'scrabbleErr',
    'drop' => 'dropErr',
    'punt' => 'puntErr',
    'grubber' => 'grubberErr',
    'goal' => 'goalErr',
];

$standard = $spin = $pop = $front = $rear = $side = $scrabble = $drop = $punt = $grubber = $goal = "";
$standardErr = $spinErr = $popErr = $frontErr = $rearErr = $sideErr = $scrabbleErr = $dropErr = $puntErr = $grubberErr = $goalErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["standard"])){
    $standard = $skillLevel[0];


  } else {
    $standard = test_input($_POST["sru"]);
    if (!preg_match("/^\d+$/", $sru)) {
        $standardErr = "Only digits allowed";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<form 
    method="POST"
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $player["player_id"];?>">
    <div id="passing-form">
      <h2>Passing Category</h2>
      <?php foreach ($playerSkills as $playerSkill): ?>
          <?php
      
          $inputName = strtolower(Utils::escape($playerSkill["skill_name"]));
          $errorMsg = $errorMessages[$inputName] ?? '';
          $skillLevelPlaceholder = Utils::escape($playerSkill["skill_level"]);

          ?>
      
      <?php if (Utils::escape($playerSkill["category"]) == "Passing"){
          ?>
          <label  class="col-sm-2 col-form-label-sm"for="dob"><?php if($playerSkill["category"] == "Passing"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?></label><br>
          <input type="text" name="<?php $inputName; ?>" placeholder="<?php echo $skillLevelPlaceholder; ?>" value="<?php echo ${$inputName};?>">
          <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>
      <?php } ?>
      <?php endforeach; ?>
      
      <input type="button" value="Next" onclick="nextTab()">
    </div>

    <div id="tackling-form">
      <h2>Tackling Category</h2>
      <?php foreach ($playerSkills as $playerSkill): ?>
          <?php
      
          $inputName = strtolower(Utils::escape($playerSkill["skill_name"]));
          $errorMsg = $errorMessages[$inputName] ?? '';
      
          ?>
      
      <?php if (Utils::escape($playerSkill["category"]) == "Tackling"){
          ?>
          <h3><?php if($playerSkill["category"] == "Passing"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?> </h3>
          <label  class="col-sm-2 col-form-label-sm"for="dob">Date of Birth:</label><br>
          <input type="text" name="<?php $inputName; ?>" placeholder="<?php echo Utils::escape($playerSkill["skill_level"]);?>" value="<?php echo ${$inputName};?>">
          <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>
      <?php } ?>
      <?php endforeach; ?>
      <input type="button" value="Previous" onclick="prevTab()">

      <input type="button" value="Next" onclick="nextTab()">
    </div>

    <div id="kicking-form">
      <h2>Kicking Category</h2>
          <?php foreach ($playerSkills as $playerSkill): ?>
          <?php
      
          $inputName = strtolower(Utils::escape($playerSkill["skill_name"]));
          $errorMsg = $errorMessages[$inputName] ?? '';
      
          ?>
      
      <?php if (Utils::escape($playerSkill["category"]) == "Kicking"){
          ?>
          <h3><?php if($playerSkill["category"] == "Passing"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?> </h3>
          <label  class="col-sm-2 col-form-label-sm"for="dob">Date of Birth:</label><br>
          <input type="text" name="<?php $inputName; ?>" placeholder="<?php echo Utils::escape($playerSkill["skill_level"]);?>" value="<?php echo ${$inputName};?>">
          <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>
      <?php } ?>
      <?php endforeach; ?>
      <input type="button" value="Previous" onclick="prevTab()">
      <input type="submit" name="submit" value="Submit">
    </div>

</form>
<script>

    var currentTab = 0;
    const pForm = document.getElementById("passing-form");
    const tForm = document.getElementById("tackling-form");
    const kForm = document.getElementById("kicking-form");

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
          pForm.style.display = "block";
          tForm.style.display = "none";
          kForm.style.display = "none";
        }

        else if (currentTab == 1){
          pForm.style.display = "none";
          tForm.style.display = "block";
          kForm.style.display = "none";
        }

        else{
          pForm.style.display = "none";
          tForm.style.display = "none";
          kForm.style.display = "block";

        }
    }

  </script>