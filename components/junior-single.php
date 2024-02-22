<main class="content-wrapper profile-content">
  <div class="profile-content-container">

  <div class="profile-container">
      <div>
        <img class="profile-img" src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $firstName; ?>" class="profile-img">
      </div>
  </div>

    <div class="profile-container">
      <div class="profile-items">
        <h2>Junior Info</h2>
        <p><?php echo 'Name: ', $firstName, ' ', $lastName; ?></p>
        <p><?php echo 'SRU:', $sruNumber; ?></p>
      </div>
      <div class="profile-items">
        <h2>Personal Details</h2>
        <p><?php echo 'Contact Number: ', $contactNumber; ?></p>
        <p><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
        <p><?php echo 'Email: ', $emailAddress; ?></p>
        <p><?php echo 'Known Health Issues: ', $healthIssues; ?></p>
      </div>
      <div class="profile-items">
        <h2>Guardian Contact Details</h2>
        <p><?php echo 'Name: ', $nextOfKin?></p>
        <p><?php echo 'Contact Number: ', $kinContactNumber; ?></p>
      </div>
      <div class="profile-items">
        <h2>Doctor Information</h2>
        <p><?php echo 'Name: ', $doctorFirstName, ' ', $doctorLastName; ?></p>
        <p><?php echo 'Contact Number: ', $doctorContact; ?></p>
      </div>
    </div>

    <div class="skills-card-container">
      <div class="skills-card passing-card">
        <div>
          <br>
          <h3>Passing</h3>
        </div>
        <?php
          $skill = Junior::getJuniorSkills($_GET["id"]);
          Components::juniorPassingSkill($skill);
        ?>
      </div>

      <div class="skills-card tackling-card">
        <div>
          <br>
          <h3>Tackling</h3>
        </div>
        <?php
          $skill = Junior::getJuniorSkills($_GET["id"]);
          Components::juniorTacklingSkill($skill);
        ?>
      </div>

      <div class="skills-card kicking-card">
        <div>
          <br>
          <h3>Kicking</h3>
        </div>
        <?php
          $skill = Junior::getJuniorSkills($_GET["id"]);
          Components::juniorKickingSkill($skill);
        ?>
      </div>
    </div>
  </div>
</main>
