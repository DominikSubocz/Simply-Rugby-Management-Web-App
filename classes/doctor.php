<?php

class Doctor{

    public static function doctorExists($firstName, $lastName, $contactNo){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$doctorExists);
        $stmt->execute([$firstName, $lastName, $contactNo]);
        $doctor = $stmt->fetch();

        return $doctor;
    }

    public static function existingDoctorId($firstName, $lastName, $contactNo){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getExistingDoctorId);
        $stmt->execute([$firstName, $lastName, $contactNo]);
        $doctorId = $stmt->fetch(PDO::FETCH_COLUMN);

        return $doctorId;
    }

    public static function createNewDoctor($firstName, $lastName, $contactNo){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$createNewDoctor);
        $stmt->execute([$firstName, $lastName, $contactNo]);

        $id = $conn->lastinsertId();
        return $id;

    }

    public static function getAllDoctors(){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getAllDoctors);
        $stmt->execute();
        $doctors = $stmt->fetchAll();

        return $doctors;
    }

    public static function getDoctor($doctorId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getDoctor);
        $stmt->execute([$doctorId]);
        $doctor = $stmt->fetch();

        return $doctor;
    }

    public static function deleteDoctor($doctorId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$deleteDoctor);
        $stmt->execute([$doctorId]);

    }
}