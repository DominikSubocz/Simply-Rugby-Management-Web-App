<?php

session_start();

require("classes/components.php");
require("classes/player.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All players", ["style"], ["mobile-nav"]);

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

if(isset($_POST['updateSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
            print_r($check);
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
  <a class="btn btn-dark" href="add-player.php">Add Player</a>
  <input type="submit" name="updateSubmit" value="Update Player">
  <!-- <a class="btn btn-dark" id="updateBtn" href="update-player.php"></a>
  <a class="btn btn-dark" id="removeBtn" href="delete-player.php">Remove Player</a> -->


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
    $players = player::getAllplayers();
    Components::allplayers($players);


    ?>
  </div>
</form>

</main>

<script>



function cbChange(obj) {
    var cbs = document.getElementsByClassName("cb");
    for (var i = 0; i < cbs.length; i++) {
        cbs[i].checked = false;
    }
    obj.checked = true;
}
  
</script>
<?php

Components::pageFooter();

?>
