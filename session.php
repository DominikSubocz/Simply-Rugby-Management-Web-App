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

if(!empty($session)){
    $pageTitle = $session["name"] . "Details";
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);
?>

<main class="content-wrapper profile-list-content">

    <?php

        Components::singleSession($session);

    ?>
</main>

<?php

    Components::pageFooter();

?>
