<?php

if(isset($_POST["confirmDelete"])){

  Member::deleteMember($member_id);


}


if(isset($_POST["updateSubmit"])){

  header("Location: " . Utils::$projectFilePath . "/update-member.php?id=$member_id");

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

          <input type="submit" id="deleteBtn" class="btn btn-danger my-2 my-2" value="Delete">  
          <input type="submit" class="btn btn-warning my-2" name="updateSubmit" value="<?php echo 'Update ', $firstName, ' ', $lastName; ?>">
        </form>
      </div>
  </div>

    <div class="profile-container">
      <div class="profile-items">
        <h2>Player Info</h2>
        <p><?php echo 'Name: ', $firstName, ' ', $lastName; ?></p>
        <p><?php echo 'SRU:', $sruNumber; ?></p>
      </div>
      <div class="profile-items">
        <h2>Personal Details</h2>
        <p><?php echo 'Contact Number: ', $contactNumber; ?></p>
        <p><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
        <p><?php echo 'Email: ', $emailAddress; ?></p>
      </div>
    </div>
  </div>

  <!-- The Modal -->
<div id="myModal" class="modal">

<!-- Modal content -->
<div class="modal-content w-50">
  <span class="close">&times;</span>
  <p><?php echo 'Are you sure you want to delete: ' . $firstName . ' ' . $lastName . '?'; ?></p>
  <form 
        method="post" 
        action="">

        <input type="submit" name="confirmDelete" class="btn btn-danger my-2" value="Yes">  
        <input type="submit" id="cancel" class="btn btn-warning my-2" value="No"> 
  </form>
</div>

</div>

<div id="updateModal" class="modal">

<!-- Modal content -->
<div class="modal-content w-50">
  <span class="close">&times;</span>
  <p><?php echo 'Are you sure you want to delete: ', $firstName, ' ', $lastName; ?>?</p>
  <form 
        method="post" 
        action="">

        <input type="submit" id="cancel" class="button" value="Update"> 
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
