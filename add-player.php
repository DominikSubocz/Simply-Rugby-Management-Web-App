<?php
session_start();

require("classes/components.php");
require("classes/sql.php");
require("classes/utils.php");
require_once("classes/connection.php");

/// Check if the user role is not Admin or Coach, then redirect to the logout page.
if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

/**
 * Initialize variables to store error messages and form data for a user registration form.
 * Also, initialize variables for doctor and address IDs.
 * 
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
 * This function is used to handle form submission when the HTTP request method is POST. 
 * It validates the form inputs and processes the data accordingly.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required"; ///< Display error message
    } else {
        $name = test_input($_POST["name"]); ///< Sanitize name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";///< Display error message
        }

        $nameParts = explode(" ", $name);

        /// Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    }

    /// Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required"; ///< Display error message
    } else {
        $email = test_input($_POST["email"]); ///< Sanitize email
        /// Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format"; ///< Display error message
        }
    }

    if (empty($_POST["sru"])){
        $sruErr = "SRU Number is required"; ///< Display error message


    } else {
        $sru = test_input($_POST["sru"]); ///< Sanitize sru number
        if (!preg_match("/^\d+$/", $sru)) {
            $sruErr = "Only digits allowed"; ///< Display error message
        }
    }

    if (empty($_POST["dob"])){
        $dobErr = "Date of birth is required"; ///< Display error message


    } else {
        $dob = test_input($_POST["dob"]); ///< Sanitize dob
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY"; ///< Display error message
        }

        $dateTime = DateTime::createFromFormat('d/m/Y', $dob); ///< Create a DateTime object from the formatted date
        $sqlDate = $dateTime->format('Y-m-d'); ///< Format the date as YYYY-MM-DD
    }

    if(empty($_POST["contactNo"])){
        $contactNoErr = "Contact Number is required"; ///< Display error message

    } else {
        $contactNo = test_input($_POST["contactNo"]); ///< Sanitize contact number
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed"; ///< Display error message
        }
    }

    if(empty($_POST["address1"])){
        $address1Err = "Address Line 1 is required"; ///< Display error message

    } else {
        $address1 = test_input($_POST["address1"]); ///< Sanitize address line 1
        if ((strlen($address1)<10) || (strlen($address1) > 50)){
            $address1Err = "Address Line 1 must be between 10 and 50 characters long!"; ///< Display error message
        }
    }

    if(!empty($_POST["address2"])){
        $address2 = test_input($_POST["address2"]); ///< Display error message
    }

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]); ///< Sanitize mobile number
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed"; ///< Display error message
        }
    } 

    if(empty($_POST["city"])){
        $cityErr = "City is required"; ///< Display error message

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
    }

    if(empty($_POST["postcode"])){
        $postcodeErr = "Postcode is required"; ///< Display error message

    } else {
        $postcode = test_input($_POST["postcode"]); ///< Sanitize postcode
        if ((strlen($postcode)<6) || (strlen($postcode) > 8)){
            $postcodeErr = "Postcode must be 6 characters long!"; ///< Display error message
        }
    }


 


    /// Emergency Contact Details

    if (empty($_POST["kin"])) {
        $kinErr = "Name is required"; ///< Display error message
    } else {
        $kin = test_input($_POST["kin"]); ///< Sanitize kin
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $kin)) {
            $kinErr = "Only letters and white space allowed"; ///< Display error message
        }
    }

    if(empty($_POST["kinContact"])){
        $kinContactErr = "Contact Number is required"; ///< Display error message

    } else {
        $kinContact = test_input($_POST["kinContact"]); ///< Sanitize kin's contact number
        if (!preg_match("/^\d+$/", $kinContact)) {
            $kinContactErr = "Only digits allowed"; ///< Display error message
        }
    }

    /// Doctor Details

    /// Validate name
    if (empty($_POST["doctorName"])) {
        $doctorNameErr = "Doctor's name is required"; ///< Display error message
    } else {
        $doctorName = test_input($_POST["doctorName"]); ///< Sanitize doctor's name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $doctorName)) {
            $doctorNameErr = "Only letters and white space allowed"; ///< Display error message
        }

        $doctorNameParts = explode(" ", $doctorName); ///< Split the name into an array

        /// Extract the first and last names
        $doctorFirstName = $doctorNameParts[0];
        $doctorLastName = end($doctorNameParts);
    }

    if(empty($_POST["doctorContact"])){
        $doctorContactErr = "Contact Number is required"; ///< Display error message

    } else {
        $doctorContact = test_input($_POST["doctorContact"]); ///< Sanitize doctor's contact number
        if (!preg_match("/^\d+$/", $kinContact)) {
            $doctorContactErr = "Only digits allowed"; ///< Display error message
        }
    }

    

    /// If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($websiteErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($healthIssuesErr) && empty($profileImageErr) 
    && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
    && empty($kinErr) && empty($kinContactErr) && empty($doctorNameErr) && empty($doctorContactErr) && empty ($genuineErr)) {

        $conn = Connection::connect();


        /**
         * Check if a player already exists in the database based on the provided parameters.
         */
        $stmt = $conn->prepare(SQL::$playerExists);
        $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
        $existingUser = $stmt->fetch();


        if($existingUser){
            $genuineErr = "ERROR: Player already exists!"; ///< Display error message
        }

        /**
         * Checks if an existing address exists in the database. If it does, retrieves the address ID.
         * If not, creates a new address in the database and then retrieves the newly created address ID.
         */
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

        /**
         * Check if a doctor already exists in the database based on first name, last name, and contact.
         * If the doctor exists, retrieve the doctor's ID. If not, create a new doctor and retrieve the new doctor's ID.
         */
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
            /**
             * Handles the upload of a profile image file.
             *
             * This function checks if a profile image file has been uploaded, validates its format and size,
             * and moves the file to the appropriate directory if it meets the criteria.
             *
             */
            if (!empty($_FILES["profileImage"]["name"])) {
                $filename = $_FILES["profileImage"]["name"];
                $filetype = Utils::getFileExtension($filename);
                $isValidImage = in_array($filetype, ["jpg", "jpeg", "png", "gif"]);
            
                $isValidSize = $_FILES["profileImage"]["size"] <= 1000000;
            
                if (!$isValidImage || !$isValidSize) {
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: Invalid file size/format</p>"; ///< Display error message
                }
            
                $tmpname = $_FILES["profileImage"]["tmp_name"];
            
                if (!move_uploaded_file($tmpname, "images/$filename")) {
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: File was not uploaded</p>"; ///< Display error message
                }
            }
            /// Create a new player in the database
            $stmt = $conn->prepare(SQL::$createNewPlayer);
            $stmt->execute([$addressId, $doctorId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename]);
        
        

            header("Location: " . Utils::$projectFilePath . "/player-list.php");
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

