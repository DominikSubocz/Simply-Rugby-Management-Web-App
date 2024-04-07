<?php


/**
 * 
 * @brief This class is responsible for actions related to address information.
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


class Address
    {

    /**
     *  @fn public static function addressExists($address1, $address2, $city, $county, $postcode)
     *  
     *  @brief This function checks if address exists.
     *         If address exists it will return results for that address.
     *         If address doesn't exist, no results will show up.
     *  
     *  @param address1 - Stores information about Address Line 1.
     *  @param address2 - Stores information about Address Line 2.
     *  @param city - Stores information about City.
     *  @param county - Stores information about County.
     *  @param postcode - Stores information about Postcode.
     * 
     *  @return existingAddress - Results for existing address.
     */

    public static function addressExists($address1, $address2, $city, $county, $postcode){

    $conn = Connection::connect(); ///< Connect to database


    $stmt = $conn->prepare(SQL::$addressExists); ///< SQL Command
    $stmt->execute([$address1, $address2, $city, $county, $postcode]); ///< Pass parameters and execute SQL command.
    $existingAddress = $stmt->fetch(PDO::FETCH_COLUMN); ///< Get single record

    return $existingAddress; ///< Return record.

    }


    /**
     *  @fn public static function getAllAddresses()
     *  
     *  @brief This function retrieves all records from addresses table.
     *  
     * 
     *  @return addreses - All records from the addresses table.
     */

    public static function getAllAddresses(){

        $conn = Connection::connect(); ///< Connect to database.
    
    
        $stmt = $conn->prepare(SQL::$getAllAddresses); ///< SQL Command.
        $stmt->execute(); ///< Execute SQL command.
        $addreses = $stmt->fetchAll();  ///< Get multiple records.
    
        return $addreses; ///< Return records.
    
        }

    /**
     *  @fn public static function createNewAddress($address1, $address2, $city, $county, $postcode)
     *  
     *  @brief This function creates a new record in the database.
     *         It also Returns the id of the address which was just created.
     *  
     *  @param address1 - Stores information about Address Line 1.
     *  @param address2 - Stores information about Address Line 2.
     *  @param city - Stores information about City.
     *  @param county - Stores information about County.
     *  @param postcode - Stores information about Postcode.
     * 
     *  @return addressId - ID of address which was just created.
     */    
    public static function createNewAddress($address1, $address2, $city, $county, $postcode){

        $conn = Connection::connect(); ///< Connect to database

        $stmt = $conn->prepare(SQL::$createNewAddress); ///< SQL Command
        $stmt->execute([$address1, $address2, $city, $county, $postcode]); ///< Pass parameters and execute SQL command.
        $addressId = $conn->lastInsertId(); ///< Get id of last inserted item.

        return $addressId; ///< Return ID.
    }

    /**
     * 
     *  @note Seems like this is a redundant function, I won't remove it as for now.
     *        This is because I'm afraid the whole thing is going to get messed up.
     *        However, I plan to remove it in furture updates to clean up this class.
     * 
     *  @fn public static function getExistingAddress($address1, $address2, $city, $county, $postcode)
     *  
     *  @brief This function checks if address exists.
     *         If address exists it will return results for that address.
     *         If address doesn't exist, no results will show up.
     *  
     *  @param address1 - Stores information about Address Line 1.
     *  @param address2 - Stores information about Address Line 2.
     *  @param city - Stores information about City.
     *  @param county - Stores information about County.
     *  @param postcode - Stores information about Postcode.
     * 
     *  @return addressId - Results for existing address.
     */

    public static function getExistingAddress($address1, $address2, $city, $county, $postcode){

        $conn = Connection::connect(); ///< Connect to database

        $stmt = $conn->prepare(SQL::$getExistingAddressId); ///< SQL Command
        $stmt->execute([$address1, $address2, $city, $county, $postcode]); ///< Pass parameters and execute SQL command.
        $addressId = $stmt->fetch(PDO::FETCH_COLUMN); ///< Get single record

        return $addressId; ///< Return ID.

    }

    /**
     *  @fn public static function getAddress($addressId)
     *  
     *  @brief This function retrieves single record from database.
     *  
     *  @param addressId - Stores information about address_id field.
     * 
     *  @return address - Single address record from the addresses table.
     */    

    public static function getAddress($addressId){
        $conn = Connection::connect(); ///< Connect to database
        $stmt = $conn->prepare(SQL::$getAddress); ///< SQL Command
        $stmt->execute([$addressId]); ///< Pass parameters and execute SQL command.
        
        $address = $stmt->fetch(); ///< Get single record

        return $address; ///< Return record
    }

    /**
     *  @fn public static function deleteAddress($addressId)
     *  
     *  @brief This function removes one record from the addresses table.
     *         Based on the address_id field, passed as parameter.
     *  
     *  @param addressId - Stores information about address_id field.
     * 
     */  

    public static function deleteAddress($addressId){
        
        $conn = Connection::connect(); ///< Connect to database
        $stmt = $conn->prepare(SQL::$deleteAddress); ///< SQL Command
        $stmt->execute([$addressId]); ///< Pass parameters and execute SQL command.
        
    }
}