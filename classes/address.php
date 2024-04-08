<?php


/**
 * 
 * @brief This class is responsible for actions related to address information.
 * 
 * These include:
 *  - Retrieving records from database (Multiple & Single).
 *  - Creating new records in database.
 *  - Deleting records from database.
 * 
 * Future Additions:
 *  @todo - Update record function.
 *  @todo - Remove redundant functions.
 */


class Address
    {

    /**
     *  
     * Check if address exists and return single record result.
     *  
     *  @param address1 - String containing Address Line 1.
     *  @param address2 - String containing Address Line 2.
     *  @param city - String containing City.
     *  @param county - String containing County.
     *  @param postcode- String containing Postcode.
     * 
     *  @return existingAddress - Results for existing address.
     */

    public static function addressExists($address1, $address2, $city, $county, $postcode){

    $conn = Connection::connect();


    $stmt = $conn->prepare(SQL::$addressExists); 
    $stmt->execute([$address1, $address2, $city, $county, $postcode]); 
    $existingAddress = $stmt->fetch(PDO::FETCH_COLUMN); 

    return $existingAddress;

    }


    /**
     *  
     *  Get all address records from database
     * 
     *  @return addreses - All records from the addresses table.
     */

    public static function getAllAddresses(){

        $conn = Connection::connect();
    
    
        $stmt = $conn->prepare(SQL::$getAllAddresses);
        $stmt->execute(); 
        $addreses = $stmt->fetchAll();  
    
        return $addreses; 
    
        }

    /**
     *  
     *  Insert new record into Addresses table
     *  
     *  @param address1 - String containing Address Line 1.
     *  @param address2 - String containing Address Line 2.
     *  @param city - String containing City.
     *  @param county - String containing County.
     *  @param postcode- String containing Postcode.
     * 
     *  @return addressId - ID of address which was just created.
     */    
    public static function createNewAddress($address1, $address2, $city, $county, $postcode){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$createNewAddress); 
        $stmt->execute([$address1, $address2, $city, $county, $postcode]); 
        $addressId = $conn->lastInsertId(); 

        return $addressId; 
    }

    /**
     * Check if address exists and get single record result.
     * 
     *  @note Seems like this is a redundant function, I won't remove it as for now.
     *  This is because I'm afraid the whole thing is going to get messed up.
     *  However, I plan to remove it in furture updates to clean up this class.
     * 
     *  
     *  
     *  @param address1 - String containing Address Line 1.
     *  @param address2 - String containing Address Line 2.
     *  @param city - String containing City.
     *  @param county - String containing County.
     *  @param postcode- String containing Postcode.
     * 
     *  @return addressId - Results for existing address.
     */

    public static function getExistingAddress($address1, $address2, $city, $county, $postcode){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getExistingAddressId); 
        $stmt->execute([$address1, $address2, $city, $county, $postcode]); 
        $addressId = $stmt->fetch(PDO::FETCH_COLUMN); 

        return $addressId; 

    }

    /**
     *  
     *  Get record of specific address
     *  
     *  @param addressId - String containing ID number of specific Address.
     * 
     *  @return address - Single address record from the addresses table.
     */    

    public static function getAddress($addressId){
        $conn = Connection::connect();
        $stmt = $conn->prepare(SQL::$getAddress); 
        $stmt->execute([$addressId]); 
        
        $address = $stmt->fetch(); 

        return $address; 
    }

    /**
     *  
     *  
     *  Delete specific address from database
     *  
     *  @param addressId - String containing ID number of specific Address.
     * 
     */  

    public static function deleteAddress($addressId){
        
        $conn = Connection::connect();
        $stmt = $conn->prepare(SQL::$deleteAddress); 
        $stmt->execute([$addressId]); 
        
    }
}