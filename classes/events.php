<?php

/**
 * 
 * @brief This class is responsible for actions related to event information.
 * 
 * These include:
 *  - Retrieving records from database (Multiple & Single).
 *  - Updating records in the Games & Session tables.
 *  - Deleting records from database.
 * 
 * @todo 
 *  - Move $stmt code from the add-event.php page here.
 */

class Events {


    /**
     * Retrieves all events from the database.
     *
     * @return array $events An array containing all events
     */
    public static function getAllEvents()
    {
      $conn = Connection::connect();
  
      /// Prepare and execute the query and get the results
      $stmt = $conn->prepare(SQL::$getEvents);
      $stmt->execute();
      $events = $stmt->fetchAll();
  
      /// Null the connection object when we no longer need it
      $conn = null;
  
      return $events;
    }



    /**
     * Retrieves a single game record from the database based on the provided game ID.
     *
     * @param int $gameId: The ID of the game to retrieve.
     * @return string $game: The game record as an associative array, or null if not found.
     */
    public static function getGame($gameId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getSingleGame);
      $stmt->execute([$gameId]);
      $game = $stmt->fetch();

      $conn = null;

      return $game;

    }



    /**
     * Retrieves the game halves for a given game ID from the database.
     *
     * @param int $gameId: The ID of the game for which to retrieve the halves.
     * @return array $gameHalves: An array containing the game halves
     */
    public static function getGameHalves($gameId){

      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getGameHalves);
      $stmt->execute([$gameId]);
      $gameHalves = $stmt->fetchAll();

      $conn = null;

      return $gameHalves;
    }



    /**
     * Delete a game and its associated halves from the database based on the provided game ID.
     *
     * @param int $gameId The ID of the game to be deleted.
     * @throws PDOException If there is an error with the database operation. - There is a try catch code in corresponding page.
     */
    public static function deleteGame($gameId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$deleteGameHalves);
      $stmt->execute([$gameId]);

      $stmt = $conn->prepare(SQL::$deleteGame);
      $stmt->execute([$gameId]);


    }


    
    /**
     * Update the details of a game half in the database.
     *
     * @param int $gameHalfId: The ID of the game half to update
     * @param string $home_team: The name of the home team
     * @param int $homeScore: The score of the home team
     * @param string $homeComment: A comment for the home team
     * @param string $opposition: The name of the opposing team
     * @param int $oppositionScore: The score of the opposing team
     * @param string $oppositionComment: A comment for the opposing team
     */
    public static function updateGameHalf($gameHalfId, $home_team, $homeScore, $homeComment, $opposition, $oppositionScore, $oppositionComment){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateGameHalf);
      $stmt->execute([$home_team, $homeScore, $homeComment, $opposition, $oppositionScore, $oppositionComment, $gameHalfId]);

      
      $conn = null;

    }

    /**
     * Update a game record in the database with the provided information.
     *
     * @param string $squad: Squad name
     * @param string $name: Name of the game
     * @param string $opposition: Opposition team name
     * @param string $start: Start date of the game 
     * @param string $end: End date of the game
     * @param string $location: Location of the game
     * @param string $kickoff: Kickoff time of the game
     * @param string $result: Result of the game
     * @param string $score: Final score of the game
     * @param int $gameId: ID of the game to be updated
     */
    public static function updateGame($squad, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId) {
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateGame);
      $stmt->execute([$squad, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId]);

      $conn = null;

    }
    


    /**
     * Retrieves a session from the database based on the provided session ID.
     *
     * @param int $sessionId The ID of the session to retrieve.
     * @return array $session The session data retrieved from the database.
     */
    public static function getSession($sessionId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getSessionId);
      $stmt->execute([$sessionId]);
      $session = $stmt->fetch();

      $conn = null;

      return $session;
    }



    /**
     * Retrieves training details for a specific session ID from the database.
     *
     * @param int $sessionId: The ID of the session
     * @return array $trainingDetails: An array containing the training details
     */
    public static function getTrainingDetails($sessionId){


      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getTrainingDetails);
      $stmt->execute([$sessionId]);
      $trainingDetails = $stmt->fetchAll();

      $conn = null;

      return $trainingDetails;


    }



    /**
     * Delete a session from the database based on the provided session ID.
     *
     * @param int $sessionId: The ID of the session to be deleted
     */
    public static function deleteSession($sessionId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$deleteTrainingDetails);
      $stmt->execute([$sessionId]);

      $stmt = $conn->prepare(SQL::$deleteSession);
      $stmt->execute([$sessionId]);


    }


    /**
     * Update session and training details in the database.
     *
     * @param int $coach: ID number of specific coach
     * @param int $squad: ID number of specific squad
     * @param string $name: Name of the training session
     * @param date $start: Start date of training session
     * @param date $end: End date of training session
     * @param string $location: Location of training session
     * @param string $skills: Skills practiced at training session
     * @param string $activities: Activities practiced at training session
     * @param string $playersPresent: Present players at training session
     * @param string $accidents: Accidents that happened at training session
     * @param string $injuries: Injuries that happened at training session
     * @param string $sessionId: ID number of specific training session.
     * @param int $trainingDetailId: ID number of specific training detail
     */
    public static function updateSession($coach, $squad, $name, $start, $end, $location, $skills, $activities, $playersPresent, $accidents, $injuries, $sessionId, $trainingDetailId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateSession);
      $stmt->execute([$coach, $squad, $name, $start, $end, $location, $sessionId]);

      $stmt = $conn->prepare(SQL::$updateTrainingDetails);
      $stmt->execute([$coach, $squad, $skills, $activities, $playersPresent, $accidents, $injuries, $trainingDetailId]);

    }
  }