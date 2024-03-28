<?php

if(isset($_POST["confirmDelete"])){
    Events::deleteSession($sessionId);
}

?>

<div class="game-container">


    <h2><?php echo 'Session ID: '. $sessionId; ?></h2>

    <h2><?php echo $sessionName; ?></h2>

    <p><?php echo 'Squad Number: '. $coachId; ?></p>


    <p><?php echo 'Squad Number: '. $squadId; ?></p>

    <p><?php echo 'Start: '. $sessionStart; ?></p>

    <p><?php echo 'End: '.$sessionEnd; ?></p>

    <p><?php echo 'Location: '. $sessionLocation; ?></p>

    <h2>Training Session Details:</h2>

    <?php

    

    $trainingDetails = Events::getTrainingDetails($sessionId);
    Components::trainingDetails($trainingDetails);
    ?>

<form 
    method="post" 
    action="">

    <input type="submit" id="deleteBtn" class="danger" value="Delete Game">  
    <a href="update-session.php?id=<?php echo $sessionId; ?>" name="updateRedirect" class="button">Update Game</a>
</form>
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
