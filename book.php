<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/player.php");

/*
  Attempt to get the id from the URL parameter.
  If it isn't set or it isn't a number, redirect
  to book list page.
*/
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
  header("Location: " . Utils::$projectFilePath . "/book-list.php");
}

$book = Book::getBook($_GET["id"]);

// Set the document title to the title and author of the book if it exists
$pageTitle = "Book not found";

if (!empty($book)) {
  $pageTitle = $book["first_name"];
}

Components::pageHeader($pageTitle, ["style"], ["mobile-nav"]);
Components::singleBook($book);
Components::pageFooter();

?>
