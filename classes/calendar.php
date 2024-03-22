<?php

require("classes/connection.php");
require("classes/sql.php");

class Result {}


class Calendar {
    public static function createEvent($squad_id, $name, $opposition_team, $start, $end, $locataion, $kickoff_time, $result, $score){
        $json = file_get_contents('php://input');
        $params = json_decode($json);

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$createEvent);

        $stmt->execute([$squad_id, $name, $opposition_team, $start, $end, $locataion, $kickoff_time, $result, $score]);

        $response = new Result();
        $response->result = 'OK';
        $response->id = $db->lastInsertId();
        $response->message = 'Created with id: '.$db->lastInsertId();
    
        header('Content-Type: application/json');
        echo json_encode($response);
    }




}