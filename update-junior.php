<?php
/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/guardian.php");
require("classes/doctor.php");
require("classes/address.php");
require("classes/junior.php");

/**
 * Check if the user is logged in by verifying the presence of the 'loggedIn' key in the session.
 * If the user is not logged in, redirect to the login page.
 * 
 * If the user is logged in check priveledge level, and proceed.
 */
if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
}

/**
 * Check if the user role is not Admin or Coach, then redirect to logout page.
 */
if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Redirects to the player list page if the 'id' parameter is not set in the GET request or if it is not a numeric value.
 */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/junior-list.php");
}


$conn = Connection::connect(); ///< Connect to database

$juniorId = $_GET["id"]; ///< Get ID of junior and store it in a variable

$junior = Junior::getJunior($juniorId); ///< Get details of specific junior by its ID number.

/**
 * Escape and assign values from the $game array to respective variables for security purposes.
 *
 * @param array $junior An array containing information about the junior.
 * 
 */

$playerFirstName = Utils::escape($junior["first_name"]);
$playerLastName = Utils::escape($junior["last_name"]);

$dobPlaceholder = Utils::escape($junior["dob"]);
$user_idPlaceholder = Utils::escape($junior["user_id"]); /// Might implement update for that later
$sruNumberPlaceholder = Utils::escape($junior["sru_no"]);
$contactNumberPlaceholder = Utils::escape($junior["contact_no"]);
$mobileNumberPlaceholder = Utils::escape($junior["mobile_no"]);
$emailAddressPlaceholder = Utils::escape($junior["email_address"]);
$healthIssuesPlaceholder = Utils::escape($junior["health_issues"]);
$filenamePlaceholder = Utils::escape($junior["filename"]);

$address1Placeholder = Utils::escape($junior["address_line"]);
$address2Placeholder = Utils::escape($junior["address_line2"]);
$cityPlaceholder = Utils::escape($junior["city"]);
$countyPlaceholder = Utils::escape($junior["county"]);
$postcodePlaceholder = Utils::escape($junior["postcode"]);
$doctorFirstNamePlaceholder = Utils::escape($junior["doctor_first_name"]);
$doctorLastNamePlaceholder = Utils::escape($junior["doctor_last_name"]);
$doctorContactPlaceholder = Utils::escape($junior["doctor_contact_no"]);

$guardians = Guardian::getGuardian($juniorId); ///< Get details about guardians based on ID number of specific junior


/**
 * Assigns guardian information and address details to variables based on the number of guardians provided.
 * If there is only one guardian, assigns the guardian information and address details to variables with suffix 1.
 * If there are multiple guardians, assigns the guardian information and address details to variables with suffix 2.
 *
 * @param array $guardians An array containing guardian information.
 */
if (count($guardians) == 1) {

    $guardianIdPlaceholder1 = Utils::escape($guardians[0]["guardian_id"]);
    $guardianFirstNamePlaceholder1 = Utils::escape($guardians[0]["guardian_first_name"]);
    $guardianLastNamePlaceholder1 = Utils::escape($guardians[0]["guardian_last_name"]);
    $guardianContactPlaceholder1 = Utils::escape($guardians[0]["guardian_contact_no"]);
    $guardianRelationshipPlaceholder1 = Utils::escape($guardians[0]["relationship"]);

    $guardianAddresses1 = Guardian::getGuardianAddress($guardianIdPlaceholder1);

    $guardianAddress1Placeholder1 = Utils::escape($guardianAddresses1["address_line"]);
    $guardianAddress2Placeholder1 = Utils::escape($guardianAddresses1["address_line2"]);
    $guardianCityPlaceholder1 = Utils::escape($guardianAddresses1["city"]);
    $guardianCountyPlaceholder1 = Utils::escape($guardianAddresses1["county"]);
    $guardianPostcodePlaceholder1 = Utils::escape($guardianAddresses1["postcode"]);
} else {
    $guardianIdPlaceholder2 = Utils::escape($guardians[1]["guardian_id"]);
    $guardianFirstNamePlaceholder2 = Utils::escape($guardians[1]["guardian_first_name"]);
    $guardianLastNamePlaceholder2 = Utils::escape($guardians[1]["guardian_last_name"]);
    $guardianContactPlaceholder2 = Utils::escape($guardians[1]["guardian_contact_no"]);
    $guardianRelationshipPlaceholder2 = Utils::escape($guardians[1]["relationship"]);

    $guardianAddresses2 = Guardian::getGuardianAddress($guardianIdPlaceholder2);
    
    $guardianAddress1Placeholder2 = Utils::escape($guardianAddresses2["address_line"]);
    $guardianAddress2Placeholder2 = Utils::escape($guardianAddresses2["address_line2"]);
    $guardianCityPlaceholder2 = Utils::escape($guardianAddresses2["city"]);
    $guardianCountyPlaceholder2 = Utils::escape($guardianAddresses2["county"]);
    $guardianPostcodePlaceholder2 = Utils::escape($guardianAddresses2["postcode"]);
}







$phpdate = strtotime( $dobPlaceholder ); ///< Converts a date of birth (dob) into a SQL date format (YYYY-MM-DD).
$ukDobPlaceholder = date( 'd/m/Y', $phpdate ); ///< Format a Unix timestamp into a UK date of birth placeholder string.


