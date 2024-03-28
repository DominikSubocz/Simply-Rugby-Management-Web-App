<?php

// If one of these file has already been included, do not do so again
require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

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
   * Get a player with a specific ID from the database.
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

  public static function getGuardians($playerId)
  {
    $conn = Connection::connect();

    $stmt = $conn->prepare(SQL::$getJuniorGuardians);
    $stmt->execute([$playerId]);
    $juniors = $stmt->fetchAll();

    $conn = null;

    return $juniors;
  }

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

  public static function updateJunior($address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId){
    $conn = Connection::connect();
    $stmt = $conn->prepare(SQL::$updateJunior);
    $stmt->execute([$address_id, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId]);
    $conn = null;
  }

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
