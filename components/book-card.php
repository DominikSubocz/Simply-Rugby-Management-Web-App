<a class="book-card" href="book.php?id=<?php echo $player_id; ?>">
  <div class="id-container card-container">
      <p><?php echo $player_id; ?></p>
  </div>

  <div class="firstN-container card-container">
      <p><?php echo $firstName; ?></p>
  </div>
  <div class="lastN-container card-container">
      <p><?php echo $lastName; ?></p>
  </div>

  <div class="sru-container card-container">
      <p class="book-price"><?php echo $sruNumber; ?></p>
  </div>
  
  <div class="dob-container card-container">
      <p class="book-price"><?php echo $dob; ?></p>
  </div>

  <div class="pfp-container card-container">
    <img src="images/<?php echo $filename; ?>" alt="Cover for <?php echo $title; ?>" class="book-image">
 </div>


</a>
