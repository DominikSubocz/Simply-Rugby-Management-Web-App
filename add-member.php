<?php
session_start();

require("classes/components.php");
require("classes/sql.php");
require("classes/utils.php");
require_once("classes/connection.php");

if(($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

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

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]);
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed";
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


    
    // If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($profileImageErr) 
    && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
    && empty ($genuineErr)) {
        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$memberExists);
        $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
        $existingUser = $stmt->fetch();


        if($existingUser){
            $genuineErr = "ERROR: Member already exists!";
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
            }

            $stmt = $conn->prepare(SQL::$createNewMember);
            $stmt->execute([$addressId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $filename]);
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