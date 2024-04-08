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
     *  
     *  
     *  @brief This function retrieves single record from the coaches table based on the coach_id.
     *  
     *  @param coachId - Stores information about coach_id.
     *  
     *  @return coach - Single coach record.
     */

    public static function getCoach($coachId){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$getCoachById); 
        $stmt->execute([$coachId]); 

        $coach = $stmt->fetch(); 

        return $coach; 
    }


    /**
     *  
     *  
     *  @brief This function retrieves all records from the coaches table.
     *  
     *  
     *  @return coaches - All coach records.
     */
    public static function getAllCoaches(){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$getAllCoaches); 
        $stmt->execute();

        $coaches = $stmt->fetchAll(); 

        return $coaches; 
    }

    /**
     *  
     *  
     *  @brief This function removes single record from coaches table.
     *  
     *  
     */
    public static function deleteCoach($coachId){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$deleteCoach); 
        $stmt->execute([$coachId]); 

    }

     /**
     *  
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
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$updateCoach); 
        $stmt->execute([$firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId]); 
    }
}

