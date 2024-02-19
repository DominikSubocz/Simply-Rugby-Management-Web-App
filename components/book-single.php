

<div class="book-container">

  <div class="pfp-container">
    <img src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $firstName; ?>" class="profile-img">
    <div><button class="button profile-btn" onclick="displayTabs(0)">Personal Information</button></div>
    <div><button class="button profile-btn" onclick="displayTabs(1)">Skills</button></div>
  </div>




    <div id="book-info" class="book-info tab">
      <h2><?php echo $firstName, ' ', $lastName; ?></h2>
      <h3><?php echo 'SRU:', $sruNumber; ?></h3>
      <p class="book-price"><?php echo 'Contact Number: ', $contactNumber; ?></p>
      <p class="book-price"><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
      <p class="book-price"><?php echo 'Email: ', $emailAddress; ?></p>
      <p class="book-price"><?php echo 'Known Health Issues: ', $healthIssues; ?></p>
      <p class="book-price"><?php echo 'Next of kin: ', $nextOfKin; ?></p>
      <p class="book-price"><?php echo 'Mobile Number: ', $kinContactNumber; ?></p>
      <h2> Address </h2>
      <p class="book-price"><?php echo 'Address Line 1: ', $address1; ?></p>
      <p class="book-price"><?php echo 'Address Line 2: ', $address2; ?></p>
      <p class="book-price"><?php echo 'City: ', $city; ?></p>
      <p class="book-price"><?php echo 'County: ', $county; ?></p>
      <p class="book-price"><?php echo 'Postcode: ', $postcode; ?></p>
    </div>
    <div id="skills-info" class="idk-info tab">
    <h2>Skills</h2>

<div class="skills-card-container">

  <div class="positions-card">
      <h3>Positions</h3>
    </div>
    
    <?php
        // $skill = Book::getJuniorPositions($_GET["id"]);
        // Components::juniorPositions($skill);
    ?>

</div>
<br>
<div class="skills-card passing-card">
  <div>
    <br>
    <h3>Passing</h3>
  </div>

    <?php
        $skill = Book::getPlayerSkills($_GET["id"]);
        Components::playerPassingSkill($skill);
        ?>
</div>

<div class="skills-card tackling-card">
  <div>
  <br>
    <h3>Tackling</h3>
  </div>

    <?php
        $skill = Book::getPlayerSkills($_GET["id"]);
        Components::playerTacklingSkill($skill);
        ?>



  </div>

  <div class="skills-card tackling-card">
  <div>
  <br>
    <h3>Kicking</h3>
  </div>

    <?php
        $skill = Book::getPlayerSkills($_GET["id"]);
        Components::playerKickingSkill($skill);
        ?>



</div>
</div>

      
    <script>

var currentTab = 0; // Current tab is set to be the first tab (0)

x = document.getElementById("book-info");
s = document.getElementById("skills-info");

if (currentTab == 0){
    x.style.display = "block";
    s.style.display = "none";
}

function displayTabs(t){

  if (t == 1){
    s.style.display = "block";
    x.style.display = "none";


  }

  else{
    x.style.display = "block";
    s.style.display = "none";
  }

}
</script>
  


</div>