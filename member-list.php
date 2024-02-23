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
  <?php

  // Get all books from the database and output list of books
  $books = Member::getAllMembers();
  Components::allMembers($books);

  ?>
</div>

<?php

Components::pageFooter();

?>
