<?php

// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

class player
{
  /**
   * Get all players from the database.
   * 
   * @return players - Array with all player records
   */
  public static function getallPlayers()
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getallPlayers);
    $stmt->execute();
    $players = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $players;
  }

  /**
   * Get a player with a specific ID from the database.
   * 
   * @return player - Single player record
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
   * 
   * Get all player positions for specific player
   * 
   * @param playerId - String containing ID number of a player
   * 
   * @return players - Array of player positions
   * 
   */

  public static function getPlayerPositions($playerId)
  {
    $conn = Connection::connect();

    // Prepare and execute the query and get the results
    $stmt = $conn->prepare(SQL::$getPlayerPositions);
    $stmt->execute([$playerId]);
    $players = $stmt->fetchAll();

    // Null the connection object when we no longer need it
    $conn = null;

    return $players;
  }

  /**
   * 
   * Get all player skills for specific player
   * 
   * @param playerId - String containing ID number of a player
   * 
   * @return players - Array of player positions
   * 
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
   * 
   * Update all skills for specific player
   * 
   * @param skillLevel - A rating for specific skill (1-5)
   * @param comment - Coach's comment for a specific skill
   * @param skillId - ID number of specific skill
   * @param playerId - String containing ID number of a player
   * 
   */

  public static function upatePlayerSkills($skillLevel, $comment, $skillId, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updatePlayerSkill);
    $stmt->execute([$skillLevel, $comment, $skillId, $playerId]);

    $conn = null;

  }

  /// I don't think this is used anywhere, but I'll comment it out just in case it is.

  // public static function test($playerId){

  //   $conn = Connection::connect();
  //   $stmt = $conn->prepare(SQL::$selectPlayer);
  //   $stmt->execute([$playerId]);
  //   $player = $stmt->fetchAll();

  //   return $player;

  //   $conn = null;

      
  // }

  /**
   * 
   * Delete all details associated with specific player
   * 
   * @param playerId - String containing ID number of a player

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
   * 
   * Update existing player in database.
   * 
   * @param address_id - ID number of address
   * @param doctor_id - ID number of doctor 
   * @param firstName - String containing player's first name
   * @param lastName - String containing player's last name
   * @param dob - String containing player's date of birth
   * @param sru - String containing player's SRU number
   * @param contactNo  - String containing player's contact number
   * @param mobileNo - String containing player's mobile number
   * @param email - String containing player's email address
   * @param kin - String containing full name of next of kin
   * @param kinContact  - String containing next of kin contact number information
   * @param healthIssues  - String containing information regarding player's health issues
   * @param filename - String containing filename of player's profile picture
   * @param playerId - String containing ID number of a player
   */

  public static function updatePlayer($address_id, $doctor_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updatePlayer);
    $stmt->execute([$address_id, $doctor_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $playerId]);

    $conn = null;



  }

  /**
   * 
   * Check if player with specific details exists in database and output single record.
   * 
   * @param firstName - String containing player's first name
   * @param lastName - String containing player's last name
   * @param sqlDate - String containing player's date of birth (converted to sql format)
   * @param sru - String containing player's SRU number
   * @param contactNo  - String containing player's contact number
   * @param mobileNo - String containing player's mobile number
   * 
   * @return existingUser - Single player record
   */

  public static function playerExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo){
    
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$playerExists);
    $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();

    return $existingUser;

  }


}
