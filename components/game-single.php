<?php

if(isset($_POST["confirmDelete"])){
    Events::deleteGame($gameId);
}

?>

<div class="event-container">


    <div>
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
    </div>


    <div class="event-details-container">
      <?php
  $gameHalves = Events::getGameHalves($game['game_id']);
  Components::gameHalves($gameHalves);
      ?>
    </div>

    <div class="event-form-container">
      <form
          method="post"
          action="">
          <input type="submit" id="deleteBtn" class="danger" value="Delete Game">
          <a href="update-game.php?id=<?php echo $gameId; ?>" name="updateRedirect" class="button">Update Game</a>
      </form>
    </div>
</div>

<div id="myModal" class="modal">

    <div class="modal-content">
    <span class="close">&times;</span>
    <p>Are you sure you want to delete this game?</p>
    <form 
            method="post" 
            action="">

            <input type="submit" name="confirmDelete" class="danger" value="Yes">  
            <input type="submit" id="cancel" class="button" value="No"> 
    </div>
</div>

<script>
  var modal = document.getElementById("myModal");
  var updateModal = document.getElementById("updateModal");


  // Get the button that opens the modal
  var delBtn = document.getElementById("deleteBtn");

  var cancelBtn = document.getElementById("cancel");


  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks on the button, open the modal
  delBtn.onclick = function(event) {
    // Prevent the default form submission action
    event.preventDefault();
    modal.style.display = "block";
  }

  cancelBtn.onclick = function(event) {
    // Prevent the default form submission action
    event.preventDefault();
    modal.style.display = "none";

  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }


  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>
