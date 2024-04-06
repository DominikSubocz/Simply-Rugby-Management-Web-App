<?php

session_start();
require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/events.php");
require("classes/utils.php");


Components::pageHeader("All players", ["style"], ["mobile-nav"]);


if(isset($_POST['updateSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/update-$check");
    }
  }
}

if(isset($_POST['addSubmit'])){
  header("Location: " . Utils::$projectFilePath . "/add-event.php");

}

if(isset($_POST['removeSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-$check");
    }
  }
}

?>


<main class="content-wrapper contact-content">
  
<form 
  method="post" 
  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<div class="bg-dark text-white d-flex p-2">          
  <input class="btn btn-primary mx-2 my-2" type="submit" id="addBtn" name="addSubmit" value="Add Event">
  <input class="btn btn-secondary mx-2 my-2" type="submit" id="updateBtn" name="updateSubmit" value="Update Player">
  <input class="btn btn-danger mx-2 my-2" type="submit" id="removeBtn" name="removeSubmit" value="Remove Player">
  <input type="button" id="settingsBtn" class="btn btn-info ms-auto my-2" value="Settings">  
</div>
<table class="table" id="customDataTable">
  <thead>
    <tr>
      <th>#</th>
      <th class="name-label">Name</th>
      <th class="type-label">Type</th>
      <th class="start-date-label">Start Date.</th>
      <th class="end-date-label">End Date</th>
      <th class="location-label">Location</th>
    </tr>
  </thead>
  <tbody>


    <?php


      $events = Events::getAllEvents();
      Components::allEvents($events);

    ?>

  </tbody>
</table>
</form>
</main>
<script>

let updateBtn = document.getElementById("updateBtn");
let removeBtn = document.getElementById("removeBtn");

function cbChange(obj) {
    var cbs = document.getElementsByClassName("cb");
    for (var i = 0; i < cbs.length; i++) {
        cbs[i].checked = false;
    }
    obj.checked = true;
    displayButtons("block");
}

function displayButtons(type){
  if(type == "block"){
    updateBtn.style.display="block";
    removeBtn.style.display="block";
  } else {
    removeBtn.style.display="none";
    updateBtn.style.display="none";

  }
}

displayButtons("none");

displayButtons("none");

</script>

