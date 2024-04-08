<?php


require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");


/**
 * 
 * @brief This class is responsible for actions related to Junior Player information.
 * 
 *        These include:
 *              - Retrieving records from database (Multiple & Single).
 *              - Inserting new records to the database.
 *              - Updating existing records in the database.
 *              - Deleting records from database.
 * 
 * 
 */

class Junior
{
  /**
   * Get all players from the database.
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

    /**
     *  @fn public static function updateJuniorSkills($skillLevel, $comment, $skillId, $playerId)
     *  
     *  @brief This function updates existing record for Junior Skills table.
     * 
     * 
     *  @param skillLevel - Stores information about the Skill level for specific skill.
     *  @param comment - Stores information about any comments made by the coach - it can be empty.
     *  @param skillId - Stores information about Skill ID number, used to determine which skill to update.
     *  @param playerId - Stores information about ID number of the player, used to dermine which skill to update for which player.
     * 
     */

  public static function updateJuniorSkills($skillLevel, $comment, $skillId, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJuniorSkills);
    $stmt->execute([$skillLevel, $comment, $skillId, $playerId]);

    $conn = null;

  }

     /**
     *  @fn public static function getJuniorSkills($playerId)
     *  
     *  @brief This function gets all records from the Juniors Skills table based on parameter.
     * 
     * 
     * 
     *  @param playerId - Stores information about the Skill level for specific skill.
     * 
     *  @return juniors - Returns all records from the Junior Skills table that match the parameter.
     * 
     */

  public static function getJuniorSkills($playerId)
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getJuniorSkills);
    $stmt->execute([$playerId]);
    $juniors = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }

      /**
     *  @fn public static function getJuniorPositions($playerId)
     *  
     *  @brief This function gets all records from the Juniors Positions table based on parameter.
     * 
     * 
     * 
     *  @param playerId - Stores information about the Skill level for specific skill.
     * 
     *  @return juniors - Returns all records from the Junior Positions table that match the parameter.
     * 
     */

  public static function getJuniorPositions($playerId)
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getJuniorPositions);
    $stmt->execute([$playerId]);
    $juniors = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $juniors;
  }

      /**
     *  @fn public static function getJunior($playerId)
     *  
     *  @brief This function gets single record of specific player based on the parameter.
     * 
     * 
     * 
     *  @param playerId - Stores information about the Skill level for specific skill.
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
     *  @fn public static function getGuardians($playerId)
     *  
     *  @brief This function gets all records from the Junior Associations table based on the parameter
     * 
     * 
     *  @param playerId - Stores information about the Skill level for specific skill.
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
     *  @fn  public static function deleteJunior($playerId)
     *  
     *  @brief This function deletes single record from multiple tables, based on parameter.
     *         It deletes a record from Junior Associations table.
     *         It deletes a record from Junior Positions table.
     *         It deletes a record from Junior Junior Skills table.
     *         It deletes a record from Junior table.
     * 
     * 
     * 
     *  @param playerId - Stores information about the Skill level for specific skill.
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
     *  @fn   public static function updateJunior($address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId)
     *  
     *  @brief This function updates existing record in the Junior Database.
     * 
     * 
     *  @param address_id - Stores information about address ID number
     *  @param firstName - Stores information about first name.
     *  @param lastName  - Stores information about last name.
     *  @param dob - Stores information about date of birth.
     *  @param sru - Stores information about SRU number.
     *  @param contactNo - Stores information about contact number.
     *  @param mobileNo  - Stores information about mobile number.
     *  @param email - Stores information about email address.
     *  @param healthIssues - Stores information about health issues.
     *  @param filename - Stores information about profile picture file name.
     *  @param juniorId - Stores information about junior's ID number, which will be used to update the right record.
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
     *  @fn    public static function updateJuniorAssociation($guardianId, $doctorId, $juniorId)
     *  
     *  @brief This function updates existing record in the Junior Database.
     * 
     * 
     *  @param address_id - Stores information about address ID number
     *  @param firstName - Stores information about first name.
     *  @param lastName  - Stores information about last name.
     *  @param dob - Stores information about date of birth.
     *  @param sru - Stores information about SRU number.
     *  @param contactNo - Stores information about contact number.
     *  @param mobileNo  - Stores information about mobile number.
     *  @param email - Stores information about email address.
     *  @param healthIssues - Stores information about health issues.
     *  @param filename - Stores information about profile picture file name.
     *  @param juniorId - Stores information about junior's ID number, which will be used to update the right record.
     * 
     * 
     */

  public static function updateJuniorAssociation($guardianId, $doctorId, $juniorId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJuniorAssociations);
    $stmt->execute([$guardianId, $doctorId, $juniorId]);
    $conn = null;

  }

  public static function juniorExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo){

    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$juniorExists);
    $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();

    return $existingUser;
  }

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
