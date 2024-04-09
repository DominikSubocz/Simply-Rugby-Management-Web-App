<?php

/// If one of these file has already been included, do not do so again
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

    /// Prepare and execute the query and get the results.
    $stmt = $conn->prepare(SQL::$getAllMembers);
    $stmt->execute();
    $members = $stmt->fetchAll();

    /// Null the connection object when we no longer need it
    $conn = null;

    return $members;
  }

  /**
   * Get a member with a specific ID from the database.
   * 
   * @param playerId - String containing member's ID number.
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
   * @param playerId - String containing member's ID number.
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
   * @param address_id - String containing address ID number.
   * @param firstName - String containing member's first name.
   * @param lastName - String containing member's last name.
   * @param dob - String containing member's date of birth
   * @param sru - String containing member's SRU number.
   * @param contactNo - String containing member's contact number.
   * @param mobileNo - String containing members's mobile number.
   * @param email - String containing member's emaila address.
   * @param filename - String containing member's profile picture filename.
   * @param memberId - String containing member's ID number.
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
   * @param playerId - String containing member's ID number.
   * @param firstName - String containing member's first name.
   * @param lastName - String containing member's last name.
   * @param dob - String containing member's date of birth
   * @param sru - String containing member's SRU number.
   * @param contactNo - String containing member's contact number.
   * @param mobileNo - String containing members's mobile number.
   */

  public static function memberExists($firstName, $lastName, $dob, $sru, $contactNo, $mobileNo){
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$memberExists);
    $stmt->execute([$firstName, $lastName, $dob, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();
  }
}
