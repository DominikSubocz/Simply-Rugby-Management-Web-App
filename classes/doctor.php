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
     * Check if a doctor exists based on the provided first name, last name, and contact number.
     *
     * @param string $firstName The first name of the doctor
     * @param string $lastName The last name of the doctor
     * @param string $contactNo The contact number of the doctor
     * @return string $doctor The doctor information if found, null otherwise
     */
    public static function doctorExists($firstName, $lastName, $contactNo){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$doctorExists);
        $stmt->execute([$firstName, $lastName, $contactNo]);
        $doctor = $stmt->fetch();

        return $doctor;
    }



    /**
     * Retrieve the existing doctor ID based on the provided first name, last name, and contact number.
     *
     * @param string $firstName The first name of the doctor.
     * @param string $lastName The last name of the doctor.
     * @param string $contactNo The contact number of the doctor.
     * @return string $doctorid The existing doctor ID if found, otherwise null.
     */
    public static function existingDoctorId($firstName, $lastName, $contactNo){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getExistingDoctorId);
        $stmt->execute([$firstName, $lastName, $contactNo]);
        $doctorId = $stmt->fetch(PDO::FETCH_COLUMN);

        return $doctorId;
    }



    /**
     * Creates a new doctor with the given first name, last name, and contact number.
     *
     * @param string $firstName The first name of the doctor
     * @param string $lastName The last name of the doctor
     * @param string $contactNo The contact number of the doctor
     * @return int $id The ID of the newly created doctor
     */
    public static function createNewDoctor($firstName, $lastName, $contactNo){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$createNewDoctor);
        $stmt->execute([$firstName, $lastName, $contactNo]);


        $id = $conn->lastinsertId(); 
        return $id; 

    }



    /**
     * Retrieves all doctors from the database.
     *
     * @return array $doctors An array containing all the doctors fetched from the database.
     */
    public static function getAllDoctors(){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getAllDoctors);
        $stmt->execute();
        $doctors = $stmt->fetchAll();

        return $doctors;
    }




    /**
     * Retrieves a doctor's information based on the provided doctor ID.
     *
     * @param int $doctorId The ID of the doctor to retrieve.
     * @return string $doctor The details of the doctor if found, or null if not found.
     */
    public static function getDoctor($doctorId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getDoctor);
        $stmt->execute([$doctorId]);
        $doctor = $stmt->fetch();

        return $doctor;
    }



    /**
     * Deletes a doctor from the database based on the provided doctor ID.
     *
     * @param int $doctorId The ID of the doctor to be deleted.
     */
    public static function deleteDoctor($doctorId){
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$deleteDoctor);
        $stmt->execute([$doctorId]);

    }
}