<?php

// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

class player
{
  /**
   * Get all players from the database.
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

  public static function getPlayerSkills($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getPlayerSkills);
    $stmt->execute([$playerId]);
    $players = $stmt->fetchAll();

    $conn = null;

    return $players;
  }

  public static function upatePlayerSkills($skillLevel, $comment, $skillId, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updatePlayerSkill);
    $stmt->execute([$skillLevel, $comment, $skillId, $playerId]);

    $conn = null;

  }

  public static function test($playerId){

    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$selectPlayer);
    $stmt->execute([$playerId]);
    $player = $stmt->fetchAll();

    return $player;

    $conn = null;

      
  }

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

  public static function updatePlayer($address_id, $doctor_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $playerId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updatePlayer);
    $stmt->execute([$address_id, $doctor_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $playerId]);

    $conn = null;



  }

  public static function playerExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo){
    
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$playerExists);
    $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
    $existingUser = $stmt->fetch();

    return $existingUser;

  }


}
