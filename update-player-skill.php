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


?>

<form 
    method="POST"
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $player["player_id"];?>">
    <h2>Passing Category</h2>
    <?php foreach ($playerSkills as $playerSkill): ?>

        <?php 
        
        $inputName = strtolower(Utils::escape($playerSkill["skill_name"])); 

        $errorMsg = $errorMessages[$inputName] ?? '';

        
        ?>
        
    <?php if (Utils::escape($playerSkill["category"]) == "Passing"){
        ?>

        <h3><?php if($playerSkill["category"] == "Passing"){ echo Utils::escape($playerSkill["skill_name"]) . ' Skill';} ?> </h3>
        <label  class="col-sm-2 col-form-label-sm"for="dob">Date of Birth:</label><br>
        <input type="text" name="<?php $inputName; ?>" placeholder="<?php echo $ukDobPlaceholder;?>" value="<?php echo $dob;?>">
        <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>
    <?php } ?>
    <?php endforeach; ?>
    
    <br>    

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
        <input type="text" name="<?php $inputName; ?>" placeholder="<?php echo $ukDobPlaceholder;?>" value="<?php echo $dob;?>">
        <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>
    <?php } ?>
    <?php endforeach; ?>











    <br>    

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
        <input type="text" name="<?php $inputName; ?>" placeholder="<?php echo $ukDobPlaceholder;?>" value="<?php echo $dob;?>">
        <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br>
    <?php } ?>
    <?php endforeach; ?>
</form>
