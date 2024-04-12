<?php
/// This must come first when we need access to the current session
session_start();


require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/junior.php");

/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){
  
  header("Location: " . Utils::$projectFilePath . "/login.php");

}
/// Redirect to logout page if user role is neither Admin nor Coach

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Redirects to the junior list page if the 'id' parameter is not set in the GET request or if it is not a numeric value.
 */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/junior-list.php");
  }
  

  
$junior = Junior::getJunior($_GET["id"]); ///< Get junior's details by it's ID
  
$juniorId = $junior['junior_id']; ///< Get ID of junior

$pageTitle = "junior not found"; ///< Default title

/**
 * Set the page title to display the details of junior if the junior array is not empty.
 *
 * @param array $junior An array containing information about the junior.
 */
if (!empty($junior)) {
  $pageTitle = "Update " . $junior["first_name"] . "'s Skills";
}

$juniorSkills = Junior::getJuniorSkills($_GET["id"]); ///< Get skills of specific junior

/**
 * Escape and assign values from the $juniorSkills array to respective variables for security purposes.
 *
 * @param array $juniorSkills An array containing information about the junior skills.
 * 
 */

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



Components::pageHeader("$pageTitle", ["style"], ["mobile-nav"]); ///< Render page header

/**
 * Get level of each skill for specific junior
 */
foreach($juniorSkills as $juniorSkill){
  $skillLevel = Utils::escape($juniorSkill["skill_level"]);
}
/**
 * Array with error messages for each skill name
 * 
 * If the skill name matches the one in the array, appropiate error message will be assigned.
 */
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

/**
 * Array with placeholder variable names for each skill name
 * 
 * If skill name matches the one in the array, appropiate placeholder variable will be assigned.
 */

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

/**
 * Variables to hold error messages for form validation.
 *
 * @var string $standardErr - Error message for standard skill validation
 * @var string $spinErr - Error message for spin skill validation
 * @var string $popErr - Error message for pop skill validation
 * @var string $frontErr - Error message for front skill validation
 * @var string $rearErr - Error message for rear skill validation
 * @var string $sideErr - Error message for side skill validation
 * @var string $scrabbleErr - Error message for srabble skill validation
 * @var string $dropErr - Error message for drop skill validation
 * @var string $puntErr - Error message for punt skill validation
 * @var string $grubberErr - Error message for grubber skill validation
 * @var string $goalErr - Error message for goal skill validation
 *
 * Variables to hold form input values.
 *
 * @var int $standard - String containing standard skill level information
 * @var int $spin - String containing spin skill level information
 * @var int $pop - String containing pop skill level information
 * @var int $front - String containing front skill level information
 * @var int $rear - String containing rear skill level information
 * @var int $side - String containing side skill level information
 * @var int $scrabble - String containing scrabble skill level information
 * @var int $drop - String containing drop skill level information
 * @var int $punt - String containing punt skill level information
 * @var int $grubber - String containing grubber skill level information
 * @var int $goal - String containing goal skill skill level information
 * 
 * @var string $standardComment - String containing coach's comment for standard skill.
 * @var string $spinComment - String containing coach's comment for spin skill.
 * @var string $popComment  - String containing coach's comment for pop skill.
 * @var string $frontComment  - String containing coach's comment for front skill.
 * @var string $rearComment  - String containing coach's comment for rear skill.
 * @var string $sideComment  - String containing coach's comment for side skill.
 * @var string $scrabbleComment  - String containing coach's comment for scrabble skill.
 * @var string $dropComment  - String containing coach's comment for drop skill.
 * @var string $puntComment  - String containing coach's comment for punt skill.
 * @var string $grubberComment  - String containing coach's comment for grubber skill.
 * @var string $goalComment  - String containing coach's comment for goal skill.
 * 
**/


$standard = $spin = $pop = $front = $rear = $side = $scrabble = $drop = $punt = $grubber = $goal = "";
$standardErr = $spinErr = $popErr = $frontErr = $rearErr = $sideErr = $scrabbleErr = $dropErr = $puntErr = $grubberErr = $goalErr = "";

$standardComment = $spinComment = $popComment = $frontComment = $rearComment = $sideComment = $scrabbleComment = $dropComment = $puntComment = $grubberComment = $goalComment = "";



