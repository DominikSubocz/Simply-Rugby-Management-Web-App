<?php

/// If one of these file has already been included, do not do so again
require_once ("classes/connection.php");
require_once ("classes/sql.php");
require_once ("classes/utils.php");

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
   * Retrieves all members from the database.
   *
   * @return array An array containing all the members
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
   * Retrieves a member from the database based on the provided player ID.
   *
   * @param int $playerId The ID of the player 
   * @return string $member The member information 
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
   * Deletes a member from the database based on the provided player ID.
   *
   * @param int $playerId The ID of the player to be deleted.
   */
  public static function deleteMember($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$deleteMember);
    $stmt->execute([$playerId]);

    $conn = null;


  }




  /**
   * Update a member's information in the database.
   *
   * @param int $address_id The address ID of the member
   * @param string $firstName The first name of the member
   * @param string $lastName The last name of the member
   * @param string $dob The date of birth of the member
   * @param string $sru The SRU of the member
   * @param string $contactNo The contact number of the member
   * @param string $mobileNo The mobile number of the member
   * @param string $email The email address of the member
   * @param string $filename The filename of the member
   * @param int $memberId The ID of the member to update
   */
  public static function updateMember($address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $filename, $memberId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$updateMember);
    $stmt->execute([$address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $filename, $memberId]);


    $conn = null;

  }



  /**
   * Check if a member with the given details already exists in the database.
   *
   * @param string $firstName The first name of the member
   * @param string $lastName The last name of the member
   * @param string $dob The date of birth of the member
   * @param string $sru The SRU of the member
   * @param string $contactNo The contact number of the member
   * @param string $mobileNo The mobile number of the member
   * @return array $existingUser Array containing existing user if found, or null if not found
   */
  public static function memberExists($firstName, $lastName, $dob, $sru, $contactNo, $mobileNo)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$memberExists);
    $stmt->execute([$firstName, $lastName, $dob, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();

    return $existingUser;
  }
}
