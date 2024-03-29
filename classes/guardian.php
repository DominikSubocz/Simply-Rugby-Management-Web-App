<?php

class Guardian
    {
        public static function guardianExists($firstName, $lastName, $contactNo){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$guardianExists);
            $stmt->execute([$firstName, $lastName, $contactNo]);
            $guardian = $stmt->fetch();

            return $guardian;

        }

        public static function createGuardian($addressId, $firstName, $lastName, $contactNo, $relationship){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$createNewGuardian);
            $stmt->execute([$addressId, $firstName, $lastName, $contactNo, $relationship]);
            $guardianIdResult = $stmt->fetch(PDO::FETCH_COLUMN);
            $guardianId = $conn->lastInsertId();

            return $guardianId;


        }

        public static function getGuardian($juniorId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardian);
            $stmt->execute([$juniorId]);
            $id = $stmt->fetchAll();

            return $id;
            
        }

        public static function getGuardianAddress($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardianAddress);
            $stmt->execute([$guardianId]);
            $address = $stmt->fetch();

            return $address;
            
        }


    }