/**
 * Variables to store error messages and input values for form validation.
 * 
 * @var string $nameErr: Error message for name field.
 * @var string $dobErr: Error message for date of birth field.
 * @var string $emailErr: Error message for email field.
 * @var string $sruErr: Error message for SRU field.
 * @var string $contactNoErr: Error message for contact number field.
 * @var string $mobileNoErr: Error message for mobile number field.
 * @var string $healthIssuesErr: Error message for health issues field.
 * @var string $profileImageErr: Error message for profile image field.
 * @var string $guardianNameErr: Error message for guardian name field.
 * @var string $guardianContactErr: Error message for guardian contact field.
 * @var string $relationshipErr: Error message for relationship
 * 
 * @var string $guardianAddress11Err: Error message for Address Line 1 of Guardian number 1.
 * @var string $guardianAddress12Err: Error message for Address Line 2 of Guardian number 1.
 * @var string $guardianCity1Err: Error message for City of Guardian number 1.
 * @var string $guardianCounty1Err: Error message for County of Guardian number 1.
 * @var string $guardianPostcode1Err: Error message for Postcode of Guardian number 1.
 * @var string $guardianAddress21Err: Error message for Address Line 1 of Guardian number 2.
 * @var string $guardianAddress22Err: Error message for Address Line 2 of Guardian number 2.
 * @var string $guardianCity2Err: Error message for City of Guardian number 2.
 * @var string $guardianCounty2Err: Error message for County of Guardian number 2.
 * @var string $guardianPostcode2Err: Error message for Postcode of Guardian number 2.
 * 
 * @var string $address1Err: Error message for Address Line 1
 * @var string $address2Err: Error message for Address Line 2
 * @var string $cityErr: Error message for City
 * @var string $countyErr: Error message for County
 * @var string $postcodeErr: Error message for Postcode
 * @var string $doctorNameErr: Error message for Doctor's name
 * @var string $doctorContactErr: Error message for Doctor's contact number
 * @var string $genuineErr: Error message that appers on top of the form i.e "Not all input fields filled/correct"
 * 
 * Personal Information:
 * @var string $name: Holds value for Name input field
 * @var \DateTime $dob: Holds value for Date of birth input field
 * @var string  $email: Holds value for Email address input field
 * @var int  $sru: Holds value for SRU input field
 * @var int  $contactNo:  Holds value forContact number input field
 * @var int  $mobileNo: Holds value for Mobile number input field
 * @var string  $healthIssues: Holds value for Health issues input field
 * @var string  $profileImage: Holds value for Profile image input field
 * @var string  $filename: Holds value for Filename image validation
 * @var string  $firstName: Holds value for First name after the splitting process
 * @var string  $lastName: Holds value for Last name after the splitting process
 *
 * Guardian 1 Information:
 * @var string  $guardianFirstName: Holds value for Guardian's first name after the splitting process
 * @var string  $guardianLastName: Holds value for Guardian's last name after the splitting process
 * @var string  $guardianName: Holds value for Guardian's name input field
 * @var string  $guardianContact: Holds value for Guardian's contact number input field
 * @var string  $relationship: Holds value for Guardian's relationship input field
 * @var string  $guardianAddress11: Holds value for Guardian's Address Line 1 input field 
 * @var string  $guardianAddress12: Holds value for Guardian's Address Line 2 input field 
 * @var string  $guardianCity1: Holds value for Guardian's City input field 
 * @var string  $guardianCounty1: Holds value for Guardian's County input field 
 * @var string  $guardianPostcode1: Holds value for Guardian's Postcode input field 
 * 
 * Guardian 2 Information:
 * @var string  $guardianFirstName2: Holds value for Guardian's first name after the splitting process
 * @var string  $guardianLastName2: Holds value for Guardian's last name after the splitting process
 * @var string  $guardianName2: Holds value for Guardian's name input field
 * @var string  $guardianContact2: Holds value for Guardian's contact number input field
 * @var string  $relationship2: Holds value for Guardian's relationship input field
 * @var string  $guardianAddress21: Holds value for Guardian's Address Line 1 input field 
 * @var string  $guardianAddress22: Holds value for Guardian's Address Line 2 input field 
 * @var string  $guardianCity2: Holds value for Guardian's City input field 
 * @var string  $guardianCounty2: Holds value for Guardian's County input field 
 * @var string  $guardianPostcode2: Holds value for Guardian's Postcode input field 
 * 
 * Address Information
 * @var string $address1: Holds value for Address Line 1 input field
 * @var string $address2: Holds value for Address Line 2 input field
 * @var string $city: Holds value for City input field 
 * @var string $county: Holds value for County input field 
 * @var string $postcode: Holds value for Postcode input field 
 * @var string $doctorName: Holds value for Doctor's name input field 
 * @var string $doctorContact: Holds value for Doctor's contact number input field 
 * 
 * Variables to store input values for form validation.
 */
$nameErr = $dobErr = $emailErr = $sruErr = $contactNoErr = $mobileNoErr = $healthIssuesErr = $profileImageErr =  "";
$guardianNameErr = $guardianContactErr = $relationshipErr = "";

$guardianAddress11Err = $guardianAddress12Err = $guardianCity1Err = $guardianCounty1Err = $guardianPostcode1Err = "";
$guardianAddress21Err = $guardianAddress22Err = $guardianCity2Err = $guardianCounty2Err = $guardianPostcode2Err = "";
$guardianName2Err = $guardianContact2Err = $relationship2Err = "";
$address1Err = $address2Err = $cityErr = $countyErr = $postcodeErr = "";
$doctorNameErr = $doctorContactErr = "";
$genuineErr = $profileImageErr = "";

