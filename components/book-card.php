<a class="book-card" href="book.php?id=<?php echo $bookId; ?>">
  <div class="id-container card-container">
      <h3><?php echo $bookId; ?></h3>
  </div>

  <div class="some-container2 card-container">
      <h3><?php echo $title; ?></h3>
  </div>
  <div class="name-container card-container">
      <p><?php echo $author; ?></p>
  </div>

  <div class="some-container card-container">
      <p class="book-price"><?php echo $price; ?></p>
  </div>

  <div class="pfp-container card-container">
    <img src="images/<?php echo $filename; ?>" alt="Cover for <?php echo $title; ?>" class="book-image">
 </div>


</a>
