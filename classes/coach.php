<?php

/**
 * 
 * @brief This class is responsible for actions related to coach information.
 * 
 * These include:
 *  - Retrieving records from database (Multiple & Single).
 *  - Deleting records from database.
 * 
 */

class Coach {




    /**
     * Retrieves a coach from the database based on the provided coach ID.
     *
     * @param int $coachId The ID of the coach to retrieve.
     * @return string $coach The coach data if found, or null if not found.
     */
    public static function getCoach($coachId){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$getCoachById); 
        $stmt->execute([$coachId]); 

        $coach = $stmt->fetch(); 

        return $coach; 
    }



    /**
     * Retrieves all coaches from the database.
     *
     * @return array $coaches An array containing all the coach records
     */
    public static function getAllCoaches(){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$getAllCoaches); 
        $stmt->execute();

        $coaches = $stmt->fetchAll(); 

        return $coaches; 
    }


    /**
     * Delete a coach from the database based on the provided coach ID.
     *
     * @param int $coachId The ID of the coach to be deleted.
     * @throws PDOException If there is an error with the database operation. - There is a try catch code in corresponding page.
     */
    public static function deleteCoach($coachId){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$deleteCoach); 
        $stmt->execute([$coachId]); 

    }



    /**
     * Update coach information in the database.
     *
     * @param string $firstName The first name of the coach.
     * @param string $lastName The last name of the coach.
     * @param string $dob The date of birth of the coach.
     * @param string $contactNo The contact number of the coach.
     * @param string $mobileNo The mobile number of the coach.
     * @param string $email The email address of the coach.
     * @param string $filename The filename of the coach's image.
     * @param int $coachId The ID of the coach to update.
     */
    public static function updateCoach($firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId){
        $conn = Connection::connect();  


        $stmt = $conn->prepare(SQL::$updateCoach); 
        $stmt->execute([$firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId]); 
    }

   

     /**
      * Creates a new coach with the provided details and stores it in the database.
      *
      * @param string $firstName The first name of the coach.
      * @param string $lastName The last name of the coach.
      * @param string $dob The date of birth of the coach.
      * @param string $contactNo The contact number of the coach.
      * @param string $mobileNo The mobile number of the coach.
      * @param string $email The email address of the coach.
      * @param string $filename The filename associated with the coach.
      */
     public static function createCoach($firstName,	$lastName, $dob, $contactNo, $mobileNo, $email, $filename){
        $conn = Connection::connect();  
        
        $stmt = $conn->prepare(SQL::$createNewCoach); 
        $stmt->execute([$firstName,	$lastName,	$dob, $contactNo, $mobileNo, $email, $filename]); 
     }
     

     /**
      * Check if a coach with the given first name, last name, and email exists in the database.
      *
      * @param string $firstName The first name of the coach
      * @param string $lastName The last name of the coach
      * @param string $email The email of the coach
      * @return array $coach Array containing coach data
      */
     public static function checkCoach($firstName,	$lastName, $email){
        $conn = Connection::connect();
        
        $stmt = $conn->prepare(SQL::$checkCoach); 
        $stmt->execute([$firstName,	$lastName, $email]); 

        $coach = $stmt->fetch();

        return $coach;

     }
}

