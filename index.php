<?php

session_start();

require("classes/components.php");
require("classes/junior.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

?>



<div class="menu-dashboard-container my-2">
    

    <?php
        if(isset($_SESSION["loggedIn"])){
            if($_SESSION["user_role"] === "Admin"){
                echo "
                <a href='player-list.php' class='menu-dashboard-item'>
                    <div>
                        Player List
                    </div>
                </a>
                
                <a href='junior-list.php' class='menu-dashboard-item'>
                    <div>
                        Junior Players List 
                    </div>
                </a>

                <a href='member-list.php' class='menu-dashboard-item'>
                    <div>
                        Members List 
                    </div>
                </a>
                
                
                <a href='timetable.php' class='menu-dashboard-item'>
                    <div>
                        View Timetable
                    </div>
                </a>";
                  
            }
                
        }

        else {
            header("Location: " . Utils::$projectFilePath . "/login.php");
        }
    ?>


    


</div>

