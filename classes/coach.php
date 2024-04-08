<?php

/**
 * 
 * @brief This class is responsible for actions related to coach information.
 * 
 * These include:
 *  - Retrieving records from database (Multiple & Single).
 *  - Deleting records from database.
 * 
 * Future Additions:
 *  @todo - Update record function.
 *  @todo - Create coach function.
 */

class Coach {


    /**
     *  
     *  Get specific Coach from database
     *  
     * @param coachId - String containing ID number of specific coach.
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
     *  Get all Coaches from database
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
     *  Delete specific coach from database
     *  
     * @param coachId - String containing ID number of specific coach.
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
     *  Update existing database record for specific coach
     *  
     * @param firstName - String containing coach's first name.
     * @param lastName - String containing coach's last name.
     * @param dob - String containing coach's date of birth.
     * @param contactNo - String containing coach's contact number.
     * @param mobileNo - String containing coach's mobile number.
     * @param email - String containing coach's email address.
     * @param filename - String containing coach's profile picture filename.
     * @param coachId - String containing ID number of specific coach.
     *  
     */

    public static function updateCoach($firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$updateCoach); 
        $stmt->execute([$firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId]); 
    }
}

