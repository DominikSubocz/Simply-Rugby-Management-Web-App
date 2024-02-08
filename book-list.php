<?php

require("classes/components.php");
require("classes/book.php");

// Output page header with a given title, stylesheet, and script
Components::pageHeader("All Books", ["style"], ["mobile-nav"]);

?>

<h2>Book List</h2>

<div class="book-list">
  <?php

  // Get all books from the database and output list of books
  $books = Book::getAllBooks();
  Components::allBooks($books);

  ?>
</div>

<?php

Components::pageFooter();

?>
