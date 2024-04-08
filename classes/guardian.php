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
     *  
     *  Check if guardian with specific details exists and output single record.
     * 
     * 
     *  @param firstName - String containing first name of the guardian.
     *  @param lastName - String containing last name of the guardian.
     *  @param contactNo - String containing guardian's contact number.
     *         
     * 
     *  @return guardian - Single record result.
     */
        public static function guardianExists($firstName, $lastName, $contactNo){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$guardianExists);
            $stmt->execute([$firstName, $lastName, $contactNo]);
            $guardian = $stmt->fetch();

            return $guardian;

        }

    /**
     *  
     *  
     *  Create new guardian in database.
     * 
     *  @param addressId - String containing address ID number
     *  @param firstName - String containing first name of the guardian.
     *  @param lastName - String containing last name of the guardian.
     *  @param contactNo - String containing guardian's contact number.
     *  @param relationshipStores - String containing guardian's relationship.
     *         
     * 
     *  @return guardianId - ID of just created record.
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
     *  Get all guardians for specific junior.
     * 
     *  @note The name of the function isn't quite right, I think it's meant to be called get Guardians.
     *  I won't change it now, but I'll do that in future updates.
     *  
     *         
     * 
     * 
     *  @param juniorId - String containing ID number of junior.

     *         
     * 
     *  @return id - Array with all records that match the parameter | Needs renaming.
     */

        public static function getGuardian($juniorId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardian);
            $stmt->execute([$juniorId]);
            $id = $stmt->fetchAll();

            return $id;
            
        }

    /**
     *  
     * Get all guardians from database, and output all records.
     *        
     *  @return guardians - All records from the Guardians table.
     */

        public static function getAllGuardians(){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getAllGuardians);
            $stmt->execute();
            $guardians = $stmt->fetchAll();

            return $guardians;
            
        }

    /**
     *  
     * Get address details of specific guardian.
     *        
     *  @param guardianId - String containing guardian ID Number
     * 
     *  @return address - Single record result.
     */

        public static function getGuardianAddress($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardianAddress);
            $stmt->execute([$guardianId]);
            $address = $stmt->fetch();

            return $address;
            
        }

     /**
     *  
     * Get specific guardian by their ID number and output single record.
     *        
     *  @param guardianId - String containing guardian ID Number
     * 
     *  @return guardian - Single record from Guardians table.
     */

        public static function getGuardianById($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$getGuardianById);
            $stmt->execute([$guardianId]);
            $guardian = $stmt->fetch();

            return $guardian;
            
        }

    /**
     *  
     * Delete specific guardian from database.
     *        
     *  @param guardianId - String containing guardian ID Number
     *      
     */

        public static function deleteGuardian($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$deleteGuardian);
            $stmt->execute([$guardianId]);
            
        }


    }
