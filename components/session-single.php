<?php

if(isset($_POST["confirmDelete"])){
    Events::deleteSession($sessionId);
}

if(isset($_POST["updateSubmit"])){
  header("Location: " . Utils::$projectFilePath . "/update-session.php?id=$sessionId");
}

?>
<div class="bg-dark text-white d-flex p-2">          
<form
      method="post"
      action="">
  
      <input type="submit" id="removeBtn" class="btn btn-danger mx-2 my-2" value="Delete Session">
      <input type="submit" id="updateBtn" name="updateSubmit" class="btn btn-warning mx-2 my-2" value="Update Session">
  </form>

</div>
<tr class="hover-overlay" >
        <td data-th="Session Name" class="session-name-label"><p><?php echo $sessionName; ?></p></td>
        <td data-th="Coach Organising" class="coach-label" ><p><?php echo 'Coach Number: '. $coachId; ?></p></td>
        <td data-th="Squad Participating" class="squad-label"><p><?php echo 'Squad Number: '. $squadId; ?></p></td>
        <td data-th="Start Date" class="start-date-label"><p><?php echo 'Start: '. $sessionStart; ?></p></td>
        <td data-th="End Date" class="end-date-label"><p><?php echo 'End: '.$sessionEnd; ?></p></td>
        <td data-th="Location" class="location-label"><p><?php echo 'Location: '. $sessionLocation; ?></p></td>
    </a>
</tr>

<table class="table" id="customDataTable">
  <thead>
    <tr>
      <th class="skills-name-label">Skills</th>
      <th class="activities-label">Activities </th>
      <th class="present-players-label">Present Players</th>
      <th class="accidents-label">Accidents</th>
      <th class="injuries-label">Injuries</th>
    </tr>
  </thead>
  <tbody>

    <?php

      $trainingDetails = Events::getTrainingDetails($sessionId);
      Components::trainingDetails($trainingDetails);    
      ?>

  </tbody>
</table>

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
