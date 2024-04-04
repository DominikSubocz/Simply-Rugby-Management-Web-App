<a class="player-card" href="member-page.php?id=<?php echo $member_id; ?>">
<div class="id-container card-container">
    <td><input type="checkbox" name="check_list[]" class="cb" onchange="cbChange(this)" value="<?php echo $member_id; ?>"></td>
  </div>

  <div class="fullN-container card-container">
  <p><?php echo $firstName . ' ' . $lastName ?></p>
  </div>

  <div class="sru-container card-container">
      <p class="player-price"><?php echo $sruNumber; ?></p>
  </div>
  
  <div class="dob-container card-container">
      <p class="player-price"><?php echo $dob; ?></p>
  </div>

  <div class="contactNo-container card-container">
      <p class="player-price"><?php echo $contactNumber; ?></p>
  </div>

  <div class="email-container card-container">
      <p class="player-price"><?php echo $emailAddress; ?></p>
  </div>

  <div class="pfp-container card-container">
    <img src="images/<?php echo $filename; ?>" alt="Cover for <?php echo $firstName; ?>" class="player-image">
 </div>


</a>
