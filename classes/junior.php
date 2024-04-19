<?php


require_once ("classes/connection.php");
require_once ("classes/sql.php");
require_once ("classes/utils.php");


/**
 * 
 * @brief This class is responsible for actions related to Junior Player information.
 * 
 * These include:
 *  - Retrieving records from database (Multiple & Single).
 *  - Inserting new records to the database.
 *  - Updating existing records in the database.
 *  - Deleting records from database.
 * 
 */

class Junior
{

  /**
   * Retrieves all junior members from the database.
   *
   * @return array $juniors An array containing all junior members
   */
  public static function getAllJuniors()
  {
    $conn = Connection::connect();

    /// Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getAllJuniors);
    $stmt->execute();
    $juniors = $stmt->fetchAll();

    /// Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }


  /**
   * Update the skill level and comment for a junior player's skill.
   *
   * @param int $skillLevel The new skill level for the player.
   * @param string $comment The comment to be associated with the skill level.
   * @param int $skillId The ID of the skill to be updated.
   * @param int $playerId The ID of the player whose skill is being updated.
   */
  public static function updateJuniorSkills($skillLevel, $comment, $skillId, $playerId)
  {
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJuniorSkills);
    $stmt->execute([$skillLevel, $comment, $skillId, $playerId]);

    $conn = null;

  }



  /**
   * Retrieves the junior skills for a specific player based on the player ID.
   *
   * @param int $playerId The ID of the player 
   * @return array $juniors An array containing the junior skills of the player.
   */
  public static function getJuniorSkills($playerId)
  {
    $conn = Connection::connect();

    /// Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getJuniorSkills);
    $stmt->execute([$playerId]);
    $juniors = $stmt->fetchAll();

    /// Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }



  /**
   * Retrieves the junior positions for a specific player based on the player ID.
   *
   * @param int $playerId The ID of the player 
   * @return array $juniors An array containing the junior positions of the player.
   */
  public static function getJuniorPositions($playerId)
  {
    $conn = Connection::connect();

    /// Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getJuniorPositions);
    $stmt->execute([$playerId]);
    $juniors = $stmt->fetchAll();

    /// Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }


  /**
   * Retrieves the junior player information based on the provided player ID.
   *
   * @param int $playerId The ID of the player
   * @return string $junior The junior player information if found, null otherwise.
   */
  public static function getJunior($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getJunior);
    $stmt->execute([$playerId]);
    $junior = $stmt->fetch();

    $conn = null;

    return $junior;
  }


  /**
   * Retrieves the guardians of a player based on the player ID.
   *
   * @param int $playerId The ID of the player
   * @return array $juniors An array of junior guardians associated with the player
   */
  public static function getGuardians($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getJuniorGuardians);
    $stmt->execute([$playerId]);
    $juniors = $stmt->fetchAll();

    $conn = null;

    return $juniors;
  }


  /**
   * Delete a junior player and associated data from the database based on the player ID.
   *
   * @param int $playerId The ID of the player to be deleted
   */
  public static function deleteJunior($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$deleteJuniorAssociation);
    $stmt->execute([$playerId]);

    $stmt = $conn->prepare(SQL::$deleteJuniorPosition);
    $stmt->execute([$playerId]);

    $stmt = $conn->prepare(SQL::$deleteJuniorSkill);
    $stmt->execute([$playerId]);

    $stmt = $conn->prepare(SQL::$deleteJunior);
    $stmt->execute([$playerId]);
    $conn = null;


  }

  /**
   * Update a junior record in the database with the provided information.
   *
   * @param int $addressId: ID number of specific address
   * @param string  $firstName:  First name of junior player
   * @param string  $lastName:  Last name of junior player
   * @param \DateTime $dob:  Date of birth of junior player
   * @param int  $sru: SRU of junior player
   * @param int  $contactNo:   Contact number of junior player
   * @param int  $mobileNo:  Mobile number of junior player
   * @param string  $email:  Email address of junior player
   * @param string  $healthIssues:  Health issues of junior player
   * @param string  $filename:  filename of profile picture of junior player
   * @param int $juniorId:  ID number of junior player
   * @throws PDOException If there is an error with the database operation. - There is a try catch code in corresponding page.
   */
  public static function updateJunior($address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId)
  {
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJunior);
    $stmt->execute([$address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId]);
    $conn = null;
  }



  /**
   * Update the association between a guardian, a doctor, and a junior in the database.
   *
   * @param int $guardianId The ID of the guardian
   * @param int $doctorId The ID of the doctor
   * @param int $juniorId The ID of the junior
   */
  public static function updateJuniorAssociation($guardianId, $doctorId, $juniorId)
  {
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJuniorAssociations);
    $stmt->execute([$guardianId, $doctorId, $juniorId]);
    $conn = null;

  }



  /**
   * Check if a junior user exists in the database based on the provided parameters.
   *
   * @param string $firstName The first name of the junior user
   * @param string $lastName The last name of the junior user
   * @param string $sqlDate The SQL date of birth of the junior user
   * @param string $sru The SRU of the junior user
   * @param string $contactNo The contact number of the junior user
   * @param string $mobileNo The mobile number of the junior user
   * @return string $existingUser The existing user if found, or null if not found
   */
  public static function juniorExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo)
  {

    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$juniorExists);
    $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();

    return $existingUser;
  }


  /**
   * Create a new junior record in the database with the provided information.
   *
   * @param int $addressId: ID number of specific address
   * @param string  $firstName:  First name of junior player
   * @param string  $lastName:  Last name of junior player
   * @param \DateTime $dob:  Date of birth of junior player
   * @param int  $sru: SRU of junior player
   * @param int  $contactNo:   Contact number of junior player
   * @param int  $mobileNo:  Mobile number of junior player
   * @param string  $email:  Email address of junior player
   * @param string  $healthIssues:  Health issues of junior player
   * @param string  $filename:  Filename of profile picture of junior player
   * @return int The ID of the newly created junior record
   */
  public static function createNewJunior($addressId, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename)
  {

    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$createNewJunior);
    $stmt->execute([$addressId, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename]);
    $juniorResult = $stmt->fetch(PDO::FETCH_COLUMN);
    $juniorId = $conn->lastInsertId();

    return $juniorId;

  }

  /**
   * Creates an association between a junior, guardian, and doctor in the database.
   *
   * @param int $juniorId The ID of the junior
   * @param int $guardianId The ID of the guardian
   * @param int $doctorId The ID of the doctor
   */
  public static function createAssociation($juniorId, $guardianId, $doctorId)
  {

    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$createAssociation);
    $stmt->execute([$juniorId, $guardianId, $doctorId]);

  }

  public static function createJuniorSkills($juniorId, $skillId, $squadId, $skillLevel, $comment)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$createJuniorSkills);
    $stmt->execute([$juniorId, $skillId, $squadId, $skillLevel, $comment]);

  }


}
