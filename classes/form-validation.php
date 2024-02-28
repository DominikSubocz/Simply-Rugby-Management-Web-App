<?php

require("classes/sql.php");
require_once("classes/connection.php");


// Define variables and initialize them
$nameErr = $dobErr = $emailErr = $websiteErr = $sruErr = $contactNoErr = $mobileNoErr = $healthIssuesErr = $profileImageErr =  "";
$address1Err = $address2Err = $cityErr = $countyErr = $postcodeErr = "";
$kinErr = $kinContactErr = $doctorNameErr = $doctorContactErr = "";
$genuineErr = "";

$doctorId = $addressId = "";


$name = $dob = $email = $website = $sru = $contactNo = $mobileNo = $healthIssues = $profileImage = "";
$firstName = $lastName = "";
$address1 = $address2 = $city = $county = $postcode = "";
$kin = $kinContact = $doctorName = $doctorContact = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
        }

        $nameParts = explode(" ", $name);

        // Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    }

    // Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        // Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["sru"])){
        $sruErr = "SRU Number is required";


    } else {
        $sru = test_input($_POST["sru"]);
        if (!preg_match("/^\d+$/", $sru)) {
            $sruErr = "Only digits allowed";
        }
    }

    if (empty($_POST["dob"])){
        $dobErr = "Date of birth is required";


    } else {
        $dob = test_input($_POST["dob"]);
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY";
        }

        $dateTime = DateTime::createFromFormat('d/m/Y', $dob);
        $sqlDate = $dateTime->format('Y-m-d');
    }

    if(empty($_POST["contactNo"])){
        $contactNoErr = "Contact Number is required";

    } else {
        $contactNo = test_input($_POST["contactNo"]);
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed";
        }
    }

    if(empty($_POST["address1"])){
        $address1Err = "Address Line 1 is required";

    } else {
        $address1 = test_input($_POST["address1"]);
        if ((strlen($address1)<10) || (strlen($address1) > 50)){
            $address1Err = "Address Line 1 must be between 10 and 50 characters long!";
        }
    }

    if(!empty($_POST["address2"])){
        $address2 = test_input($_POST["address2"]);
    }

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]);
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed";
        }
    } 

    if(empty($_POST["city"])){
        $cityErr = "City is required";

    } else {
        $city = test_input($_POST["city"]);
        if ((strlen($city)<5) || (strlen($city) > 50)){
            $cityErr = "City must be between 10 and 50 characters long!";
        }
    }

    if(!empty($_POST["county"])){
        $county = test_input($_POST["county"]);
        if ((strlen($county)<5) || (strlen($county) > 50)){
            $countyErr = "County must be between 10 and 50 characters long!";
        }
    }

    if(empty($_POST["postcode"])){
        $postcodeErr = "Postcode is required";

    } else {
        $postcode = test_input($_POST["postcode"]);
        if ((strlen($postcode)<6) || (strlen($postcode) > 8)){
            $postcodeErr = "Postcode must be 6 characters long!";
        }
    }

    if(empty($_POST["profileImage"])){
        $profileImageErr = "Profile Image is required";
    }


 


    // Emergency Contact Details

    if (empty($_POST["kin"])) {
        $kinErr = "Name is required";
    } else {
        $kin = test_input($_POST["kin"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $kin)) {
            $kinErr = "Only letters and white space allowed";
        }
    }

    if(empty($_POST["kinContact"])){
        $kinContactErr = "Contact Number is required";

    } else {
        $kinContact = test_input($_POST["kinContact"]);
        if (!preg_match("/^\d+$/", $kinContact)) {
            $kinContactErr = "Only digits allowed";
        }
    }

    // Doctor Details

    // Validate name
    if (empty($_POST["doctorName"])) {
        $doctorNameErr = "Doctor's name is required";
    } else {
        $doctorName = test_input($_POST["doctorName"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $doctorName)) {
            $doctorNameErr = "Only letters and white space allowed";
        }

        $doctorNameParts = explode(" ", $doctorName);

        // Extract the first and last names
        $doctorFirstName = $doctorNameParts[0];
        $doctorLastName = end($doctorNameParts);
    }

    if(empty($_POST["doctorContact"])){
        $doctorContactErr = "Contact Number is required";

    } else {
        $doctorContact = test_input($_POST["doctorContact"]);
        if (!preg_match("/^\d+$/", $kinContact)) {
            $doctorContactErr = "Only digits allowed";
        }
    }

    

    // If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($websiteErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($healthIssuesErr) && empty($profileImageErr) 
    && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
    && empty($kinErr) && empty($kinContactErr) && empty($doctorNameErr) && empty($doctorContactErr) && empty ($genuineErr)) {

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$playerExists);
        $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
        $existingUser = $stmt->fetch();


        if($existingUser){
            $genuineErr = "ERROR: Player already exists!";
        }

        else{
            // $_SESSION["successMessage"] = "Your message has been submitted successfully!";
            // header("Location: success.php");
            // exit();

        }

        $stmt = $conn->prepare(SQL::$addressExists);
        $stmt->execute([$address1, $address2, $city, $county, $postcode]);
        $existingAddress = $stmt->fetch();

        if($existingAddress){

            $stmt = $conn->prepare(SQL::$getExistingAddressId);
            $stmt->execute([$address1, $address2, $city, $county, $postcode]);
            $addressId = $stmt->fetch(PDO::FETCH_COLUMN);
        }

        else{

            $stmt = $conn->prepare(SQL::$createNewAddress);
            $stmt->execute([$address1, $address2, $city, $county, $postcode]);

            $stmt = $conn->prepare(SQL::$getExistingAddressId);
            $stmt->execute([$address1, $address2, $city, $county, $postcode]);
            $addressId = $stmt->fetch(PDO::FETCH_COLUMN);

        }

        $stmt = $conn->prepare(SQL::$doctorExists);
        $stmt->execute([$doctorFirstName, $doctorLastName, $doctorContact]);
        $existingDoctor = $stmt->fetch();

        if($existingDoctor){
            $stmt = $conn->prepare(SQL::$getExistingDoctorId);
            $stmt->execute([$doctorFirstName, $doctorLastName, $doctorContact]);
            $doctorId = $stmt->fetch(PDO::FETCH_COLUMN);
        }

        else{
            $stmt = $conn->prepare(SQL::$createNewDoctor);
            $stmt->execute([$doctorFirstName, $doctorLastName, $doctorContact]);

            $stmt = $conn->prepare(SQL::$getExistingDoctorId);
            $stmt->execute([$doctorFirstName, $doctorLastName, $doctorContact]);
            $doctorId = $stmt->fetch(PDO::FETCH_COLUMN);
        }

        if(empty($genuineErr)){
            var_dump($addressId);
            var_dump($doctorId);
            $stmt = $conn->prepare(SQL::$createNewPlayer);
            $stmt->execute([$addressId, $doctorId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $profileImage]);
        }

    }

    else{
        $genuineErr = "ERROR: Not all form inputs filled/correct!";
    }

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>