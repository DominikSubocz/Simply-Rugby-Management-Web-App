<?php

session_start();

require("classes/components.php");
require("classes/player.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

if(!isset($_SESSION["loggedIn"])){


}

if(isset($_POST['updateSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/update-player.php?id=$check");
    }
  }
}

if(isset($_POST['addSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/add-player.php?");
    }
  }
}

if(isset($_POST['removeSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-player.php?id=$check");
    }
  }
}





?>
<main class="content-wrapper profile-list-content my-5">


<div class="list-controls my-3 mx-auto">
  <div class="my-3">
    <h2 >Player List</h2>
  </div>

</div>

<div class="alert alert-info my-3">
  
  <form 
    method="post" 
    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <input class="btn btn-dark" type="submit" id="addBtn" name="addSubmit" value="Add Player">
      <input class="btn btn-dark" type="submit" id="updateBtn" name="updateSubmit" value="Update Player">
      <input class="btn btn-danger" type="submit" id="removeBtn" name="removeSubmit" value="Remove Player">



</div>

  <div class="player-list">
    <div class="player-card column-headings ">
    <div class="id-container card-container">ID</div>
    <div class="fullN-container card-container">Name</div>
    <div class="sru-container card-container">SRU Number</div>
    <div class="dob-container card-container">Date of Birth</div>
    <div class="contactNo-container card-container">Contact Number</div>
    <div class="email-container card-container">Email Address</div>
    <div class="pfp-container card-container">Profile Picture</div>
  </div>



    <?php


    // Get all players from the database and output list of players
    $players = player::getallPlayers();
    Components::allPlayers($players);


    ?>
  </div>
</form>

</main>

<script>

let updateBtn = document.getElementById("updateBtn");
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
    updateBtn.style.display="block";
    removeBtn.style.display="block";
  } else {
    removeBtn.style.display="none";
    updateBtn.style.display="none";

  }
}
  
</script>
<?php

Components::pageFooter();

?>
