<?php

class Coach {

    public static function getCoach($coachId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getCoachById);
        $stmt->execute([$coachId]);

        $coach = $stmt->fetch();

        return $coach;
    }
}
