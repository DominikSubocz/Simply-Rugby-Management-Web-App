<?php

session_start();

require("classes/components.php");
require("classes/member.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All Books", ["style"], ["mobile-nav"]);

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

?>
<main class="content-wrapper profile-list-content">

<h2>Book List</h2>

<div class="book-list">

<div class="book-card column-headings">
  <div class="id-container card-container">ID</div>
  <div class="firstN-container card-container">First Name</div>
  <div class="lastN-container card-container">Last Name</div>
  <div class="sru-container card-container">SRU Number</div>
  <div class="dob-container card-container">Date of Birth</div>
  <div class="contactNo-container card-container">Contact Number</div>
  <div class="email-container card-container">Email Address</div>
  <div class="pfp-container card-container">Profile Picture</div>

</div>

  <?php

  // Get all books from the database and output list of books
  $books = Member::getAllMembers();
  Components::allMembers($books);

  ?>
</div>
</main>
<?php

Components::pageFooter();

?>
