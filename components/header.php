<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>

  <?php

  if (!empty($stylesheets)) {
    foreach ($stylesheets as $sheet) {
      echo "<link rel=\"stylesheet\" href=\"css/$sheet.css\">";
    }
  }

  if (!empty($scripts)) {
    foreach ($scripts as $script) {
      echo "<script src=\"js/$script.js\" defer></script>";
    }
  }

  ?>

</head>
<body>
  <header class="page-header">
    <div class="content-wrapper desktop-header-row">
      <div class="mobile-top">
        <h1 class="page-title">Book Store</h1>

        <button class="nav-button" id="nav-button">
          <img src="icons/nav-button.png">
        </button>
      </div>

      <nav class="page-navigation" id="nav-list">
        <ul class="nav-links">
          <li><a href="book-list.php">Books</a></li>

          <?php

          if(isset($_SESSION["loggedIn"])){
            if($_SESSION["user_role"] === "Admin"){
              echo "<li><a href='add-book.php'>Add Book</a></li>";
              
            }

            echo "<li><a href='timetable.php'>Timetable</a></li>
            <li><a href='profile.php'>Profile</a></li>
            <li><a href='logout.php'>Logout</a></li>";
            
          } else {
            echo "<li><a href='register.php'>Register</a></li>
            <li><a href='login.php'>Login</a></li>";
          }
          ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="content-wrapper main-content">