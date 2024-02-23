<?php
session_start();

require("classes/components.php");
require("classes/utils.php");
require("classes/form-validation.php");

components::pageHeader("Add Player", ["style"], ["mobile-nav"]);
?>

<main class="content-wrapper contact-content">

<h2>PHP Form Validation Example</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  
  <div id="personal-details-form">
      <label for="name">Name:</label><br>
      <input type="text" name="name" value="<?php echo $name;?>">
      <span class="error"><?php echo $nameErr;?></span><br>

      <label for="sru">SRU Number:</label><br>
      <input type="text" name="sru" value="<?php echo $sru;?>">
      <span class="error"><?php echo $sruErr;?></span><br>

      <label for="email">Email:</label><br>
      <input type="text" name="email" value="<?php echo $email;?>">
      <span class="error"><?php echo $emailErr;?></span><br>

      <label for="contactNo">Contact Number:</label><br>
      <input type="text" name="contactNo" value="<?php echo $contactNo;?>">
      <span class="error"><?php echo $contactNoErr;?></span><br>

      <label for="mobileNo">Mobile Number:</label><br>
      <input type="text" name="mobileNo" value="<?php echo $mobileNo;?>">
      <span class="error"><?php echo $mobileNoErr;?></span><br>

      <label for="healthIssues">Health Issues:</label><br>
      <input type="text" name="healthIssues" value="<?php echo $healthIssues;?>">
      <span class="error"><?php echo $healthIssuesErr;?></span><br>


      <input type="button" value="Next" onclick="nextTab()">
  </div>

  <div id="address-details-form">
    <label for="address1">Address Line 1:</label><br>
        <input type="text" name="address1" value="<?php echo $address1;?>">
        <span class="error"><?php echo $address1Err;?></span><br>

    <label for="address2">Address Line 2:</label><br>
        <input type="text" name="address2" value="<?php echo $address2;?>">
        <span class="error"><?php echo $address2Err;?></span><br>   

    <label for="city">City:</label><br>
        <input type="text" name="city" value="<?php echo $city;?>">
        <span class="error"><?php echo $cityErr;?></span><br>  

    <label for="county">County:</label><br>
        <input type="text" name="county" value="<?php echo $county;?>">
        <span class="error"><?php echo $countyErr;?></span><br>  

    <label for="postcode">Postcode:</label><br>
        <input type="text" name="postcode" value="<?php echo $postcode;?>">
        <span class="error"><?php echo $postcodeErr;?></span><br>  
 </div>

  <input type="submit" name="submit" value="Submit">  

</form>

<script>

    var currentTab = 0;
    const pDetails = document.getElementById("personal-details-form");
    const aDetails = document.getElementById("address-details-form");
    if ( currentTab == 0){
        pDetails.style.display = "block";
        aDetails.style.display = "none";
    }

    function nextTab(){
        currentTab +=1;

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