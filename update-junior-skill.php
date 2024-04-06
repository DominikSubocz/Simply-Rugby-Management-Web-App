<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/junior.php");

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

session_start();

/*
  Attempt to get the id from the URL parameter.
  If it isn't set or it isn't a number, redirect
  to junior list page.
*/
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/junior-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }
  
  $junior = Junior::getJunior($_GET["id"]);
  
$juniorId = $junior['junior_id'];

// Set the document title to the title and author of the junior if it exists
$pageTitle = "junior not found";

if (!empty($junior)) {
  $pageTitle = "Update " . $junior["first_name"] . "'s Skills";
}

$juniorSkills = Junior::getJuniorSkills($_GET["id"]);

$standardPlaceholder = Utils::escape($juniorSkills[0]["skill_level"]);
$spinPlaceholder = Utils::escape($juniorSkills[1]["skill_level"]);
$popPlaceholder = Utils::escape($juniorSkills[2]["skill_level"]);
$frontPlaceholder = Utils::escape($juniorSkills[3]["skill_level"]);
$rearPlaceholder = Utils::escape($juniorSkills[4]["skill_level"]);
$sidePlaceholder = Utils::escape($juniorSkills[5]["skill_level"]);
$scrabblePlaceholder = Utils::escape($juniorSkills[6]["skill_level"]);
$dropPlaceholder = Utils::escape($juniorSkills[7]["skill_level"]);
$puntPlaceholder = Utils::escape($juniorSkills[8]["skill_level"]);
$grubberPlaceholder = Utils::escape($juniorSkills[9]["skill_level"]);
$goalPlaceholder = Utils::escape($juniorSkills[10]["skill_level"]);


$standardCommentPlaceholder = Utils::escape($juniorSkills[0]["comment"]);
$spinCommentPlaceholder = Utils::escape($juniorSkills[1]["comment"]);
$popCommentPlaceholder = Utils::escape($juniorSkills[2]["comment"]);
$frontCommentPlaceholder = Utils::escape($juniorSkills[3]["comment"]);
$rearCommentPlaceholder = Utils::escape($juniorSkills[4]["comment"]);
$sideCommentPlaceholder = Utils::escape($juniorSkills[5]["comment"]);
$scrabbleCommentPlaceholder = Utils::escape($juniorSkills[6]["comment"]);
$dropCommentPlaceholder = Utils::escape($juniorSkills[7]["comment"]);
$puntCommentPlaceholder = Utils::escape($juniorSkills[8]["comment"]);
$grubberCommentPlaceholder = Utils::escape($juniorSkills[9]["comment"]);
$goalCommentPlaceholder = Utils::escape($juniorSkills[10]["comment"]);



Components::pageHeader("$pageTitle", ["style"], ["mobile-nav"]);

foreach($juniorSkills as $playerSkill){
  $skillLevel = Utils::escape($playerSkill["skill_level"]);

}

foreach($juniorSkills as $playerSkill){

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
    'goal' => 'goalErr'
];


$placeHolders = [
  'standard' => 'standardPlaceholder',
  'spin' => 'spinPlaceholder',
  'pop' => 'popPlaceholder',
  'front' => 'frontPlaceholder',
  'rear' => 'rearPlaceholder',
  'side' => 'sidePlaceholder',
  'scrabble' => 'scrabblePlaceholder',
  'drop' => 'dropPlaceholder',
  'punt' => 'puntPlaceholder',
  'grubber' => 'grubberPlaceholder',
  'goal' => 'goalPlaceholder',
  'standardComment' => 'standardCommentPlaceholder',
  'spinComment' => 'spinCommentPlaceholder',
  'popComment' => 'popCommentPlaceholder',
  'frontComment' => 'frontCommentPlaceholder',
  'rearComment' => 'rearCommentPlaceholder',
  'sideComment' => 'sideCommentPlaceholder',
  'scrabbleComment' => 'scrabbleCommentPlaceholder',
  'dropComment' => 'dropCommentPlaceholder',
  'puntComment' => 'puntCommentPlaceholder',
  'grubberComment' => 'grubberCommentPlaceholder',
  'goalComment' => 'goalCommentPlaceholder'
];



