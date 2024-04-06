<?php

session_start();

require("classes/components.php");
require("classes/utils.php");
require("classes/coach.php");
require("classes/connection.php");
require("classes/sql.php");

if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    header("Location: " . Utils::$projectFilePath . "/player-list.php");
} 

$coach = Coach::getCoach($_GET["id"]);

Components::pageHeader("List of Addresses", ["style"], ["mobile-nav"]);
?>




<?php

Components::singleCoach($coach);


Components::pageFooter();

?>
