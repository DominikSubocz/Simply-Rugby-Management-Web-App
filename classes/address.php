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
 *  @todo 
 *  - Update record function.
 *  - Remove redundant functions.
 */


class Address
{
    /**
     * Check if an address already exists in the database based on the provided address details.
     *
     * @param string $address1 The first line of the address
     * @param string $address2 The second line of the address
     * @param string $city The city of the address
     * @param string $county The county of the address
     * @param string $postcode The postcode of the address
     * @return string $existingAddress The existing address if found, or null if not found
     */

    public static function addressExists($address1, $address2, $city, $county, $postcode)
    {

        $conn = Connection::connect();


        $stmt = $conn->prepare(SQL::$addressExists);
        $stmt->execute([$address1, $address2, $city, $county, $postcode]);
        $existingAddress = $stmt->fetch(PDO::FETCH_COLUMN);

        return $existingAddress;

    }




    /**
     * Retrieves all addresses from the database.
     *
     * @return array $addresses An array containing all addresses fetched from the database.
     */

    public static function getAllAddresses()
    {

        $conn = Connection::connect();


        $stmt = $conn->prepare(SQL::$getAllAddresses);
        $stmt->execute();
        $addreses = $stmt->fetchAll();

        return $addreses;

    }


    /**
     * Creates a new address record in the database with the provided address details.
     *
     * @param string $address1 The first line of the address
     * @param string $address2 The second line of the address
     * @param string $city The city of the address
     * @param string $county The county of the address
     * @param string $postcode The postcode of the address
     * @return int $addressId The ID of the newly created address record
     */

    public static function createNewAddress($address1, $address2, $city, $county, $postcode)
    {

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$createNewAddress);
        $stmt->execute([$address1, $address2, $city, $county, $postcode]);
        $addressId = $conn->lastInsertId();

        return $addressId;
    }


    /**
     * Retrieves the existing address ID from the database based on the provided address details.
     *
     * @param string $address1 The first line of the address
     * @param string $address2 The second line of the address
     * @param string $city The city of the address
     * @param string $county The county of the address
     * @param string $postcode The postcode of the address
     * @return string $addressId The address ID if found, null otherwise
     */

    public static function getExistingAddress($address1, $address2, $city, $county, $postcode)
    {

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getExistingAddressId);
        $stmt->execute([$address1, $address2, $city, $county, $postcode]);
        $addressId = $stmt->fetch(PDO::FETCH_COLUMN);

        return $addressId;

    }


    /**
     * Get the address details for the given address ID.
     *
     * @param int $addressId The ID of the address to retrieve
     * @return array $addresses The address details as an associative array, or null if address not found
     */

    public static function getAddress($addressId)
    {
        $conn = Connection::connect();
        $stmt = $conn->prepare(SQL::$getAddress);
        $stmt->execute([$addressId]);

        $address = $stmt->fetch();

        return $address;
    }



    /**
     * Delete an address from the database based on the given address ID.
     *
     * @param int $addressId The ID of the address to be deleted.
     * @throws PDOException If there is an error with the database operation. - There is a try catch code in corresponding page.
     */

    public static function deleteAddress($addressId)
    {

        $conn = Connection::connect();
        $stmt = $conn->prepare(SQL::$deleteAddress);
        $stmt->execute([$addressId]);

    }
}