<main class="content-wrapper contact-content my-5">

<h2>Add New Player</h2>

<div class="alert alert-info">
  <p><strong>NOTE: </strong> Fields marked with <span class="required">*</span> are mandatory.</p>
</div>
<form 
method="post" 
action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
enctype="multipart/form-data">

  <p class="alert alert-danger"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label class="col-sm-2 col-form-label-sm"for="name"><span class="required">*</span>Name:</label><br>
      <input type="text" name="name" value="<?php echo $name;?>">
      <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

      <label class="col-sm-2 col-form-label-sm"for="sru"><span class="required">*</span>SRU Number:</label><br>
      <input type="text" name="sru" value="<?php echo $sru;?>">
      <p class="alert alert-danger"><?php echo $sruErr;?></p><br>

      <label class="col-sm-2 col-form-label-sm"for="dob"><span class="required">*</span>Date of Birth:</label><br>
      <input type="text" name="dob" value="<?php echo $dob;?>">
      <p class="alert alert-danger"><?php echo $dobErr;?></p><br>

      <label class="col-sm-2 col-form-label-sm"for="email"><span class="required">*</span>Email:</label><br>
      <input type="text" name="email" value="<?php echo $email;?>">
      <p class="alert alert-danger"><?php echo $emailErr;?></p><br>

      <label class="col-sm-2 col-form-label-sm"for="contactNo"><span class="required">*</span>Contact Number:</label><br>
      <input type="text" name="contactNo" value="<?php echo $contactNo;?>">
      <p class="alert alert-danger"><?php echo $contactNoErr;?></p><br>

      <label class="col-sm-2 col-form-label-sm"for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" value="<?php echo $mobileNo;?>">
      <p class="alert alert-danger"><?php echo $mobileNoErr;?></p><br>

      <label class="col-sm-2 col-form-label-sm"for="healthIssues">Health Issues:</label><br>
      <input type="text" name="healthIssues" value="<?php echo $healthIssues;?>">
      <p class="alert alert-danger"><?php echo $healthIssuesErr;?></p><br>

      <label><span class="required">*</span>Profile image</label>
      <input type="file" name="profileImage" value="">
      <p class="alert alert-danger"><?php echo $profileImageErr;?></p><br>


      <input class="btn btn-dark" type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form" class="add-form-section">
    <label class="col-sm-2 col-form-label-sm"for="address1"><span class="required">*</span>Address Line 1:</label><br>
        <input type="text" name="address1" value="<?php echo $address1;?>">
        <p class="alert alert-danger"><?php echo $address1Err;?></p><br>

    <label class="col-sm-2 col-form-label-sm"for="address2">Address Line 2:</label><br>
        <input type="text" name="address2" value="<?php echo $address2;?>">
        <p class="alert alert-danger"><?php echo $address2Err;?></p><br>   

    <label class="col-sm-2 col-form-label-sm"for="city"><span class="required">*</span>City:</label><br>
        <input type="text" name="city" value="<?php echo $city;?>">
        <p class="alert alert-danger"><?php echo $cityErr;?></p><br>  

    <label class="col-sm-2 col-form-label-sm"for="county">County:</label><br>
        <input type="text" name="county" value="<?php echo $county;?>">
        <p class="alert alert-danger"><?php echo $countyErr;?></p><br>  

    <label class="col-sm-2 col-form-label-sm"for="postcode"><span class="required">*</span>Postcode:</label><br>
        <input type="text" name="postcode" value="<?php echo $postcode;?>">
        <p class="alert alert-danger"><?php echo $postcodeErr;?></p><br>  
        <div>
            <input class="btn btn-dark" type="button" value="Previous" onclick="prevTab()">
            <input class="btn btn-dark" type="button" value="Next" onclick="nextTab()">
        </div>

 </div>

 <div id="kin-details-form" class="add-form-section">
    <label class="col-sm-2 col-form-label-sm"for="kin"><span class="required">*</span>Next of Kin:</label><br>
        <input type="text" name="kin" value="<?php echo $kin;?>">
        <p class="alert alert-danger"><?php echo $kinErr;?></p><br>

    <label class="col-sm-2 col-form-label-sm"for="kinContact"><span class="required">*</span>Contact Number:</label><br>
        <input type="text" name="kinContact" value="<?php echo $kinContact;?>">
        <p class="alert alert-danger"><?php echo $kinContactErr;?></p><br>   
        <div>
            <input class="btn btn-dark" type="button" value="Previous" onclick="prevTab()">
            <input class="btn btn-dark" type="button" value="Next" onclick="nextTab()">
        </div>
 </div>

 <div id="doctor-details-form">
    <label class="col-sm-2 col-form-label-sm"for="doctorName"><span class="required">*</span>Doctor Name:</label><br>
        <input type="text" name="doctorName" value="<?php echo $doctorName;?>">
        <p class="alert alert-danger"><?php echo $doctorNameErr;?></p><br>

    <label class="col-sm-2 col-form-label-sm"for="doctorContact"><span class="required">*</span>Contact Number:</label><br>
        <input type="text" name="doctorContact" value="<?php echo $doctorContact;?>">
        <p class="alert alert-danger"><?php echo $doctorContactErr;?></p><br>   
        <input class="btn btn-dark" type="button" value="Previous" onclick="prevTab()">
 </div>

 <input class="btn btn-dark" type="submit" name="submit" onclick="return validateForm()" value="Submit">  