$doctorId = $addressId = "";

$name = $dob = $email = $sru = $contactNo = $mobileNo = $healthIssues = $profileImage = $filename = "";
$firstName = $lastName = "";

$guardianFirstName = $guardianLastName = "";

$guardianName = $guardianContact = $relationship = "";
$guardianAddress11 = $guardianAddress12 = $guardianCity1 = $guardianCounty1 = $guardianPostcode1 = "";

$guardianFirstName2 = $guardianLastName2 ="";
$guardianName2 = $guardianContact2 = $relationship2 ="";
$guardianAddress21 = $guardianAddress22 = $guardianCity2 = $guardianCounty2 = $guardianPostcode2 = "";


$address1 = $address2 = $city = $county = $postcode = "";
$doctorName = $doctorContact = "";

/**
 * This function is used to handle form submission when the HTTP request method is POST. 
 * It validates the form inputs and processes the data accordingly.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $name = $playerFirstName . ' ' . $playerLastName; ///< Combines the first name and last name placeholders values if left empty
        $nameParts = explode(" ", $name); ///< Split name into first and last name

        /// Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    } else {
        $name = test_input($_POST["name"]); ///< Sanitize name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed"; ///< Display error message
        }

        $nameParts = explode(" ", $name); ///< Split name into first and last name


        /// Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    }

    /// Validate email
    if (empty($_POST["email"])) {
        $email = $emailAddressPlaceholder;
    } else {
        $email = test_input($_POST["email"]); ///< Sanitize email address
        /// Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format"; ///< Display error message
        }
    }

    if (empty($_POST["sru"])){
        $sru = $sruNumberPlaceholder;


    } else {
        $sru = test_input($_POST["sru"]); ///< Sanitize sru number
        if (!preg_match("/^\d+$/", $sru)) {
            $sruErr = "Only digits allowed"; ///< Display error message
        }
    }

    if (empty($_POST["dob"])){
        $dob = date('d/m/Y', strtotime($dobPlaceholder));  ///< Format a Unix timestamp into a UK date of birth placeholder string.

        $sqlDate = date('Y-m-d', strtotime($dob)); ///< Converts a date string to a Unix timestamp.


    } else {
        $dob = test_input($_POST["dob"]); ///< Sanitize dob
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY"; ///< Display error message
        }

        $sqlDate = date('Y-m-d', strtotime($dob)); ///< Converts a date of birth (dob) into a SQL date format (YYYY-MM-DD).

    }

    if(empty($_POST["contactNo"])){
        $contactNo = $contactNumberPlaceholder; ///< Set value to placeholder if left empty

    } else {
        $contactNo = test_input($_POST["contactNo"]); ///< Sanitize contact number
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed"; ///< Display error message
        }
    }

    if(empty($_POST["address1"])){
        $address1 = $address1Placeholder; ///< Set value to placeholder if left empty

    } else {
        $address1 = test_input($_POST["address1"]); ///< Sanitize address line 1
        if ((strlen($address1)<10) || (strlen($address1) > 50)){
            $address1Err = "Address Line 1 must be between 10 and 50 characters long!"; ///< Display error message
        }
    }

    if(!empty($_POST["address2"])){
        $address2 = test_input($_POST["address2"]); ///< Sanitize address line 2
    } else {
        $address2 = $address2Placeholder; ///< Set value to placeholder if left empty

    }

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]); ///< Sanitize mobile number
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed"; ///< Display error message
        }
    } else {
        $mobileNo = $mobileNumberPlaceholder; ///< Set value to placeholder if left empty
    }

    if(empty($_POST["city"])){
        $city = $cityPlaceholder; ///< Set value to placeholder if left empty

    } else {
        $city = test_input($_POST["city"]); ///< Sanitize city
        if ((strlen($city)<5) || (strlen($city) > 50)){
            $cityErr = "City must be between 10 and 50 characters long!"; ///< Display error message
        }
    }

    if(!empty($_POST["county"])){
        $county = test_input($_POST["county"]); ///< Sanitize county
        if ((strlen($county)<5) || (strlen($county) > 50)){
            $countyErr = "County must be between 10 and 50 characters long!"; ///< Display error message
        }
    } else {
        $county = $countyPlaceholder; ///< Set value to placeholder if left empty
    }

    if(empty($_POST["postcode"])){
        $postcode = $postcodePlaceholder; ///< Set value to placeholder if left empty

    } else {
        $postcode = test_input($_POST["postcode"]); ///< Sanitize postcode
        if ((strlen($postcode)<6) || (strlen($postcode) > 8)){
            $postcodeErr = "Postcode must be 6 characters long!"; ///< Display error message
        }
    }


 


    /// Guardian Contact Details

    if (empty($_POST["guardianName"])) {
        $guardianName = $guardianFirstNamePlaceholder1 . ' ' . $guardianLastNamePlaceholder1; ///< Set value to placeholder if left empty

        $guardianNameParts = explode(" ", $guardianName); ///< Split name into first and last name

        /// Extract the first and last names
        $guardianFirstName = $guardianNameParts[0];
        $guardianLastName = end($guardianNameParts);
    } else {
        $guardianName = test_input($_POST["guardianName"]); ///< Sanitize guardian's name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $guardianName)) {
            $guardianNameErr = "Only letters and white space allowed"; ///< Display error message
        }

        $guardianNameParts = explode(" ", $guardianName); ///< Split name into first and last name

        /// Extract the first and last names
        $guardianFirstName = $guardianNameParts[0];
        $guardianLastName = end($guardianNameParts);
    }

    if(empty($_POST["guardianContact"])){
        $guardianContact = $guardianContactPlaceholder1; ///< Set value to placeholder if left empty

    } else {
        $guardianContact = test_input($_POST["guardianContact"]); ///< Sanitize guardian's contact number
        if (!preg_match("/^\d+$/", $guardianContact)) {
            $guardianContactErr = "Only digits allowed"; ///< Display error message
        }
    }

    if(empty($_POST["relationship"])){
        $relationship = $guardianRelationshipPlaceholder1; ///< Set value to placeholder if left empty
    } else{
        $relationship = test_input($_POST["relationship"]); ///< Sanitize relationship
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship)) {
            $relationshipErr = "Only letters and white space allowed"; ///< Display error message
        }
    }


    if(empty($_POST["guardianAddress11"])){
        $guardianAddress11 = $guardianAddress1Placeholder1; ///< Set value to placeholder if left empty

    } else {
        $guardianAddress11 = test_input($_POST["guardianAddress11"]); ///< Sanitize address line 1 of guardian 1
        if ((strlen($guardianAddress11)<10) || (strlen($guardianAddress11) > 50)){
            $guardianAddress11Err = "Address Line 1 must be between 10 and 50 characters long!"; ///< Display error message
        }
    }

    if(!empty($_POST["guardianAddress12"])){
        $guardianAddress12 = test_input($_POST["guardianAddress12"]); ///< Sanitize address line 2 of guardian 1
    } else {
        $guardianAddress12 = $guardianAddress2Placeholder1; ///< Set value to placeholder if left empty
    }

    if(empty($_POST["guardianCity1"])){
        $guardianCity1 = $guardianCityPlaceholder1; ///< Set value to placeholder if left empty

    } else {
        $guardianCity1 = test_input($_POST["guardianCity1"]); ///< Sanitize city of guardian 1
        if ((strlen($guardianCity1)<5) || (strlen($guardianCity1) > 50)){
            $guardianCity1Err = "City must be between 10 and 50 characters long!"; ///< Display error message
        }
    }

    if(!empty($_POST["guardianCounty1"])){
        $guardianCounty1 = test_input($_POST["guardianCounty1"]); ///< Sanitize county of guardian 1
        if ((strlen($guardianCounty1)<5) || (strlen($guardianCounty1) > 50)){
            $guardianCounty1Err = "County must be between 10 and 50 characters long!"; ///< Display error message
        }
    } else {
        $guardianCounty1 = $guardianCountyPlaceholder1; ///< Set value to placeholder if left empty
    }

    if(empty($_POST["guardianPostcode1"])){
        $guardianPostcode1 = $guardianPostcodePlaceholder1; ///< Set value to placeholder if left empty

    } else {
        $guardianPostcode1 = test_input($_POST["guardianPostcode1"]); ///< Sanitize postcode of guardian 1
        if ((strlen($guardianPostcode1)<6) || (strlen($guardianPostcode1) > 8)){
            $guardianPostcode1Err = "Postcode must be 6 characters long!"; ///< Display error message
        }
    }





    

    ///Secondary Guradian Validation

    if($_POST['elementForVar1HiddenField'] == 1){
        if(empty($_POST["guardianName2"])){
            if(isset($guardianFirstNamePlaceholder2) && isset ( $guardianLastNamePlaceholder2)){
                $guardianName2 = $guardianFirstNamePlaceholder2 . ' ' . $guardianLastNamePlaceholder2; ///< Combines the first name and last name placeholders values if left empty

                
                $guardianNameParts2 = explode(" ", $guardianName2); ///< Split name into first and last name
        
                /// Extract the first and last names
                $guardianFirstName2 = $guardianNameParts2[0];
                $guardianLastName2 = end($guardianNameParts2);
            } 
        } else {
            $guardianName2 = test_input($_POST["guardianName2"]); ///< Sanitize name of guardian 2
            /// Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $guardianName2)) {
                $guardianName2Err = "Only letters and white space allowed"; ///< Display error message
            }
    
            $guardianNameParts2 = explode(" ", $guardianName2); ///< Split name into first and last name
    
            /// Extract the first and last names
            $guardianFirstName2 = $guardianNameParts2[0];
            $guardianLastName2 = end($guardianNameParts2);
        }
    
        if(empty($_POST["guardianContact2"])){
            if(isset($guardianContactPlaceholder2)){
                $guardianContact2 = $guardianContactPlaceholder2; ///< Set value to placeholder if left empty


            }
    
        } else {
            $guardianContact2 = test_input($_POST["guardianContact"]); ///< Sanitize contact number of guardian 2
            if (!preg_match("/^\d+$/", $guardianContact2)) {
                $guardianContact2Err = "Only digits allowed"; ///< Display error message
            }
        }
    
        if(empty($_POST["relationship2"])){
            if(isset($guardianRelationshipPlaceholder2)){
                $relationship2 = $guardianRelationshipPlaceholder2; ///< Set value to placeholder if left empty
            }
        } else{
            $relationship2 = test_input($_POST["relationship2"]); ///< Sanitize relationship of guardian 2
            /// Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship2)) {
                $relationship2Err = "Only letters and white space allowed"; ///< Display error message
            }
        }

        if(empty($_POST["guardianAddress21"])){
            if(isset($guardianAddress1Placeholder2)){
                $guardianAddress21 = $guardianAddress1Placeholder2; ///< Set value to placeholder if left empty
            }
    
        } else {
            $guardianAddress21 = test_input($_POST["guardianAddress21"]); ///< Sanitize address line 1 of guardian 2
            if ((strlen($guardianAddress21)<10) || (strlen($guardianAddress21) > 50)){
                $guardianAddress21Err = "Address Line 1 must be between 10 and 50 characters long!"; ///< Display error message
            }
        }
    
        if(!empty($_POST["guardianAddress22"])){
            $guardianAddress22 = test_input($_POST["guardianAddress22"]); ///< Sanitize address line 2 of guardian 2
        } else {
            if(isset($guardianAddress2Placeholder2)){
                $guardianAddress22 = $guardianAddress2Placeholder2; ///< Set value to placeholder if left empty

            }
        }
    
        if(empty($_POST["guardianCity2"])){
            if(isset($guardianCityPlaceholder2)){
                $guardianCity2 = $guardianCityPlaceholder2;  ///< Set value to placeholder if left empty

            }
        } else {
            $guardianCity2 = test_input($_POST["guardianCity2"]); ///< Sanitize city of guardian 2
            if ((strlen($guardianCity2)<5) || (strlen($guardianCity2) > 50)){
                $guardianCity2Err = "City must be between 10 and 50 characters long!"; ///< Display error message
            }
        }
    
        if(!empty($_POST["guardianCounty2"])){
            $guardianCounty2 = test_input($_POST["guardianCounty2"]); ///< Sanitize county of guardian 2
            if ((strlen($guardianCounty2)<5) || (strlen($guardianCounty2) > 50)){
                $guardianCounty2Err = "County must be between 10 and 50 characters long!"; ///< Display error message
            }
        } else {
            if(isset($guardianCountyPlaceholder2)){
                $guardianCounty2 = $guardianCountyPlaceholder2; ///< Set value to placeholder if left empty
            }
        }
    
        if(empty($_POST["guardianPostcode2"])){
            if(isset($guardianPostcodePlaceholder2)){
                $guardianPostcode2 = $guardianPostcodePlaceholder2; ///< Set value to placeholder if left empty
            }
    
        } else {
            $guardianPostcode2 = test_input($_POST["guardianPostcode2"]); ///< Sanitize postcode of guardian 2
            if ((strlen($guardianPostcode2)<6) || (strlen($guardianPostcode2) > 8)){
                $guardianPostcode2Err = "Postcode must be 6 characters long!"; ///< Display error message
            }
        }
    }
  

    /// Doctor Details Validation

    /// Validate name
    if (empty($_POST["doctorName"])) {
        $doctorName = $doctorFirstNamePlaceholder . ' ' . $doctorLastNamePlaceholder; ///< Set value to placeholder if left empty

        $doctorNameParts = explode(" ", $doctorName); ///< Split name into first and last name

        /// Extract the first and last names
        $doctorFirstName = $doctorNameParts[0];
        $doctorLastName = end($doctorNameParts);
    } else {
        $doctorName = test_input($_POST["doctorName"]); ///< Sanitize doctor's name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $doctorName)) {
            $doctorNameErr = "Only letters and white space allowed";  ///< Display error message
        }

        $doctorNameParts = explode(" ", $doctorName); ///< Split name into first and last name

        /// Extract the first and last names
        $doctorFirstName = $doctorNameParts[0];
        $doctorLastName = end($doctorNameParts);
    }

    if(empty($_POST["doctorContact"])){
        $doctorContact = $doctorContactPlaceholder; ///< Set value to placeholder if left empty

    } else {
        $doctorContact = test_input($_POST["doctorContact"]); ///< Sanitize doctor's contact number
        if (!preg_match("/^\d+$/", $doctorContact)) {
            $doctorContactErr = "Only digits allowed";  ///< Display error message
        }
    }

    

    /// If there are no errors, proceed with sql querries
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($websiteErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($healthIssuesErr) && empty($profileImageErr) 
        && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
        && empty($guardianNameErr) && empty($guardianContactErr) && empty($relationshipErr) 
        && empty($guardianAddress11Err) && empty($guardianAddress12Err) && empty($guardianCity1Err) && empty($guardianCounty1Err) && empty($guardianPostcode1Err)
        && empty($guardianAddress21Err) && empty($guardianAddress22Err) && empty($guardianCity2Err) && empty($guardianCounty2Err) && empty($guardianPostcode2Err)
        && empty($guardianName2Err) && empty($guardianContact2Err) && empty($relationship2Err)  
        && empty($doctorNameErr) && empty($doctorContactErr) && empty ($genuineErr)) {

        $conn = Connection::connect(); ///< Connect to database

        /**
         * Initialize variables for guardian addresses and IDs.
         */

        $guardian1AddressId = $guardian2AddressId = $guardian2AddressId = $guardianId = $guardianId2 = "";

        /**
         * Check if a junior user already exists in the database based on the provided parameters.
         */
        $existingUser = Junior::juniorExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo);

        /**
         * Check if an address already exists in the database.
         */
        $existingAddress = Address::addressExists($address1, $address2, $city, $county, $postcode);

        /**
         * Checks if the address for guardian 1 exists in the database. If it does not exist, a new address is created.
         * Then, checks if the guardian with the given details exists in the database, retrieve the ID of that guardian.
         * If the guardian does not exist, a new guardian is created with the provided details.
         */
        $guardian1Address = Address::addressExists($guardianAddress11, $guardianAddress12, $guardianCity1, $guardianCounty1, $guardianPostcode1);
        
        if (!$guardian1Address) {
            /// Create guardian address if it doesn't exist
            $guardian1AddressId = Address::createNewAddress($guardianAddress11, $guardianAddress12, $guardianCity1, $guardianCounty1, $guardianPostcode1);
        } else {
            /// Use the existing guardian address ID
            $guardian1AddressId = $guardian1Address;
        }

        $existingGuardian = Guardian::guardianExists($guardianFirstName, $guardianLastName, $guardianContact);
        
        if ($existingGuardian) {
            $guardianId = $existingGuardian["guardian_id"];
        } else {
            $guardianId = Guardian::createGuardian($guardian1AddressId, $guardianFirstName, $guardianLastName, $guardianContact, $relationship);
        }

        /// Same as above but for guardian 2
        
        if ($_POST['elementForVar1HiddenField'] == 1) {

            $guardian2Address = Address::addressExists($guardianAddress21, $guardianAddress22, $guardianCity2, $guardianCounty2, $guardianPostcode2);
    
            if (!$guardian2Address) {
                /// Create guardian address if it doesn't exist
                $guardian2AddressId = Address::createNewAddress($guardianAddress21, $guardianAddress22, $guardianCity2, $guardianCounty2, $guardianPostcode2);
            } else {
                $guardian2AddressId = $guardian2Address;
            }

            $existingGuardian2 = Guardian::guardianExists($guardianFirstName2, $guardianLastName2, $guardianContact2);
            
            if ($existingGuardian2) {
                $guardianId2 = $existingGuardian2['guardian_id'];
            } else {

                $guardianId2 = Guardian::createGuardian($guardian2AddressId, $guardianFirstName2, $guardianLastName2, $guardianContact2, $relationship2);

            }
        }
        



        /**
         * Checks if an existing address exists based on the provided address details. 
         * If the address exists, retrieves the address ID; otherwise, creates a new address and retrieves the address ID.
         *  
         */ 
        if($existingAddress){
            $addressId = Address::getExistingAddress($address1, $address2, $city, $county, $postcode);
        }

        else{

            $addressId = Address::createNewAddress($address1, $address2, $city, $county, $postcode);

        }

        /**
         * Checks if an existing doctor exists based on the provided doctor details. 
         * If the doctor exists, retrieves the doctor ID; otherwise, creates a new doctor and retrieves the doctor ID.
         * 
         */

        $existingDoctor = Doctor::doctorExists($doctorFirstName, $doctorLastName, $doctorContact);

        if($existingDoctor){

            $doctorId = Doctor::existingDoctorId($doctorFirstName, $doctorLastName, $doctorContact);
        }

        else{

            $doctorId = Doctor::createNewDoctor($doctorFirstName, $doctorLastName, $doctorContact);
        }

        

        if(empty($genuineErr)){

            /**
             * Handles the upload of a profile image file.
             *
             * This function checks if a profile image file has been uploaded, validates its format and size,
             * and moves the file to the designated directory if it meets the criteria.
             *
             */
            if (!empty($_FILES["profileImage"]["name"])) {
                $filename = $_FILES["profileImage"]["name"];
                $filetype = Utils::getFileExtension($filename);
                $isValidImage = in_array($filetype, ["jpg", "jpeg", "png", "gif"]);
            
                $isValidSize = $_FILES["profileImage"]["size"] <= 1000000;
            
                if (!$isValidImage || !$isValidSize) {
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: Invalid file size/format</p>";
                }
            
                $tmpname = $_FILES["profileImage"]["tmp_name"];
            
                if (!move_uploaded_file($tmpname, "images/$filename")) {
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: File was not uploaded</p>";
                }
            } else {
                $filename = $filenamePlaceholder; /// Okay this is very funny, this line of code works here as well but not in member.

                
                /// PS: The issue was that instead of getting the filename from '$member' I was getting it from '$player' which didnt exist.
                /// Fixed it by swapping '$player' with '$member'
            }


            /**
             * Update the details of a junior with the provided information.
             */
            Junior::updateJunior($addressId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId);

            Junior::updateJuniorAssociation($guardianId, $doctorId, $juniorId);


            /// Update guardian 2 if picked
            if ($_POST['elementForVar1HiddenField'] == 1) {

                Junior::updateJuniorAssociation($guardianId2, $doctorId, $juniorId);

                
            }

            header("Location: " . Utils::$projectFilePath . "/junior-list.php"); ///< Redirect back to junior list
        }

    }

    else{
        $genuineErr = "ERROR: Not all form inputs filled/correct!"; 
    }
}

