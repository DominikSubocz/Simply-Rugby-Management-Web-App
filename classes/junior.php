<?php

// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

class Junior
{
  /**
   * Get all books from the database.
   */

  public static function getAllJuniors()
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getAllJuniors);
    $stmt->execute();
    $juniors = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }

  public static function getJuniorSkills($bookId)
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getJuniorSkills);
    $stmt->execute([$bookId]);
    $juniors = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }

  public static function getJuniorPositions($bookId)
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getJuniorPositions);
    $stmt->execute([$bookId]);
    $juniors = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }

  /**
   * Get a book with a specific ID from the database.
   */
  public static function getJunior($bookId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getJunior);
    $stmt->execute([$bookId]);
    $junior = $stmt->fetch();

    $conn = null;

    return $junior;
  }
}
