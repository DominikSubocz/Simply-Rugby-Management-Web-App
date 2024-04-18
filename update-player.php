<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/player.php");
require("classes/doctor.php");
require("classes/address.php");

/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
}

/// Redirect to logout page if user role is neither Admin nor Coach

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }


$conn = Connection::connect(); ///< Connect to database


Components::pageHeader("Update Player", ["style"], ["mobile-nav"]); ///< Render page header

$playerId = $_GET["id"]; ///< Get ID of specific player


$player = Player::getplayer($playerId); ///< Get details about that player based on the ID number

/**
 * Escape and assign values from the $player array to respective variables for security purposes.
 *
 * @param array $player An array containing information about the player.
 * 
 */


$playerFirstName = Utils::escape($player["first_name"]);
$playerLastName = Utils::escape($player["last_name"]);

$dobPlaceholder = Utils::escape($player["dob"]);
$user_idPlaceholder = Utils::escape($player["user_id"]); /// Might implement update for that later
$sruNumberPlaceholder = Utils::escape($player["sru_no"]);
$contactNumberPlaceholder = Utils::escape($player["contact_no"]);
$mobileNumberPlaceholder = Utils::escape($player["mobile_no"]);
$emailAddressPlaceholder = Utils::escape($player["email_address"]);
$healthIssuesPlaceholder = Utils::escape($player["health_issues"]);
$filenamePlaceholder = Utils::escape($player["filename"]);
$nextOfKinPlaceholder = Utils::escape($player["next_of_kin"]);
$kinContactNumberPlaceholder = Utils::escape($player["kin_contact_no"]);

$address1Placeholder = Utils::escape($player["address_line"]);
$address2Placeholder = Utils::escape($player["address_line2"]);
$cityPlaceholder = Utils::escape($player["city"]);
$countyPlaceholder = Utils::escape($player["county"]);
$postcodePlaceholder = Utils::escape($player["postcode"]);
$doctorFirstNamePlaceholder = Utils::escape($player["doctor_first_name"]);
$doctorLastNamePlaceholder = Utils::escape($player["doctor_last_name"]);
$doctorContactPlaceholder = Utils::escape($player["doctor_contact_no"]);

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
 * 
 * @var string $address1Err: Error message for Address Line 1
 * @var string $address2Err: Error message for Address Line 2
 * @var string $cityErr: Error message for City
 * @var string $countyErr: Error message for County
 * @var string $postcodeErr: Error message for Postcode
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
 */

$nameErr = $dobErr = $emailErr = $websiteErr = $sruErr = $contactNoErr = $mobileNoErr = $healthIssuesErr = $profileImageErr =  "";
$address1Err = $address2Err = $cityErr = $countyErr = $postcodeErr = "";
$kinErr = $kinContactErr = $doctorNameErr = $doctorContactErr = "";
$genuineErr = $profileImageErr = "";

$doctorId = $addressId = "";


$name = $dob = $email = $website = $sru = $contactNo = $mobileNo = $healthIssues = $profileImage = $filename = "";
$firstName = $lastName = "";
$address1 = $address2 = $city = $county = $postcode = "";
$kin = $kinContact = $doctorName = $doctorContact = "";