/**
 * 
 * Sanitizes input data to prevent SQL injection and cross-siste scripting (XSS) attacks.
 * 
 * @param data - Input data to be sanitized
 * @return data - String containing sanitized input data.
 * 
 */

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
components::pageHeader("Add Player", ["style"], ["mobile-nav"]);
?>

<main class="content-wrapper contact-content">

<h2>Add New Player</h2>
<form 
    method="POST"
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $junior["junior_id"];?>"
    enctype="multipart/form-data">

  <p class="alert alert-danger"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label  class="col-sm-2 col-form-label-sm" for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $playerFirstName. ' '. $playerLastName?>" value="<?php echo $name;?>">
      <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="sru">SRU Number:</label><br>
      <input type="text" name="sru" placeholder="<?php echo $sruNumberPlaceholder;?>" value="<?php echo $sru;?>">
      <p class="alert alert-danger"><?php echo $sruErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="dob">Date of Birth:</label><br>
      <input type="text" name="dob" placeholder="<?php echo $ukDobPlaceholder;?>" value="<?php echo $dob;?>">
      <p class="alert alert-danger"><?php echo $dobErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="email">Email:</label><br>
      <input type="text" name="email" placeholder="<?php echo $emailAddressPlaceholder;?>" value="<?php echo $email;?>">
      <p class="alert alert-danger"><?php echo $emailErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="contactNo">Contact Number:</label><br>
      <input type="text" name="contactNo" placeholder="<?php echo $contactNumberPlaceholder;?>" value="<?php echo $contactNo;?>">
      <p class="alert alert-danger"><?php echo $contactNoErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" placeholder="<?php echo $mobileNumberPlaceholder;?>" value="<?php echo $mobileNo;?>">
      <p class="alert alert-danger"><?php echo $mobileNoErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="healthIssues">Health Issues:</label><br>
      <input type="text" name="healthIssues" placeholder="<?php echo $healthIssuesPlaceholder;?>" value="<?php echo $healthIssues;?>">
      <p class="alert alert-danger"><?php echo $healthIssuesErr;?></p><br>

      <label>Profile image</label>
      <input type="file" name="profileImage" value="">
      <p class="alert alert-danger"><?php echo $profileImageErr;?></p><br>


      <input type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form" class="add-form-section">
    <label  class="col-sm-2 col-form-label-sm"for="address1">Address Line 1:</label><br>
        <input type="text" name="address1"  placeholder="<?php echo $address1Placeholder;?>" value="<?php echo $address1;?>">
        <p class="alert alert-danger"><?php echo $address1Err;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="address2">Address Line 2:</label><br>
        <input type="text" name="address2"  placeholder="<?php echo $address2Placeholder;?>" value="<?php echo $address2;?>">
        <p class="alert alert-danger"><?php echo $address2Err;?></p><br>   

    <label  class="col-sm-2 col-form-label-sm"for="city">City:</label><br>
        <input type="text" name="city"  placeholder="<?php echo $cityPlaceholder;?>" value="<?php echo $city;?>">
        <p class="alert alert-danger"><?php echo $cityErr;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="county">County:</label><br>
        <input type="text" name="county"  placeholder="<?php echo $countyPlaceholder;?>" value="<?php echo $county;?>">
        <p class="alert alert-danger"><?php echo $countyErr;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="postcode">Postcode:</label><br>
        <input type="text" name="postcode"  placeholder="<?php echo $postcodePlaceholder;?>" value="<?php echo $postcode;?>">
        <p class="alert alert-danger"><?php echo $postcodeErr;?></p><br>  
        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>

 </div>

 <div id="guardian-details-form" class="add-form-section">

    <div class="radio-container">
        <label class="radio" >One
        <input type="radio" id="radio-one" checked="checked" name="radio" onclick="radioChecked()">
        <span class="checkmark"></span>
        </label>
        <label class="radio" >Two
        <input type="radio" id="radio-two" name="radio" onclick="radioChecked()">
        <span class="checkmark"></span>
        </label>
    </div>
    
    <label  class="col-sm-2 col-form-label-sm"for="guardianName">Guardian's name:</label><br>
        <input type="text" name="guardianName" value="<?php echo $guardianName;?>">
        <p class="alert alert-danger"><?php echo $guardianNameErr;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="guardianContact">Contact Number:</label><br>
        <input type="text" name="guardianContact" value="<?php echo $guardianContact;?>">
        <p class="alert alert-danger"><?php echo $guardianContactErr;?></p><br>   

    <label  class="col-sm-2 col-form-label-sm"for="relationship">Relationship:</label><br>
        <input type="text" name="relationship" value="<?php echo $relationship;?>">
        <p class="alert alert-danger"><?php echo $relationshipErr;?></p><br>  
        
    
    <label  class="col-sm-2 col-form-label-sm"for="guardianAddress11">Address Line 1:</label><br>
        <input type="text" name="guardianAddress11" value="<?php echo $guardianAddress11;?>">
        <p class="alert alert-danger"><?php echo $guardianAddress11Err;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="guardianAddress12">Address Line 2:</label><br>
        <input type="text" name="guardianAddress12" value="<?php echo $guardianAddress12;?>">
        <p class="alert alert-danger"><?php echo $guardianAddress12Err;?></p><br>   

    <label  class="col-sm-2 col-form-label-sm"for="guardianCity1">City:</label><br>
        <input type="text" name="guardianCity1" value="<?php echo $guardianCity1;?>">
        <p class="alert alert-danger"><?php echo $guardianCity1Err;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="guardianCounty1">County:</label><br>
        <input type="text" name="guardianCounty1" value="<?php echo $guardianCounty1;?>">
        <p class="alert alert-danger"><?php echo $guardianCounty1Err;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="guardianPostcode1">Postcode:</label><br>
        <input type="text" name="guardianPostcode1" value="<?php echo $guardianPostcode1;?>">
        <p class="alert alert-danger"><?php echo $guardianPostcode1Err;?></p><br>  

        <div id="second-guardian-form">
            <input type="hidden" id="elementForVar1HiddenField" name="elementForVar1HiddenField" value="0" />
            <label  class="col-sm-2 col-form-label-sm"for="guardianName">Guardian's name:</label><br>
            <input type="text" name="guardianName2" value="<?php echo $guardianName2;?>">
            <p class="alert alert-danger"><?php echo $guardianName2Err;?></p><br>

        <label  class="col-sm-2 col-form-label-sm"for="guardianContact">Contact Number:</label><br>
            <input type="text" name="guardianContact2" value="<?php echo $guardianContact2;?>">
            <p class="alert alert-danger"><?php echo $guardianContact2Err;?></p><br>   

        <label  class="col-sm-2 col-form-label-sm"for="relationship2">Relationship:</label><br>
            <input type="text" name="relationship2" value="<?php echo $relationship2;?>">
            <p class="alert alert-danger"><?php echo $relationship2Err;?></p><br>
            
        <label  class="col-sm-2 col-form-label-sm"for="guardianAddress21">Address Line 1:</label><br>
            <input type="text" name="guardianAddress21" value="<?php echo $guardianAddress21;?>">
            <p class="alert alert-danger"><?php echo $guardianAddress21Err;?></p><br>

        <label  class="col-sm-2 col-form-label-sm"for="guardianAddress22">Address Line 2:</label><br>
            <input type="text" name="guardianAddress22" value="<?php echo $guardianAddress22;?>">
            <p class="alert alert-danger"><?php echo $guardianAddress22Err;?></p><br>   

        <label  class="col-sm-2 col-form-label-sm"for="guardianCity2">City:</label><br>
            <input type="text" name="guardianCity2" value="<?php echo $guardianCity2;?>">
            <p class="alert alert-danger"><?php echo $guardianCity2Err;?></p><br>  

        <label  class="col-sm-2 col-form-label-sm"for="guardianCounty2">County:</label><br>
            <input type="text" name="guardianCounty2" value="<?php echo $guardianCounty2;?>">
            <p class="alert alert-danger"><?php echo $guardianCounty2Err;?></p><br>  

        <label  class="col-sm-2 col-form-label-sm"for="guardianPostcode2">Postcode:</label><br>
            <input type="text" name="guardianPostcode2" value="<?php echo $guardianPostcode2;?>">
            <p class="alert alert-danger"><?php echo $guardianPostcode2Err;?></p><br>  
        </div>

        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>


 </div>

 <div id="doctor-details-form">
    <label  class="col-sm-2 col-form-label-sm"for="doctorName">Doctor Name:</label><br>
        <input type="text" name="doctorName" value="<?php echo $doctorName;?>">
        <p class="alert alert-danger"><?php echo $doctorNameErr;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="doctorContact">Contact Number:</label><br>
        <input type="text" name="doctorContact" value="<?php echo $doctorContact;?>">
        <p class="alert alert-danger"><?php echo $doctorContactErr;?></p><br>   
        <input type="button" value="Previous" onclick="prevTab()">
 </div>

  <input type="submit" name="submit" value="Submit">  

