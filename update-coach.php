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
require("classes/coach.php");
require("classes/address.php");


/**
 * Check if the user role is not Admin or Coach, and redirect to logout page if true.
 */
if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
}

$coachId = $_GET["id"]; ///< Get ID of coach


$coach = Coach::getCoach($coachId); ///< Get coach's details based on ID number

/**
 * Escape and assign placeholders for coach information.
 */
$user_idPlaceholder = Utils::escape($coach["user_id"]);
$dobPlaceholder = Utils::escape($coach["dob"]);
$filenamePlaceholder = Utils::escape($coach["filename"]);

$firstNamePlaceholder = Utils::escape($coach["first_name"]);
$lastNamePlaceholder = Utils::escape($coach["last_name"]);
$contactNumberPlaceholder = Utils::escape($coach["contact_no"]);
$mobileNumberPlaceholder = Utils::escape($coach["mobile_no"]);
$emailAddressPlaceholder = Utils::escape($coach["email_address"]);

$phpdate = strtotime( $dobPlaceholder); ///< Converts a date of birth (dob) into a SQL date format (YYYY-MM-DD).
$ukDobPlaceholder = date( 'd/m/Y', $phpdate ); ///< Format a Unix timestamp into a UK date of birth placeholder string.

/**
 * Variables to hold error messages for form validation.
 *
 * @var string $nameErr - Error message for name validation
 * @var string $dobErr - Error message for date of birth validation
 * @var string $emailErr - Error message for emaill validation
 * @var string $contactNoErr - Error message for contact number validation
 * @var string $mobileNoErr - Error message for mobile number validation
 * @var string $profileImageErr - Error message for profile image validation
 * @var string $genuineErr - Error message to be displayed on top of the form i.e "not all input fields filled/correct"
 * @var string $filename - Error message for profile image validation
 *
 * Variables to hold form input values.
 *
 * @var string $name - Full name of coach
 * @var string $dob - Coach's date of birth
 * @var string $email - Coach's email address
 * @var string $contactNo - Coach's contact number
 * @var string $mobileNo - Coach's mobile number
 * @var string $profileImage - Coach's profile image
 * @var string $firstName - Coach's first name (first half of $name after explode())
 * @var string $lastName - Coach's last name (second half of $name after explode())
 */
$nameErr = $dobErr = $emailErr = $contactNoErr = $mobileNoErr = $profileImageErr =  "";
$genuineErr = $profileImageErr = "";

$name = $dob = $email = $contactNo = $mobileNo = $profileImage = $filename = "";
$firstName = $lastName = "";


/**
 * This function is used to handle form submission when the HTTP request method is POST. 
 * It validates the form inputs and processes the data accordingly.
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /// Validate name
    if (empty($_POST["name"])) {
        $name = $firstNamePlaceholder . ' ' . $lastNamePlaceholder; ///< Set value to placeholder if left empty

        $nameParts = explode(" ", $name);   ///< Split coach name into first and last name

        /// Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    } else {
        $name = test_input($_POST["name"]); ///< Sanitize name
        /// Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed"; //< Display error message
        }

        $nameParts = explode(" ", $name); ///< Splits a string into an array using a space as the delimiter.

        /// Extract the first and last names
        $firstName = $nameParts[0];
        $lastName = end($nameParts);
    }

    /// Validate email
    if (empty($_POST["email"])) {
        $email = $emailAddressPlaceholder; ///< Set value to placeholder if left empty
    } else {
        $email = test_input($_POST["email"]); ///< Sanitize email address
        /// Check if email address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format"; //< Display error message
        }
    }

    if (empty($_POST["dob"])){
        $dob = date('d/m/Y', strtotime($dobPlaceholder)); ///< Set value to placeholder if left empty

        $sqlDate = date('Y-m-d', strtotime($dob)); ///< Converts a date of birth (dob) into a SQL date format (YYYY-MM-DD).
    } else {
        $dob = test_input($_POST["dob"]); ///< Sanitize dob
        if (!preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
            $dobErr = "Invalid date of birth format. Please use DD/MM/YYYY"; //< Display error message
        }

        $sqlDate = date('Y-m-d', strtotime($dob)); ///< Converts a date of birth (dob) into a SQL date format (YYYY-MM-DD).
    }

    if(empty($_POST["contactNo"])){
        $contactNo = $contactNumberPlaceholder; ///< Set value to placeholder if left empty

    } else {
        $contactNo = test_input($_POST["contactNo"]); ///< Sanitize contact number
        if (!preg_match("/^\d+$/", $contactNo)) {
            $contactNoErr = "Only digits allowed"; //< Display error message
        }
    }

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]); ///< Sanitize mobile number
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed"; //< Display error message
        }
    }  else {
        $mobileNo = $mobileNumberPlaceholder;  ///< Set value to placeholder if left empty
    }

    /// If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($profileImageErr) 
    && empty ($genuineErr)) {

        /**
         * Validates and processes the profile image upload, and updates the coach information if no errors are found.
         */
        if(empty($genuineErr)){
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
                $filename = $filenamePlaceholder;  /// Turns out I was using $player instead of $coach, so easy fix.
            }   
            /**
             * Update coach information in the database.
             *
             * @param string $firstName The first name of the coach.
             * @param string $lastName The last name of the coach.
             * @param string $dob The date of birth of the coach.
             * @param string $contactNo The contact number of the coach.
             * @param string $mobileNo The mobile number of the coach.
             * @param string $email The email address of the coach.
             * @param string $filename The filename of the coach's image.
             * @param int $coachId The ID of the coach to update.
             */
            Coach::updateCoach($firstName, $lastName, $dob, $contactNo, $mobileNo, $email, $filename, $coachId);
        }
    } else{
        $genuineErr = "ERROR: Not all form inputs filled/correct!"; ///< Output if there are errors
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
components::pageHeader("Add Player", ["style"], ["mobile-nav"]); ///< Render page header
?>

<main class="content-wrapper contact-content">

<h2>Add New Player</h2>
<form 
method="post" 
action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $coach["coach_id"];?>"
enctype="multipart/form-data">

  <p class="alert alert-danger"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label  class="col-sm-2 col-form-label-sm"for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $firstNamePlaceholder . ' '. $lastNamePlaceholder;?> " value="<?php echo $name;?>">
      <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="dob">Date of Birth:</label><br>
      <input type="text" name="dob" placeholder="<?php echo $ukDobPlaceholder; ?>"  value="<?php echo $dob;?>">
      <p class="alert alert-danger"><?php echo $dobErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="email">Email:</label><br>
      <input type="text" name="email" placeholder="<?php echo $emailAddressPlaceholder; ?>"   value="<?php echo $email;?>">
      <p class="alert alert-danger"><?php echo $emailErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="contactNo">Contact Number:</label><br>
      <input type="text" name="contactNo" placeholder="<?php echo $contactNumberPlaceholder; ?>"   value="<?php echo $contactNo;?>">
      <p class="alert alert-danger"><?php echo $contactNoErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" placeholder="<?php echo $mobileNumberPlaceholder; ?>"   value="<?php echo $mobileNo;?>">
      <p class="alert alert-danger"><?php echo $mobileNoErr;?></p><br>

      <label>Profile image</label>
      <input type="file" name="profileImage" value="">
      <p class="alert alert-danger"><?php echo $profileImageErr;?></p><br>

      <input type="submit" name="submit" value="Submit">  
  </div>

</form>
</main>

<?php
components::pageFooter(); ///< Render page footer
?>