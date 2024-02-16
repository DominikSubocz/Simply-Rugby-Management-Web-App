<?php

// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

class Book
{
  /**
   * Get all books from the database.
   */
  public static function getAllBooks()
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getAllBooks);
    $stmt->execute();
    $books = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $books;
  }

  /**
   * Get a book with a specific ID from the database.
   */
  public static function getBook($bookId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getBook);
    $stmt->execute([$bookId]);
    $book = $stmt->fetch();

    $conn = null;

    return $book;
  }

  public static function getPlayerPositions($bookId)
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getPlayerPositions);
    $stmt->execute([$bookId]);
    $books = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $books;
  }

  public static function getPlayerSkills($bookId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getPlayerSkills);
    $stmt->execute([$bookId]);
    $books = $stmt->fetchAll();

    $conn = null;

    return $books;
  }
}
