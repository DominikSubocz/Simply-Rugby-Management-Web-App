<?php


require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");


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
   * Get all junior records from the database.
   * 
   * @return juniors - Array of all junior player records
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
     *  Update skills of specific junior player. 
     * 
     *  @param skillLevel - String containing the Skill level for specific skill.
     *  @param comment - String containing any comments made by the coach - it can be empty.
     *  @param skillId - String containing Skill ID number, used to determine which skill to update.
     *  @param playerId - String containing ID number of the player, used to dermine which skill to update for which player.
     * 
     */

  public static function updateJuniorSkills($skillLevel, $comment, $skillId, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJuniorSkills);
    $stmt->execute([$skillLevel, $comment, $skillId, $playerId]);

    $conn = null;

  }

    /**
     *  Get skills of specific junior player
     * 
     *  @param playerId - String containing the Skill level for specific skill.
     * 
     *  @return juniors - Returns all records from the Junior Skills table that match the parameter.
     * 
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
     *  Get positions of specific junior player
     * 
     * 
     *  @param playerId - String containing the Skill level for specific skill.
     * 
     *  @return juniors - Returns all records from the Junior Positions table that match the parameter.
     * 
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
     * 
     *  Get record for specific Junior.
     * 
     *  @param playerId - String containing the Skill level for specific skill.
     * 
     *  @return junior - Single record with information about specific player.
     * 
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
     * 
     *  Get guardian information for specific Junior.
     * 
     *  @param playerId - String containing the Skill level for specific skill.
     * 
     *  @return juniors - All records that match the parameter.
     * 
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
     * 
     * Delete details about specific Junior from multiple tables.
     * 
     *  @param playerId - String containing the Skill level for specific skill.
     * 
     */

  public static function deleteJunior($playerId){
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
     * 
     * Update existing record for specific Junior
     * 
     *  @param address_id - String containing address ID number of specific address
     *  @param firstName - String containing junior's first name.
     *  @param lastName  - String containing junior's first name.
     *  @param dob - String containing date of birth.
     *  @param sru - String containing junior's SRU number.
     *  @param contactNo - String containing junior's contact number.
     *  @param mobileNo  - String containing junior's mobile number.
     *  @param email - String containing junior's email address.
     *  @param healthIssues - String containing junior's health issues
     *  @param filename - String containing junior's profile picture file name.
     *  @param juniorId - String containing junior's ID number, which will be used to update the right record.
     * 
     * 
     */

  public static function updateJunior($address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJunior);
    $stmt->execute([$address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId]);
    $conn = null;
  }

    /**
     * 
     * Update association information for specific junior (Guardians, Doctors)
     * 
     * 
     *  @param address_id - String containing address ID number of specific address
     *  @param firstName - String containing junior's first name.
     *  @param lastName  - String containing junior's first name.
     *  @param dob - String containing date of birth.
     *  @param sru - String containing junior's SRU number.
     *  @param contactNo - String containing junior's contact number.
     *  @param mobileNo  - String containing junior's mobile number.
     *  @param email - String containing junior's email address.
     *  @param healthIssues - String containing junior's health issues
     *  @param filename - String containing junior's profile picture file name.
     *  @param juniorId - String containing junior's ID number, which will be used to update the right record.
     * 
     * 
     */

  public static function updateJuniorAssociation($guardianId, $doctorId, $juniorId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJuniorAssociations);
    $stmt->execute([$guardianId, $doctorId, $juniorId]);
    $conn = null;

  }

  /**
   * 
   * Check if specific Junior exists and output single record.
   * 
   * @param firstName - String containing junior's first name.
   * @param lastName  - String containing junior's first name.
   * @param sqlDate  - String containing date of birth. (Converted to SQL date format.)
   * @param sru - String containing junior's SRU number.
   * @param contactNo - String containing junior's contact number.
   * @param mobileNo  - String containing junior's mobile number.
   */

  public static function juniorExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo){

    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$juniorExists);
    $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();

    return $existingUser;
  }

  /**
   * 
   * Create new Junior record in the database.
   * 
   * @param firstName - String containing junior's first name.
   * @param lastName  - String containing junior's first name.
   * @param sqlDate  - String containing date of birth. (Converted to SQL date format.)
   * @param sru - String containing junior's SRU number.
   * @param contactNo - String containing junior's contact number.
   * @param mobileNo  - String containing junior's mobile number.
   * 
   * @param addressId - String containing ID number of specific address
   * @param email - String containing junior's junior's email address
   * @param healthIssues - String containing junior's health issues
   * @param filename - String containing filename of junior's profile picture.
   */

  public static function createNewJunior($addressId, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename){

    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$createNewJunior);
    $stmt->execute([$addressId, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename]);
    $juniorResult = $stmt->fetch(PDO::FETCH_COLUMN);
    $juniorId = $conn->lastInsertId();

    return $juniorId;

  }

  public static function createAssociation($juniorId, $guardianId, $doctorId){

    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$createAssociation);
    $stmt->execute([$juniorId, $guardianId, $doctorId]);

  }


}
