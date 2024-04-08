<?php

/**
 * 
 * @brief This class is responsible for actions related to Guardian information.
 * 
 *        These include:
 *              - Retrieving records from database (Multiple & Single).
 *              - Deleting records from database.
 * 
 *        Future Additions:
 *        @todo - Move $stmt code from the add-event.php page here.
 *        @todo - Update record function.
 * 
 */

class Guardian
    {

    /**
     *  @fn public static function guardianExists($firstName, $lastName, $contactNo)
     *  
     *  @brief This function checks if a record that matches with the passed parameters exists in the Guardians table.
     *         It passes these 3 parameters to SELECT SQL command, and returns results.
     * 
     * 
     *  @param firstName - Stores information about first name of the guardian.
     *  @param lastName - Stores information about last name of the guardian.
     *  @param contactNo - Stores information about guardian's contact number.
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
     *  @fn public static function createGuardian($addressId, $firstName, $lastName, $contactNo, $relationship)
     *  
     *  @brief This function inserts a single record into the Guardians table.
     * 
     * 
     *  @param addressId - Stores information about address ID number
     *  @param firstName - Stores information about first name of the guardian.
     *  @param lastName - Stores information about last name of the guardian.
     *  @param contactNo - Stores information about guardian's contact number.
     *  @param relationshipStores - Stores information about guardian's relationship.
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
     *  @fn public static function getGuardian($juniorId)
     * 
     *  @note The name of the function isn't quite right, I think it's meant to be called get Guardians.
     *        I won't change it now, but I'll do that in future updates.
     *  
     *  @brief This function returns all records for guardians associated with specific Junior.
     *         It takes a parameter and passes it onto SELECT SQL command and returns array of records.
     *         
     * 
     * 
     *  @param juniorId - Stores information about ID number of junior.

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
     *  @fn public static function getAllGuardians()
     * 
     *  @brief This function returns all records from the Guardians table.
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
     *  @fn public static function getGuardianAddress($guardianId)
     * 
     *  @brief This function returns single record of address details that match the parameter.
     *         It passes the parameter onto SQL SELECT command and returns single result.
     *        
     *  @param guardianId - Stores information about guardian ID Number
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
     *  @fn public static function getGuardianById($guardianId)
     * 
     *  @brief This function retrieves single record from Guardians table based on the parameter.
     *        
     *  @param guardianId - Stores information about guardian ID Number
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
     *  @fn public static function deleteGuardian($guardianId)
     * 
     *  @brief This function removes single record from Guardians table based on the parameter.
     *        
     *  @param guardianId - Stores information about guardian ID Number
     *      
     */

        public static function deleteGuardian($guardianId){

            $conn = Connection::connect();

            $stmt = $conn->prepare(SQL::$deleteGuardian);
            $stmt->execute([$guardianId]);
            
        }


    }