/**
 * Validates the form inputs and processes the data accordingly.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  /// Passing Skills
  if (empty($_POST["standard"])){
    $standard = $standardPlaceholder; ///< Set value to placeholder's value if left empty


  } else {
    /// Only accept integer values
    $standard = test_input($_POST["standard"]); ///< Sanitize standard skill value.
    if (!preg_match("/^\d+$/", $standard)) {
        $standardErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["standard"])){
    $spin = $spinPlaceholder; ///< Set value to placeholder's value if left empty


  } else {
    $spin = test_input($_POST["spin"]); ///< Sanitize spin skill value.
    if (!preg_match("/^\d+$/", $spin)) {
        $spinErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["pop"])){
    $pop = $popPlaceholder; ///< Set value to placeholder's value if left empty


  } else {
    $pop = test_input($_POST["pop"]); ///< Sanitize pop skill value.
    if (!preg_match("/^\d+$/", $pop)) {
        $popErr = "Only digits allowed"; ///< Display error message
    }
  }

  /// Tackling Skills


  if (empty($_POST["front"])){
    $front = $frontPlaceholder; ///< Set value to placeholder's value if left empty


  } else {
    $front = test_input($_POST["front"]); ///< Sanitize front skill value.
    if (!preg_match("/^\d+$/", $front)) {
        $frontErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["rear"])){
    $rear = $rearPlaceholder; ///< Set value to placeholder's value if left empty


  } else {
    $rear = test_input($_POST["rear"]); ///< Sanitize rear skill value.
    if (!preg_match("/^\d+$/", $rear)) {
        $rearErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["side"])){
    $side = $sidePlaceholder; ///< Set value to placeholder's value if left empty


  } else {
    $side = test_input($_POST["side"]); ///< Sanitize side skill value.
    if (!preg_match("/^\d+$/", $side)) {
        $sideErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["scrabble"])){
    $scrabble = $scrabblePlaceholder; ///< Set value to placeholder's value if left empty


  } else {
    $scrabble = test_input($_POST["scrabble"]); ///< Sanitize scrabble skill value.
    if (!preg_match("/^\d+$/", $scrabble)) {
        $scrabbleErr = "Only digits allowed"; ///< Display error message
    }
  }

  /// Kicking Category

  if (empty($_POST["drop"])){
    $drop = $dropPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $drop = test_input($_POST["drop"]); ///< Sanitize drop skill value.
    if (!preg_match("/^\d+$/", $drop)) {
        $dropErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["punt"])){
    $punt = $puntPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $punt = test_input($_POST["punt"]); ///< Sanitize punt skill value.
    if (!preg_match("/^\d+$/", $punt)) {
        $puntErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["grubber"])){
    $grubber = $grubberPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $grubber = test_input($_POST["grubber"]); ///< Sanitize grubber skill value.
    if (!preg_match("/^\d+$/", $grubber)) {
        $grubberErr = "Only digits allowed"; ///< Display error message
    }
  }

  if (empty($_POST["goal"])){
    $goal = $goalPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $goal = test_input($_POST["goal"]); ///< Sanitize goal skill value.
    if (!preg_match("/^\d+$/", $goal)) {
        $goalErr = "Only digits allowed"; ///< Display error message
    }
  }

  ///Comment Validation

  if(empty($_POST["standardComment"])){
    $standardComment = $standardCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $standardComment = test_input($_POST["standardComment"]); ///< Sanitize standard comment
  }

  if(empty($_POST["spinComment"])){
    $spinComment = $spinCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $spinComment = test_input($_POST["spinComment"]); ///< Sanitize spin comment
  }

  if(empty($_POST["popComment"])){
    $popComment = $popCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $popComment = test_input($_POST["popComment"]); ///< Sanitize pop comment
  }

  if(empty($_POST["frontComment"])){
    $frontComment = $frontCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $frontComment = test_input($_POST["frontComment"]); ///< Sanitize front comment
  }

  if(empty($_POST["rearComment"])){
    $rearComment = $rearCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $rearComment = test_input($_POST["rearComment"]); ///< Sanitize rear comment
  }

  if(empty($_POST["sideComment"])){
    $sideComment = $sideCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $sideComment = test_input($_POST["sideComment"]); ///< Sanitize side comment
  }

  if(empty($_POST["scrabbleComment"])){
    $scrabbleComment = $scrabbleCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $scrabbleComment = test_input($_POST["scrabbleComment"]); ///< Sanitize scrabble comment
  }

  if(empty($_POST["dropComment"])){
    $dropComment = $dropCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $dropComment = test_input($_POST["dropComment"]); ///< Sanitize drop comment
  }

  if(empty($_POST["puntComment"])){
    $puntComment = $puntCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $puntComment = test_input($_POST["puntComment"]); ///< Sanitize punt comment
  }

  if(empty($_POST["grubberComment"])){
    $grubberComment = $grubberCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $grubberComment = test_input($_POST["grubberComment"]); ///< Sanitize grubber comment
  }

  if(empty($_POST["goalComment"])){
    $goal = $goalCommentPlaceholder; ///< Set value to placeholder's value if left empty

  } else {
    $goalComment = test_input($_POST["goalComment"]); ///< Sanitize goal comment
  }
    
  /// If there are no errors, proceed with sql querries
  if(empty($standardErr) && empty($spinErr) && empty($popErr) 
  && empty($frontErr) && empty($rearErr) && empty($sideErr) && empty($scrabbleErr) 
  && empty($dropErr) && empty($puntErr) && empty($grubberErr) && empty($goalErr)){


    /**
     * Update the skills of a junior player with the provided parameters.
     *
     * @param int $skill - Int containing skill level to be updated
     * @param string $comment - String containing coach's comment for that skill
     * @param int $skillId - Int containing ID of skill to be updated
     * @param int $juniorId - Int containing ID of junior for which skill will be updated.
     */
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
<main class="content-wrapper profile-list-content my-5">

  <form 
      method="POST"
      action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $junior["junior_id"];?>">
      <div id="passing-form">
        <!-- Populate dropdown with records from database -->
        <h2>Passing Category</h2>
        <?php foreach ($juniorSkills as $juniorSkill): ?>
            <?php
        
            $inputName = strtolower(Utils::escape($juniorSkill["skill_name"]));

            $errorMsg = $errorMessages[$inputName] ?? ''; ///< Check if $inputName matches a key in the $errorMessage array, and assign error message if there's a match
            $skillLevelPlaceholder = $placeHolders[$inputName] ?? ''; ///< Check if $inputName matches a key in the $placeHolders array, and assign placeholder variable for skill level if there's a match.
            $commentField = strtolower($inputName) . 'Comment'; ///< convert $inputName to lower case and add 'Comment' at the end to create a commentField variable.


            $commentPlaceholder = $placeHolders[$commentField] ?? ''; ///< Check if $commentField matches a key in the $placeholders array, and assign placeholder variable for comment if there's a match

            

            ?>
        
        <!-- Check for specific skill category, and only output records under that category -->
        <?php if (Utils::escape($juniorSkill["category"]) == "Passing"){
            ?>
            <label  class="col-sm-2 col-form-label-sm"for="<?php echo strtolower($inputName); ?>"><?php if($juniorSkill["category"] == "Passing"){ echo Utils::escape($juniorSkill["skill_name"]) . ' Skill';} ?></label><br>
            <input type="text" name="<?php echo strtolower($inputName); ?>" placeholder="<?php echo ${$skillLevelPlaceholder}; ?>" value="<?php echo ${strtolower($inputName)};?>"> <!-- Get placeholder from the array, and use the right value -->
            <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br> <!-- Get error message from the array -->

            <label  class="col-sm-2 col-form-label-sm"for="<?php echo $commentField; ?>"><?php if($juniorSkill["category"] == "Passing"){echo'Comment';} ?></label><br>
            <input type="text" name="<?php echo $commentField; ?>" placeholder="<?php echo ${$commentPlaceholder};?>" value="<?php echo ${$commentField};?>">
        <?php } ?>
        <?php endforeach; ?>
        
        <input type="button" value="Next" onclick="nextTab()">
      </div>

      <div id="tackling-form">
        <h2>Tackling Category</h2>
        <?php foreach ($juniorSkills as $juniorSkill): ?>
            <?php
        
        $inputName = strtolower(Utils::escape($juniorSkill["skill_name"]));

        $errorMsg = $errorMessages[$inputName] ?? ''; //< Check if $inputName matches a key in the $errorMessage array, and assign error message if there's a match
        $skillLevelPlaceholder = $placeHolders[$inputName] ?? ''; ///< Check if $inputName matches a key in the $placeHolders array, and assign placeholder variable for skill level if there's a match.
        $commentField = strtolower($inputName) . 'Comment'; ///< convert $inputName to lower case and add 'Comment' at the end to create a commentField variable.


        $commentPlaceholder = $placeHolders[$commentField] ?? ''; ///< Check if $commentField matches a key in the $placeholders array, and assign placeholder variable for comment if there's a match

            ?>
        <!-- Check for specific skill category, and only output records under that category -->
        <?php if (Utils::escape($juniorSkill["category"]) == "Tackling"){
            ?>
            <h3><?php if($juniorSkill["category"] == "Passing"){ echo Utils::escape($juniorSkill["skill_name"]) . ' Skill';} ?> </h3>
            <label  class="col-sm-2 col-form-label-sm"for="<?php echo strtolower($inputName); ?>"><?php if($juniorSkill["category"] == "Tackling"){ echo Utils::escape($juniorSkill["skill_name"]) . ' Skill';} ?></label><br>
            <input type="text" name="<?php echo strtolower($inputName); ?>" placeholder="<?php echo Utils::escape($juniorSkill["skill_level"]);?>" value="<?php echo ${strtolower($inputName)};?>"> <!-- Get placeholder from the array, and use the right value -->
            <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br> <!-- Get error message from the array -->

            <label  class="col-sm-2 col-form-label-sm"for="<?php echo $commentField; ?>"><?php if($juniorSkill["category"] == "Tackling"){echo'Comment';} ?></label><br>
            <input type="text" name="<?php echo $commentField; ?>" placeholder="<?php echo ${$commentPlaceholder};?>" value="<?php echo ${$commentField};?>">

        <?php } ?>
        <?php endforeach; ?>
        <input type="button" value="Previous" onclick="prevTab()">

        <input type="button" value="Next" onclick="nextTab()">
      </div>

      <div id="kicking-form">
        <h2>Kicking Category</h2>
            <?php foreach ($juniorSkills as $juniorSkill): ?>
            <?php
        
        $inputName = strtolower(Utils::escape($juniorSkill["skill_name"]));

        $errorMsg = $errorMessages[$inputName] ?? ''; //< Check if $inputName matches a key in the $errorMessage array, and assign error message if there's a match
        $skillLevelPlaceholder = $placeHolders[$inputName] ?? ''; ///< Check if $inputName matches a key in the $placeHolders array, and assign placeholder variable for skill level if there's a match.
        $commentField = strtolower($inputName) . 'Comment'; ///< convert $inputName to lower case and add 'Comment' at the end to create a commentField variable.


        $commentPlaceholder = $placeHolders[$commentField] ?? '';
        
            ?>
        <!-- Check for specific skill category, and only output records under that category -->
        <?php if (Utils::escape($juniorSkill["category"]) == "Kicking"){
            ?>
            <h3><?php if($juniorSkill["category"] == "Passing"){ echo Utils::escape($juniorSkill["skill_name"]) . ' Skill';} ?> </h3>
            <label  class="col-sm-2 col-form-label-sm"for="dob"><?php if($juniorSkill["category"] == "Kicking"){ echo Utils::escape($juniorSkill["skill_name"]) . ' Skill';} ?></label><br>
            <input type="text" name="<?php echo strtolower($inputName); ?>" placeholder="<?php echo Utils::escape($juniorSkill["skill_level"]);?>" value="<?php echo ${strtolower($inputName)};?>"> <!-- Get placeholder from the array, and use the right value -->
            <p class="alert alert-danger"><?php echo ${$errorMsg}; ?></p><br> <!-- Get error message from the array -->

            <label  class="col-sm-2 col-form-label-sm"for="<?php echo $commentField; ?>"><?php if($juniorSkill["category"] == "Kicking"){echo'Comment';} ?></label><br>
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



    /**
     * Show the tab based on the currentTab value.
     */

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