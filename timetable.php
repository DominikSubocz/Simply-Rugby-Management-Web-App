<?php

/// This must come first when we need access to the current session
session_start();
require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/events.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");

Components::pageHeader("Timetable", ["style"], ["mobile-nav"]); ///< Render page header

/**
 * Check if the update button was clicked.
 * If clicked redirect to the update page for each checked item in the 'check_list'.
 * The update page URL is constructed using the project file path and the checked item.
 *
 * @param array $_POST The associative array containing POST data.
 */
if(isset($_POST['updateSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/update-$check");
    }
  }
}
/**
 * Check if the add button was clicked.
 * Redirect to the 'add-event.php' page if clicked
 */
if(isset($_POST['addSubmit'])){
  header("Location: " . Utils::$projectFilePath . "/add-event.php");

}

/**
 * Check if the delete button was clicked.
 * and redirect to the delete page for each checked item.
 * 
 * The update page URL is constructed using the project file path and the checked item.
 *
 * @param array $_POST The associative array containing POST data.
 */
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
  <input class="btn btn-secondary mx-2 my-2" type="submit" id="updateBtn" name="updateSubmit" value="Update Event">
  <input class="btn btn-danger mx-2 my-2" type="submit" id="removeBtn" name="removeSubmit" value="Remove Event">
  <input type="hidden" id="hidden-role-field" name="hidden-role-field" value="<?php echo $_SESSION["user_role"];?>">
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


      $events = Events::getAllEvents(); ///< Get all events
      Components::allEvents($events); ///< Render row for each event

    ?>

  </tbody>
</table>
</form>
</main>
<script>

let updateBtn = document.getElementById("updateBtn");
let addBtn = document.getElementById("addBtn");
let removeBtn = document.getElementById("removeBtn");
var role = document.getElementById("hidden-role-field");

/**
 * Selects one checkbox while hiding others and displays buttons
 */

function cbChange(obj) {
    var cbs = document.getElementsByClassName("cb");
    for (var i = 0; i < cbs.length; i++) {
        cbs[i].checked = false;
    }
    obj.checked = true;
    displayButtons("block");
}

if((role.value != "Coach") && (role.value != "Admin")){
  addBtn.style.display="none";
}

/**
 * Display buttons based on the type provided.
 */

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

