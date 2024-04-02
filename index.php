<?php

session_start();

require("classes/components.php");
require("classes/junior.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

?>



<main class="content-wrapper index-content my-5">


    <?php
        if(isset($_SESSION["loggedIn"])){
            if($_SESSION["user_role"] !== "Admin"){

                header("Location: " . Utils::$projectFilePath . "/login.php");

            }
                
        }

    ?>

    <div class="container">
        <div class="row">
            <div class="col col1 card my-1  py-4">
            <a href="player-list.php">Player List <i class="fa fa-user"></i></a>
            </div>
            <div class="col col2 card my-1   py-4">
            <a href="junior-list.php">Junior Player List <i class="fa fa-child"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col col3 card my-1  py-4">
            <a href="member-list.php">Member List <i class="fa fa-users"></i></a>
            </div>
            <div class="col col4 card my-1  py-4">
            <a href="add-player.php">Add Player <i class="fa fa-user-plus"></i></a>
            </div>
            <div class="col col5 card my-1  py-4">
            <a href="add-junior.php">Add Junior Player <i class="fa fa-child"></i><i class="fa fa-plus"></i></a>
            </div>
        </div>
        <div class="row">
            <div class="col col6 card my-1  py-4">
            <a href="add-member.php">Add Member <i class="fa fa-users"></i><i class="fa fa-plus"></i></a>
            </div>
            <div class="col col7 card my-1  py-4 py-4">
            <a href="timetable.php">Timetable <i class="fa fa-calendar"></i></a>
            </div>
        </div>
        
    </div>

    <div class="alert alert-info my-3">
        <p><strong>Note: </strong> To update/remove a player click on player list, then click on profile of the player and click update/remove button.</p>
    </div>

</main>


