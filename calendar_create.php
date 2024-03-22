<?php
require_once 'classes/connection.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$conn = Connection::connect();

$insert = "INSERT INTO games (name, squad_id, opposition_team, start, end, location, kickoff_time, result, score ) VALUES (:name, :squad, :opposition, :start, :end, :location, :kickoff, :result, :score)";

$stmt = $conn->prepare($insert);

$stmt->bindParam(':name', $params->text);
$stmt->bindParam(':squad', $params->squad);
$stmt->bindParam(':opposition', $params->opposition);
$stmt->bindParam(':start', $params->start);
$stmt->bindParam(':end', $params->end);
$stmt->bindParam(':location', $params->location);
$stmt->bindParam(':kickoff', $params->kickoff);
$stmt->bindParam(':result', $params->result);
$stmt->bindParam(':score', $params->score);


$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->id = $conn->lastInsertId();
$response->message = 'Created with id: '.$conn->lastInsertId();

header('Content-Type: application/json');
echo json_encode($response);
