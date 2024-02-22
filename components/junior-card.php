<a class="book-card" href="junior-page.php?id=<?php echo $junior_id; ?>">
  <div class="id-container card-container">
      <h3><?php echo $junior_id; ?></h3>
  </div>

  <div class="firstN-container card-container">
      <h3><?php echo $firstName; ?></h3>
  </div>
  <div class="lastN-container card-container">
      <p><?php echo $lastName; ?></p>
  </div>

  <div class="sru-container card-container">
      <p class="book-price">SRU:<?php echo $sruNumber; ?></p>
  </div>
  
  <div class="dob-container card-container">
      <p class="book-price"><?php echo $dob; ?></p>
  </div>

  <div class="contactNo-container card-container">
      <p class="book-price"><?php echo $contactNumber; ?></p>
  </div>

  <div class="email-container card-container">
      <p class="book-price"><?php echo $emailAddress; ?></p>
  </div>

  <div class="pfp-container junior-pfp card-container">
    <img src="images/<?php echo $filename; ?>" alt="Cover for <?php echo $firstName; ?>" class="book-image">
 </div>


</a>
