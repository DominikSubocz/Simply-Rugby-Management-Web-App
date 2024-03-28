<?php

// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

class Member
{
  /**
   * Get all players from the database.
   */

  public static function getAllMembers()
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getAllMembers);
    $stmt->execute();
    $members = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $members;
  }

  /**
   * Get a player with a specific ID from the database.
   */
  public static function getMember($playerId)
  {
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$getMember);
    $stmt->execute([$playerId]);
    $member = $stmt->fetch();

    $conn = null;

    return $member;
  }

  public static function deleteMember ($playerId){
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$deleteMember);
    $stmt->execute([$playerId]);

    $conn = null;


    }

  public static function updateMember($address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $filename, $memberId){
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$updateMember);
    $stmt->execute([$address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $filename, $memberId]);


    $conn = null;

  }
}
