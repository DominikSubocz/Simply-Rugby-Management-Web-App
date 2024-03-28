<?php

session_start();

require("classes/components.php");
require("classes/utils.php");
require("classes/events.php");
require("classes/connection.php");
require("classes/sql.php");

if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
} 

$session = Events::getSession($_GET["id"]);

$pageTitle = "Session not found";

if(!empty($game)){
    $pageTitle = $session["name"] . "Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);

$sessionId = Utils::escape($session["session_id"]);


$sessionName = Utils::escape($session["name"]);
$sessionSquadId = Utils::escape($session["squad_id"]);
$sessionCoachId = Utils::escape($session["coach_id"]);
$sessionLocation = Utils::escape($session["location"]);

$trainingDetails = Events::getTrainingDetails($sessionId);
foreach($trainingDetails as $trainingDetail){
    $trainingDetailId = Utils::escape($trainingDetail["training_details_id"]);
}

$skills = $activities = $playersPresent = $accidents = $injuries = "";
$skillsErr = $activitiesErr = $playersPresentErr = $accidentsErr = $injuriesErr = "";



$name = $coach = $squad = $start = $end = $location = "";
$nameErr = $coachErr = $squadErr = $startErr = $endErr = $locationErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

        // Validate name
        if (empty($_POST["coach"])) {
            $coachErr = "Coach ID number is required";
        } else {
            $coach = test_input($_POST["coach"]);
        }

        if (empty($_POST["squad"])) {
            $squadErr = "Squad ID number is required";
        } else {
            $squad = test_input($_POST["squad"]);
        }

        if (empty($_POST["start"])) {
            $startErr = "Start date is required";
        } else {
            $start = test_input($_POST["start"]);
        }

        if (empty($_POST["end"])) {
            $endErr = "End date is required";
        } else {
            $end = test_input($_POST["end"]);
        }

        if (empty($_POST["location"])) {
            $locationErr = "Location is required";
        } else {
            $location = test_input($_POST["location"]);
        }

        // Training Details

        // Validate name
        if (empty($_POST["skills"])) {
            $skillsErr = "Skills are required";
        } else {
            $skills = test_input($_POST["skills"]);
        }

        if (empty($_POST["activities"])) {
            $activitiesErr = "Activities are required";
        } else {
            $activities = test_input($_POST["activities"]);
        }

        if (empty($_POST["present_players"])) {
            $playersPresentErr = "Present players are required";
        } else {
            $playersPresent = test_input($_POST["present_players"]);
        }

        if (empty($nameErr) && empty($coachErr) && empty($squadErr) && empty($startErr) && empty($endErr) && empty($locationErr) 
        && empty($skillsErr) && empty($activitiesErr) && empty($playersPresentErr) && empty($accidentsErr) && empty($injuriesErr)){
    

            Events::updateSession($coach, $squad, $name, $start, $end, $location, $skills, $activities, $playersPresent, $accidents, $injuries, $sessionId, $trainingDetailId);
        
            header("Location: " . Utils::$projectFilePath . "/timetable.php");

        }

}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<main class="content-wrapper profile-list-content">
    <form 
        method="POST"
        action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $session["session_id"];?>">


    
    <div id="basic-session-details">
        <label for="name">Name:</label><br>
        <input type="text" name="name" placeholder="<?php echo $sessionName;?>" value="<?php echo $name;?>">
        <p class="error"><?php echo $nameErr;?></p><br>

        <label for="coach">Coach ID:</label><br>
        <input type="text" name="coach" placeholder="<?php echo $sessionCoachId;?>" value="<?php echo $coach;?>">
        <p class="error"><?php echo $coachErr;?></p><br>


        <label for="squad">Squad ID::</label><br>
        <input type="text" name="squad" placeholder="<?php echo $sessionSquadId;?>" value="<?php echo $squad;?>">
        <p class="error"><?php echo $squadErr;?></p><br>

        <label for="start">Start:</label><br>
        <input type="datetime-local" name="start" value="<?php echo $start;?>">
        <p class="error"><?php echo $startErr;?></p><br>

        <label for="end">End:</label><br>
        <input type="datetime-local" name="end" value="<?php echo $end;?>">
        <p class="error"><?php echo $endErr;?></p><br>

        <label for="location">Location:</label><br>
        <input type="text" name="location" placeholder="<?php echo $sessionLocation;?>" value="<?php echo $location;?>">
        <p class="error"><?php echo $locationErr;?></p><br>

        <input type="button" value="Next" onclick="nextTab()">
    </div>
    
    <div id="training-details-form">

        <label for="skills">Skills Practiced:</label><br>
        <input type="text" name="skills" value="<?php echo $skills;?>">
        <p class="error"><?php echo $skillsErr;?></p><br>

        <label for="activities">Activities Practiced:</label><br>
        <input type="text" name="activities" value="<?php echo $activities;?>">
        <p class="error"><?php echo $activitiesErr;?></p><br>

        <label for="present_players">Players Present:</label><br>
        <input type="text" name="present_players" value="<?php echo $playersPresent;?>">
        <p class="error"><?php echo $playersPresentErr;?></p><br>

        <label for="accidents">Accidents:</label><br>
        <input type="text" name="accidents" value="<?php echo $accidents;?>">
        <p class="error"><?php echo $accidentsErr;?></p><br>

        <label for="injuries">Injuries:</label><br>
        <input type="text" name="injuries" value="<?php echo $injuries;?>">
        <p class="error"><?php echo $injuriesErr;?></p><br>

        <input type="button" value="Previous" onclick="prevTab()">

    </div>

    <input type="submit" name="submit" value="Submit">  


    </form>

    <script>

        var currentTab = 0;
        const basicDetails = document.getElementById("basic-session-details");
        const trainingDetails = document.getElementById("training-details-form");

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
                trainingDetails.style.display = "none";

            }

            else{
                basicDetails.style.display = "none";
                trainingDetails.style.display = "block";

            }
        }


    </script>
</main>
