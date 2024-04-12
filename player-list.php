<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
require("classes/player.php");

/// Output page header with a given title, stylesheet, and script
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){
  header("Location: " . Utils::$projectFilePath . "/login.php");
}

/// Redirect to logout page if user role is neither Admin nor Coach

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Check if the update button was clicked.
 * If clicked check if the 'check_list' POST parameter is not empty.
 * Redirect to the 'update-player.php' page with the IDs from the 'check_list' array as query parameters.
 */

if(isset($_POST['updateSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/update-player.php?id=$check");
    }
  }
}

/**
 * Redirect to the 'add-player.php' page if clicked.
 */

if(isset($_POST['addSubmit'])){
  header("Location: " . Utils::$projectFilePath . "/add-player.php?");

}

/**
 * Check if the delete button was clicked.
 * If clicked check if the 'check_list' POST parameter is not empty.
 * Redirect to the 'delete-player.php' page with the IDs from the 'check_list' array as query parameters.
 */

if(isset($_POST['removeSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-player.php?id=$check");
    }
  }
}

/**
 * Check if the update skill button was clicked.
 * If clicked check if the 'check_list' POST parameter is not empty.
 * Redirect to the 'update-player-skill.php' page with the IDs from the 'check_list' array as query parameters.
 */

if(isset($_POST['updateSkillSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/update-player-skill.php?id=$check");
    }
  }
}





?>
<main class="content-wrapper profile-list-content my-5">


<div class="list-controls my-3 mx-auto">
<h2 >Player List</h2>


</div>

<form 
  method="post" 
  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">



  <div class="bg-dark text-white d-flex p-2">          
  <input class="btn btn-primary mx-2 my-2" type="submit" id="addBtn" name="addSubmit" value="Add Player">
  <input class="btn btn-secondary mx-2 my-2" type="submit" id="updateBtn" name="updateSubmit" value="Update Player">
  <input class="btn btn-secondary mx-2 my-2" type="submit" id="updateSkillBtn" name="updateSkillSubmit" value="Update Player Skill">
  <input class="btn btn-danger mx-2 my-2" type="submit" id="removeBtn" name="removeSubmit" value="Remove Player">
  <input type="button" id="settingsBtn" class="btn btn-info ms-auto my-2" value="Settings">  
  <input type="hidden" id="hidden-role-field" name="hidden-role-field" value="<?php echo $_SESSION["user_role"];?>">

</div>

<table class="table" id="customDataTable">
  <thead>
    <tr>
      <th>#</th>
      <th class="first-name-label">First Name</th>
      <th class="last-name-label">Last Name</th>
      <th class="sru-label">SRU No.</th>
      <th class="dob-label">Date of Birth</th>
      <th class="contact-label">Contact No.</th>
      <th class="email-label">Email Address</th>
      <th class="pfp-label">Profile Picture</th>
    </tr>
  </thead>
  <tbody>


    <?php

    /// Get all players from the database and output list of players
    $players = Player::getAllPlayers();
    Components::allPlayers($players);

    ?>

  </tbody>
</table>
</form>

<div id="myModal" class="modal">
  <div class="modal-content column-settings-content  w-50">
      <span class="close">&times;</span>
      <h3>Column Settings</h3>
      <div class="container">
        <div class="row">
          <div class="col">            
            <label class="checkbox-inline">First Name</label>
            <input type="checkbox" id="inlineCheckbox1" value="option1" onclick="displayColumn()" checked>
          </div>
          <div class="col">      
            <label class="checkbox-inline">Last Name</label>
            <input type="checkbox" id="inlineCheckbox2" value="option2" onclick="displayColumn()" checked>
          </div>
          <div class="w-100"></div>
          <div class="col">      
            <label class="checkbox-inline">Sru No.</label>
            <input type="checkbox" id="inlineCheckbox3" value="option3" onclick="displayColumn()" checked>
          </div>
          <div class="col">      
            <label class="checkbox-inline">DOB</label>
            <input type="checkbox" id="inlineCheckbox4" value="option4" onclick="displayColumn()" checked>
          </div>

          <div class="w-100"></div>
          <div class="col">      
            <label class="checkbox-inline">Contact No.</label>
            <input type="checkbox" id="inlineCheckbox5" value="option5" onclick="displayColumn()" checked>
          </div>
          <div class="col">      
            <label class="checkbox-inline">Email Address</label>
            <input type="checkbox" id="inlineCheckbox6" value="option6" onclick="displayColumn()" checked>
          </div>

          <div class="w-100"></div>
          <div class="col">      
            <label class="checkbox-inline">Profile Image</label>
            <input type="checkbox" id="inlineCheckbox7" value="option7" onclick="displayColumn()" checked>
          </div>
        </div>
      </div>
  </div>
