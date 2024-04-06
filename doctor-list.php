<?php

session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/utils.php");
require("classes/doctor.php");

Components::pageHeader("List of Doctors", ["style"], ["mobile-nav"]);

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

if(!isset($_SESSION["loggedIn"])){

    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  
if(isset($_POST['removeSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-doctor.php?id=$check");
    }
  }
}

  
?>

<main class="content-wrapper profile-list-content my-5">
  
<div id="address-controls" class="alert alert-info my-3">
  
  <form 
    method="post" 
    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div>
        <p><strong>NOTE: </strong>Ensure that the Doctor is not present in any other table before removing!</p>
        </div>
</div>


<div class="bg-dark text-white d-flex p-2">          
    <input type="button" id="settingsBtn" class="btn btn-info mx-2 my-2" value="Settings">  
    <input class="btn btn-danger mx-2 my-2" id="removeBtn" type="submit" name="removeSubmit" value="Remove Doctor">

</div>

<table class="table" id="customDataTable">
  <thead>
    <tr>
      <th>#</th>
      <th class="first-name-label">First Name</th>
      <th class="last-name-label">Last Name</th>
      <th class="contact-label">Contact No.</th>
    </tr>
  </thead>
  <tbody>


    <?php

    // Get all players from the database and output list of players
    $doctors = Doctor::getAllDoctors();
    Components::allDoctors($doctors);

    ?>

  </tbody>
</table>
</form>

<div id="myModal" class="modal">
  <div class="modal-content column-settings-content">
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
            <label class="checkbox-inline">Contact No.</label>
            <input type="checkbox" id="inlineCheckbox3" value="option3" onclick="displayColumn()" checked>
          </div>
          </div>
        </div>
      </div>
  </div>
</div>
<script>
var modal = document.getElementById("myModal");
let settingsBtn = document.getElementById("settingsBtn");
var span = document.getElementsByClassName("close")[0];


settingsBtn.onclick = function(event) {
    // Prevent the default form submission action
    event.preventDefault();
    modal.style.display = "block";
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


function displayColumn(){

  var checkBox1 = document.getElementById("inlineCheckbox1");
  var checkBox2 = document.getElementById("inlineCheckbox2");
  var checkBox3 = document.getElementById("inlineCheckbox3");

  var firstName = document.querySelectorAll(".first-name-label");
  var lastName = document.querySelectorAll(".last-name-label");
  var contact = document.querySelectorAll(".contact-label");

  // Check if checkbox 1 is checked
  if (checkBox1.checked) {
    for (var i = 0; i < firstName.length; i++) {
      firstName[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < firstName.length; i++) {
      firstName[i].style.display = "none";
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
    for (var i = 0; i < contact.length; i++) {
      contact[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < contact.length; i++) {
      contact[i].style.display = "none";
    }
  }

}

displayColumn();

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
    removeBtn.style.display="block";
  } else {
    removeBtn.style.display="none";

  }
}

displayButtons("none");

  
</script>