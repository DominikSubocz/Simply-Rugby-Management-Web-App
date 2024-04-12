<?php

/**
 * 
 * @brief This class is responsible for actions related to Guardian information.
 * 
 * These include:
 *  - Retrieving records from database (Multiple & Single).
 *  - Deleting records from database.
 * 
 * Future Additions:
 *  @todo - Move $stmt code from the add-event.php page here.
 *  @todo - Update record function.
 * 
 */

class Guardian
    {


        /**
         * Check if a guardian with the given first name, last name, and contact number exists in the database.
         *
         * @param string $firstName The first name of the guardian
         * @param string $lastName The last name of the guardian
         * @param string $contactNo The contact number of the guardian
         * @return string $guardian The guardian if found, null otherwise
         */
        public static function guardianExists($firstName, $lastName, $contactNo){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$guardianExists);
            $stmt->execute([$firstName, $lastName, $contactNo]);
            $guardian = $stmt->fetch();

            return $guardian;

        }



        /**
         * Creates a new guardian with the provided information and returns the guardian ID.
         *
         * @param int $addressId The ID of the guardian's address
         * @param string $firstName The first name of the guardian
         * @param string $lastName The last name of the guardian
         * @param string $contactNo The contact number of the guardian
         * @param string $relationship The relationship of the guardian
         * @return int $guardianId The ID of the newly created guardian
         */
        public static function createGuardian($addressId, $firstName, $lastName, $contactNo, $relationship){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$createNewGuardian);
            $stmt->execute([$addressId, $firstName, $lastName, $contactNo, $relationship]);
            $guardianIdResult = $stmt->fetch(PDO::FETCH_COLUMN);
            $guardianId = $conn->lastInsertId();

            return $guardianId;


        }

   /**
    *     * 
    * Retrieves the guardian information for a given junior ID.
    *
    *  @note The name of the function isn't quite right, I think it's meant to be called get Guardians.
    *  I won't change it now, but I'll do that in future updates.
    * 
    * @param int $juniorId The ID of the junior
    * @return array $id An array containing the guardian information.
    */
        public static function getGuardian($juniorId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardian);
            $stmt->execute([$juniorId]);
            $id = $stmt->fetchAll();

            return $id;
            
        }



        /**
         * Retrieves all guardians from the database.
         *
         * @return array $guardians An array containing all guardians
         */
        public static function getAllGuardians(){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getAllGuardians);
            $stmt->execute();
            $guardians = $stmt->fetchAll();

            return $guardians;
            
        }



        /**
         * Retrieves the address of a guardian based on the provided guardian ID.
         *
         * @param int $guardianId The ID of the guardian 
         * @return string $address The address information of the guardian.
         */
        public static function getGuardianAddress($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardianAddress);
            $stmt->execute([$guardianId]);
            $address = $stmt->fetch();

            return $address;
            
        }



        /**
         * Retrieves a guardian from the database based on the provided guardian ID.
         *
         * @param int $guardianId The ID of the guardian
         * @return string $guardian The guardian information if found, or null if not found.
         */
        public static function getGuardianById($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardianById);
            $stmt->execute([$guardianId]);
            $guardian = $stmt->fetch();

            return $guardian;
            
        }


        /**
         * Deletes a guardian from the database based on the provided guardian ID.
         *
         * @param int $guardianId The ID of the guardian to be deleted.
         * @throws PDOException If there is an error with the database operation. - There is a try catch code in corresponding page.
         */
        public static function deleteGuardian($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$deleteGuardian);
            $stmt->execute([$guardianId]);
            
        }


    }
