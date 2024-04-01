<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="js/daypilot/daypilot-all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
        <h1 class="page-title">SimplyRugby</h1>

        <button class="nav-button" id="nav-button">
          <img src="icons/nav-button.png">
        </button>
      </div>

      <nav class="page-navigation" id="nav-list">
        <ul class="nav-links">

          <?php
          

          if(isset($_SESSION["loggedIn"])){
            if($_SESSION["user_role"] === "Admin"){
              echo "<li><a href='index.php'>Dashboard</a></li>
              <div class='dropdown'>
              <button class='dropBTN'>Member Management ▼</button>
              <div class='dropdown-content'>

              
              <li><a href='player-list.php'>Players</a></li>
              <li><a href='add-player.php'>Add Player</a></li>
              <li><a href='junior-list.php'>Junior Players</a></li>
              <li><a href='add-junior.php'>Add Junior Player</a></li>
              <li><a href='member-list.php'>Members</a></li>
              <li><a href='add-member.php'>Add Member</a></li>
              
              </div>
              </div>";
            }

            if($_SESSION["user_role"] === "Member"){
              $profileId = $_SESSION["profileId"];
              echo "<li><a href='$profileId'>Profile</a></li>";


            }

            echo "<li><a href='timetable.php'>Timetable</a></li>
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

