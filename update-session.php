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

$coachSql = "SELECT first_name, last_name FROM simplyrugby.coaches";

$conn = Connection::connect();

$stmt = $conn->prepare($coachSql);
$stmt->execute();
$coaches = $stmt->fetchAll();

$stmt = $conn->prepare(SQL::$getSquads);
$stmt->execute();
$squads = $stmt->fetchAll();



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
$sessionStart = Utils::escape($session["start"]);
$sessionEnd = Utils::escape($session["end"]);
$sessionLocation = Utils::escape($session["location"]);


$stmt = $conn->prepare(SQL::$getSquadName);
$stmt->execute([$sessionSquadId]);
$squadResults = $stmt->fetch();
$squadNamePlaceholder = $squadResults['squad_name'];

$stmt = $conn->prepare(SQL::$getCoachById);
$stmt->execute([$sessionCoachId]);
$coachResults = $stmt->fetch();
$coachFirstNamePlaceholder = $coachResults['first_name'];
$coachLastNamePlaceholder = $coachResults['last_name'];

$coachNamePlaceholder = $coachFirstNamePlaceholder. ' ' . $coachLastNamePlaceholder;


$trainingDetails = Events::getTrainingDetails($sessionId);
foreach($trainingDetails as $trainingDetail){
    $trainingDetailId = Utils::escape($trainingDetail["training_details_id"]);
    $skillsPlaceholder = Utils::escape($trainingDetail["skills"]);
    $activitiesPlaceholder = Utils::escape($trainingDetail["activities"]);
    $presentPlayersPlaceholder = Utils::escape($trainingDetail["present_players"]);
    $accidentsPlaceholder = Utils::escape($trainingDetail["accidents"]);
    $injuriesPlaceholder = Utils::escape($trainingDetail["injuries"]);

}

$skills = $activities = $playersPresent = $accidents = $injuries = "";
$skillsErr = $activitiesErr = $playersPresentErr = $accidentsErr = $injuriesErr = "";



