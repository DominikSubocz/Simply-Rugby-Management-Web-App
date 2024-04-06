<?php
session_start();

require("classes/components.php");
require("classes/sql.php");
require("classes/utils.php");
require_once("classes/connection.php");
require("classes/member.php");
require("classes/address.php");


if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

$memberId = $_GET["id"];


$member = Member::getMember($memberId);

$address_idPlaceholder = Utils::escape($member["address_id"]);

$user_idPlaceholder = Utils::escape($member["user_id"]);
$dobPlaceholder = Utils::escape($member["dob"]);
$filenamePlaceholder = Utils::escape($member["filename"]);

$firstNamePlaceholder = Utils::escape($member["first_name"]);
$lastNamePlaceholder = Utils::escape($member["last_name"]);
$sruNumberPlaceholder = Utils::escape($member["sru_no"]);
$contactNumberPlaceholder = Utils::escape($member["contact_no"]);
$mobileNumberPlaceholder = Utils::escape($member["mobile_no"]);
$emailAddressPlaceholder = Utils::escape($member["email_address"]);

$address1Placeholder = Utils::escape($member["address_line"]);
$address2Placeholder = Utils::escape($member["address_line2"]);
$cityPlaceholder = Utils::escape($member["city"]);
$countyPlaceholder = Utils::escape($member["county"]);
$postcodePlaceholder = Utils::escape($member["postcode"]);

$phpdate = strtotime( $dobPlaceholder );
$ukDobPlaceholder = date( 'd/m/Y', $phpdate );

// Define variables and initialize them
$nameErr = $dobErr = $emailErr = $sruErr = $contactNoErr = $mobileNoErr = $profileImageErr =  "";
$address1Err = $address2Err = $cityErr = $countyErr = $postcodeErr = "";
$genuineErr = $profileImageErr = "";

$name = $dob = $email = $sru = $contactNo = $mobileNo = $profileImage = $filename = "";
$address1 = $address2 = $city = $county = $postcode = "";
$firstName = $lastName = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["name"])) {
        $name = $firstNamePlaceholder . ' ' . $lastNamePlaceholder;

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

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]);
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed";
        }
    }  else {
        $mobileNo = $mobileNumberPlaceholder;
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


    
    // This will execute regardless of the file upload status
    var_dump($filename);

    // If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($profileImageErr) 
    && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
    && empty ($genuineErr)) {

        $existingUser = Member::memberExists($firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo);

        $existingAddress = Address::addressExists($address1, $address2, $city, $county, $postcode);

        if($existingAddress){

            $addressId = Address::getExistingAddress($address1, $address2, $city, $county, $postcode);
        
        }

        else{

            $addressId = Address::createNewAddress($address1, $address2, $city, $county, $postcode);

        }

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
                $filename = $filenamePlaceholder;  // Turns out I was using $player instead of $member, so easy fix.


            }   

            Member::updateMember($addressId, $firstName, $lastName, $dob, $sru, $contactNo, $mobileNo, $email, $filename, $memberId);


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
method="post" 
action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $member["member_id"];?>"
enctype="multipart/form-data">

  <p class="alert alert-danger"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label  class="col-sm-2 col-form-label-sm"for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $firstNamePlaceholder . ' '. $lastNamePlaceholder;?> " value="<?php echo $name;?>">
      <p class="alert alert-danger"><?php echo $nameErr;?></p><br>

      <label  class="col-sm-2 col-form-label-sm"for="sru">SRU Number:</label><br>
      <input type="text" name="sru" placeholder="<?php echo $sruNumberPlaceholder;?>"  value="<?php echo $sru;?>">
      <p class="alert alert-danger"><?php echo $sruErr;?></p><br>

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

      <input type="button" value="Next" onclick="nextTab()">


  </div>

  <div id="address-details-form" class="add-form-section">
    <label  class="col-sm-2 col-form-label-sm"for="address1">Address Line 1:</label><br>
        <input type="text" placeholder="<?php echo $address1Placeholder; ?>" s  name="address1" value="<?php echo $address1;?>">
        <p class="alert alert-danger"><?php echo $address1Err;?></p><br>

    <label  class="col-sm-2 col-form-label-sm"for="address2">Address Line 2:</label><br>
        <input type="text" name="address2" placeholder="<?php echo $address2Placeholder; ?>"   value="<?php echo $address2;?>">
        <p class="alert alert-danger"><?php echo $address2Err;?></p><br>   

    <label  class="col-sm-2 col-form-label-sm"for="city">City:</label><br>
        <input type="text" name="city" placeholder="<?php echo $cityPlaceholder; ?>"   value="<?php echo $city;?>">
        <p class="alert alert-danger"><?php echo $cityErr;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="county">County:</label><br>
        <input type="text" name="county" placeholder="<?php echo $countyPlaceholder; ?>"   value="<?php echo $county;?>">
        <p class="alert alert-danger"><?php echo $countyErr;?></p><br>  

    <label  class="col-sm-2 col-form-label-sm"for="postcode">Postcode:</label><br>
        <input type="text" name="postcode" placeholder="<?php echo $postcodePlaceholder; ?>"  value="<?php echo $postcode;?>">
        <p class="alert alert-danger"><?php echo $postcodeErr;?></p><br>  
        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="submit" name="submit" value="Submit">  
        </div>

 </div>








</form>

<script>
    var currentTab = 0;
    const pDetails = document.getElementById("personal-details-form");
    const aDetails = document.getElementById("address-details-form");

    showTab();

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

        }

        else{
            pDetails.style.display = "none";
            aDetails.style.display = "block";

        }
    }


</script>
</main>

<?php
components::pageFooter();
?>