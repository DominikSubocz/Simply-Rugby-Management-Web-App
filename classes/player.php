<?php

/// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");


/**
 * @brief This class is responsible for actions related to Player information.
 * 
 * These include:
 * - Retrieving records from database (Multiple & Single).
 * - Inserting new records to the database.
 * - Updating existing records in the database.
 * - Deleting records from database.
 * 
 */

class player
{

  
  /**
   * Retrieves all players from the database.
   * 
   * @return array $players An array containing all players retrieved from the database.
   */
  public static function getallPlayers()
  {
    $conn = Connection::connect();

    /// Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getallPlayers);
    $stmt->execute();
    $players = $stmt->fetchAll();

    /// Null the connection object when we no longer need it
    $conn = null;

    return $players;
  }


  /**
   * Retrieves a player from the database based on the provided player ID.
   *
   * @param int $playerId The ID of the player to retrieve.
   * @return string $player The player data if found, or null if not found.
   */
  public static function getplayer($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getplayer);
    $stmt->execute([$playerId]);
    $player = $stmt->fetch();

    $conn = null;

    return $player;
  }


  /**
   * Retrieves the positions of a player based on the player ID.
   *
   * @param int $playerId The ID of the player to retrieve positions for.
   * @return array $players An array containing the positions of the player.
   */
  public static function getPlayerPositions($playerId)
  {
    $conn = Connection::connect();

    /// Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getPlayerPositions);
    $stmt->execute([$playerId]);
    $players = $stmt->fetchAll();

    /// Null the connection object when we no longer need it
    $conn = null;

    return $players;
  }


  /**
   * Retrieve the skills of a player based on the player ID.
   *
   * @param int $playerId The ID of the player to retrieve skills for.
   * @return array $players An array containing the skills of the player.
   */
  public static function getPlayerSkills($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getPlayerSkills);
    $stmt->execute([$playerId]);
    $players = $stmt->fetchAll();

    $conn = null;

    return $players;
  }


  /**
   * Update the skills of a player in the database.
   *
   * @param int $skillLevel The new skill level of the player.
   * @param string $comment Any comment or note related to the skill update.
   * @param int $skillId The ID of the skill to update.
   * @param int $playerId The ID of the player whose skill is being updated.
   */
  public static function upatePlayerSkills($skillLevel, $comment, $skillId, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updatePlayerSkill);
    $stmt->execute([$skillLevel, $comment, $skillId, $playerId]);

    $conn = null;

  }

  /// I don't think this is used anywhere, but I'll comment it out just in case it is.

  /// public static function test($playerId){

  ///   $conn = Connection::connect();
  ///   $stmt = $conn->prepare(SQL::$selectPlayer);
  ///   $stmt->execute([$playerId]);
  ///   $player = $stmt->fetchAll();

  ///   return $player;

  ///   $conn = null;

      
  /// }


  /**
   * Delete a player from the database along with their associated skills and positions.
   *
   * @param int $playerId The ID of the player to be deleted.
   */
  public static function deletePlayer($playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$deletePlayerSkill);
    $stmt->execute([$playerId]);

    $stmt = $conn->prepare(SQL::$deletePlayerPosition);
    $stmt->execute([$playerId]);

    $stmt = $conn->prepare(SQL::$deletePlayer);
    $stmt->execute([$playerId]);

    $conn = null;

    
  }



  /**
   * Update player information in the database.
   *
   * @param int $address_id
   * @param int $doctor_id
   * @param string $firstName
   * @param string $lastName
   * @param string $dob
   * @param string $sru
   * @param string $contactNo
   * @param string $mobileNo
   * @param string $email
   * @param string $kin
   * @param string $kinContact
   * @param string $healthIssues
   * @param string $filename
   * @param int $playerId
   */
  public static function updatePlayer($address_id, $doctor_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updatePlayer);
    $stmt->execute([$address_id, $doctor_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $playerId]);

    $conn = null;



  }



  /**
   * Check if a player exists in the database based on the provided parameters.
   *
   * @param string $firstName The first name of the player
   * @param string $lastName The last name of the player
   * @param string $sqlDate The SQL date of birth of the player
   * @param string $sru The SRU number of the player
   * @param string $contactNo The contact number of the player
   * @param string $mobileNo The mobile number of the player
   * @return string $existingUser The existing user data if found, otherwise null
   */
  public static function playerExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo){
    
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$playerExists);
    $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();

    return $existingUser;

  }


}
