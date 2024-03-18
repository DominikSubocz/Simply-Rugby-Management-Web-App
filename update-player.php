<?php

session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");


$conn = Connection::connect();


Components::pageHeader("Login", ["style"], ["mobile-nav"]);

$bookId = $_GET["id"];

require("classes/player.php");

$book = Book::getBook($bookId);

$playerFirstName = Utils::escape($book["first_name"]);
$playerLastName = Utils::escape($book["last_name"]);

$dobPlaceholder = Utils::escape($book["dob"]);
$user_idPlaceholder = Utils::escape($book["user_id"]);
$sruNumberPlaceholder = Utils::escape($book["sru_no"]);
$contactNumberPlaceholder = Utils::escape($book["contact_no"]);
$mobileNumberPlaceholder = Utils::escape($book["mobile_no"]);
$emailAddressPlaceholder = Utils::escape($book["email_address"]);
$healthIssuesPlaceholder = Utils::escape($book["health_issues"]);
$filenamePlaceholder = Utils::escape($book["filename"]);
$nextOfKinPlaceholder = Utils::escape($book["next_of_kin"]);
$kinContactNumberPlaceholder = Utils::escape($book["kin_contact_no"]);

$address1Placeholder = Utils::escape($book["address_line"]);
$address2Placeholder = Utils::escape($book["address_line2"]);
$cityPlaceholder = Utils::escape($book["city"]);
$countyPlaceholder = Utils::escape($book["county"]);
$postcodePlaceholder = Utils::escape($book["postcode"]);
$doctorFirstNamePlaceholder = Utils::escape($book["doctor_first_name"]);
$doctorLastNamePlaceholder = Utils::escape($book["doctor_last_name"]);
$doctorContactPlaceholder = Utils::escape($book["doctor_contact_no"]);

$phpdate = strtotime( $dobPlaceholder );
$ukDobPlaceholder = date( 'd/m/Y', $phpdate );


$nameErr = $dobErr = $emailErr = $websiteErr = $sruErr = $contactNoErr = $mobileNoErr = $healthIssuesErr = $profileImageErr =  "";
$address1Err = $address2Err = $cityErr = $countyErr = $postcodeErr = "";
$kinErr = $kinContactErr = $doctorNameErr = $doctorContactErr = "";
$genuineErr = $profileImageErr = "";

$doctorId = $addressId = "";


$name = $dob = $email = $website = $sru = $contactNo = $mobileNo = $healthIssues = $profileImage = $filename = "";
$firstName = $lastName = "";
$address1 = $address2 = $city = $county = $postcode = "";
$kin = $kinContact = $doctorName = $doctorContact = "";

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

    if(!empty($_POST["mobileNo"])){
        $mobileNo = test_input($_POST["mobileNo"]);
        if (!preg_match("/^\d+$/", $mobileNo)) {
            $mobileNoErr = "Only digits allowed";
        }
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


 


    // Emergency Contact Details

    if (empty($_POST["kin"])) {
        $kinErr = "Name is required";
    } else {
        $kin = test_input($_POST["kin"]);
        // Check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z-' ]*$/", $kin)) {
            $kinErr = "Only letters and white space allowed";
        }
    }

    if(empty($_POST["kinContact"])){
        $kinContactErr = "Contact Number is required";

    } else {
        $kinContact = test_input($_POST["kinContact"]);
        if (!preg_match("/^\d+$/", $kinContact)) {
            $kinContactErr = "Only digits allowed";
        }
    }

    // Doctor Details

    // Validate name
    if (empty($_POST["doctorName"])) {
        $doctorNameErr = "Doctor's name is required";
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
        $doctorContactErr = "Contact Number is required";

    } else {
        $doctorContact = test_input($_POST["doctorContact"]);
        if (!preg_match("/^\d+$/", $kinContact)) {
            $doctorContactErr = "Only digits allowed";
        }
    }

    

    // If there are no errors, redirect to success page
    if (empty($nameErr) && empty($dobErr) && empty($emailErr) && empty($websiteErr) && empty($contactNoErr) && empty($mobileNoErr) && empty($healthIssuesErr) && empty($profileImageErr) 
    && empty($address1Err) && empty($address2Err) && empty($cityErr) && empty($countyErr) && empty($postcodeErr)
    && empty($kinErr) && empty($kinContactErr) && empty($doctorNameErr) && empty($doctorContactErr) && empty ($genuineErr)) {

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$playerExists);
        $stmt->execute([$firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo]);
        $existingUser = $stmt->fetch();


        if($existingUser){
            var_dump("Updating player but not changing main");
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
            }
            var_dump("Update Player");
        
        

            var_dump(Book::updatePlayer($addressId, $doctorId, $firstName, $lastName, $sqlDate, $sru, $contactNo, $mobileNo, $email, $kin, $kinContact, $healthIssues, $filename, $bookId));
            
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



