<?php

class Coach {

    public static function getCoach($coachId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getCoachById);
        $stmt->execute([$coachId]);

        $coach = $stmt->fetch();

        return $coach;
    }

    public static function getAllCoaches(){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getAllCoaches);
        $stmt->execute();

        $coaches = $stmt->fetchAll();

        return $coaches;
    }

    public static function deleteCoach($coachId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$deleteCoach);
        $stmt->execute([$coachId]);

    }

    public static function updateCoach($firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$updateCoach);
        $stmt->execute([$firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId]);
    }
}

