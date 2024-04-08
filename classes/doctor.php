<?php

/**
 * 
 * @brief This class is responsible for actions related to doctor information.
 * 
 *        These include:
 *              - Retrieving records from database (Multiple & Single).
 *              - Creating new records in database.
 *              - Deleting records from database.
 * 
 *        Future Additions:
 *        @todo - Update record function.
 *        @todo - Remove redundant functions.
 */

class Doctor{


    
    /**
     *  
     *  
     *  @brief This function checks if doctor exists.
     *         If doctor exists it will return results for that doctor.
     *         If doctor doesn't exist, no results will show up.
     *  
     *  @param firstName - Stores information about Doctor's first name.
     *  @param lastName - Stores information about Doctor's last name.
     *  @param contactNo - Stores information about Doctor's contact number.

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
     * 
     *  @note Seems like this is a redundant function, I won't remove it as for now.
     *        This is because I'm afraid the whole thing is going to get messed up.
     *        However, I plan to remove it in furture updates to clean up this class.
     *  
     *  @brief This function checks if doctor exists.
     *         If doctor exists it will return results for that doctor.
     *         If doctor doesn't exist, no results will show up.
     *  
     *  @param firstName - Stores information about Doctor's first name.
     *  @param lastName - Stores information about Doctor's last name.
     *  @param contactNo - Stores information about Doctor's contact number.

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
     *  
     *  @brief This function inserts a new record into the Doctors table.
     *         It also returns id of just created record.
     *  
     *  @param firstName - Stores information about Doctor's first name.
     *  @param lastName - Stores information about Doctor's last name.
     *  @param contactNo - Stores information about Doctor's contact number.
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
     *  
     *  @brief This function retrieves all records from the Doctors table.
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
     *  
     *  @brief This function retrieves single record from the Doctors table, based on doctor_id field.
     *        
     * 
     *  @param doctorId - Stores information about Doctor's ID number.
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
     *  
     *  
     *  @brief This function removes single record from the Doctors table.
     *        
     * 
     *  @param doctorId - Stores information about Doctor's ID number.
     * 
     */

    public static function deleteDoctor($doctorId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$deleteDoctor);
        $stmt->execute([$doctorId]);

    }
}