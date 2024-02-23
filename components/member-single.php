<main class="content-wrapper profile-content">
  <div class="profile-content-container">

  <div class="profile-container">
      <div>
        <img class="profile-img" src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $firstName; ?>" class="profile-img">
      </div>
  </div>

    <div class="profile-container">
      <div class="profile-items">
        <h2>Player Info</h2>
        <p><?php echo 'Name: ', $firstName, ' ', $lastName; ?></p>
        <p><?php echo 'SRU:', $sruNumber; ?></p>
      </div>
      <div class="profile-items">
        <h2>Personal Details</h2>
        <p><?php echo 'Contact Number: ', $contactNumber; ?></p>
        <p><?php echo 'Mobile Number: ', $mobileNumber; ?></p>
        <p><?php echo 'Email: ', $emailAddress; ?></p>
      </div>
    </div>
  </div>
</main>
