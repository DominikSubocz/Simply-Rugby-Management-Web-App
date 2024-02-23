<?php

session_start();

require("classes/components.php");
require("classes/junior.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All Books", ["style"], ["mobile-nav"]);

if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}
?>

<h2>Book List</h2>

<div class="book-list">
  <?php

  // Get all books from the database and output list of books
  $books = Junior::getAllJuniors();
  Components::allJuniors($books);

  ?>
</div>


<?php

Components::pageFooter();

?>