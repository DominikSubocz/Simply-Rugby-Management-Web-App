<?php

session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/coach.php");
require("classes/utils.php");


// Output page header with a given title, stylesheet, and script
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

if($_SESSION["user_role"] != "Admin"){
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

if(isset($_POST['updateSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/update-coach.php?id=$check");
    }
  }
}

if(isset($_POST['addSubmit'])){
  header("Location: " . Utils::$projectFilePath . "/add-coach.php?");

}

if(isset($_POST['removeSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-coach.php?id=$check");
    }
  }
}

?>
<main class="content-wrapper profile-list-content my-5">
  <div class="list-controls my-3 mx-auto">
  <h2 >Member List</h2>

  <form 
    method="post" 
    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      
<div class="bg-dark text-white d-flex p-2">          
  <input class="btn btn-primary mx-2 my-2" type="submit" id="addBtn" name="addSubmit" value="Add Player">
  <input class="btn btn-secondary mx-2 my-2" type="submit" id="updateBtn" name="updateSubmit" value="Update Player">
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
      <th class="dob-label">Date of Birth</th>
      <th class="contact-label">Contact No.</th>
      <th class="mobile-label">Mobile No.</th>
      <th class="email-label">Email Address</th>
      <th class="pfp-label">Profile Picture</th>
    </tr>
  </thead>
  <tbody>


    <?php

    $coaches = Coach::getAllCoaches();
    Components::allCoaches($coaches);

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
let addBtn = document.getElementById("addBtn");

var role = document.getElementById("hidden-role-field");

if(role.value ==="Coach"){
  addBtn.style.display="none";
}

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
    if(role.value === "Coach"){
      updateBtn.style.display="none";
      removeBtn.style.display="none";
    } else {
      updateBtn.style.display="block";
      removeBtn.style.display="block";
    }

  } else {
    if(role.value === "Coach"){
      updateBtn.style.display="none";
      removeBtn.style.display="none";
    } else {
      updateBtn.style.display="none";
    removeBtn.style.display="none";
}

  }
}

displayButtons("none");

  
</script>
<?php

Components::pageFooter();

?>