</div>


</main>

<script>

let updateBtn = document.getElementById("updateBtn");
let removeBtn = document.getElementById("removeBtn");
let updateSkillBtn = document.getElementById("updateSkillBtn");
let addBtn = document.getElementById("addBtn");

var role = document.getElementById("hidden-role-field");


/**
 * Hide the add button if the role value is "Coach".
 */
if(role.value ==="Coach"){
  addBtn.style.display="none";
}

var modal = document.getElementById("myModal");
let settingsBtn = document.getElementById("settingsBtn");
var span = document.getElementsByClassName("close")[0];

settingsBtn.onclick = function(event) {
    /// Prevent the default form submission action
    event.preventDefault();
    modal.style.display = "block";
  }


  /// When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }


  /// When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

/**
 * Display or hide columns based on the checkboxes checked.
 */

function displayColumn(){

  var checkBox1 = document.getElementById("inlineCheckbox1");
  var checkBox2 = document.getElementById("inlineCheckbox2");
  var checkBox3 = document.getElementById("inlineCheckbox3");
  var checkBox4 = document.getElementById("inlineCheckbox4");
  var checkBox5 = document.getElementById("inlineCheckbox5");
  var checkBox6 = document.getElementById("inlineCheckbox6");
  var checkBox7 = document.getElementById("inlineCheckbox7");

  var firstName = document.querySelectorAll(".first-name-label"); 
  var lastName = document.querySelectorAll(".last-name-label");
  var sru = document.querySelectorAll(".sru-label");
  var dob = document.querySelectorAll(".dob-label");
  var contact = document.querySelectorAll(".contact-label");
  var email = document.querySelectorAll(".email-label");
  var pfp = document.querySelectorAll(".pfp-label");

  /// Check if checkbox 1 is checked
  if (checkBox1.checked) {
    for (var i = 0; i < firstName.length; i++) {
      firstName[i].style.display = "table-cell"; ///< Display each element in the firstName array as a table cell.
    }
  } else {
    for (var i = 0; i < firstName.length; i++) {
      firstName[i].style.display = "none"; ///< Hide each element in the firstName array.
    }
  }

  if (checkBox2.checked) {
    for (var i = 0; i < lastName.length; i++) {
      lastName[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < lastName.length; i++) {
      lastName[i].style.display = "none";
    }
  }

  if (checkBox3.checked) {
    for (var i = 0; i < sru.length; i++) {
      sru[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < sru.length; i++) {
      sru[i].style.display = "none";
    }
  }

  if (checkBox4.checked) {
    for (var i = 0; i < dob.length; i++) {
      dob[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < dob.length; i++) {
      dob[i].style.display = "none";
    }
  }

  if (checkBox5.checked) {
    for (var i = 0; i < contact.length; i++) {
      contact[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < contact.length; i++) {
      contact[i].style.display = "none";
    }
  }

  if (checkBox6.checked) {
    for (var i = 0; i < email.length; i++) {
      email[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < email.length; i++) {
      email[i].style.display = "none";
    }
  }

  if (checkBox7.checked) {
    for (var i = 0; i < pfp.length; i++) {
      pfp[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < pfp.length; i++) {
      pfp[i].style.display = "none";
    }
  }
}

displayColumn();

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

/**
 * Display buttons based on the type provided.
 */

function displayButtons(type){
  if(type == "block"){
    if(role.value === "Coach"){
      updateSkillBtn.style.display="block";
    } else{
    updateBtn.style.display="block";
    removeBtn.style.display="block";
    updateSkillBtn.style.display="block";

    }

  } else {

    if(role === "Coach"){
      updateSkillBtn.style.display="none";
    } else{
    removeBtn.style.display="none";
    updateBtn.style.display="none";
    updateSkillBtn.style.display="none";

    }

  }
}

displayButtons("none");

  
</script>
<?php

Components::pageFooter(); ///< Render page footer

?>
