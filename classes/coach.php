<?php

/**
 * 
 * @brief This class is responsible for actions related to coach information.
 * 
 *        These include:
 *              - Retrieving records from database (Multiple & Single).
 *              - Deleting records from database.
 * 
 *        Future Additions:
 *        @todo - Update record function.
 *        @todo - Create coach function.
 */

class Coach {


    /**
     *  @fn public static function getCoach($coachId)
     *  
     *  @brief This function retrieves single record from the coaches table based on the coach_id.
     *  
     *  @param coachId - Stores information about coach_id.
     *  
     *  @return coach - Single coach record.
     */

    public static function getCoach($coachId){
        $conn = Connection::connect();  ///< Connect to database


        $stmt = $conn->prepare(SQL::$getCoachById); ///< SQL Command
        $stmt->execute([$coachId]); ///< Pass parameters and execute SQL command.

        $coach = $stmt->fetch(); ///< Get single record

        return $coach; ///< Return record.
    }


    /**
     *  @fn public static function getCoach($coachId)
     *  
     *  @brief This function retrieves all records from the coaches table.
     *  
     *  
     *  @return coaches - All coach records.
     */
    public static function getAllCoaches(){
        $conn = Connection::connect();  ///< Connect to database


        $stmt = $conn->prepare(SQL::$getAllCoaches); ///< SQL Command
        $stmt->execute();

        $coaches = $stmt->fetchAll(); ///< Get multiple records.

        return $coaches; ///< Return records.
    }

    /**
     *  @fn public static function deleteCoach($coachId)
     *  
     *  @brief This function removes single record from coaches table.
     *  
     *  
     */
    public static function deleteCoach($coachId){
        $conn = Connection::connect();  ///< Connect to database


        $stmt = $conn->prepare(SQL::$deleteCoach); ///< SQL Command
        $stmt->execute([$coachId]); ///< Pass parameters and execute SQL command.

    }

     /**
     *  @fn public static function updateCoach($firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId)
     *  
     *  @brief This function updates single record in the coaches table.
     *         It takes couple of parameters which are then passed onto SQL update command.
     *  
     *  
     *  @return firstName - Stores information about coach's first name.
     * @return lastName -Stores information about coach's last name.
     * @return dob - Stores information about coach's date of birth.
     * @return contactNo - Stores information about coach's contact number.
     * @return mobileNo - Stores information about coach's mobile number.
     * @return email - Stores information about coach's email address.
     * @return filename - Stores information about coach's profile picture.
     * @return coachId - Stores information about coach's ID number, it is used to update the right record.
     * 
     */

    public static function updateCoach($firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId){
        $conn = Connection::connect();  ///< Connect to database


        $stmt = $conn->prepare(SQL::$updateCoach); ///< SQL Command
        $stmt->execute([$firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId]); ///< Pass parameters and execute SQL command.
    }
}

