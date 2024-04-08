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
 * Future Additions:
 *  @todo - Move $stmt code from the add-event.php page here.
 */

class Events {

    /**
     *  
     *  Get all events from database.
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
     *  Get specific game from database
     * 
     *  @param gameId - String containing Game ID number.
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
     *  Get all game halves for specific game
     * 
     *  @param gameId - String containing Game ID number.
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
     *  Delete specific game from database
     * 
     *  @param gameId - String containing Game ID number.
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
     *  Update existing game halves for specific game
     *  
     *  @param gameHalfId - String containing which Game Half to update (1 or 2)
     *  @param home_team - String containing name of the home team.
     *  @param homeScore - String containing score for the home team.
     *  @param homeComment - String containing comments from the home team.
     *  @param opposition - String containing name of the opposition team.
     *  @param oppositionScore - String containing score for the opposition team.
     *  @param oppositionComment - String containing comments from the opposition team.
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
     *  Update existing game in the database 
     *  
     *  @param squad - String containing squad ID.
     *  @param name - String containing name of the game.
     *  @param opposition - String containing name of the opposition team.
     *  @param start - String containing start date of the game.
     *  @param end - String containing end date of the game.
     *  @param location - String containing location of the game.
     *  @param kickoff - String containing kickoff time of the game.
     *  @param result - String containing final result of the game.
     *  @param score - String containing final score of the game.
     *  @param gameId - String containing Game ID, which will be used to determine which game to update.
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
     *  Get specific session
     * 
     *  @param sessionId - String containing ID number of specific training session.        
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
     *  Get all training details for specific training session
     * 
     *  @note If there is only one training details record for each training session why do we fetchAll?
     *  Perpahs I need to rework this in future update.
     * 
     *  @param sessionId - String containing ID number of specific training session. 
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
     *  Delete all details associated with specific Training Session
     * 
     *  @param sessionId - String containing ID number of specific training session.      
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
     *  Update existing training session in database
     *  
     *  @param coach - String containing coach's ID number.
     *  @param squad - String containing ID number of specific squad.
     *  @param name - String containing name of the event.
     *  @param start - String containing start date of a event.
     *  @param end- String containing end date of a event.
     *  @param location - String containing location of a event.
     *  @param skills - String containing skills practiced at the training session.
     *  @param activities - String containing activities practiced at the training session.
     *  @param playersPresent - String containing all present players.
     *  @param accidents - String containing information about the accidents.
     *  @param injuries - String containing information about injuries
     *  @param sessionId - String containing ID number of specific training session.
     *  @param trainingDetailId - String containing ID number of specific training detail.
     */

    public static function updateSession($coach, $squad, $name, $start, $end, $location, $skills, $activities, $playersPresent, $accidents, $injuries, $sessionId, $trainingDetailId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateSession);
      $stmt->execute([$coach, $squad, $name, $start, $end, $location, $sessionId]);

      $stmt = $conn->prepare(SQL::$updateTrainingDetails);
      $stmt->execute([$coach, $squad, $skills, $activities, $playersPresent, $accidents, $injuries, $trainingDetailId]);

    }
  }