?>
<main class="content-wrapper contact-content">

<h2>Update <?php echo $playerFirstName . ' '. $playerLastName; ?></h2>
<form 
    method="POST"
    action="<?php echo $_SERVER["PHP_SELF"]; ?>?id=<?php echo $book["player_id"];?>"
    encypte="multipart/form-data">

  <p class="error"><?php echo $genuineErr;?></p><br>

  
  <div id="personal-details-form">
      <label for="name">Name:</label><br>
      <input type="text" name="name" placeholder="<?php echo $playerFirstName. ' '. $playerLastName;?>" value="<?php echo $name;?>">
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
      <input type="file" name="profileImage"  value="">
      <p class="error"><?php echo $profileImageErr;?></p><br>


      <input type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form" class="add-form-section">
    <label for="address1">Address Line 1:</label><br>
        <input type="text" name="address1" placeholder="<?php echo $address1Placeholder;?>" value="<?php echo $address1;?>">
        <p class="error"><?php echo $address1Err;?></p><br>

    <label for="address2">Address Line 2:</label><br>
        <input type="text" name="address2" placeholder="<?php echo $address2Placeholder;?>" value="<?php echo $address2;?>">
        <p class="error"><?php echo $address2Err;?></p><br>   

    <label for="city">City:</label><br>
        <input type="text" name="city" placeholder="<?php echo $cityPlaceholder;?>" value="<?php echo $city;?>">
        <p class="error"><?php echo $cityErr;?></p><br>  

    <label for="county">County:</label><br>
        <input type="text" name="county" placeholder="<?php echo $countyPlaceholder;?>" value="<?php echo $county;?>">
        <p class="error"><?php echo $countyErr;?></p><br>  

    <label for="postcode">Postcode:</label><br>
        <input type="text" name="postcode" placeholder="<?php echo $postcodePlaceholder;?>" value="<?php echo $postcode;?>">
        <p class="error"><?php echo  $postcodeErr;?></p><br>  
        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>

 </div>

 <div id="kin-details-form" class="add-form-section">
    <label for="kin">Next of Kin:</label><br>
        <input type="text" name="kin" placeholder="<?php echo $nextOfKinPlaceholder;?>" value="<?php echo $kin;?>">
        <p class="error"><?php echo $kinErr;?></p><br>

    <label for="kinContact">Contact Number:</label><br>
        <input type="text" name="kinContact" placeholder="<?php echo $kinContactNumberPlaceholder;?>" value="<?php echo $kinContact;?>">
        <p class="error"><?php echo $kinContactErr;?></p><br>   
        <div>
            <input type="button" value="Previous" onclick="prevTab()">
            <input type="button" value="Next" onclick="nextTab()">
        </div>
 </div>

 <div id="doctor-details-form">
    <label for="doctorName">Doctor Name:</label><br>
        <input type="text" name="doctorName" placeholder="<?php echo $doctorFirstNamePlaceholder. ' '. $doctorLastNamePlaceholder;?>" value="<?php echo $doctorName;?>">
        <p class="error"><?php echo $doctorNameErr;?></p><br>

    <label for="doctorContact">Contact Number:</label><br>
        <input type="text" name="doctorContact" placeholder="<?php echo $doctorContactPlaceholder;?>" value="<?php echo $doctorContact;?>">
        <p class="error"><?php echo $doctorContactErr;?></p><br>   
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


</script>
</main>

<?php
components::pageFooter();
?>