$standard = $spin = $pop = $front = $rear = $side = $scrabble = $drop = $punt = $grubber = $goal = "";
$standardErr = $spinErr = $popErr = $frontErr = $rearErr = $sideErr = $scrabbleErr = $dropErr = $puntErr = $grubberErr = $goalErr = "";

$standardComment = $spinComment = $popComment = $frontComment = $rearComment = $sideComment = $scrabbleComment = $dropComment = $puntComment = $grubberComment = $goalComment = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Passing Skills
  if (empty($_POST["standard"])){
    $standard = $standardPlaceholder;


  } else {
    $standard = test_input($_POST["standard"]);
    if (!preg_match("/^\d+$/", $standard)) {
        $standardErr = "Only digits allowed";
    }
  }

  if (empty($_POST["standard"])){
    $spin = $spinPlaceholder;


  } else {
    $spin = test_input($_POST["spin"]);
    if (!preg_match("/^\d+$/", $spin)) {
        $spinErr = "Only digits allowed";
    }
  }

  if (empty($_POST["pop"])){
    $pop = $popPlaceholder;


  } else {
    $pop = test_input($_POST["pop"]);
    if (!preg_match("/^\d+$/", $pop)) {
        $popErr = "Only digits allowed";
    }
  }

  // Tackling Skills


  if (empty($_POST["front"])){
    $front = $frontPlaceholder;


  } else {
    $front = test_input($_POST["front"]);
    if (!preg_match("/^\d+$/", $front)) {
        $frontErr = "Only digits allowed";
    }
  }

  if (empty($_POST["rear"])){
    $rear = $rearPlaceholder;


  } else {
    $rear = test_input($_POST["rear"]);
    if (!preg_match("/^\d+$/", $rear)) {
        $rearErr = "Only digits allowed";
    }
  }

  if (empty($_POST["side"])){
    $side = $sidePlaceholder;


  } else {
    $side = test_input($_POST["side"]);
    if (!preg_match("/^\d+$/", $side)) {
        $sideErr = "Only digits allowed";
    }
  }

  if (empty($_POST["scrabble"])){
    $scrabble = $scrabblePlaceholder;


  } else {
    $scrabble = test_input($_POST["scrabble"]);
    if (!preg_match("/^\d+$/", $scrabble)) {
        $scrabbleErr = "Only digits allowed";
    }
  }

  // Kicking Category

  if (empty($_POST["drop"])){
    $drop = $dropPlaceholder;

  } else {
    $drop = test_input($_POST["drop"]);
    if (!preg_match("/^\d+$/", $drop)) {
        $dropErr = "Only digits allowed";
    }
  }

  if (empty($_POST["punt"])){
    $punt = $puntPlaceholder;

  } else {
    $punt = test_input($_POST["punt"]);
    if (!preg_match("/^\d+$/", $punt)) {
        $puntErr = "Only digits allowed";
    }
  }

  if (empty($_POST["grubber"])){
    $grubber = $grubberPlaceholder;

  } else {
    $grubber = test_input($_POST["grubber"]);
    if (!preg_match("/^\d+$/", $grubber)) {
        $grubberErr = "Only digits allowed";
    }
  }

  if (empty($_POST["goal"])){
    $goal = $goalPlaceholder;

  } else {
    $goal = test_input($_POST["goal"]);
    if (!preg_match("/^\d+$/", $goal)) {
        $goalErr = "Only digits allowed";
    }
  }

  //Comment Validation

  if(empty($_POST["standardComment"])){
    $standardComment = $standardCommentPlaceholder;

  } else {
    $standardComment = test_input($_POST["standardComment"]);
  }

  if(empty($_POST["spinComment"])){
    $spinComment = $spinCommentPlaceholder;

  } else {
    $spinComment = test_input($_POST["spinComment"]);
  }

  if(empty($_POST["popComment"])){
    $popComment = $popCommentPlaceholder;

  } else {
    $popComment = test_input($_POST["popComment"]);
  }

  if(empty($_POST["frontComment"])){
    $frontComment = $frontCommentPlaceholder;

  } else {
    $frontComment = test_input($_POST["frontComment"]);
  }

  if(empty($_POST["rearComment"])){
    $rearComment = $rearCommentPlaceholder;

  } else {
    $rearComment = test_input($_POST["rearComment"]);
  }

  if(empty($_POST["sideComment"])){
    $sideComment = $sideCommentPlaceholder;

  } else {
    $sideComment = test_input($_POST["sideComment"]);
  }

  if(empty($_POST["scrabbleComment"])){
    $scrabbleComment = $scrabbleCommentPlaceholder;

  } else {
    $scrabbleComment = test_input($_POST["scrabbleComment"]);
  }

  if(empty($_POST["dropComment"])){
    $dropComment = $dropCommentPlaceholder;

  } else {
    $dropComment = test_input($_POST["dropComment"]);
  }

  if(empty($_POST["puntComment"])){
    $puntComment = $puntCommentPlaceholder;

  } else {
    $puntComment = test_input($_POST["puntComment"]);
  }

  if(empty($_POST["grubberComment"])){
    $grubberComment = $grubberCommentPlaceholder;

  } else {
    $grubberComment = test_input($_POST["grubberComment"]);
  }

  if(empty($_POST["goalComment"])){
    $goal = $goalCommentPlaceholder;

  } else {
    $goalComment = test_input($_POST["goalComment"]);
  }

  if(empty($standardErr) && empty($spinErr) && empty($popErr) 
  && empty($frontErr) && empty($rearErr) && empty($sideErr) && empty($scrabbleErr) 
  && empty($dropErr) && empty($puntErr) && empty($grubberErr) && empty($goalErr)){


    Junior::updateJuniorSkills($standard, $standardComment, 1, $juniorId);
    Junior::updateJuniorSkills($spin, $spinComment, 2, $juniorId);
    Junior::updateJuniorSkills($pop, $popComment, 3, $juniorId);
    Junior::updateJuniorSkills($front, $frontComment, 4, $juniorId);
    Junior::updateJuniorSkills($rear, $rearComment, 5, $juniorId);
    Junior::updateJuniorSkills($side, $sideComment, 6, $juniorId);
    Junior::updateJuniorSkills($scrabble, $scrabbleComment, 7, $juniorId);
    Junior::updateJuniorSkills($drop, $dropComment, 8, $juniorId);
    Junior::updateJuniorSkills($punt, $puntComment, 9, $juniorId);
    Junior::updateJuniorSkills($grubber, $grubberComment, 10, $juniorId);
    Junior::updateJuniorSkills($goal, $goalComment, 11, $juniorId);

  }

  

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
<main class="content-wrapper profile-list-content my-5">

  <form 
      method="POST"
      action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $junior["junior_id"];?>">
      <div id="passing-form">
        <h2>Passing Category</h2>
        <?php foreach ($juniorSkills as $playerSkill): ?>
            <?php
        
            $inputName = strtolower(Utils::escape($playerSkill["skill_name"]));

            $errorMsg = $errorMessages[$inputName] ?? '';
            $skillLevelPlaceholder = $placeHolders[$inputName] ?? '';
            $commentField = strtolower($inputName) . 'Comment';


            $commentPlaceholder = $placeHolders[$commentField] ?? '';

            

            ?>
        
        <?php if (Utils::escape($playerSkill["category"]) == "Passing"){
            ?>
            <label  class="col-sm-2 col-form-label-sm"for="<?php echo strtolower($inputName); ?>"><?php if($playerSkill["category"] == "Passing"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?></label><br>
            <input type="text" name="<?php echo strtolower($inputName); ?>" placeholder="<?php echo ${$skillLevelPlaceholder}; ?>" value="<?php echo ${strtolower($inputName)};?>">
            <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>

            <label  class="col-sm-2 col-form-label-sm"for="<?php echo $commentField; ?>"><?php if($playerSkill["category"] == "Passing"){echo'Comment';} ?></label><br>
            <input type="text" name="<?php echo $commentField; ?>" placeholder="<?php echo ${$commentPlaceholder};?>" value="<?php echo ${$commentField};?>">
        <?php } ?>
        <?php endforeach; ?>
        
        <input type="button" value="Next" onclick="nextTab()">
      </div>

      <div id="tackling-form">
        <h2>Tackling Category</h2>
        <?php foreach ($juniorSkills as $playerSkill): ?>
            <?php
        
        $inputName = strtolower(Utils::escape($playerSkill["skill_name"]));

        $errorMsg = $errorMessages[$inputName] ?? '';
        $skillLevelPlaceholder = $placeHolders[$inputName] ?? '';
        $commentField = strtolower($inputName) . 'Comment';


        $commentPlaceholder = $placeHolders[$commentField] ?? '';

            ?>
        
        <?php if (Utils::escape($playerSkill["category"]) == "Tackling"){
            ?>
            <h3><?php if($playerSkill["category"] == "Passing"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?> </h3>
            <label  class="col-sm-2 col-form-label-sm"for="<?php echo strtolower($inputName); ?>"><?php if($playerSkill["category"] == "Tackling"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?></label><br>
            <input type="text" name="<?php echo strtolower($inputName); ?>" placeholder="<?php echo Utils::escape($playerSkill["skill_level"]);?>" value="<?php echo ${strtolower($inputName)};?>">
            <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>

            <label  class="col-sm-2 col-form-label-sm"for="<?php echo $commentField; ?>"><?php if($playerSkill["category"] == "Tackling"){echo'Comment';} ?></label><br>
            <input type="text" name="<?php echo $commentField; ?>" placeholder="<?php echo ${$commentPlaceholder};?>" value="<?php echo ${$commentField};?>">

        <?php } ?>
        <?php endforeach; ?>
        <input type="button" value="Previous" onclick="prevTab()">

        <input type="button" value="Next" onclick="nextTab()">
      </div>

      <div id="kicking-form">
        <h2>Kicking Category</h2>
            <?php foreach ($juniorSkills as $playerSkill): ?>
            <?php
        
        $inputName = strtolower(Utils::escape($playerSkill["skill_name"]));

        $errorMsg = $errorMessages[$inputName] ?? '';
        $skillLevelPlaceholder = $placeHolders[$inputName] ?? '';
        $commentField = strtolower($inputName) . 'Comment';


        $commentPlaceholder = $placeHolders[$commentField] ?? '';
        
            ?>
        
        <?php if (Utils::escape($playerSkill["category"]) == "Kicking"){
            ?>
            <h3><?php if($playerSkill["category"] == "Passing"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?> </h3>
            <label  class="col-sm-2 col-form-label-sm"for="dob"><?php if($playerSkill["category"] == "Kicking"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?></label><br>
            <input type="text" name="<?php echo strtolower($inputName); ?>" placeholder="<?php echo Utils::escape($playerSkill["skill_level"]);?>" value="<?php echo ${strtolower($inputName)};?>">
            <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>

            <label  class="col-sm-2 col-form-label-sm"for="<?php echo $commentField; ?>"><?php if($playerSkill["category"] == "Kicking"){echo'Comment';} ?></label><br>
            <input type="text" name="<?php echo $commentField; ?>"placeholder="<?php echo ${$commentPlaceholder};?>" value="<?php echo ${$commentField};?>">

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
  </main>