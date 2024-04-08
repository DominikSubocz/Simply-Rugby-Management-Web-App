<?php

/**
 * 
 * @brief This class is responsible for actions related to doctor information.
 * 
 * These include:
 * - Retrieving records from database (Multiple & Single).
 * - Creating new records in database.
 * - Deleting records from database.
 * 
 * Future Additions:
 *  @todo - Update record function.
 *  @todo - Remove redundant functions.
 */

class Doctor{


    
    /**
     *  
     * Check if doctor with specific details exists and get single record result. 
     *  
     *  @param firstName - String containing Doctor's first name.     
     *  @param lastName - String containing coach's last name.
     *  @param contactNo - String containing coach's contact number.

     * 
     *  @return doctor - Single result.
     */

    public static function doctorExists($firstName, $lastName, $contactNo){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$doctorExists);
        $stmt->execute([$firstName, $lastName, $contactNo]);
        $doctor = $stmt->fetch();

        return $doctor;
    }

    /**
     *  
     * Check if doctor exists by using ID and get single record result. 
     * 
     *  
     *  
     *  @param firstName - String containing Doctor's first name.     
     *  @param lastName - String containing coach's last name.
     *  @param contactNo - String containing coach's contact number.

     * 
     *  @return doctorId - Single result.
     */

    public static function existingDoctorId($firstName, $lastName, $contactNo){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getExistingDoctorId);
        $stmt->execute([$firstName, $lastName, $contactNo]);
        $doctorId = $stmt->fetch(PDO::FETCH_COLUMN);

        return $doctorId;
    }

    /**
     *  
     *  Create new doctor record in database.
     *  
     *  @param firstName - String containing Doctor's first name.
     *  @param lastName - String containing coach's last name.
     *  @param contactNo - String containing coach's contact number.
     * 
     * 
     *  @return id - ID of just created record.
     */

    public static function createNewDoctor($firstName, $lastName, $contactNo){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$createNewDoctor);
        $stmt->execute([$firstName, $lastName, $contactNo]);


        $id = $conn->lastinsertId(); 
        return $id; 

    }

    /**
     *  
     *  Get all doctors from the database.
     *        
     * 
     *  @return doctors - Array of all doctor records.
     */

    public static function getAllDoctors(){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getAllDoctors);
        $stmt->execute();
        $doctors = $stmt->fetchAll();

        return $doctors;
    }

    /**
     *  
     *  Get specific doctor, output single record result.
     *        
     * 
     *  @param doctorId - String containing Doctor's ID number
     * 
     *  @return doctor - Single record.
     */


    public static function getDoctor($doctorId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getDoctor);
        $stmt->execute([$doctorId]);
        $doctor = $stmt->fetch();

        return $doctor;
    }

    /**
     *   Delete specific doctor from database     
     * 
     *  @param doctorId - String containing Doctor's ID number
     * 
     */

    public static function deleteDoctor($doctorId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$deleteDoctor);
        $stmt->execute([$doctorId]);

    }
}