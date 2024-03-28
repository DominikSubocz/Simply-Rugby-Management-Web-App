<?php

class Events {
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

    public static function getGame($gameId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getSingleGame);
      $stmt->execute([$gameId]);
      $game = $stmt->fetch();

      $conn = null;

      return $game;

    }

    public static function getGameHalves($gameId){

      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getGameHalves);
      $stmt->execute([$gameId]);
      $gameHalves = $stmt->fetchAll();

      $conn = null;

      return $gameHalves;
    }

    public static function deleteGame($gameId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$deleteGameHalves);
      $stmt->execute([$gameId]);

      $stmt = $conn->prepare(SQL::$deleteGame);
      $stmt->execute([$gameId]);


    }
    
    public static function updateGameHalf($gameHalfId, $home_team, $homeScore, $homeComment, $opposition, $oppositionScore, $oppositionComment){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateGameHalf);
      $stmt->execute([$home_team, $homeScore, $homeComment, $opposition, $oppositionScore, $oppositionComment, $gameHalfId]);

      
      $conn = null;

    }

    public static function updateGame($squad, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId) {
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateGame);
      $stmt->execute([$squad, $name, $opposition, $start, $end, $location, $kickoff, $result, $score, $gameId]);

      $conn = null;

    }

    public static function getSession($sessionId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getSessionId);
      $stmt->execute([$sessionId]);
      $session = $stmt->fetch();

      $conn = null;

      return $session;
    }

    public static function getTrainingDetails($sessionId){


      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$getTrainingDetails);
      $stmt->execute([$sessionId]);
      $trainingDetails = $stmt->fetchAll();

      $conn = null;

      return $trainingDetails;


    }

    public static function deleteSession($sessionId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$deleteTrainingDetails);
      $stmt->execute([$sessionId]);

      $stmt = $conn->prepare(SQL::$deleteSession);
      $stmt->execute([$sessionId]);


    }

    public static function updateSession($coach, $squad, $name, $start, $end, $location, $skills, $activities, $playersPresent, $accidents, $injuries, $sessionId, $trainingDetailId){
      $conn = Connection::connect();

      $stmt = $conn->prepare(SQL::$updateSession);
      $stmt->execute([$coach, $squad, $name, $start, $end, $location, $sessionId]);

      $stmt = $conn->prepare(SQL::$updateTrainingDetails);
      $stmt->execute([$coach, $squad, $skills, $activities, $playersPresent, $accidents, $injuries, $trainingDetailId]);

    }
  }