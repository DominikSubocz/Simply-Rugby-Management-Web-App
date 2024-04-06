<?php


/**
 * This class is responsible for actions related to address information.
 * 
 * Main responsible
 */

class Address
    {

    public static function addressExists($address1, $address2, $city, $county, $postcode){

    $conn = Connection::connect();


    $stmt = $conn->prepare(SQL::$addressExists);
    $stmt->execute([$address1, $address2, $city, $county, $postcode]);
    $existingAddress = $stmt->fetch(PDO::FETCH_COLUMN);

    return $existingAddress;

    }

    public static function getAllAddresses(){

        $conn = Connection::connect();
    
    
        $stmt = $conn->prepare(SQL::$getAllAddresses);
        $stmt->execute();
        $addreses = $stmt->fetchAll();
    
        return $addreses;
    
        }

    public static function createNewAddress($address1, $address2, $city, $county, $postcode){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$createNewAddress);
        $stmt->execute([$address1, $address2, $city, $county, $postcode]);
        $addressId = $conn->lastInsertId();

        return $addressId;
    }

    public static function getExistingAddress($address1, $address2, $city, $county, $postcode){

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getExistingAddressId);
        $stmt->execute([$address1, $address2, $city, $county, $postcode]);
        $addressId = $stmt->fetch(PDO::FETCH_COLUMN);

        return $addressId;

    }

    public static function getAddress($addressId){
        $conn = Connection::connect();
        $stmt = $conn->prepare(SQL::$getAddress);
        $stmt->execute([$addressId]);
        
        $address = $stmt->fetch();

        return $address;
    }

    public static function deleteAddress($addressId){
        
        $conn = Connection::connect();
        $stmt = $conn->prepare(SQL::$deleteAddress);
        $stmt->execute([$addressId]);
        
    }
}