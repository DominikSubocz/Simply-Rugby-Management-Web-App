<?php
require_once 'classes/connection.php';

$json = file_get_contents('php://input');
$params = json_decode($json);

$conn = Connection::connect();

$start = $_GET["start"];
$end = $_GET["end"];

$stmt = $conn->prepare('SELECT * FROM games WHERE NOT ((end <= :start) OR (start >= :end))');

$stmt->bindParam(':start', $start);
$stmt->bindParam(':end', $end);

$stmt->execute();
$result = $stmt->fetchAll();

class Event {}
$events = array();

foreach($result as $row) {
  $e = new Event();
  $e->id = $row['game_id'];
  $e->text = $row['name'];
  $e->start = $row['start'];
  $e->end = $row['end'];
  $e->backColor = $row['color'];
  $events[] = $e;
}

header('Content-Type: application/json');
echo json_encode($events);
