<?php
/**
 * Future Additions/Fixes
 * 
 * @todo Move $stmt code into a class
 * 
 */

/// This must come first when we need access to the current session
session_start();

require ("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require ("classes/utils.php");
require ("classes/events.php");
require ("classes/connection.php");
require ("classes/sql.php");

/**
 * Check if the user is logged in; if not, redirect to login page
 */
if (!isset($_SESSION["loggedIn"])) {

    header("Location: " . Utils::$projectFilePath . "/login.php");

}


/// Redirect to logout page if user role is neither Admin nor Coach

if (($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Redirects to the timetable page if the 'id' parameter is not set in the GET request or if it is not a numeric value.
 */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/timetable.php");
}

/**
 * Retrieves data from the 'coaches' and 'squads' tables.
 * 
 * Later to be used in dropdown input fields
 */
$conn = Connection::connect();

$coachSql = "SELECT first_name, last_name FROM simplyrugby.coaches";

$stmt = $conn->prepare($coachSql);
$stmt->execute();
$coaches = $stmt->fetchAll();

$stmt = $conn->prepare(SQL::$getSquads);
$stmt->execute();
$squads = $stmt->fetchAll();



$session = Events::getSession($_GET["id"]); ///< Get specific session by its ID number

$pageTitle = "Session not found"; ///< Default title

/**
 * If the $session variable is not empty, set the title of the page to the session name.
 */
if (!empty($session)) {
    $pageTitle = $session["name"] . "Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]); ///< Render page header

$sessionId = Utils::escape($session["session_id"]); ///< Store ID of session

/**
 * Escape and assign values from the $session array to respective variables for security purposes.
 *
 * @param array $session An array containing information about the session.
 */

$sessionName = Utils::escape($session["name"]);
$sessionSquadId = Utils::escape($session["squad_id"]);
$sessionCoachId = Utils::escape($session["coach_id"]);
$sessionStart = Utils::escape($session["start"]);
$sessionEnd = Utils::escape($session["end"]);
$sessionLocation = Utils::escape($session["location"]);


/**
 * Retrieve the squad name based on the provided squad ID. 
 * 
 * This will later be used in placeholder value
 */
$stmt = $conn->prepare(SQL::$getSquadName);
$stmt->execute([$sessionSquadId]);
$squadResults = $stmt->fetch();
$squadNamePlaceholder = $squadResults['squad_name'];

/**
 * Retrieve the coach's first and last name based on the provided coach ID. 
 * 
 * This will later be used in placeholder value
 */

$stmt = $conn->prepare(SQL::$getCoachById);
$stmt->execute([$sessionCoachId]);
$coachResults = $stmt->fetch();
$coachFirstNamePlaceholder = $coachResults['first_name'];
$coachLastNamePlaceholder = $coachResults['last_name'];

$coachNamePlaceholder = $coachFirstNamePlaceholder . ' ' . $coachLastNamePlaceholder;


$trainingDetails = Events::getTrainingDetails($sessionId);
foreach ($trainingDetails as $trainingDetail) {
    $trainingDetailId = Utils::escape($trainingDetail["training_details_id"]);
    $skillsPlaceholder = Utils::escape($trainingDetail["skills"]);
    $activitiesPlaceholder = Utils::escape($trainingDetail["activities"]);
    $presentPlayersPlaceholder = Utils::escape($trainingDetail["present_players"]);
    $accidentsPlaceholder = Utils::escape($trainingDetail["accidents"]);
    $injuriesPlaceholder = Utils::escape($trainingDetail["injuries"]);

}

/**
 * Variables to store information related to a sports squad match.
 * 
 * @var string $skills: Skills practiced on training session
 * @var string $activities: Activities practiced on training session
 * @var string $playersPresent: Players that were present on training session
 * @var string $accidents: Any accidents that took place on training session (optional)
 * @var string $injuries: Any injuries that took place on training session (optional)
 * 
 * @var string $name: Name of the training session
 * @var string $coach: Selected coach from the dropdown
 * @var string $squad: Selected squad from the dropdown
 * @var \DateTime $start: The start date of the match
 * @var \DateTime  $end: The end date of the match
 * @var string $location: The location of the match
 *
 * Error variables for each corresponding field to handle validation errors:
 * @var string $skillsErr: Error message for skills field
 * @var string $activitiesErr: Error message for activities field
 * @var string $playersPresentErr: Error message for playersPresent field
 * @var string $accidentsErr: Error message for accidents field
 * @var string $injuriesErr: Error message for injuries field
 * 
 * @var string $nameErr: Error message for name field
 * @var string $coachErr: Error message for coach field
 * @var string $squadErr: Error message for squad field
 * @var string $startErr: Error message for start field
 * @var string $endErr: Error message for end field
 * @var string $locationErr: Error message for location field
 */

$skills = $activities = $playersPresent = $accidents = $injuries = "";
$skillsErr = $activitiesErr = $playersPresentErr = $accidentsErr = $injuriesErr = "";



$name = $coach = $squad = $start = $end = $location = "";
$nameErr = $coachErr = $squadErr = $startErr = $endErr = $locationErr = "";

/**
 * Validates the form inputs and processes the data accordingly.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $name = $sessionName; ///< Set value to placeholder if left empty
    } else {
        $name = test_input($_POST["name"]); ///< Sanitize name
    }

    /// Validate name
    if (empty($_POST["coach"])) {
        $coach = $coachNamePlaceholder; ///< Set value to placeholder if left empty
    } else {
        $coach = test_input($_POST["coach"]); ///< Sanitize coach's name
    }

    if (empty($_POST["squad"])) {
        $squad = $squadNamePlaceholder; ///< Set value to placeholder if left empty
    } else {
        $squad = test_input($_POST["squad"]); ///< Sanitize squad's name
    }

    if (empty($_POST["start"])) {
        $start = $sessionStart; ///< Set value to placeholder if left empty
    } else {
        $start = test_input($_POST["start"]); ///< Sanitize start date
    }

    if (empty($_POST["end"])) {
        $end = $sessionEnd; ///< Set value to placeholder if left empty
    } else {
        $end = test_input($_POST["end"]); ///< Sanitize end date
    }

    if (empty($_POST["location"])) {
        $location = $sessionLocation; ///< Set value to placeholder if left empty
    } else {
        $location = test_input($_POST["location"]); ///< Sanitize location
    }

    /// Training Details

    /// Validate name
    if (empty($_POST["skills"])) {
        $skills = $skillsPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $skills = test_input($_POST["skills"]); ///< Sanitize skills
    }

    if (empty($_POST["activities"])) {
        $activities = $activitiesPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $activities = test_input($_POST["activities"]); ///< Sanitize activities
    }

    if (empty($_POST["present_players"])) {
        $playersPresent = $presentPlayersPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $playersPresent = test_input($_POST["present_players"]); ///< Sanitize present players
    }

    if (empty($_POST["accidents"])) {
        $accidents = $accidentsPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $accidents = test_input($_POST["accidents"]); ///< Sanitize accidents
    }

    if (empty($_POST["injuries"])) {
        $injuries = $injuriesPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $injuries = test_input($_POST["injuries"]); ///< Sanitize injuries
    }

    /// If there are no errors, proceed with sql querries
    if (
        empty($nameErr) && empty($coachErr) && empty($squadErr) && empty($startErr) && empty($endErr) && empty($locationErr)
        && empty($skillsErr) && empty($activitiesErr) && empty($playersPresentErr) && empty($accidentsErr) && empty($injuriesErr)
    ) {

        /**
         * Retrieves the coach ID from the database using the provided first name and last name placeholders.
         */
        $stmt = $conn->prepare(SQL::$getCoach);
        $stmt->execute([$coachFirstNamePlaceholder, $coachLastNamePlaceholder]);
        $coachIdResults = $stmt->fetch();
        $coachId = $coachIdResults["coach_id"];

        /**
         * Retrieves the squad ID from the database based on the provided squad name.
         */
        $stmt = $conn->prepare(SQL::$getSquad);
        $stmt->execute([$squad]);
        $squadIdResults = $stmt->fetch();
        $squadId = $squadIdResults["squad_id"];

        /**
         * Update session details in the Events class.
         */
        Events::updateSession($coachId, $squadId, $name, $start, $end, $location, $skills, $activities, $playersPresent, $accidents, $injuries, $sessionId, $trainingDetailId);

        header("Location: " . Utils::$projectFilePath . "/timetable.php"); ///< Redirect back to timetable page

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

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} ?>

<main class="content-wrapper profile-list-content">
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $session["session_id"]; ?>">



        <div id="basic-session-details">
            <label for="name">Name:</label><br>
            <input type="text" name="name" placeholder="<?php echo $sessionName; ?>" value="<?php echo $name; ?>">
            <p class="alert alert-danger"><?php echo $nameErr; ?></p><br>
            <!-- Populate dropdown with values from database -->
            <label for="coach">Coach:</label><br>
            <select name="coach">
                <?php
                /**
                 * Loops through an array of squads and creates an <option> element for each squad.
                 */
                foreach ($coaches as $coach) {
                    $coachName = $coach["first_name"] . ' ' . $coach["last_name"];
                    ?>
                    <option value="<?php echo $coachName; ?>" <?php if ($coachName == $coachNamePlaceholder) {
                           echo "selected";
                       } ?>>
                        <?php echo $coach["first_name"] . ' ' . $coach["last_name"]; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <p class="alert alert-danger"><?php echo $coachErr; ?></p><br>

            <!-- Populate dropdown with values from database -->
            <label for="squad">Home Team:</label><br>
            <select name="squad">
                <?php
                /**
                 * Loops through an array of squads and creates an <option> element for each squad.
                 */
                foreach ($squads as $squad) {
                    ?>
                    <option value="<?php echo $squad["squad_name"]; ?>" <?php if ($squad['squad_name'] == $squadNamePlaceholder) {
                           echo "selected";
                       } ?>>
                        <?php echo $squad["squad_name"]; ?>
                    </option>
                    <?php
                }
                ?>
            </select>
            <p class="alert alert-danger"><?php echo $squadErr; ?></p><br>

            <label for="start">Start:</label><br>
            <input type="datetime-local" name="start" value="<?php echo $start; ?>">
            <p class="alert alert-danger"><?php echo $startErr; ?></p><br>

            <label for="end">End:</label><br>
            <input type="datetime-local" name="end" value="<?php echo $end; ?>">
            <p class="alert alert-danger"><?php echo $endErr; ?></p><br>

            <label for="location">Location:</label><br>
            <input type="text" name="location" placeholder="<?php echo $sessionLocation; ?>"
                value="<?php echo $location; ?>">
            <p class="alert alert-danger"><?php echo $locationErr; ?></p><br>

            <input type="button" value="Next" onclick="nextTab()">
        </div>

        <div id="training-details-form">

            <label for="skills">Skills Practiced:</label><br>
            <input type="text" name="skills" placeholder="<?php echo $skillsPlaceholder; ?>"
                value="<?php echo $skills; ?>">
            <p class="alert alert-danger"><?php echo $skillsErr; ?></p><br>

            <label for="activities">Activities Practiced:</label><br>
            <input type="text" name="activities" placeholder="<?php echo $activitiesPlaceholder; ?>"
                value="<?php echo $activities; ?>">
            <p class="alert alert-danger"><?php echo $activitiesErr; ?></p><br>

            <label for="present_players">Players Present:</label><br>
            <input type="text" name="present_players" placeholder="<?php echo $presentPlayersPlaceholder; ?>"
                value="<?php echo $playersPresent; ?>">
            <p class="alert alert-danger"><?php echo $playersPresentErr; ?></p><br>

            <label for="accidents">Accidents:</label><br>
            <input type="text" name="accidents" placeholder="<?php echo $accidentsPlaceholder; ?>"
                value="<?php echo $accidents; ?>">
            <p class="alert alert-danger"><?php echo $accidentsErr; ?></p><br>

            <label for="injuries">Injuries:</label><br>
            <input type="text" name="injuries" placeholder="<?php echo $injuriesPlaceholder; ?>"
                value="<?php echo $injuries; ?>">
            <p class="alert alert-danger"><?php echo $injuriesErr; ?></p><br>

            <input type="button" value="Previous" onclick="prevTab()">

        </div>

        <input type="submit" name="submit" value="Submit">


    </form>

    <script>

        var currentTab = 0;
        const basicDetails = document.getElementById("basic-session-details");
        const trainingDetails = document.getElementById("training-details-form");

        /**
         * Show the tab based on the currentTab value.
         */
        function showTab() {
            if (currentTab == 0) {
                basicDetails.style.display = "block";
                trainingDetails.style.display = "none";

            }

            else {
                basicDetails.style.display = "none";
                trainingDetails.style.display = "block";

            }
        }
        /**
         * Increases the current tab index by 1 and displays the next tab.
         */
        function nextTab() {
            currentTab += 1;
            showTab();
        }
        /**
         * Decrements the current tab index by 1 and displays the updated tab.
         */
        function prevTab() {
            currentTab -= 1;
            showTab();
        }

        showTab();



    </script>
</main>