/**
 * Validates the form inputs and processes the data accordingly.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $name = $playerFirstName . ' ' . $playerLastName; ///< Combines the first name and last name placeholders values if left empty
    } else {
        $name = test_input($_POST["name"]); ///< Sanitize name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";  ///< Display error message
        }

        $nameParts = explode(" ", $name); ///< Split name into first and last name


        /// Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    }

    /// Validate email
    if (empty($_POST["email"])) {
        $email = $emailAddressPlaceholder; //< Set value to placeholder if left empty
    } else {
        $email = test_input($_POST["email"]); ///< Sanitize email address
        /// Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";  ///< Display error message
        }
    }

    if (empty($_POST["sru"])){
        $sru = $sruNumberPlaceholder; //< Set value to placeholder if left empty


    } else {
        $sru = test_input($_POST["sru"]); ///< Sanitize sru number
        if (!preg_match("/^\d+$/", $sru)) {
            $sruErr = "Only digits allowed";  ///< Display error message
        }
    }

    if (empty($_POST["dob"])){
        $dob = date('d/m/Y', strtotime($dobPlaceholder));

        $sqlDate = date('Y-m-d', strtotime($dob)); ///< Converts a date of birth (dob) into a SQL date format (YYYY-MM-DD).


    } else {
        $dob = test_input($_POST["dob"]); ///< Sanitize dob
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY";  ///< Display error message
        }

        $sqlDate = date('Y-m-d', strtotime($dob)); ///< Converts a date of birth (dob) into a SQL date format (YYYY-MM-DD).

    }

    if(empty($_POST["contactNo"])){
        $contactNo = $contactNumberPlaceholder; //< Set value to placeholder if left empty

    } else {
        $contactNo = test_input($_POST["contactNo"]); ///< Sanitize contact number
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed";  ///< Display error message
        }
    }

    if(empty($_POST["address1"])){
        $address1 = $address1Placeholder; //< Set value to placeholder if left empty

    } else {
        $address1 = test_input($_POST["address1"]); ///< Sanitize address line 1
        if ((strlen($address1)<10) || (strlen($address1) > 50)){
            $address1Err = "Address Line 1 must be between 10 and 50 characters long!";  ///< Display error message
        }
    }

    if(!empty($_POST["address2"])){
        $address2 = test_input($_POST["address2"]); ///< Sanitize address line 2
    } else {
        $address2 = $address2Placeholder; //< Set value to placeholder if left empty
    }

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]); ///< Sanitize mobile number
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed";  ///< Display error message
        }
    } else {
        $mobileNo = $mobileNumberPlaceholder; //< Set value to placeholder if left empty
    }

    if(empty($_POST["city"])){
        $city = $cityPlaceholder; //< Set value to placeholder if left empty

    } else {
        $city = test_input($_POST["city"]); ///< Sanitize city
        if ((strlen($city)<5) || (strlen($city) > 50)){
            $cityErr = "City must be between 10 and 50 characters long!";  ///< Display error message
        }
    }

    if(!empty($_POST["county"])){
        $county = test_input($_POST["county"]); ///< Sanitize county
        if ((strlen($county)<5) || (strlen($county) > 50)){
            $countyErr = "County must be between 10 and 50 characters long!";  ///< Display error message
        }
    } else { 
        $county = $countyPlaceholder; //< Set value to placeholder if left empty
    }

    if(empty($_POST["postcode"])){
        $postcode = $postcodePlaceholder; //< Set value to placeholder if left empty

    } else {
        $postcode = test_input($_POST["postcode"]); ///< Sanitize postcode
        if ((strlen($postcode)<6) || (strlen($postcode) > 8)){
            $postcodeErr = "Postcode must be 6 characters long!";  ///< Display error message
        }
    }


 


    /// Emergency Contact Details

    if (empty($_POST["kin"])) {
        $kin = $nextOfKinPlaceholder; //< Set value to placeholder if left empty
    } else {
        $kin = test_input($_POST["kin"]); ///< Sanitize next of kin
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $kin)) {
            $kinErr = "Only letters and white space allowed";  ///< Display error message
        }
    }

    if(empty($_POST["kinContact"])){
        $kinContact = $kinContactNumberPlaceholder; //< Set value to placeholder if left empty

    } else {
        $kinContact = test_input($_POST["kinContact"]); ///< Sanitize next of kin's contact number
        if (!preg_match("/^\d+$/", $kinContact)) {
            $kinContactErr = "Only digits allowed";  ///< Display error message
        }
    }

    /// Doctor Details

    /// Validate name
    if (empty($_POST["doctorName"])) {
        $doctorName = $doctorFirstNamePlaceholder . ' ' . $doctorLastNamePlaceholder; ///< Combines the first name and last name placeholders values if left empty

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
        $doctorContact = $doctorContactPlaceholder; //< Set value to placeholder if left empty

    } else {
        $doctorContact = test_input($_POST["doctorContact"]); ///< Sanitize doctor's contact number
        if (!preg_match("/^\d+$/", $kinContact)) {
            $doctorContactErr = "Only digits allowed";  ///< Display error message
        }
    }

    if(empty($_POST["healthIssues"])){
        $healthIssues = $healthIssuesPlaceholder; //< Set value to placeholder if left empty
    }

    

    /// If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($websiteErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($healthIssuesErr) && empty($profileImageErr) 
    && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
    && empty($kinErr) && empty($kinContactErr) && empty($doctorNameErr) && empty($doctorContactErr) && empty ($genuineErr)) {


        /**
         * Check if a player with the given details already exists in the database.
         */
        $existingUser = Player::playerExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo);

        
        /**
         * Checks if an address already exists in the database based on the provided address details. 
         */
        $existingAddress = Address::addressExists($address1, $address2, $city, $county, $postcode);

        if($existingAddress){
            $addressId = Address::getExistingAddress($address1, $address2, $city, $county, $postcode);
        }else{
            $addressId = Address::createNewAddress($address1, $address2, $city, $county, $postcode);
        }

        /**
         * Checks if an doctor already exists in the database based on the provided doctor details. 
         */

        $existingDoctor = Doctor::doctorExists($doctorFirstName, $doctorLastName, $doctorContact);

        if($existingDoctor){
            $doctorId = Doctor::existingDoctorId($doctorFirstName, $doctorLastName, $doctorContact);
        }else{
            $doctorId = Doctor::createNewDoctor($doctorFirstName, $doctorLastName, $doctorContact);
        }

    /// If there are no errors, proceed with sql querries
        if(empty($genuineErr)){
            /**
             * Handles the upload of a profile image file.
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
            } else if (!isset($_POST["profileImage"])) {
                $filename = $filenamePlaceholder;  ///Okay so this doesn't work here but it works in update player, I love php.


            }   

            /**
             * Update player information in the database.
             */
            Player::updatePlayer($addressId, $doctorId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $playerId);

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


?>
<main class="content-wrapper contact-content">

<h2>Update <?php echo $playerFirstName . ' '. $playerLastName; ?></h2>
<form 
    method="POST"
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $player["player_id"];?>"
    enctype="multipart/form-data">

  <p class="alert alert-danger"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label  class="col-sm-2 col-form-label-sm"for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $playerFirstName. ' '. $playerLastName;?>" value="<?php echo $name;?>">
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
      <input type="file" name="profileImage"  value="">
      <p class="alert alert-danger"><?php echo $profileImageErr;?></p><br>


      <input type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form" class="add-form-section">
    <label  class="col-sm-2 col-form-label-sm"for="address1">Address Line 1:</label><br>
        <input type="text" name="address1" placeholder="<?php echo $address1Placeholder;?>" value="<?php echo $address1;?>">
        <p class="alert alert-danger"><?php echo $address1Err;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="address2">Address Line 2:</label><br>
        <input type="text" name="address2" placeholder="<?php echo $address2Placeholder;?>" value="<?php echo $address2;?>">
        <p class="alert alert-danger"><?php echo $address2Err;?></p><br>   

    <label  class="col-sm-2 col-form-label-sm"for="city">City:</label><br>
        <input type="text" name="city" placeholder="<?php echo $cityPlaceholder;?>" value="<?php echo $city;?>">
        <p class="alert alert-danger"><?php echo $cityErr;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="county">County:</label><br>
        <input type="text" name="county" placeholder="<?php echo $countyPlaceholder;?>" value="<?php echo $county;?>">
        <p class="alert alert-danger"><?php echo $countyErr;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="postcode">Postcode:</label><br>
        <input type="text" name="postcode" placeholder="<?php echo $postcodePlaceholder;?>" value="<?php echo $postcode;?>">
        <p class="alert alert-danger"><?php echo  $postcodeErr;?></p><br>  
        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>

 </div>

 <div id="kin-details-form" class="add-form-section">
    <label  class="col-sm-2 col-form-label-sm"for="kin">Next of Kin:</label><br>
        <input type="text" name="kin" placeholder="<?php echo $nextOfKinPlaceholder;?>" value="<?php echo $kin;?>">
        <p class="alert alert-danger"><?php echo $kinErr;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="kinContact">Contact Number:</label><br>
        <input type="text" name="kinContact" placeholder="<?php echo $kinContactNumberPlaceholder;?>" value="<?php echo $kinContact;?>">
        <p class="alert alert-danger"><?php echo $kinContactErr;?></p><br>   
        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>
 </div>

 <div id="doctor-details-form">
    <label  class="col-sm-2 col-form-label-sm"for="doctorName">Doctor Name:</label><br>
        <input type="text" name="doctorName" placeholder="<?php echo $doctorFirstNamePlaceholder. ' '. $doctorLastNamePlaceholder;?>" value="<?php echo $doctorName;?>">
        <p class="alert alert-danger"><?php echo $doctorNameErr;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="doctorContact">Contact Number:</label><br>
        <input type="text" name="doctorContact" placeholder="<?php echo $doctorContactPlaceholder;?>" value="<?php echo $doctorContact;?>">
        <p class="alert alert-danger"><?php echo $doctorContactErr;?></p><br>   
        <input type="button" value="Previous" onclick="prevTab()">
 </div>

  <input type="submit" name="submit" value="Submit">  

</form>

<script>

    var currentTab = 0;
    const pDetails = document.getElementById("personal-details-form");
    const aDetails = document.getElementById("address-details-form");
    const kDetails = document.getElementById("kin-details-form");
    const dDetails = document.getElementById("doctor-details-form");

    /**
     * Show the tab based on the currentTab value.
     */
    function showTab(){
        if ( currentTab == 0){
            pDetails.style.display = "block";
            aDetails.style.display = "none";
            kDetails.style.display = "none";
            dDetails.style.display = "none";

        }

        else if (currentTab == 1){
            pDetails.style.display = "none";
            aDetails.style.display = "block";
            kDetails.style.display = "none";
            dDetails.style.display = "none";

        }

        else if (currentTab == 2) {
            pDetails.style.display = "none";
            aDetails.style.display = "none";
            kDetails.style.display = "block";
            dDetails.style.display = "none";

        }

        else{
            pDetails.style.display = "none";
            aDetails.style.display = "none";
            kDetails.style.display = "none";
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


</script>
</main>

<?php
components::pageFooter();
?>
