

<div class="player-info-card">
  
    <div class="pfp-container">
      <img src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $firstName; ?>" class="profile-img">
      <div><button class="button profile-btn" onclick="displayTabs(0)">Personal Information</button></div>
      <div><button class="button profile-btn" onclick="displayTabs(1)">Skills</button></div>
    </div>
    
  <div>
    <div id="player-info" class="book-info tab">
      <div>
        <h2> Personal Details </h2>
          <div class="basic-info-card profile-card">
            <p><?php echo 'Name: ', $firstName, ' ', $lastName; ?></p>
            <p><?php echo 'SRU: ', $sruNumber; ?></p>
            <p ><?php echo 'Contact Number: ', $contactNumber; ?></p>
            <p ><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
            <p ><?php echo 'Email: ', $emailAddress; ?></p>
            <p ><?php echo 'Known Health Issues: ', $healthIssues; ?></p>
          </div>

          <div>
            <h2>Emergency Contact</h2>
            <div class="emergency-info-card profile-card">
              <p ><?php echo 'Next of kin: ', $nextOfKin; ?></p>
              <p ><?php echo 'Mobile Number: ', $kinContactNumber; ?></p>
            </div>
          </div>
      </div>



        <div>
          <h2>Address Information</h2>
          <div class="address-info-card profile-card">
            <p ><?php echo 'Address Line 1: ', $address1; ?></p>
            <p ><?php echo 'Address Line 2: ', $address2; ?></p>
            <p ><?php echo 'City: ', $city; ?></p>
            <p ><?php echo 'County: ', $county; ?></p>
            <p ><?php echo 'Postcode: ', $postcode; ?></p>
          </div>
        </div>
    </div>
  </div>
  
  <div class="skills-info-card">  
      <div id="skills-info" class="idk-info tab">
    <h2> Skill Ratings </h2>
  
        <br>
        <div class="skills-card skill-card-container passing-card">
          <div>
            <br>
            <h3>Passing</h3>
          </div>
  
            <?php
                $skill = Book::getPlayerSkills($_GET["id"]);
                Components::playerPassingSkill($skill);
                ?>
        </div>
  
        <div class="skills-card skill-card-container tackling-card">
        <div>
          <br>
            <h3>Tackling</h3>
          </div>
  
            <?php
                $skill = Book::getPlayerSkills($_GET["id"]);
                Components::playerTacklingSkill($skill);
                ?>
  
  
  
          </div>
  
        <div class="skills-card skill-card-container kicking-card">
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
  
  
  </div>
</div>

