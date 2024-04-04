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
      <input class="btn btn-danger" type="submit" name="removeSubmit" value="Remove Address">
</div>

<div class="player-list">

<div class="player-card column-headings">
  <div class="id-container card-container">ID</div>
  <div class="address-line1-container ard-container">Address Line 1</div>
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
</main>

<script>

let removeBtn = document.getElementById("removeBtn");

displayButtons("none");


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
