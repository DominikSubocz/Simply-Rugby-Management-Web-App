<?php

if(isset($_POST["confirmDelete"])){
    Events::deleteGame($gameId);
}

if(isset($_POST["updateSubmit"])){
  header("Location: " . Utils::$projectFilePath . "/update-game.php?id=$gameId");
}


?>

<div class="bg-dark text-white d-flex p-2">          
<form
      method="post"
      action="">
  
      <input type="submit" id="removeBtn" class="btn btn-danger mx-2 my-2" value="Delete Game">
      <input type="submit" id="updateBtn" name="updateSubmit" class="btn btn-warning mx-2 my-2" value="Update Game">
  </form>

</div>
<tr class="hover-overlay" >
        <td data-th="Game Name" class="game-name-label"><p><?php echo $gameName; ?></p></td>
        <td data-th="Home Team" class="squad-label" ><p><?php echo $squadId; ?></p></td>
        <td data-th="Opposition Team" class="opposition-label"><p><?php echo $squadId; ?></p></td>
        <td data-th="Start Date" class="start-date-label"><p><?php echo $gameStart; ?></p></td>
        <td data-th="End Date" class="end-date-label"><p><?php echo $gameEnd; ?></p></td>
        <td data-th="Location" class="location-label"><p><?php echo $gameLocation; ?></p></td>
        <td data-th="Kickoff Time" class="kickoff-label"><p><?php echo $gameKickoff; ?></p></td>
        <td data-th="Result" class="result-label"><p><?php echo $gameResult; ?></p></td>
        <td data-th="Score" class="score-label"><p><?php echo $gameScore; ?></p></td>

    </a>
</tr>



<?php

  $gameHalves = Events::getGameHalves($game['game_id']);
  Components::gameHalves($gameHalves);    
?>





<div id="myModal" class="modal">

    <div class="modal-content w-50">
    <span class="close">&times;</span>
    <p>Are you sure you want to delete this game?</p>
    <form 
            method="post" 
            action="">

            <input type="submit" name="confirmDelete" class="btn btn-danger" value="Yes">  
            <input type="submit" id="cancel" class="btn btn-warning" value="No"> 
    </div>
</div>

<script>
  var modal = document.getElementById("myModal");
  var updateModal = document.getElementById("updateModal");


  // Get the button that opens the modal
  var delBtn = document.getElementById("removeBtn");

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
