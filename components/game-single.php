<div class="game-container">


    <h2><?php echo 'Game ID: '. $gameId; ?></h2>

    <h2><?php echo $gameName; ?></h2>

    <p><?php echo 'Squad Number: '. $squadId; ?></p>

    <p><?php echo 'Opposition Team: '. $oppositionName; ?></p>

    <p><?php echo 'Start: '. $gameStart; ?></p>

    <p><?php echo 'End: '.$gameEnd; ?></p>

    <p><?php echo 'Location: '. $gameLocation; ?></p>

    <p><?php echo 'Kickoff Time: '. $gameKickoff; ?></p>

    <p><?php echo 'Result: '. $gameResult; ?></p>

    <p><?php echo 'Score '.$gameScore; ?></p>


    <?php

    $gameHalves = Events::getGameHalves($gameId);
    Components::gameHalves($gameHalves);
    ?>

<form 
    method="post" 
    action="">

    <input type="submit" id="deleteBtn" class="danger" value="Delete Game">  
    <a href="update-game.php?id=<?php echo $gameId; ?>" name="updateRedirect" class="button">Update Game</a>
</form>





</div>

