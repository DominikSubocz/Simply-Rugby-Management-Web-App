<?php

/// This must come first when we need access to the current session
session_start(); 
require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");
require_once("classes/connection.php");
require("classes/junior.php");
require("classes/address.php");
require("classes/guardian.php");
require("classes/doctor.php");

/// Redirect to logout page if user role is neither Admin nor Coach
if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

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
 * Validates the form inputs and processes the data accordingly.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required"; ///< Display error message
    } else {
        $name = test_input($_POST["name"]);
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
        $emailErr = "Email is required"; ///< Display error message
    } else {
        $email = test_input($_POST["email"]); ///< Sanitize email address
        /// Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format"; ///< Display error message
        }
    }

    /// Validate SRU number
    if (empty($_POST["sru"])){
        $sruErr = "SRU Number is required"; ///< Display error message
    } else {
        $sru = test_input($_POST["sru"]); ///< Sanitize sru number
        if (!preg_match("/^\d+$/", $sru)) {
            $sruErr = "Only digits allowed";
        }
    }

    /// Validate date of birth
    if (empty($_POST["dob"])){
        $dobErr = "Date of birth is required";  ///< Display error message
    } else {
        $dob = test_input($_POST["dob"]);  ///< Sanitize date of birth
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY";
        }

        $dateTime = DateTime::createFromFormat('d/m/Y', $dob); ///< Create DateTime object from date of birth
        $sqlDate = $dateTime->format('Y-m-d'); ///< Format date of birth to YYYY-MM-DD
    }

    /// Validate contact number
    if(empty($_POST["contactNo"])){
        $contactNoErr = "Contact Number is required"; ///< Display error message
    } else {
        $contactNo = test_input($_POST["contactNo"]);  ///< Sanitize contact number
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed"; ///< Display error message
        }
    }

    /// Validate address line 1
    if(empty($_POST["address1"])){
        $address1Err = "Address Line 1 is required"; ///< Display error message
    } else {
        $address1 = test_input($_POST["address1"]);  ///< Sanitize address line 1
        if ((strlen($address1)<10) || (strlen($address1) > 50)){
            $address1Err = "Address Line 1 must be between 10 and 50 characters long!"; ///< Display error message
        }
    }

    /// Validate city
    if(empty($_POST["city"])){
        $cityErr = "City is required"; ///< Display error message
    } else {
        $city = test_input($_POST["city"]);  ///< Sanitize city
        if ((strlen($city)<5) || (strlen($city) > 50)){
            $cityErr = "City must be between 5 and 50 characters long!"; ///< Display error message
        }
    }

    /// Validate postcode
    if(empty($_POST["postcode"])){
        $postcodeErr = "Postcode is required"; ///< Display error message
    } else {
        $postcode = test_input($_POST["postcode"]);  ///< Sanitize postcode
        if ((strlen($postcode)<6) || (strlen($postcode) > 8)){
            $postcodeErr = "Postcode must be between 6 and 8 characters long!"; ///< Display error message
        }
    }

    /// Validate guardian's name
    if (empty($_POST["guardianName"])) {
        $guardianNameErr = "Guardian's name is required"; ///< Display error message
    } else {
        $guardianName = test_input($_POST["guardianName"]);   ///< Sanitize guardian's name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $guardianName)) {
            $guardianNameErr = "Only letters and white space allowed"; ///< Display error message
        }

        $guardianNameParts = explode(" ", $guardianName); ///< Split name into first and last name

        /// Extract the first and last names
        $guardianFirstName = $guardianNameParts[0];
        $guardianLastName = end($guardianNameParts);
    }

    /// Validate guardian's contact number
    if(empty($_POST["guardianContact"])){
        $guardianContactErr = "Contact Number is required"; ///< Display error messages
    } else {
        $guardianContact = test_input($_POST["guardianContact"]);  ///< Sanitize guardian's contact number
        if (!preg_match("/^\d+$/", $guardianContact)) {
            $guardianContactErr = "Only digits allowed"; ///< Display error message
        }
    }

    /// Validate guardian's relationship
    if(empty($_POST["relationship"])){
        $relationshipErr = "Relationship is required"; ///< Display error message
    } else{
        $relationship = test_input($_POST["relationship"]);  ///< Sanitize relationship
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship)) {
            $relationshipErr = "Only letters and white space allowed"; ///< Display error message
        }
    }

    /// Validate guardian's address line 1
    if(empty($_POST["guardianAddress11"])){
        $guardianAddress11Err = "Address Line 1 is required"; ///< Display error message
    } else {
        $guardianAddress11 = test_input($_POST["guardianAddress11"]);  ///< Sanitize guardian's address line 1
        if ((strlen($guardianAddress11)<10) || (strlen($guardianAddress11) > 50)){
            $guardianAddress11Err = "Address Line 1 must be between 10 and 50 characters long!"; ///< Display error message
        }
    }

    /// Validate guardian's city
    if(empty($_POST["guardianCity1"])){
        $guardianCity1Err = "City is required"; ///< Display error message
    } else {
        $guardianCity1 = test_input($_POST["guardianCity1"]);  ///< Sanitize guardian's city
        if ((strlen($guardianCity1)<5) || (strlen($guardianCity1) > 50)){
            $guardianCity1Err = "City must be between 5 and 50 characters long!"; ///< Display error message
        }
    }

    /// Validate guardian's postcode
    if(empty($_POST["guardianPostcode1"])){
        $guardianPostcode1Err = "Postcode is required"; ///< Display error message
    } else {
        $guardianPostcode1 = test_input($_POST["guardianPostcode1"]);  ///< Sanitize guardian's postcode
        if ((strlen($guardianPostcode1)<6) || (strlen($guardianPostcode1) > 8)){
            $guardianPostcode1Err = "Postcode must be 6 characters long!"; ///< Display error message
        }
    }

    /// Check if secondary guardian details are provided
    if($_POST['elementForVar1HiddenField'] == 1){
        /// Validate secondary guardian's name
        if(empty($_POST["guardianName2"])){
            $guardianName2Err =  "Guardian's name is required"; ///< Display error message
        } else {
            $guardianName2 = test_input($_POST["guardianName2"]);  ///< Sanitize guardian's name
            /// Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $guardianName2)) {
                $guardianName2Err = "Only letters and white space allowed"; ///< Display error message
            }

            $guardianNameParts2 = explode(" ", $guardianName2); ///< Split name into first and last name

            /// Extract the first and last names
            $guardianFirstName2 = $guardianNameParts2[0];
            $guardianLastName2 = end($guardianNameParts2);
        }

        /// Validate secondary guardian's contact number
        if(empty($_POST["guardianContact2"])){
            $guardianContact2Err = "Contact Number is required"; ///< Display error message
        } else {
            $guardianContact2 = test_input($_POST["guardianContact2"]);  ///< Sanitize guardian's contact number
            if (!preg_match("/^\d+$/", $guardianContact2)) {
                $guardianContact2Err = "Only digits allowed"; ///< Display error message
            }
        }

        /// Validate secondary guardian's relationship
        if(empty($_POST["relationship2"])){
            $relationship2Err = "Relationship is required"; ///< Display error message
        } else{
            $relationship2 = test_input($_POST["relationship2"]);  ///< Sanitize relationship
            /// Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship2)) {
                $relationship2Err = "Only letters and white space allowed"; ///< Display error message
            }
        }

        /// Validate secondary guardian's address line 1
        if(empty($_POST["guardianAddress21"])){
            $guardianAddress21Err = "Address Line 1 is required"; ///< Display error message
        } else {
            $guardianAddress21 = test_input($_POST["guardianAddress21"]);  ///< Sanitize guardian's address line 1
            if ((strlen($guardianAddress21)<10) || (strlen($guardianAddress21) > 50)){
                $guardianAddress21Err = "Address Line 1 must be between 10 and 50 characters long!"; ///< Display error message
            }
        }

        /// Validate secondary guardian's city
        if(empty($_POST["guardianCity2"])){
            $guardianCity2Err = "City is required"; ///< Display error message
        } else {
            $guardianCity2 = test_input($_POST["guardianCity2"]);  ///< Sanitize guardian's city
            if ((strlen($guardianCity2)<5) || (strlen($guardianCity2) > 50)){
                $guardianCity2Err = "City must be between 5 and 50 characters long!"; ///< Display error message
            }
        }

        /// Validate secondary guardian's postcode
        if(empty($_POST["guardianPostcode2"])){
            $guardianPostcode2Err = "Postcode is required"; ///< Display error message
        } else {
            $guardianPostcode2 = test_input($_POST["guardianPostcode2"]);  ///< Sanitize guardian's postcode
            if ((strlen($guardianPostcode2)<6) || (strlen($guardianPostcode2) > 8)){
                $guardianPostcode2Err = "Postcode must be 6 characters long!"; ///< Display error message
            }
        }
    }

    /// Validate doctor's name
    if (empty($_POST["doctorName"])) {
        $doctorNameErr = "Doctor's name is required"; ///< Display error message
    } else {
        $doctorName = test_input($_POST["doctorName"]);  ///< Sanitize doctor's name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $doctorName)) {
            $doctorNameErr = "Only letters and white space allowed"; ///< Display error message
        }

        $doctorNameParts = explode(" ", $doctorName); ///< Split name into first and last name

        /// Extract the first and last names
        $doctorFirstName = $doctorNameParts[0];
        $doctorLastName = end($doctorNameParts);
    }

    /// Validate doctor's contact number
    if(empty($_POST["doctorContact"])){
        $doctorContactErr = "Contact Number is required"; ///< Display error message
    } else {
        $doctorContact = test_input($_POST["doctorContact"]);  ///< Sanitize doctor's contact number
        if (!preg_match("/^\d+$/", $doctorContact)) {
            $doctorContactErr = "Only digits allowed"; ///< Display error message
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

        $guardian1AddressId = $guardian2AddressId = $guardian2AddressId = $guardianId = $guardianId2 = ""; ///< Empty for now, but will be set and passed as parameter to SQL querries
        
        $existingUser = Junior::juniorExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo); /// Check if junior exists

        /// If junior exists output error message
        if($existingUser){
            $genuineErr = "ERROR: Junior already exists!";
        }


        /**
         * Check if the address exists in the database based on the provided parameters.
         */
        $existingAddress = Address::addressExists($address1, $address2, $city, $county, $postcode);
        $guardian1Address = Address::addressExists($guardianAddress11, $guardianAddress12, $guardianCity1, $guardianCounty1, $guardianPostcode1);
        
        if (!$guardian1Address) {
            $guardian1AddressId = Address::createNewAddress($guardianAddress11, $guardianAddress12, $guardianCity1, $guardianCounty1, $guardianPostcode1);
        } else {
            $guardian1AddressId = $guardian1Address;
        }

        /**
         * Check if a guardian already exists based on first name, last name, and contact.
         */
        $existingGuardian = Guardian::guardianExists($guardianFirstName, $guardianLastName, $guardianContact);
        
        if ($existingGuardian) {
            $guardianId = $existingGuardian["guardian_id"];
        } else {
            $guardianId = Guardian::createGuardian($guardian1AddressId, $guardianFirstName, $guardianLastName, $guardianContact, $relationship);
        }

        /// Validation for second guardian if radio option 2 is selected.
        if ($_POST['elementForVar1HiddenField'] == 1) {

            /**
             * Check if the address already exists in the database. 
             */
            $guardian2Address = Address::addressExists($guardianAddress21, $guardianAddress22, $guardianCity2, $guardianCounty2, $guardianPostcode2);
    
            if (!$guardian2Address) {
                $guardian2AddressId = Address::createNewAddress($guardianAddress21, $guardianAddress22, $guardianCity2, $guardianCounty2, $guardianPostcode2);
            } else {
                $guardian2AddressId = $guardian2Address;
            }


            
            /**
             * Checks if a guardian with the given first name, last name, and contact number exists in the database. 
             */
            $existingGuardian2 = Guardian::guardianExists($guardianFirstName2, $guardianLastName2, $guardianContact2);
            
            if ($existingGuardian2) {
                $guardianId2 = $existingGuardian2['guardian_id'];
            } else {
                $guardianId2 = Guardian::createGuardian($guardian2AddressId, $guardianFirstName2, $guardianLastName2, $guardianContact2, $relationship2);

            }
        }
        

        


        /// Check if address exists. If not, create new address.
        if($existingAddress){
            $addressId = Address::getExistingAddress($address1, $address2, $city, $county, $postcode);
        }
        else{
            $addressId = Address::createNewAddress($address1, $address2, $city, $county, $postcode);

        }
        
        /**
         * Check if a doctor already exists based on first name, last name, and contact number.
         */
        $existingDoctor = Doctor::doctorExists($doctorFirstName, $doctorLastName, $doctorContact);
        
        if($existingDoctor){

            $doctorId = Doctor::existingDoctorId($doctorFirstName, $doctorLastName, $doctorContact);
        }
        else{
            $doctorId = Doctor::createNewDoctor($doctorFirstName, $doctorLastName, $doctorContact);
        
        }

        /// If genuine error like "not all field filled/correct" is empty
        if(empty($genuineErr)){

            /**
             * Handles the upload of a profile image file.
             */
            if (!empty($_FILES["profileImage"]["name"])) {
                $filename = $_FILES["profileImage"]["name"];
                $filetype = Utils::getFileExtension($filename);
                $isValidImage = in_array($filetype, ["jpg", "jpeg", "png", "gif"]); ///< Valid image formats
            
                $isValidSize = $_FILES["profileImage"]["size"] <= 1000000; ///< Max image size
            
                if (!$isValidImage || !$isValidSize) {
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: Invalid file size/format</p>";
                }
            
                $tmpname = $_FILES["profileImage"]["tmp_name"];
            
                if (!move_uploaded_file($tmpname, "images/$filename")) {
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: File was not uploaded</p>";
                }
            }
            /// Create a new junior junior 
            $juniorId = Junior::createNewJunior($addressId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename);


            /**
             * Create a new association between a junior, guardian, and doctor.
             */
            Junior::createAssociation($juniorId, $guardianId, $doctorId);

            /**
             * Check if the value of the hidden input is equal to 1.
             */
            if ($_POST['elementForVar1HiddenField'] == 1) {
                Junior::createAssociation($juniorId, $guardianId2, $doctorId);
            }
        }
        /// Redirect back to junior list to see changes
        header("Location: " . Utils::$projectFilePath . "/junior-list.php");


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

components::pageHeader("Add Junior Player", ["style"], ["mobile-nav"]);
?>

<main class="content-wrapper contact-content my-5">

<h2>Add New Junior Player</h2>

<div class="alert alert-info">
    <p><strong>NOTE: </strong> Fields marked with <span class="required">*</span> are mandatory.</p>
</div>

<form 
method="post" 
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
enctype="multipart/form-data">

  <p class="alert alert-danger"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label for="name"><span class="required">*</span>Name:</label><br>
      <input type="text" name="name" value="<?php echo $name;?>">
      <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

      <label for="sru"><span class="required">*</span>SRU Number:</label><br>
      <input type="text" name="sru" value="<?php echo $sru;?>">
      <p class="alert alert-danger"><?php echo $sruErr;?></p><br>

      <label for="dob"><span class="required">*</span>Date of Birth:</label><br>
      <input type="text" name="dob" value="<?php echo $dob;?>">
      <p class="alert alert-danger"><?php echo $dobErr;?></p><br>

      <label for="email"><span class="required">*</span>Email:</label><br>
      <input type="text" name="email" value="<?php echo $email;?>">
      <p class="alert alert-danger"><?php echo $emailErr;?></p><br>

      <label for="contactNo"><span class="required">*</span>Contact Number:</label><br>
      <input type="text" name="contactNo" value="<?php echo $contactNo;?>">
      <p class="alert alert-danger"><?php echo $contactNoErr;?></p><br>

      <label for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" value="<?php echo $mobileNo;?>">
      <p class="alert alert-danger"><?php echo $mobileNoErr;?></p><br>

      <label for="healthIssues">Health Issues:</label><br>
      <input type="text" name="healthIssues" value="<?php echo $healthIssues;?>">
      <p class="alert alert-danger"><?php echo $healthIssuesErr;?></p><br>

      <label><span class="required">*</span>Profile image</label>
      <input type="file" name="profileImage" value="">
      <p class="alert alert-danger"><?php echo $profileImageErr;?></p><br>


      <input class="btn btn-dark" type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form" class="add-form-section">
    <label for="address1"><span class="required">*</span>Address Line 1:</label><br>
        <input type="text" name="address1" value="<?php echo $address1;?>">
        <p class="alert alert-danger"><?php echo $address1Err;?></p><br>

    <label for="address2">Address Line 2:</label><br>
        <input type="text" name="address2" value="<?php echo $address2;?>">
        <p class="alert alert-danger"><?php echo $address2Err;?></p><br>   

    <label for="city"><span class="required">*</span>City:</label><br>
        <input type="text" name="city" value="<?php echo $city;?>">
        <p class="alert alert-danger"><?php echo $cityErr;?></p><br>  

    <label for="county">County:</label><br>
        <input type="text" name="county" value="<?php echo $county;?>">
        <p class="alert alert-danger"><?php echo $countyErr;?></p><br>  

    <label for="postcode"><span class="required">*</span>Postcode:</label><br>
        <input type="text" name="postcode" value="<?php echo $postcode;?>">
        <p class="alert alert-danger"><?php echo $postcodeErr;?></p><br>  
        <div>
            <input class="btn btn-dark" type="button" value="Previous" onclick="prevTab()">
            <input class="btn btn-dark" type="button" value="Next" onclick="nextTab()">
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
    
    <h2>Guardian 1 </h2>
    
    <label class="col-sm-2 col-form-label-sm" for="guardianName"><span class="required">*</span>Guardian's name:</label><br>
        <input type="text" name="guardianName" value="<?php echo $guardianName;?>">
        <p class="alert alert-danger"><?php echo $guardianNameErr;?></p><br>

    <label class="col-sm-2 col-form-label-sm" for="guardianContact"><span class="required">*</span>Contact Number:</label><br>
        <input type="text" name="guardianContact" value="<?php echo $guardianContact;?>">
        <p class="alert alert-danger"><?php echo $guardianContactErr;?></p><br>   

    <label class="col-sm-2 col-form-label-sm" for="relationship"><span class="required">*</span>Relationship:</label><br>
        <input type="text" name="relationship" value="<?php echo $relationship;?>">
        <p class="alert alert-danger"><?php echo $relationshipErr;?></p><br>  
        
    
    <label class="col-sm-2 col-form-label-sm" for="guardianAddress11"><span class="required">*</span>Address Line 1:</label><br>
        <input type="text" name="guardianAddress11" value="<?php echo $guardianAddress11;?>">
        <p class="alert alert-danger"><?php echo $guardianAddress11Err;?></p><br>

    <label class="col-sm-2 col-form-label-sm" for="guardianAddress12">Address Line 2:</label><br>
        <input type="text" name="guardianAddress12" value="<?php echo $guardianAddress12;?>">
        <p class="alert alert-danger"><?php echo $guardianAddress12Err;?></p><br>   

    <label class="col-sm-2 col-form-label-sm" for="guardianCity1"><span class="required">*</span>City:</label><br>
        <input type="text" name="guardianCity1" value="<?php echo $guardianCity1;?>">
        <p class="alert alert-danger"><?php echo $guardianCity1Err;?></p><br>  

    <label class="col-sm-2 col-form-label-sm" for="guardianCounty1">County:</label><br>
        <input type="text" name="guardianCounty1" value="<?php echo $guardianCounty1;?>">
        <p class="alert alert-danger"><?php echo $guardianCounty1Err;?></p><br>  

    <label class="col-sm-2 col-form-label-sm" for="guardianPostcode1"><span class="required">*</span>Postcode:</label><br>
        <input type="text" name="guardianPostcode1" value="<?php echo $guardianPostcode1;?>">
        <p class="alert alert-danger"><?php echo $guardianPostcode1Err;?></p><br>  

    <div id="second-guardian-form">

        <h2>Guardian 2 </h2>

        <input type="hidden" id="elementForVar1HiddenField" name="elementForVar1HiddenField" value="0" />
        <label  class="col-sm-2 col-form-label-sm"for="guardianName"><span class="required">*</span>Guardian's name:</label><br>
        <input type="text" name="guardianName2" value="<?php echo $guardianName2;?>">
        <p class="alert alert-danger"><?php echo $guardianName2Err;?></p><br>

        <label  class="col-sm-2 col-form-label-sm"for="guardianContact"><span class="required">*</span>Contact Number:</label><br>
            <input type="text" name="guardianContact2" value="<?php echo $guardianContact2;?>">
            <p class="alert alert-danger"><?php echo $guardianContact2Err;?></p><br>   

        <label class="col-sm-2 col-form-label-sm" for="relationship2"><span class="required">*</span>Relationship:</label><br>
            <input type="text" name="relationship2" value="<?php echo $relationship2;?>">
            <p class="alert alert-danger"><?php echo $relationship2Err;?></p><br>
            
        <label class="col-sm-2 col-form-label-sm" for="guardianAddress21"><span class="required">*</span>Address Line 1:</label><br>
            <input type="text" name="guardianAddress21" value="<?php echo $guardianAddress21;?>">
            <p class="alert alert-danger"><?php echo $guardianAddress21Err;?></p><br>

        <label class="col-sm-2 col-form-label-sm" for="guardianAddress22">Address Line 2:</label><br>
            <input type="text" name="guardianAddress22" value="<?php echo $guardianAddress22;?>">
            <p class="alert alert-danger"><?php echo $guardianAddress22Err;?></p><br>   

        <label class="col-sm-2 col-form-label-sm" for="guardianCity2"><span class="required">*</span>City:</label><br>
            <input type="text" name="guardianCity2" value="<?php echo $guardianCity2;?>">
            <p class="alert alert-danger"><?php echo $guardianCity2Err;?></p><br>  

        <label class="col-sm-2 col-form-label-sm" class="col-sm-2 col-form-label-sm" for="guardianCounty2">County:</label><br>
            <input type="text" name="guardianCounty2" value="<?php echo $guardianCounty2;?>">
            <p class="alert alert-danger"><?php echo $guardianCounty2Err;?></p><br>  

        <label class="col-sm-2 col-form-label-sm" for="guardianPostcode2"><span class="required">*</span>Postcode:</label><br>
            <input type="text" name="guardianPostcode2" value="<?php echo $guardianPostcode2;?>">
            <p class="alert alert-danger"><?php echo $guardianPostcode2Err;?></p><br>  
    </div>




        <div>
            <input class="btn btn-dark" type="button" value="Previous" onclick="prevTab()">
            <input class="btn btn-dark" type="button" value="Next" onclick="nextTab()">
        </div>


 </div>

 <div id="doctor-details-form">
    <label class="col-sm-2 col-form-label-sm" for="doctorName"><span class="required">*</span>Doctor Name:</label><br>
        <input type="text" name="doctorName" value="<?php echo $doctorName;?>">
        <p class="alert alert-danger"><?php echo $doctorNameErr;?></p><br>

    <label class="col-sm-2 col-form-label-sm" for="doctorContact"><span class="required">*</span>Contact Number:</label><br>
        <input type="text" name="doctorContact" value="<?php echo $doctorContact;?>">
        <p class="alert alert-danger"><?php echo $doctorContactErr;?></p><br>   
        <input class="btn btn-dark" type="button" value="Previous" onclick="prevTab()">

 </div>

 <input class="btn btn-dark" type="submit" onclick="return validateForm()" name="submit" value="Submit">  

</form>

<script>

    var currentTab = 0;
    const pDetails = document.getElementById("personal-details-form");
    const aDetails = document.getElementById("address-details-form");
    const gDetails = document.getElementById("guardian-details-form");
    const dDetails = document.getElementById("doctor-details-form");

    const sGuardDetails = document.getElementById("second-guardian-form");

    
    /**
     * Check if a radio button is checked and display or hide a specific element.
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
     * Increments the current tab index and displays next tab.
     */
    function nextTab(){
        currentTab += 1;
        showTab();
    }

    /**
     * Decrements the current tab index and displays previous tab.
     */

    function prevTab(){
        currentTab -= 1;
        showTab();
    }

    /**
     * Validates a form with multiple input fields.
     */
    function validateForm() {
        let hiddenInput = document.getElementById('elementForVar1HiddenField');
        let nameInput = document.forms[0]["name"].value.trim();
        let sruInput = document.forms[0]["sru"].value.trim();
        let dobInput = document.forms[0]["dob"].value.trim();
        let emailInput = document.forms[0]["email"].value.trim();
        let contactInput = document.forms[0]["contactNo"].value.trim();
        let pfpInput = document.forms[0]["profileImage"].value.trim();

        let addressInput = document.forms[0]["address1"].value.trim();
        let cityInput = document.forms[0]["city"].value.trim();
        let postcodeInput = document.forms[0]["postcode"].value.trim();

        let guardianName1Input = document.forms[0]["guardianName"].value.trim();
        let guardianContactInput = document.forms[0]["guardianContact"].value.trim();
        let guardianRelationshipInput = document.forms[0]["relationship"].value.trim();
        let guardianAddressInput = document.forms[0]["guardianAddress11"].value.trim();
        let guardianCityInput = document.forms[0]["guardianCity1"].value.trim();
        let guardianPostcodeInput = document.forms[0]["guardianPostcode1"].value.trim();

        let guardianName2Input = document.forms[0]["guardianName2"].value.trim();
        let guardianContact2Input = document.forms[0]["guardianContact2"].value.trim();
        let guardianRelationship2Input = document.forms[0]["relationship2"].value.trim();
        let guardianAddress2Input = document.forms[0]["guardianAddress21"].value.trim();
        let guardianCity2Input = document.forms[0]["guardianCity2"].value.trim();
        let guardianPostcode2Input = document.forms[0]["guardianPostcode2"].value.trim();

        let doctorNameInput = document.forms[0]["doctorName"].value.trim();
        let doctorContactInput = document.forms[0]["doctorContact"].value.trim();

        if (nameInput == "") {
            alert("Name must be filled out");
            return false;
        }

        if (sruInput == "") {
            alert("SRU number must be filled out");
            return false;
        }

        if (dobInput == "") {
            alert("Date of Birth must be filled out");
            return false;
        }

        if (emailInput == "") {
            alert("Email Address must be filled out");
            return false;
        }

        if (contactInput == "") {
            alert("Contact Number must be filled out");
            return false;
        }

        if (pfpInput == "") {
            alert("Profile picture must be selected.");
            return false;
        }

        if (addressInput == "") {
            alert("Address Line 1 must be filled out");
            return false;
        }

        if (cityInput == "") {
            alert("City must be filled out");
            return false;
        }

        if (postcodeInput == "") {
            alert("Postcode must be selected.");
            return false;
        }

        if (guardianName1Input == "") {
                alert("Full name of Guardian 1 must be filled out");
                return false;
            }

        if (guardianContactInput == "") {
                alert("Contact number of Guardian 1 number must be filled out");
                return false;
        }

        if (guardianRelationshipInput == "") {
                alert("Relationship of Guardian 1 must be filled out");
                return false;
        }

        if (guardianAddressInput == "") {
            alert("Address Line of Guardian 1 must be filled out");
            return false;
        }

        if (guardianCityInput == "") {
                alert("City of Guardian 1 must be filled out");
                return false;
        }

        if (guardianPostcodeInput == "") {
                alert("Postcode of Guardian 1 must be filled out");
                return false;
        }


        if(hiddenInput.value == 1){
            if (guardianName2Input == "") {
                alert("Full Name of Guardian 2 must be filled out");
                return false;
            }

            if (guardianContact2Input == "") {
                    alert("Contact number of Guardian 2 must be filled out");
                    return false;
            }

            if (guardianRelationship2Input == "") {
                    alert("Relationship of Guardian 2 must be filled out");
                    return false;
            }

            if (guardianAddress2Input == "") {
                alert("Address Line of Guardian 2 must be filled out");
                return false;
            }

            if (guardianCity2Input == "") {
                    alert("City of Guardian 2 must be filled out");
                    return false;
            }

            if (guardianPostcode2Input == "") {
                    alert("Postcode of Guardian 2 must be filled out");
                    return false;
            }
        } 

        if (doctorNameInput == "") {
            alert("Doctor's full name must be filled out");
            return false;
        }

        if (doctorContactInput == "") {
            alert("Doctor's contact number must be selected.");
            return false;
        }
    }

</script>
</main>

<?php
components::pageFooter();
?>