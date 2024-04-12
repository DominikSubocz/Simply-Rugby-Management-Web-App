<?php
/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
require("classes/sql.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require_once("classes/connection.php");

/**
 * Check if the session variable "newMember" is not set, and if the user role is not "Admin" or "Coach",
 * redirect to the logout page.
 */
if(!isset($_SESSION["newMember"])){
    if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
        header("Location: " . Utils::$projectFilePath . "/logout.php");
      }
} 


/**
 * Initialize error variables for form validation.
 * These variables will be used to display error messages on the form.
 */
$nameErr = $dobErr = $emailErr = $sruErr = $contactNoErr = $mobileNoErr = $profileImageErr =  "";
$address1Err = $address2Err = $cityErr = $countyErr = $postcodeErr = "";
$genuineErr = $profileImageErr = "";

/// Initialize variables
$name = $dob = $email = $sru = $contactNo = $mobileNo = $profileImage = $filename = "";
$address1 = $address2 = $city = $county = $postcode = "";
$firstName = $lastName = "";

/**
 * This function is used to handle form submission when the HTTP request method is POST. 
 * It validates the form inputs and processes the data accordingly.
 */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed"; ///< Display error message
        }

        $nameParts = explode(" ", $name); ///< Split the name into first and last name

        /// Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    }

    /// Validate email
    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        /// Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format"; ///< Display error message
        }
    }
    /// Validate SRU number
    if (empty($_POST["sru"])){
        $sruErr = "SRU Number is required"; ///< Display error message


    } else {
        $sru = test_input($_POST["sru"]);
        if (!preg_match("/^\d+$/", $sru)) {
            $sruErr = "Only digits allowed"; ///< Display error message
        }
    }

    /// Validate DOB 
    if (empty($_POST["dob"])){
        $dobErr = "Date of birth is required"; ///< Display error message


    } else {
        $dob = test_input($_POST["dob"]);
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY"; ///< Display error message
        }

        $dateTime = DateTime::createFromFormat('d/m/Y', $dob); ///< Create a DateTime object from the DOB
        $sqlDate = $dateTime->format('Y-m-d');  ///< Format the DateTime object to YYYY-MM-DD
    }
    /// Validate Contact number
    if(empty($_POST["contactNo"])){
        $contactNoErr = "Contact Number is required"; ///< Display error message

    } else {
        $contactNo = test_input($_POST["contactNo"]); ///< Sanitize the contact number
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed"; ///< Display error message
        }
    }
    /// Validate Mobile number if it isn't empty
    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]); ///< Sanitize the mobile number
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed"; ///< Display error message
        }
    } 
    /// Validate Address Line 1
    if(empty($_POST["address1"])){
        $address1Err = "Address Line 1 is required"; ///< Display error message

    } else {
        $address1 = test_input($_POST["address1"]); ///< Sanitize the address line 1
        if ((strlen($address1)<10) || (strlen($address1) > 50)){
            $address1Err = "Address Line 1 must be between 10 and 50 characters long!";
        }
    }
    /// Validate Address Line 2 if it isn't empty
    if(!empty($_POST["address2"])){
        $address2 = test_input($_POST["address2"]); ///< Sanitize the address line 2
    }
    /// Validate city
    if(empty($_POST["city"])){
        $cityErr = "City is required"; ///< Display error message

    } else {
        $city = test_input($_POST["city"]); ///< Sanitize the city  
        if ((strlen($city)<5) || (strlen($city) > 50)){
            $cityErr = "City must be between 10 and 50 characters long!"; ///< Display error message
        }
    }
    /// Validate county if it isn't empty
    if(!empty($_POST["county"])){
        $county = test_input($_POST["county"]); ///< Sanitize the county
        if ((strlen($county)<5) || (strlen($county) > 50)){
            $countyErr = "County must be between 10 and 50 characters long!"; ///< Display error message
        }
    }
    /// Validate postcode
    if(empty($_POST["postcode"])){
        $postcodeErr = "Postcode is required"; ///< Display error message

    } else {
        $postcode = test_input($_POST["postcode"]); ///< Sanitize the postcode
        if ((strlen($postcode)<6) || (strlen($postcode) > 8)){
            $postcodeErr = "Postcode must be 6 characters long!"; ///< Display error message
        }
    }


    
    /// If there are no errors, proceed with sql querries
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($profileImageErr) 
    && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
    && empty ($genuineErr)) {
        $conn = Connection::connect();

        /**
         * Check if a member exists in the database.
         */
        $stmt = $conn->prepare(SQL::$memberExists);
        $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
        $existingUser = $stmt->fetch();


        if($existingUser){
            $genuineErr = "ERROR: Member already exists!";
        }

        /**
         * Check if an address already exists in the database.
         *
         */
        $stmt = $conn->prepare(SQL::$addressExists);
        $stmt->execute([$address1, $address2, $city, $county, $postcode]);
        $existingAddress = $stmt->fetch();

        if($existingAddress){

            /**
             * Retrieves the existing address ID from the database.
             *
             */
            $stmt = $conn->prepare(SQL::$getExistingAddressId);
            $stmt->execute([$address1, $address2, $city, $county, $postcode]);
            $addressId = $stmt->fetch(PDO::FETCH_COLUMN);
        }

        else{

            /**
             * Prepares and executes a SQL statement to create a new address.
             */
            $stmt = $conn->prepare(SQL::$createNewAddress);
            $stmt->execute([$address1, $address2, $city, $county, $postcode]);

            /**
             * Retrieves the existing address ID from the database.
             */
            $stmt = $conn->prepare(SQL::$getExistingAddressId);
            $stmt->execute([$address1, $address2, $city, $county, $postcode]);
            $addressId = $stmt->fetch(PDO::FETCH_COLUMN);

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
            }

            /**
             * Prepares and executes a SQL statement to create a new member in the database.
             */
            $stmt = $conn->prepare(SQL::$createNewMember);
            $stmt->execute([$addressId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $filename]);

            /**
             * Redirects the user based on the session data.
             * If the session variable "newMember" is set, it sets a success message and redirects to success.php.
             * If the session variable "newMember" is not set, it redirects to member-list.php.
             */
            if(isset($_SESSION["newMember"])){
                $_SESSION["successMessage"] = "Registration Successful!";
                header("Location: " . Utils::$projectFilePath . "/success.php");
            }

            else{
                header("Location: " . Utils::$projectFilePath . "/member-list.php");
            }


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

<h2>Add New Member</h2>

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
        </div>

 </div>

 <input class="btn btn-dark" type="submit" onclick="return validateForm()" name="submit" value="Submit">  







</form>

<script>
    var currentTab = 0;
    const pDetails = document.getElementById("personal-details-form");
    const aDetails = document.getElementById("address-details-form");




    /**
     * Show the tab based on the currentTab value.
     * If currentTab is 0, display the paragraph details and hide the anchor details.
     * If currentTab is not 0, hide the paragraph details and display the anchor details.
     */
    function showTab(){
        if ( currentTab == 0){
            pDetails.style.display = "block";
            aDetails.style.display = "none";

        }

        else{
            pDetails.style.display = "none";
            aDetails.style.display = "block";

        }
    }

    showTab();

    /**
     * Functions to navigate to the next and previous tabs in a multi-step form.
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
     * Validates the form fields to ensure all required fields are filled out.
     * Displays an alert message if any required field is empty.
     * 
     * @return boolean - Returns false if any required field is empty, otherwise returns true.
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
    }
</script>
</main>

<?php
components::pageFooter();
?>