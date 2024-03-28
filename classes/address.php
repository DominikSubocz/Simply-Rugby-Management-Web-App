<?php

class Address
    {

    public static function addressExists($address1, $address2, $city, $county, $postcode){

    $conn = Connection::connect();


    $stmt = $conn->prepare(SQL::$addressExists);
    $stmt->execute([$address1, $address2, $city, $county, $postcode]);
    $existingAddress = $stmt->fetch(PDO::FETCH_COLUMN);

    return $existingAddress;

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
}