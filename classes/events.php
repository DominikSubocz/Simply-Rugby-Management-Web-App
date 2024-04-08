<?php

/**
 * 
 * @brief This class is responsible for actions related to event information.
 * 
 *        These include:
 *              - Retrieving records from database (Multiple & Single).
 *              - Updating records in the Games & Session tables.
 *              - Deleting records from database.
 * 
 *        Future Additions:
 *        @todo - Move $stmt code from the add-event.php page here.
 */

class Events {

    /**
     *  
     *  
     *  @brief This function retrieves all records from UNION SQL command.
     *         
     * 
     *  @return events - All records from the UNION SQL command, which unions the Games & Sessions table.
     */

    public static function getAllEvents()
    {
      $conn = Connection::connect();
  
      // Prepare and execute the query and get the results
      $stmt = $conn->prepare(SQL::$getEvents);
      $stmt->execute();
      $events = $stmt->fetchAll();
  
      // Null the connection object when we no longer need it
      $conn = null;
  
      return $events;
    }

    /**
     *  
     *  
     *  @brief This function retrieves single record from the games table.
     * 
     *  @param gameId - Stores information about Game ID number.
     *         
     * 
     *  @return game - Single game record.
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
     *  
     *  
     *  @brief This function gets all records from Game Halves tables that match the passed parameter.
     * 
     *  @param gameId - Stores information about Game ID number.
     * 
     *  @return gameHalves - All records that match the parameter.
     *         
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
     *  
     *  
     *  @brief This function removes single record from the Games & Game Halves tables.
     * 
     *  @param gameId - Stores information about Game ID number.
     *         
     */

    public static function deleteGame($gameId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$deleteGameHalves);
      $stmt->execute([$gameId]);

      $stmt = $conn->prepare(SQL::$deleteGame);
      $stmt->execute([$gameId]);


    }

    /**
     *  
     *  
     *  @brief This function updates records for Game Halves table.
     *         It takes in multiple parameters and passes them onto UPDATE SQL command.
     *  
     *  @param gameHalfId - Stores information about which Game Half to update (1 or 2)
     *  @param home_team - Stores information about name of the home team.
     *  @param homeScore - Stores information about score for the home team.
     *  @param homeComment - Stores information about comments from the home team.
     *  @param opposition - Stores information about name of the opposition team.
     *  @param oppositionScore - Stores information about score for the opposition team.
     *  @param oppositionComment - Stores information about comments from the opposition team.
     * 
     */
    
    public static function updateGameHalf($gameHalfId, $home_team, $homeScore, $homeComment, $opposition, $oppositionScore, $oppositionComment){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateGameHalf);
      $stmt->execute([$home_team, $homeScore, $homeComment, $opposition, $oppositionScore, $oppositionComment, $gameHalfId]);

      
      $conn = null;

    }

    /**
     *  
     *  
     *  @brief This function updates records for Games table.
     *         It takes in multiple parameters and passes them onto UPDATE SQL command.
     *  
     *  @param squad - Stores information about squad ID.
     *  @param name - Stores information about name of the game.
     *  @param opposition - Stores information about name of the opposition team.
     *  @param start - Stores information about start date of the game.
     *  @param end - Stores information about end date of the game.
     *  @param location - Stores information about location of the game.
     *  @param kickoff - Stores information about kickoff time of the game.
     *  @param result - Stores information about final result of the game.
     *  @param score - Stores information about final score of the game.
     *  @param gameId - Stores information about Game ID, which will be used to determine which game to update.
     * 
     */
    public static function updateGame($squad, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId) {
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateGame);
      $stmt->execute([$squad, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId]);

      $conn = null;

    }
    
    /**
     *  
     *  
     *  @brief This function retrieves single record from the sessions table.
     * 
     *  @param sessionId - Stores information about Session ID number.
     *         
     * 
     *  @return session - All records from the Sessions table.
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
     *  
     *  
     *  @brief This function gets all records from Training Details tables that match the passed parameter.
     * 
     *  @param sessionId - Stores information about Session ID number.
     * 
     *  @return trainingDetails - All records that match the parameter.
     *         
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
     *  
     *  
     *  @brief This function removes single record from the Sessions & Training Details tables.
     * 
     *  @param sessionId - Stores information about Session ID number.
     *         
     */

    public static function deleteSession($sessionId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$deleteTrainingDetails);
      $stmt->execute([$sessionId]);

      $stmt = $conn->prepare(SQL::$deleteSession);
      $stmt->execute([$sessionId]);


    }

    /**
     *  
     *  
     *  @brief This function updates records for Sessions & Training Details tables.
     *         It takes in multiple parameters and passes them onto UPDATE SQL command.
     *  
     *  @param coach - Stores information about Coach ID number
     *  @param squad - Stores information about Squad ID number
     *  @param name - Stores information about name of training session
     *  @param start - Stores information about start date of training session
     *  @param end - Stores information about end date of training session
     *  @param location - Stores information about location of training session
     *  @param skills - Stores information about skills practiced
     *  @param activities - Stores information about activities practiced
     *  @param playersPresent - Stores information about all present players
     *  @param accidents - Stores information about accidents
     *  @param injuries - Stores information about injuries
     *  @param sessionId - Stores information about Session ID number, which will be used to determine which session to update.
     *  @param trainingDetailId - Stores information Training Detail ID number, which will be used to determine which session to update.
     */

    public static function updateSession($coach, $squad, $name, $start, $end, $location, $skills, $activities, $playersPresent, $accidents, $injuries, $sessionId, $trainingDetailId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateSession);
      $stmt->execute([$coach, $squad, $name, $start, $end, $location, $sessionId]);

      $stmt = $conn->prepare(SQL::$updateTrainingDetails);
      $stmt->execute([$coach, $squad, $skills, $activities, $playersPresent, $accidents, $injuries, $trainingDetailId]);

    }
  }