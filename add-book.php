<?php
session_start();

require("classes/components.php");
require("classes/form-validation.php");

// TO DO:

// 1. Check if player's personal details (name, sru, dob, contact details) are 100% identical with any record in database
// If it matches 100% throw error: "player already exists"
// 2. Check if address is already in database, if 100% match just assign the new player with existing address id and don't add new address. Else add new doctor.
// 3. Not rly much for next of kin, after all they don't have a table so idk.
// 4. Check if doctor is already in database, if 100% match just assign the new player with existing doctor id and don't add new address. Else add new doctor.


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

      <label for="healthIssues">Health Issues:</label><br>
      <input type="text" name="healthIssues" value="<?php echo $healthIssues;?>">
      <p class="error"><?php echo $healthIssuesErr;?></p><br>


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
            <input type="button" value="Next" onclick="nextTab()">
        </div>

 </div>

 <div id="kin-details-form" class="add-form-section">
    <label for="kin">Next of Kin:</label><br>
        <input type="text" name="kin" value="<?php echo $kin;?>">
        <p class="error"><?php echo $kinErr;?></p><br>

    <label for="kinContact">Contact Number:</label><br>
        <input type="text" name="kinContact" value="<?php echo $kinContact;?>">
        <p class="error"><?php echo $kinContactErr;?></p><br>   
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