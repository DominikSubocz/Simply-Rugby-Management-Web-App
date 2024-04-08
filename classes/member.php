<?php

// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

/**
 * 
 * @brief This class is responsible for actions related to Member information.
 * 
 * These include:
 * - Retrieving records from database (Multiple & Single).
 * - Inserting new records to the database.
 * - Updating existing records in the database.
 * - Deleting records from database.
 * 
 */

class Member
{
  /**
   * Get all members from the database.
   * 
   * @return members - Array with all records from database.
   */

  public static function getAllMembers()
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results.
    $stmt = $conn->prepare(SQL::$getAllMembers);
    $stmt->execute();
    $members = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $members;
  }

  /**
   * Get a member with a specific ID from the database.
   * 
   * @param playerId - Stores information about member's ID number.
   * 
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

  /**
   * Delete a member with specific ID from the database.
   * 
   * @param playerId - Stores information about member's ID number.
   * 
   */


  public static function deleteMember ($playerId){
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$deleteMember);
    $stmt->execute([$playerId]);

    $conn = null;


    }

  /**
   * Update a existing record with specific member ID number.
   * 
   * @param address_id - Stores information about address ID number.
   * @param firstName - Stores information about member's first name.
   * @param lastName - Stores information about member's last name.
   * @param dob - Stores information about member's date of birth
   * @param sru - Stores information about member's SRU number.
   * @param contactNo - Stores information about member's contact number.
   * @param mobileNo - Stores information about members's mobile number.
   * @param email - Stores information about member's emaila address.
   * @param filename - Stores information about member's profile picture filename.
   * @param memberId - Stores information about member's ID number.
   * 
   */

  public static function updateMember($address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $filename, $memberId){
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$updateMember);
    $stmt->execute([$address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $filename, $memberId]);


    $conn = null;

  }

  /**
   * Check if member specific exists and get single record result for that member.
   * 
   * @param playerId - Stores information about member's ID number.
   * @param firstName - Stores information about member's first name.
   * @param lastName - Stores information about member's last name.
   * @param dob - Stores information about member's date of birth
   * @param sru - Stores information about member's SRU number.
   * @param contactNo - Stores information about member's contact number.
   * @param mobileNo - Stores information about members's mobile number.
   */

  public static function memberExists($firstName, $lastName, $dob, $sru, $contactNo, $mobileNo){
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$memberExists);
    $stmt->execute([$firstName, $lastName, $dob, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();
  }
}