</form>

<script>

    var currentTab = 0;
    const pDetails = document.getElementById("personal-details-form");
    const aDetails = document.getElementById("address-details-form");
    const gDetails = document.getElementById("guardian-details-form");
    const dDetails = document.getElementById("doctor-details-form");

    const sGuardDetails = document.getElementById("second-guardian-form");

/**
 * Function to handle radio button checked event and update form elements accordingly.
 */
    function radioChecked(){
        if (document.getElementById("radio-two").checked){
            sGuardDetails.style.display = "block";
            document.getElementById('elementForVar1HiddenField').value = 1;

        }

        else{
            sGuardDetails.style.display = "none";
            document.getElementById('elementForVar1HiddenField').value = 0;

        }
    }

    radioChecked();



    /**
     * Show the tab based on the currentTab value.
     * Display the corresponding details section based on the currentTab value.
     */
    function showTab(){
        if ( currentTab == 0){
            pDetails.style.display = "block";
            aDetails.style.display = "none";
            gDetails.style.display = "none";
            dDetails.style.display = "none";

        }

        else if (currentTab == 1){
            pDetails.style.display = "none";
            aDetails.style.display = "block";
            gDetails.style.display = "none";
            dDetails.style.display = "none";

        }

        else if (currentTab == 2) {
            pDetails.style.display = "none";
            aDetails.style.display = "none";
            gDetails.style.display = "block";
            dDetails.style.display = "none";

        }

        else{
            pDetails.style.display = "none";
            aDetails.style.display = "none";
            gDetails.style.display = "none";
            dDetails.style.display = "block";



        }
    }

    showTab();

    /**
     * Function to navigate to the next tab by incrementing the current tab index and displaying the tab.
     */
    function nextTab(){
        currentTab += 1;
        showTab();
    }

    function prevTab(){
        currentTab -= 1;
        showTab();
    }


</script>
</main>

<?php
components::pageFooter();
?>