</form>

<script>

    var currentTab = 0;
    const pDetails = document.getElementById("personal-details-form");
    const aDetails = document.getElementById("address-details-form");
    const kDetails = document.getElementById("kin-details-form");
    const dDetails = document.getElementById("doctor-details-form");

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

    /**
     * Show the tab based on the value of the currentTab variable.
     * Depending on the value of currentTab, display the corresponding tab details.
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

    /**
     * Validates the form fields to ensure all required fields are filled out.
     * Displays an alert message if any field is empty and returns false.
     * 
     * @return boolean
     */
    function validateForm() {
        let nameInput = document.forms[0]["name"].value.trim();
        let sruInput = document.forms[0]["sru"].value.trim();
        let dobInput = document.forms[0]["dob"].value.trim();
        let emailInput = document.forms[0]["email"].value.trim();
        let contactInput = document.forms[0]["contactNo"].value.trim();
        let pfpInput = document.forms[0]["profileImage"].value.trim();

        let addressInput = document.forms[0]["address1"].value.trim();
        let cityInput = document.forms[0]["city"].value.trim();
        let postcodeInput = document.forms[0]["postcode"].value.trim();

        let kinNameInput= document.forms[0]["kin"].value.trim();
        let kinContactInput = document.forms[0]["kinContact"].value.trim();

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

        if (kinNameInput == "") {
            alert("Next of Kin must be filled out");
            return false;
        }

        if (kinContactInput == "") {
            alert("Next of Kin's contact number must be fillet out.");
            return false;
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