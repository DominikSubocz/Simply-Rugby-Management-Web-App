<?php

session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/utils.php");
require("classes/address.php");

Components::pageHeader("List of Addresses", ["style"], ["mobile-nav"]);

if(!isset($_SESSION["loggedIn"])){

    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  
if(isset($_POST['removeSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-address.php?id=$check");
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
      <p><strong>NOTE: </strong>Ensure that the address isn't used anywhere else before removing!</p>
        <input class="btn btn-danger" id="removeBtn" type="submit" name="removeSubmit" value="Remove Address">
    </div>
</div>



<div class="address-list">
<div class="bg-dark text-white">          
  <input type="button" id="settingsBtn" class="btn btn-info mx-2 my-2" value="Settings">  
</div>
<div class="address-card column-headings">
  <div class="id-container card-container">ID</div>
  <div class="address-line1-container card-container">Address Line 1</div>
  <div class="address-line2-container card-container">Address Line 2</div>
  <div class="city-container card-container">City</div>
  <div class="county-container card-container">County</div>
  <div class="postcode-container card-container">Postcode</div>

</div>
  <?php

  // Get all players from the database and output list of players
  $addresses = Address::getAllAddresses();
  Components::allAddresses($addresses);

  ?>
</div>
</form>
<div id="myModal" class="modal">
  <div class="modal-content column-settings-content">
      <span class="close">&times;</span>
      <h3>Column Settings</h3>
      <div class="container">
        <div class="row">
          <div class="col">
            <label class="checkbox-inline">Address Line 1</label>
            <input type="checkbox" id="inlineCheckbox1" value="option1" onclick="displayColumn()" checked>
          </div>
          <div class="col">
            <label class="checkbox-inline">Address Line 2</label>
            <input type="checkbox" id="inlineCheckbox2" value="option2" onclick="displayColumn()" >
          </div>
          <div class="w-100"></div>
          <div class="col">      
            <label class="checkbox-inline">City</label>
            <input type="checkbox" id="inlineCheckbox3" value="option3" onclick="displayColumn()"checked>
          </div>
          <div class="col">      
            <label class="checkbox-inline">County</label>
            <input type="checkbox" id="inlineCheckbox4" value="option4" onclick="displayColumn()">
          </div>
        </div>
      </div>
  </div>
</div>
</main>

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

displayButtons("none");

function displayColumn(){

  var checkBox1 = document.getElementById("inlineCheckbox1");
  var checkBox2 = document.getElementById("inlineCheckbox2");
  var checkBox3 = document.getElementById("inlineCheckbox3");
  var checkBox4 = document.getElementById("inlineCheckbox4");

  var addressLine1 = document.querySelectorAll(".address-line1-container");
  var addressLine2 = document.querySelectorAll(".address-line2-container");
  var city = document.querySelectorAll(".city-container");
  var county = document.querySelectorAll(".county-container");
  var postcode = document.querySelectorAll(".postcode-container");

  // Check if checkbox 1 is checked
  if (checkBox1.checked) {
    for (var i = 0; i < addressLine1.length; i++) {
      addressLine1[i].style.display = "block";
    }
  } else {
    for (var i = 0; i < addressLine1.length; i++) {
      addressLine1[i].style.display = "none";
    }
  }

  if (checkBox2.checked) {
    for (var i = 0; i < addressLine2.length; i++) {
      addressLine2[i].style.display = "block";
    }
  } else {
    for (var i = 0; i < addressLine2.length; i++) {
      addressLine2[i].style.display = "none";
    }
  }

  if (checkBox3.checked) {
    for (var i = 0; i < city.length; i++) {
      city[i].style.display = "block";
    }
  } else {
    for (var i = 0; i < city.length; i++) {
      city[i].style.display = "none";
    }
  }

  if (checkBox4.checked) {
    console.log("Checkbox 1 checked:", checkBox1.checked);
    for (var i = 0; i < county.length; i++) {
      county[i].style.display = "block";
    }
  } else {
    for (var i = 0; i < county.length; i++) {
      county[i].style.display = "none";
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
  
</script>
