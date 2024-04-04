<?php

if(isset($_POST["confirmDelete"])){
  player::deletePlayer($player_id);
}

if(isset($_POST["updateSubmit"])){

  header("Location: " . Utils::$projectFilePath . "/update-player.php?id=$player_id");

}

if(isset($_POST["updateSkillSubmit"])){

  header("Location: " . Utils::$projectFilePath . "/update-player-skill.php?id=$player_id");

}

?>
<main class="content-wrapper profile-content">
  <div class="profile-content-container">

  <div class="profile-container">
      <div>
        <img class="profile-img" src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $firstName; ?>" class="profile-img">

        <form 
          method="post" 
          action="">

          <input type="submit" id="deleteBtn" class="btn btn-danger my-2" value="Delete">  
          <input type="submit" class="btn btn-warning my-2" name="updateSubmit" value="<?php echo 'Update ', $firstName, ' ', $lastName; ?>">
          <input type="submit" class="btn btn-warning my-2" name="updateSkillSubmit" value="<?php echo 'Update ', $firstName. '\'s Skills'; ?>">
        </form>

      </div>
  </div>

    <div class="profile-container">
      <div class="profile-items">
        <h2>Player Info</h2>
        <p><?php echo 'Name: ', $firstName, ' ', $lastName; ?></p>
        <p><?php echo 'SRU:', $sruNumber; ?></p>
        <p><?php echo 'Date of Birth:', $dob; ?></p>

      </div>
      <div class="profile-items">
        <h2>Personal Details</h2>
        <p><?php echo 'Contact Number: ', $contactNumber; ?></p>
        <p><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
        <p><?php echo 'Email: ', $emailAddress; ?></p>
        <p><?php echo 'Known Health Issues: ', $healthIssues; ?></p>
      </div>
      <div class="profile-items">
        <h2>Address Details</h2>
        <p><?php echo 'Address Line1: ', $address1; ?></p>
        <p><?php echo 'Address Line 2: ', $address2; ?></p>
        <p><?php echo 'City: ', $city; ?></p>
        <p><?php echo 'County: ', $county; ?></p>
      </div>
      <div class="profile-items">
        <h2>Emergency Contact Details</h2>
        <p><?php echo 'Name: ', $nextOfKin?></p>
        <p><?php echo 'Contact Number: ', $kinContactNumber; ?></p>
      </div>
      <div class="profile-items">
        <h2>Doctor Information</h2>
        <p><?php echo 'Name: ', $doctorFirstName, ' ', $doctorLastName; ?></p>
        <p><?php echo 'Contact Number: ', $doctorContact; ?></p>
      </div>
    </div>

    <div class="skills-card-container">
      <div class="skills-card passing-card">
        <div>
          <br>
          <h3>Passing</h3>
        </div>
        <?php
          $skill = player::getPlayerSkills($_GET["id"]);
          Components::playerPassingSkill($skill);
        ?>
      </div>

      <div class="skills-card tackling-card">
        <div>
          <br>
          <h3>Tackling</h3>
        </div>
        <?php
          $skill = player::getPlayerSkills($_GET["id"]);
          Components::playerTacklingSkill($skill);
        ?>
      </div>

      <div class="skills-card kicking-card">
        <div>
          <br>
          <h3>Kicking</h3>
        </div>
        <?php
          $skill = player::getPlayerSkills($_GET["id"]);
          Components::playerKickingSkill($skill);
        ?>
      </div>
    </div>
  </div>

  <!-- The Modal -->
<div id="myModal" class="modal">

<!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p><?php echo 'Are you sure you want to delete: ', $firstName, ' ', $lastName; ?>?</p>
    <form 
      method="post" 
      action="">

      <input type="submit" name="confirmDelete" class="btn btn-danger my-2" value="Yes">  
      <input type="submit" id="cancel" class="btn btn-warning my-2" value="No"> 
    </form>
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
</main>
