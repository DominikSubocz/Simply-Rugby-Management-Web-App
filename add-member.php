<?php
session_start();

require("classes/components.php");
require("classes/sql.php");
require_once("classes/connection.php");


// Define variables and initialize them
$nameErr = $dobErr = $emailErr = $sruErr = $contactNoErr = $mobileNoErr = $profileImageErr =  "";
$address1Err = $address2Err = $cityErr = $countyErr = $postcodeErr = "";
$genuineErr = "";

$name = $dob = $email = $sru = $contactNo = $mobileNo = $profileImage = "";
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

    if(empty($_POST["profileImage"])){
        $profileImageErr = "Profile Image is required";
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
            $genuineErr = "ERROR: Player already exists!";
        }

        else{
            // $_SESSION["successMessage"] = "Your message has been submitted successfully!";
            // header("Location: success.php");
            // exit();

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
            $stmt = $conn->prepare(SQL::$createNewMember);
            $stmt->execute([$addressId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $profileImage]);
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
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

  <p class="error"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label for="name">Name:</label><br>
      <input type="text" name="name" value="<?php echo $name;?>">
      <p class="error"><?php echo $nameErr;?></p><br>

      <label for="sru">SRU Number:</label><br>
      <input type="text" name="sru" value="<?php echo $sru;?>">
      <p class="error"><?php echo $sruErr;?></p><br>

      <label for="dob">Date of Birth:</label><br>
      <input type="text" name="dob" value="<?php echo $dob;?>">
      <p class="error"><?php echo $dobErr;?></p><br>

      <label for="email">Email:</label><br>
      <input type="text" name="email" value="<?php echo $email;?>">
      <p class="error"><?php echo $emailErr;?></p><br>

      <label for="contactNo">Contact Number:</label><br>
      <input type="text" name="contactNo" value="<?php echo $contactNo;?>">
      <p class="error"><?php echo $contactNoErr;?></p><br>

      <label for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" value="<?php echo $mobileNo;?>">
      <p class="error"><?php echo $mobileNoErr;?></p><br>

      <label>Profile image</label>
      <input type="file" name="profileImage" value="<?php echo $profileImage;?>">
      <p class="error"><?php echo $profileImageErr;?></p><br>

      <input type="button" value="Next" onclick="nextTab()">


  </div>

  <div id="address-details-form" class="add-form-section">
    <label for="address1">Address Line 1:</label><br>
        <input type="text" name="address1" value="<?php echo $address1;?>">
        <p class="error"><?php echo $address1Err;?></p><br>

    <label for="address2">Address Line 2:</label><br>
        <input type="text" name="address2" value="<?php echo $address2;?>">
        <p class="error"><?php echo $address2Err;?></p><br>   

    <label for="city">City:</label><br>
        <input type="text" name="city" value="<?php echo $city;?>">
        <p class="error"><?php echo $cityErr;?></p><br>  

    <label for="county">County:</label><br>
        <input type="text" name="county" value="<?php echo $county;?>">
        <p class="error"><?php echo $countyErr;?></p><br>  

    <label for="postcode">Postcode:</label><br>
        <input type="text" name="postcode" value="<?php echo $postcode;?>">
        <p class="error"><?php echo $postcodeErr;?></p><br>  
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