

<div class="book-container">

  <div class="pfp-container">
    <img src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $firstName; ?>" class="profile-img">
    <div><button class="button profile-btn" onclick="displayTabs(0)">Personal Information</button></div>
    <div><button class="button profile-btn" onclick="displayTabs(1)">Guardian Information</button></div>
    <div><button class="button profile-btn" onclick="displayTabs(2)">Skills</button></div>
  </div>




    <div id="book-info" class="book-info tab">
      <h2><?php echo $firstName, ' ', $lastName; ?></h2>
      <h3><?php echo 'SRU:', $sruNumber; ?></h3>
      <p class="book-price"><?php echo 'Contact Number: ', $contactNumber; ?></p>
      <p class="book-price"><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
      <p class="book-price"><?php echo 'Email: ', $emailAddress; ?></p>
      <p class="book-price"><?php echo 'Known Health Issues: ', $healthIssues; ?></p>
      <h2> Address </h2>
      <p class="book-price"><?php echo 'Address Line 1: ', $address1; ?></p>
      <p class="book-price"><?php echo 'Address Line 2: ', $address2; ?></p>
      <p class="book-price"><?php echo 'City: ', $city; ?></p>
      <p class="book-price"><?php echo 'County: ', $county; ?></p>
      <p class="book-price"><?php echo 'Postcode: ', $postcode; ?></p>
    </div>
    <div id="abc-info" class="abc-info tab">
      <h2><?php echo $firstName, ' ', $lastName; ?></h2>
      <h3><?php echo 'SRU:', $sruNumber; ?></h3>
      <p class="book-price"><?php echo 'Contact Number: ', $contactNumber; ?></p>
      <p class="book-price"><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
      <p class="book-price"><?php echo 'Email: ', $emailAddress; ?></p>
      <p class="book-price"><?php echo 'Known Health Issues: ', $healthIssues; ?></p>
    </div>
    <div id="skills-info" class="idk-info tab">
      <h2>Skills</h2>

      <table>

        <tr>
            <th>Positions</th>
          </tr>
          
          <?php
              $skill = Junior::getJuniorPositions($_GET["id"]);
              Components::juniorPositions($skill);
              ?>

      </table>
      <table>
        <tr>
          <th>Category</th>
          <th>Skill</th>
          <th>Level</th>
          <th>Comment</th>
        </tr>
      
        <tr>
          <td rowspan="6">Passing</td>
        </tr>

          <?php
              $skill = Junior::getJuniorSkills($_GET["id"]);
              Components::juniorPassingSkill($skill);
              ?>


        <tr>
          <td rowspan="8">Tackling</td>
        </tr>

          <?php
              $skill = Junior::getJuniorSkills($_GET["id"]);
              Components::juniorTacklingSkill($skill);
              ?>


        <tr>
          <td rowspan="8">Kicking</td>


          <?php
              $skill = Junior::getJuniorSkills($_GET["id"]);
              Components::juniorKickingSkill($skill);
              ?>

      </table>





</div>

      
    <script>

var currentTab = 0; // Current tab is set to be the first tab (0)

x = document.getElementById("book-info");
y = document.getElementById("abc-info");
s = document.getElementById("skills-info");

if (currentTab == 0){
    x.style.display = "block";
    y.style.display = "none";
    s.style.display = "none";
}

function displayTabs(t){

  if (t == 1){
    y.style.display = "block";
    s.style.display = "none";
    x.style.display = "none";


  }

  else if (t == 2){
    s.style.display = "block";
    x.style.display = "none";
    y.style.display = "none";

  }

  else{
    x.style.display = "block";
    y.style.display = "none";
    s.style.display = "none";
  }

}
</script>
  


</div>