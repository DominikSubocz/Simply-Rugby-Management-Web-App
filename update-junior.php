<?php
session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/guardian.php");
require("classes/doctor.php");
require("classes/address.php");
require("classes/junior.php");


$conn = Connection::connect();

$juniorId = $_GET["id"];

$junior = Junior::getJunior($juniorId);

$playerFirstName = Utils::escape($junior["first_name"]);
$playerLastName = Utils::escape($junior["last_name"]);

$dobPlaceholder = Utils::escape($junior["dob"]);
$user_idPlaceholder = Utils::escape($junior["user_id"]); // Might implement update for that later
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

$guardians = Guardian::getGuardian($juniorId);

if (count($guardians) >= 1) {

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







$phpdate = strtotime( $dobPlaceholder );
$ukDobPlaceholder = date( 'd/m/Y', $phpdate );

// Define variables and initialize them
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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $name = $playerFirstName . ' ' . $playerLastName;

        $nameParts = explode(" ", $name);

        // Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
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
        $email = $emailAddressPlaceholder;
    } else {
        $email = test_input($_POST["email"]);
        // Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["sru"])){
        $sru = $sruNumberPlaceholder;


    } else {
        $sru = test_input($_POST["sru"]);
        if (!preg_match("/^\d+$/", $sru)) {
            $sruErr = "Only digits allowed";
        }
    }

    if (empty($_POST["dob"])){
        $dob = date('d/m/Y', strtotime($dobPlaceholder));;

        $sqlDate = date('Y-m-d', strtotime($dob));


    } else {
        $dob = test_input($_POST["dob"]);
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY";
        }

        $sqlDate = date('Y-m-d', strtotime($dob));

    }

    if(empty($_POST["contactNo"])){
        $contactNo = $contactNumberPlaceholder;

    } else {
        $contactNo = test_input($_POST["contactNo"]);
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed";
        }
    }

    if(empty($_POST["address1"])){
        $address1 = $address1Placeholder;

    } else {
        $address1 = test_input($_POST["address1"]);
        if ((strlen($address1)<10) || (strlen($address1) > 50)){
            $address1Err = "Address Line 1 must be between 10 and 50 characters long!";
        }
    }

    if(!empty($_POST["address2"])){
        $address2 = test_input($_POST["address2"]);
    } else {
        $address2 = $address2Placeholder;

    }

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]);
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed";
        }
    } else {
        $mobileNo = $mobileNumberPlaceholder;
    }

    if(empty($_POST["city"])){
        $city = $cityPlaceholder;

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
    } else {
        $county = $countyPlaceholder;
    }

    if(empty($_POST["postcode"])){
        $postcode = $postcodePlaceholder;

    } else {
        $postcode = test_input($_POST["postcode"]);
        if ((strlen($postcode)<6) || (strlen($postcode) > 8)){
            $postcodeErr = "Postcode must be 6 characters long!";
        }
    }


 


    // Guardian Contact Details

    if (empty($_POST["guardianName"])) {
        $guardianName = $guardianFirstNamePlaceholder1 . ' ' . $guardianLastNamePlaceholder1;

        $guardianNameParts = explode(" ", $guardianName);

        // Extract the first and last names
        $guardianFirstName = $guardianNameParts[0];
        $guardianLastName = end($guardianNameParts);
    } else {
        $guardianName = test_input($_POST["guardianName"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $guardianName)) {
            $guardianNameErr = "Only letters and white space allowed";
        }

        $guardianNameParts = explode(" ", $guardianName);

        // Extract the first and last names
        $guardianFirstName = $guardianNameParts[0];
        $guardianLastName = end($guardianNameParts);
    }

    if(empty($_POST["guardianContact"])){
        $guardianContact = $guardianContactPlaceholder1;

    } else {
        $guardianContact = test_input($_POST["guardianContact"]);
        if (!preg_match("/^\d+$/", $guardianContact)) {
            $guardianContactErr = "Only digits allowed";
        }
    }

    if(empty($_POST["relationship"])){
        $relationship = $guardianRelationshipPlaceholder1;
    } else{
        $relationship = test_input($_POST["relationship"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship)) {
            $relationshipErr = "Only letters and white space allowed";
        }
    }


    if(empty($_POST["guardianAddress11"])){
        $guardianAddress11 = $guardianAddress1Placeholder1;

    } else {
        $guardianAddress11 = test_input($_POST["guardianAddress11"]);
        if ((strlen($guardianAddress11)<10) || (strlen($guardianAddress11) > 50)){
            $guardianAddress11Err = "Address Line 1 must be between 10 and 50 characters long!";
        }
    }

    if(!empty($_POST["guardianAddress12"])){
        $guardianAddress12 = test_input($_POST["guardianAddress12"]);
    } else {
        $guardianAddress12 = $guardianAddress2Placeholder1;
    }

    if(empty($_POST["guardianCity1"])){
        $guardianCity1 = $guardianCityPlaceholder1;

    } else {
        $guardianCity1 = test_input($_POST["guardianCity1"]);
        if ((strlen($guardianCity1)<5) || (strlen($guardianCity1) > 50)){
            $guardianCity1Err = "City must be between 10 and 50 characters long!";
        }
    }

    if(!empty($_POST["guardianCounty1"])){
        $guardianCounty1 = test_input($_POST["guardianCounty1"]);
        if ((strlen($guardianCounty1)<5) || (strlen($guardianCounty1) > 50)){
            $guardianCounty1Err = "County must be between 10 and 50 characters long!";
        }
    } else {
        $guardianCounty1 = $guardianCountyPlaceholder1;
    }

    if(empty($_POST["guardianPostcode1"])){
        $guardianPostcode1 = $guardianPostcodePlaceholder1;

    } else {
        $guardianPostcode1 = test_input($_POST["guardianPostcode1"]);
        if ((strlen($guardianPostcode1)<6) || (strlen($guardianPostcode1) > 8)){
            $guardianPostcode1Err = "Postcode must be 6 characters long!";
        }
    }





    

    //Secondary Guradian

    if($_POST['elementForVar1HiddenField'] == 1){
        if(empty($_POST["guardianName2"])){
            if(isset($guardianFirstNamePlaceholder2) && isset ( $guardianLastNamePlaceholder2)){
                $guardianName2 = $guardianFirstNamePlaceholder2 . ' ' . $guardianLastNamePlaceholder2;

                
                $guardianNameParts2 = explode(" ", $guardianName2);
        
                // Extract the first and last names
                $guardianFirstName2 = $guardianNameParts2[0];
                $guardianLastName2 = end($guardianNameParts2);
            } 
        } else {
            $guardianName2 = test_input($_POST["guardianName2"]);
            // Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $guardianName2)) {
                $guardianName2Err = "Only letters and white space allowed";
            }
    
            $guardianNameParts2 = explode(" ", $guardianName2);
    
            // Extract the first and last names
            $guardianFirstName2 = $guardianNameParts2[0];
            $guardianLastName2 = end($guardianNameParts2);
        }
    
        if(empty($_POST["guardianContact2"])){
            if(isset($guardianContactPlaceholder2)){
                $guardianContact2 = $guardianContactPlaceholder2;

            }
    
        } else {
            $guardianContact2 = test_input($_POST["guardianContact"]);
            if (!preg_match("/^\d+$/", $guardianContact2)) {
                $guardianContact2Err = "Only digits allowed";
            }
        }
    
        if(empty($_POST["relationship2"])){
            if(isset($guardianRelationshipPlaceholder2)){
                $relationship2 = $guardianRelationshipPlaceholder2;
            }
        } else{
            $relationship2 = test_input($_POST["relationship2"]);
            // Check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/", $relationship2)) {
                $relationship2Err = "Only letters and white space allowed";
            }
        }

        if(empty($_POST["guardianAddress21"])){
            if(isset($guardianAddress1Placeholder2)){
                $guardianAddress21 = $guardianAddress1Placeholder2;
            }
    
        } else {
            $guardianAddress21 = test_input($_POST["guardianAddress21"]);
            if ((strlen($guardianAddress21)<10) || (strlen($guardianAddress21) > 50)){
                $guardianAddress21Err = "Address Line 1 must be between 10 and 50 characters long!";
            }
        }
    
        if(!empty($_POST["guardianAddress22"])){
            $guardianAddress22 = test_input($_POST["guardianAddress22"]);
        } else {
            if(isset($guardianAddress2Placeholder2)){
                $guardianAddress22 = $guardianAddress2Placeholder2;

            }
        }
    
        if(empty($_POST["guardianCity2"])){
            if(isset($guardianCityPlaceholder2)){
                $guardianCity2 = $guardianCityPlaceholder2;

            }
        } else {
            $guardianCity2 = test_input($_POST["guardianCity2"]);
            if ((strlen($guardianCity2)<5) || (strlen($guardianCity2) > 50)){
                $guardianCity2Err = "City must be between 10 and 50 characters long!";
            }
        }
    
        if(!empty($_POST["guardianCounty2"])){
            $guardianCounty2 = test_input($_POST["guardianCounty2"]);
            if ((strlen($guardianCounty2)<5) || (strlen($guardianCounty2) > 50)){
                $guardianCounty2Err = "County must be between 10 and 50 characters long!";
            }
        } else {
            if(isset($guardianCountyPlaceholder2)){
                $guardianCounty2 = $guardianCountyPlaceholder2;
            }
        }
    
        if(empty($_POST["guardianPostcode2"])){
            if(isset($guardianPostcodePlaceholder2)){
                $guardianPostcode2 = $guardianPostcodePlaceholder2;
            }
    
        } else {
            $guardianPostcode2 = test_input($_POST["guardianPostcode2"]);
            if ((strlen($guardianPostcode2)<6) || (strlen($guardianPostcode2) > 8)){
                $guardianPostcode2Err = "Postcode must be 6 characters long!";
            }
        }
    }
  

    // Doctor Details

    // Validate name
    if (empty($_POST["doctorName"])) {
        $doctorName = $doctorFirstNamePlaceholder . ' ' . $doctorLastNamePlaceholder;

        $doctorNameParts = explode(" ", $doctorName);

        // Extract the first and last names
        $doctorFirstName = $doctorNameParts[0];
        $doctorLastName = end($doctorNameParts);
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
        $doctorContact = $doctorContactPlaceholder;

    } else {
        $doctorContact = test_input($_POST["doctorContact"]);
        if (!preg_match("/^\d+$/", $doctorContact)) {
            $doctorContactErr = "Only digits allowed";
        }
    }

    

    // If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($websiteErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($healthIssuesErr) && empty($profileImageErr) 
        && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
        && empty($guardianNameErr) && empty($guardianContactErr) && empty($relationshipErr) 
        && empty($guardianAddress11Err) && empty($guardianAddress12Err) && empty($guardianCity1Err) && empty($guardianCounty1Err) && empty($guardianPostcode1Err)
        && empty($guardianAddress21Err) && empty($guardianAddress22Err) && empty($guardianCity2Err) && empty($guardianCounty2Err) && empty($guardianPostcode2Err)
        && empty($guardianName2Err) && empty($guardianContact2Err) && empty($relationship2Err)  
        && empty($doctorNameErr) && empty($doctorContactErr) && empty ($genuineErr)) {

        $conn = Connection::connect();

        $guardian1AddressId = $guardian2AddressId = $guardian2AddressId = $guardianId = $guardianId2 = "";

        $existingUser = Junior::juniorExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo);

        $existingAddress = Address::addressExists($address1, $address2, $city, $county, $postcode);

        $guardian1Address = Address::addressExists($guardianAddress11, $guardianAddress12, $guardianCity1, $guardianCounty1, $guardianPostcode1);
        
        if (!$guardian1Address) {
            // Create guardian address if it doesn't exist
            $guardian1AddressId = Address::createNewAddress($guardianAddress11, $guardianAddress12, $guardianCity1, $guardianCounty1, $guardianPostcode1);
        } else {
            // Use the existing guardian address ID
            $guardian1AddressId = $guardian1Address;
        }





        // First guardian
        // Check existing guardian
        $existingGuardian = Guardian::guardianExists($guardianFirstName, $guardianLastName, $guardianContact);
        
        if ($existingGuardian) {
            $guardianId = $existingGuardian["guardian_id"];
        } else {
            $guardianId = Guardian::createGuardian($guardian1AddressId, $guardianFirstName, $guardianLastName, $guardianContact, $relationship);
        }

        
        if ($_POST['elementForVar1HiddenField'] == 1) {

            $guardian2Address = Address::addressExists($guardianAddress21, $guardianAddress22, $guardianCity2, $guardianCounty2, $guardianPostcode2);
    
            if (!$guardian2Address) {
                // Create guardian address if it doesn't exist
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
        

        



        if($existingAddress){
            $addressId = Address::getExistingAddress($address1, $address2, $city, $county, $postcode);
        }

        else{

            $addressId = Address::createNewAddress($address1, $address2, $city, $county, $postcode);

        }

        $existingDoctor = Doctor::doctorExists($doctorFirstName, $doctorLastName, $doctorContact);

        if($existingDoctor){

            $doctorId = Doctor::existingDoctorId($doctorFirstName, $doctorLastName, $doctorContact);
        }

        else{

            $doctorId = Doctor::createNewDoctor($doctorFirstName, $doctorLastName, $doctorContact);
        }

        if(empty($genuineErr)){
            if (!empty($_FILES["profileImage"]["name"])) {
                $filename = $_FILES["profileImage"]["name"];
                $filetype = Utils::getFileExtension($filename);
                $isValidImage = in_array($filetype, ["jpg", "jpeg", "png", "gif"]);
            
                $isValidSize = $_FILES["profileImage"]["size"] <= 1000000;
            
                if (!$isValidImage || !$isValidSize) {
                    $profileImageErr = "<p class='error'>ERROR: Invalid file size/format</p>";
                }
            
                $tmpname = $_FILES["profileImage"]["tmp_name"];
            
                if (!move_uploaded_file($tmpname, "images/$filename")) {
                    $profileImageErr = "<p class='error'>ERROR: File was not uploaded</p>";
                }
            } else {
                $filename = $filenamePlaceholder; // Okay this is very funny, this line of code works here as well but not in member.

                
                // PS: The issue was that instead of getting the filename from '$member' I was getting it from '$player' which didnt exist.
                // Fixed it by swapping '$player' with '$member'
            }

            Junior::updateJunior($addressId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $healthIssues, $filename, $juniorId);

            Junior::updateJuniorAssociation($guardianId, $doctorId, $juniorId);



            if ($_POST['elementForVar1HiddenField'] == 1) {

                Junior::updateJuniorAssociation($guardianId2, $doctorId, $juniorId);

            // header("Location: " . Utils::$projectFilePath . "/index.php");
            }
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

components::pageHeader("Add Player", ["style"], ["mobile-nav"]);
?>

<main class="content-wrapper contact-content">

<h2>Add New Player</h2>
<form 
    method="POST"
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $junior["junior_id"];?>"
    enctype="multipart/form-data">

  <p class="error"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $playerFirstName. ' '. $playerLastName?>" value="<?php echo $name;?>">
      <p class="error"><?php echo $nameErr;?></p><br>

      <label for="sru">SRU Number:</label><br>
      <input type="text" name="sru" placeholder="<?php echo $sruNumberPlaceholder;?>" value="<?php echo $sru;?>">
      <p class="error"><?php echo $sruErr;?></p><br>

      <label for="dob">Date of Birth:</label><br>
      <input type="text" name="dob" placeholder="<?php echo $ukDobPlaceholder;?>" value="<?php echo $dob;?>">
      <p class="error"><?php echo $dobErr;?></p><br>

      <label for="email">Email:</label><br>
      <input type="text" name="email" placeholder="<?php echo $emailAddressPlaceholder;?>" value="<?php echo $email;?>">
      <p class="error"><?php echo $emailErr;?></p><br>

      <label for="contactNo">Contact Number:</label><br>
      <input type="text" name="contactNo" placeholder="<?php echo $contactNumberPlaceholder;?>" value="<?php echo $contactNo;?>">
      <p class="error"><?php echo $contactNoErr;?></p><br>

      <label for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" placeholder="<?php echo $mobileNumberPlaceholder;?>" value="<?php echo $mobileNo;?>">
      <p class="error"><?php echo $mobileNoErr;?></p><br>

      <label for="healthIssues">Health Issues:</label><br>
      <input type="text" name="healthIssues" placeholder="<?php echo $healthIssuesPlaceholder;?>" value="<?php echo $healthIssues;?>">
      <p class="error"><?php echo $healthIssuesErr;?></p><br>

      <label>Profile image</label>
      <input type="file" name="profileImage" value="">
      <p class="error"><?php echo $profileImageErr;?></p><br>


      <input type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form" class="add-form-section">
    <label for="address1">Address Line 1:</label><br>
        <input type="text" name="address1"  placeholder="<?php echo $address1Placeholder;?>" value="<?php echo $address1;?>">
        <p class="error"><?php echo $address1Err;?></p><br>

    <label for="address2">Address Line 2:</label><br>
        <input type="text" name="address2"  placeholder="<?php echo $address2Placeholder;?>" value="<?php echo $address2;?>">
        <p class="error"><?php echo $address2Err;?></p><br>   

    <label for="city">City:</label><br>
        <input type="text" name="city"  placeholder="<?php echo $cityPlaceholder;?>" value="<?php echo $city;?>">
        <p class="error"><?php echo $cityErr;?></p><br>  

    <label for="county">County:</label><br>
        <input type="text" name="county"  placeholder="<?php echo $countyPlaceholder;?>" value="<?php echo $county;?>">
        <p class="error"><?php echo $countyErr;?></p><br>  

    <label for="postcode">Postcode:</label><br>
        <input type="text" name="postcode"  placeholder="<?php echo $postcodePlaceholder;?>" value="<?php echo $postcode;?>">
        <p class="error"><?php echo $postcodeErr;?></p><br>  
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
    
    <label for="guardianName">Guardian's name:</label><br>
        <input type="text" name="guardianName" value="<?php echo $guardianName;?>">
        <p class="error"><?php echo $guardianNameErr;?></p><br>

    <label for="guardianContact">Contact Number:</label><br>
        <input type="text" name="guardianContact" value="<?php echo $guardianContact;?>">
        <p class="error"><?php echo $guardianContactErr;?></p><br>   

    <label for="relationship">Relationship:</label><br>
        <input type="text" name="relationship" value="<?php echo $relationship;?>">
        <p class="error"><?php echo $relationshipErr;?></p><br>  
        
    
    <label for="guardianAddress11">Address Line 1:</label><br>
        <input type="text" name="guardianAddress11" value="<?php echo $guardianAddress11;?>">
        <p class="error"><?php echo $guardianAddress11Err;?></p><br>

    <label for="guardianAddress12">Address Line 2:</label><br>
        <input type="text" name="guardianAddress12" value="<?php echo $guardianAddress12;?>">
        <p class="error"><?php echo $guardianAddress12Err;?></p><br>   

    <label for="guardianCity1">City:</label><br>
        <input type="text" name="guardianCity1" value="<?php echo $guardianCity1;?>">
        <p class="error"><?php echo $guardianCity1Err;?></p><br>  

    <label for="guardianCounty1">County:</label><br>
        <input type="text" name="guardianCounty1" value="<?php echo $guardianCounty1;?>">
        <p class="error"><?php echo $guardianCounty1Err;?></p><br>  

    <label for="guardianPostcode1">Postcode:</label><br>
        <input type="text" name="guardianPostcode1" value="<?php echo $guardianPostcode1;?>">
        <p class="error"><?php echo $guardianPostcode1Err;?></p><br>  

        <div id="second-guardian-form">
            <input type="hidden" id="elementForVar1HiddenField" name="elementForVar1HiddenField" value="0" />
            <label for="guardianName">Guardian's name:</label><br>
            <input type="text" name="guardianName2" value="<?php echo $guardianName2;?>">
            <p class="error"><?php echo $guardianName2Err;?></p><br>

        <label for="guardianContact">Contact Number:</label><br>
            <input type="text" name="guardianContact2" value="<?php echo $guardianContact2;?>">
            <p class="error"><?php echo $guardianContact2Err;?></p><br>   

        <label for="relationship2">Relationship:</label><br>
            <input type="text" name="relationship2" value="<?php echo $relationship2;?>">
            <p class="error"><?php echo $relationship2Err;?></p><br>
            
        <label for="guardianAddress21">Address Line 1:</label><br>
            <input type="text" name="guardianAddress21" value="<?php echo $guardianAddress21;?>">
            <p class="error"><?php echo $guardianAddress21Err;?></p><br>

        <label for="guardianAddress22">Address Line 2:</label><br>
            <input type="text" name="guardianAddress22" value="<?php echo $guardianAddress22;?>">
            <p class="error"><?php echo $guardianAddress22Err;?></p><br>   

        <label for="guardianCity2">City:</label><br>
            <input type="text" name="guardianCity2" value="<?php echo $guardianCity2;?>">
            <p class="error"><?php echo $guardianCity2Err;?></p><br>  

        <label for="guardianCounty2">County:</label><br>
            <input type="text" name="guardianCounty2" value="<?php echo $guardianCounty2;?>">
            <p class="error"><?php echo $guardianCounty2Err;?></p><br>  

        <label for="guardianPostcode2">Postcode:</label><br>
            <input type="text" name="guardianPostcode2" value="<?php echo $guardianPostcode2;?>">
            <p class="error"><?php echo $guardianPostcode2Err;?></p><br>  
        </div>



        


        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>


 </div>

 <div id="doctor-details-form">
    <label for="doctorName">Doctor Name:</label><br>
        <input type="text" name="doctorName" value="<?php echo $doctorName;?>">
        <p class="error"><?php echo $doctorNameErr;?></p><br>

    <label for="doctorContact">Contact Number:</label><br>
        <input type="text" name="doctorContact" value="<?php echo $doctorContact;?>">
        <p class="error"><?php echo $doctorContactErr;?></p><br>   
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

    showTab();
    radioChecked();

    function nextTab(){
        currentTab += 1;
        showTab();
    }

    function prevTab(){
        currentTab -= 1;
        showTab();
    }

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


</script>
</main>

<?php
components::pageFooter();
?>