<?php
require_once 'classes/connection.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$conn = Connection::connect();

$insert = "DELETE FROM games WHERE game_id = :id";

$stmt = $conn->prepare($insert);

$stmt->bindParam(':id', $params->id);

$stmt->execute();

class Result {}

$response = new Result();
$response->result = 'OK';
$response->message = 'Update successful';

header('Content-Type: application/json');
echo json_encode($response);