$name = $coach = $squad = $start = $end = $location = "";
$nameErr = $coachErr = $squadErr = $startErr = $endErr = $locationErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $name = $sessionName;
    } else {
        $name = test_input($_POST["name"]);
    }

        // Validate name
        if (empty($_POST["coach"])) {
            $coach = $coachNamePlaceholder;
        } else {
            $coach = test_input($_POST["coach"]);
        }

        if (empty($_POST["squad"])) {
            $squad = $squadNamePlaceholder;
        } else {
            $squad = test_input($_POST["squad"]);
        }

        if (empty($_POST["start"])) {
            $start = $sessionStart;
        } else {
            $start = test_input($_POST["start"]);
        }

        if (empty($_POST["end"])) {
            $end = $sessionEnd;
        } else {
            $end = test_input($_POST["end"]);
        }

        if (empty($_POST["location"])) {
            $location = $sessionLocation;
        } else {
            $location = test_input($_POST["location"]);
        }

        // Training Details

        // Validate name
        if (empty($_POST["skills"])) {
            $skills = $skillsPlaceholder;
        } else {
            $skills = test_input($_POST["skills"]);
        }

        if (empty($_POST["activities"])) {
            $activities = $activitiesPlaceholder;
        } else {
            $activities = test_input($_POST["activities"]);
        }

        if (empty($_POST["present_players"])) {
            $playersPresent = $presentPlayersPlaceholder;
        } else {
            $playersPresent = test_input($_POST["present_players"]);
        }

        if (empty($_POST["accidents"])) {
            $accidents = $accidentsPlaceholder;
        } else {
            $accidents = test_input($_POST["accidents"]);
        }

        if (empty($_POST["injuries"])) {
            $injuries = $injuriesPlaceholder;
        } else {
            $injuries = test_input($_POST["injuries"]);
        }

        if (empty($nameErr) && empty($coachErr) && empty($squadErr) && empty($startErr) && empty($endErr) && empty($locationErr) 
        && empty($skillsErr) && empty($activitiesErr) && empty($playersPresentErr) && empty($accidentsErr) && empty($injuriesErr)){
    
            $stmt = $conn->prepare(SQL::$getCoach);
            $stmt->execute([$coachFirstNamePlaceholder, $coachLastNamePlaceholder]);
            $coachIdResults = $stmt->fetch();
            $coachId = $coachIdResults["coach_id"];

            $stmt = $conn->prepare(SQL::$getSquad);
            $stmt->execute([$squad]);
            $squadIdResults = $stmt->fetch();
            $squadId = $squadIdResults["squad_id"];

            Events::updateSession($coachId, $squadId, $name, $start, $end, $location, $skills, $activities, $playersPresent, $accidents, $injuries, $sessionId, $trainingDetailId);
        
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
        <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

        <label for="coach">Coach:</label><br>
            <select name="coach">
            <?php
            foreach($coaches as $coach){
                $coachName = $coach["first_name"] . ' ' . $coach["last_name"];
                ?>
                <option value="<?php echo $coachName; ?>" <?php if ($coachName == $coachNamePlaceholder){echo "selected";}?>>
                <?php echo $coach["first_name"] . ' ' . $coach["last_name"]; ?>
                </option>
                <?php
            }
            ?>
            </select>
            <p class="alert alert-danger"><?php echo $coachErr;?></p><br>


        <label for="squad">Home Team:</label><br>
            <select name="squad">
            <?php
            foreach($squads as $squad){
                ?>
                <option value="<?php echo $squad["squad_name"]; ?>" <?php if($squad['squad_name'] == $squadNamePlaceholder) {echo "selected";}?>>
                <?php echo $squad["squad_name"]; ?>
                </option>
                <?php
            }
            ?>
            </select>
            <p class="alert alert-danger"><?php echo $squadErr;?></p><br>

        <label for="start">Start:</label><br>
        <input type="datetime-local" name="start" value="<?php echo $start;?>">
        <p class="alert alert-danger"><?php echo $startErr;?></p><br>

        <label for="end">End:</label><br>
        <input type="datetime-local" name="end" value="<?php echo $end;?>">
        <p class="alert alert-danger"><?php echo $endErr;?></p><br>

        <label for="location">Location:</label><br>
        <input type="text" name="location" placeholder="<?php echo $sessionLocation;?>" value="<?php echo $location;?>">
        <p class="alert alert-danger"><?php echo $locationErr;?></p><br>

        <input type="button" value="Next" onclick="nextTab()">
    </div>
    
    <div id="training-details-form">

        <label for="skills">Skills Practiced:</label><br>
        <input type="text" name="skills" placeholder="<?php echo $skillsPlaceholder;?>" value="<?php echo $skills;?>">
        <p class="alert alert-danger"><?php echo $skillsErr;?></p><br>

        <label for="activities">Activities Practiced:</label><br>
        <input type="text" name="activities" placeholder="<?php echo $activitiesPlaceholder;?>" value="<?php echo $activities;?>">
        <p class="alert alert-danger"><?php echo $activitiesErr;?></p><br>

        <label for="present_players">Players Present:</label><br>
        <input type="text" name="present_players" placeholder="<?php echo $presentPlayersPlaceholder;?>" value="<?php echo $playersPresent;?>">
        <p class="alert alert-danger"><?php echo $playersPresentErr;?></p><br>

        <label for="accidents">Accidents:</label><br>
        <input type="text" name="accidents" placeholder="<?php echo $accidentsPlaceholder;?>" value="<?php echo $accidents;?>">
        <p class="alert alert-danger"><?php echo $accidentsErr;?></p><br>

        <label for="injuries">Injuries:</label><br>
        <input type="text" name="injuries" placeholder="<?php echo $injuriesPlaceholder;?>" value="<?php echo $injuries;?>">
        <p class="alert alert-danger"><?php echo $injuriesErr;?></p><br>

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
