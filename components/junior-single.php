<div class="book-container">
  <img src="images/<?php echo $filename; ?>" alt="Cover of <?php echo $title; ?>" class="profile-img">

  <div class="book-info">
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
</div>