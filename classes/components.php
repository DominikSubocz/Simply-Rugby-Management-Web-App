<?php

class Components {
  /**
   * Output a standard page header with customisable options.
   *
   * $pageTitle - string
   * $stylesheets - array
   * $scripts - array
   */
  public static function pageHeader($pageTitle, $stylesheets, $scripts) {
    require("components/header.php");
  }

  /**
   * Output a standard page footer.
   */
  public static function pageFooter() {
    require("components/footer.php");
  }

  /**
   * Renders an array of book arrays as a gallery.
   */
  public static function allBooks($books)
  {
    if (!empty($books)) {
      // Output a book card for each book in the $books array
      foreach ($books as $book) {
        $bookId = Utils::escape($book["book_id"]);
        $title = Utils::escape($book["title"]);
        $author = Utils::escape($book["author"]);
        $price = Utils::escape($book["price"]);
        $filename = Utils::escape($book["filename"]);

        require("components/book-card.php");
      }
    } else {
      // Output a message if the $books array is empty
      require("components/no-books-found.php");
    }
  }

  /**
   * Renders a book array to the page.
   */
  public static function singleBook($book)
  {
    if (!empty($book)) {
      $bookId = Utils::escape($book["book_id"]);
      $title = Utils::escape($book["title"]);
      $author = Utils::escape($book["author"]);
      $price = Utils::escape($book["price"]);
      $filename = Utils::escape($book["filename"]);

      // Output information on a single book
      require("components/book-single.php");
    } else {
      // Output a message if the $books array is empty
      require("components/no-single-book-found.php");
    }
  }
}
