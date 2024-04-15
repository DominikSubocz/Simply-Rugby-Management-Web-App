<?php
/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
require("classes/sql.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");
require_once("classes/connection.php");
require("classes/coach.php");

/// Check if the user role is not Admin, then redirect to the logout page.
if($_SESSION["user_role"] != "Admin") {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
}
/**
 * Variables to store error messages and input values for form validation.
 * 
 * @var string $nameErr: Error message for name field.
 * @var string $dobErr: Error message for date of birth field.
 * @var string $contactNoErr: Error message for contact number field.
 * @var string $mobileNoErr: Error message for mobile number field.
 * @var string $emailErr: Error message for email field.
 * @var string $profileImageErr: Error message for profile image field.
 * @var string $genuineErr: Error message that appers on top of the form i.e "Not all input fields filled/correct"

 * 
 * Personal Information:
 * @var string $name: Holds value for Name input field
 * @var \DateTime $dob: Holds value for Date of birth input field
 * @var int  $contactNo:  Holds value forContact number input field
 * @var int  $mobileNo: Holds value for Mobile number input field
 * @var string  $email: Holds value for Email address input field
 * @var string  $filename: Holds value for Filename image validation
 * @var string  $firstName: Holds value for First name after the splitting process
 * @var string  $lastName: Holds value for Last name after the splitting proces
 */

 $nameErr = $dobErr = $emailErr = $contactNoErr = $mobileNoErr = $profileImageErr = $genuineErr = "";
 $name = $dob = $email = $contactNo = $mobileNo = $profileImage = $filename = "";
 $firstName = $lastName = "";

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

        $nameParts = explode(" ", $name); ///< Split player's name into first and last name

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

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]); ///< Sanitize mobile number
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed"; ///< Display error message
        }
    } 

    if(empty($nameErr) && empty($dobErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($emailErr)){
       
        $existingCoach = Coach::checkCoach($firstName, $lastName, $email);

        if($existingCoach){
            $genuineErr = "Coach already exists!";
        } else {

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
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: Invalid file size/format</p>"; ///< Display error message
                }
            
                $tmpname = $_FILES["profileImage"]["tmp_name"];
            
                if (!move_uploaded_file($tmpname, "images/$filename")) {
                    $profileImageErr = "<p class='alert alert-danger'>ERROR: File was not uploaded</p>"; ///< Display error message
                }
            }

            Coach::createCoach($firstName, $lastName, $sqlDate, $contactNo, $mobileNo, $email, $filename);

            }
        }
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

  components::pageHeader("Add Coach", ["style"], ["mobile-nav"]);
?>
<main class="content-wrapper contact-content my-5">
    <h2>Add New Coach</h2>
    <div class="alert alert-info">
        <p><strong>NOTE: </strong> Fields marked with <span class="required">*</span> are mandatory.</p>
    </div>
    <form 
        method="post" 
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"
        enctype="multipart/form-data">

        <p class="alert alert-danger"><?php echo $genuineErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="name"><span class="required">*</span>Name:</label><br>
        <input type="text" name="name" value="<?php echo $name;?>">
        <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="dob"><span class="required">*</span>Date of Birth:</label><br>
        <input type="text" name="dob" value="<?php echo $dob;?>">
        <p class="alert alert-danger"><?php echo $dobErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="contactNo"><span class="required">*</span>Contact Number:</label><br>
        <input type="text" name="contactNo" value="<?php echo $contactNo;?>">
        <p class="alert alert-danger"><?php echo $contactNoErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="mobileNo">Mobile Number:</label><br>
        <input type="text" name="mobileNo" value="<?php echo $mobileNo;?>">
        <p class="alert alert-danger"><?php echo $mobileNoErr;?></p><br>

        <label class="col-sm-2 col-form-label-sm"for="email"><span class="required">*</span>Email:</label><br>
        <input type="text" name="email" value="<?php echo $email;?>">
        <p class="alert alert-danger"><?php echo $emailErr;?></p><br>

        <label><span class="required">*</span>Profile image</label>
        <input type="file" name="profileImage" value="">
        <p class="alert alert-danger"><?php echo $profileImageErr;?></p><br>

        <input class="btn btn-dark" type="submit" name="submit" onclick="return validateForm()" value="Submit">  

</form>
<script>

function validateForm() {
        let nameInput = document.forms[0]["name"].value.trim();
        let dobInput = document.forms[0]["dob"].value.trim();
        let emailInput = document.forms[0]["email"].value.trim();
        let contactInput = document.forms[0]["contactNo"].value.trim();
        let pfpInput = document.forms[0]["profileImage"].value.trim();

        
        if (nameInput == "") {
            alert("Name must be filled out");
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
    }

</script>