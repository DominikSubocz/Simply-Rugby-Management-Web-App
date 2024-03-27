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

}