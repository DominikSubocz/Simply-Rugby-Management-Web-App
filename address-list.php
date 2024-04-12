<?php

/// This must come first when we need access to the current session
session_start();

require("classes/components.php");
require("classes/connection.php");
require("classes/sql.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");require("classes/address.php");

Components::pageHeader("List of Addresses", ["style"], ["mobile-nav"]);

/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){

  header("Location: " . Utils::$projectFilePath . "/login.php");

}

/**
 * Check if the user role is not Admin or Coach, then redirect to logout page.
 */

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

/**
 * Check if the remove button was clicked.
 * If clicked check if the 'check_list' POST parameter is not empty.
 * Redirect to the 'delete-address.php' page with the IDs from the 'check_list' array as query parameters.
 */
if(isset($_POST['removeSubmit'])){
  if(!empty($_POST['check_list'])) {
    foreach($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-address.php?id=$check");
    }
  }
}

  
?>

<main class="content-wrapper profile-list-content my-5">
  
<div id="address-controls" class="alert alert-info my-3">
  
  <form 
    method="post" 
    action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <div>
      <p><strong>NOTE: </strong>Ensure that the address isn't used anywhere else before removing!</p>
    </div>
</div>

<div class="bg-dark text-white d-flex p-2">          
  <input type="button" id="settingsBtn" class="btn btn-info mx-2 my-2" value="Settings">  
  <input class="btn btn-danger mx-2 my-2" id="removeBtn" type="submit" name="removeSubmit" value="Remove Address">
</div>

<table class="table" id="customDataTable">
  <thead>
    <tr>
      <th>#</th>
      <th class="address-line-1-label">Address Line 1</th>
      <th class="address-line-2-label">Address Line 2</th>
      <th class="city-label">City</th>
      <th class="county-label">County</th>
      <th class="postcode-label">Postcode</th>
    </tr>
  </thead>
  <tbody>


    <?php

    /// Get all addresses from the database and output addresses as table rows
    $addresses = Address::getAllAddresses();
    Components::allAddresses($addresses);

    ?>

  </tbody>
</table>


</div>
</form>
<div id="myModal" class="modal">
  <div class="modal-content column-settings-content  w-50">
      <span class="close">&times;</span>
      <h3>Column Settings</h3>
 
      <div class="container">
        <div class="row">
          <div class="col">            
            <label class="checkbox-inline">Address Line 1</label>
            <input type="checkbox" id="inlineCheckbox1" value="option1" onclick="displayColumn()" checked>
          </div>
          <div class="col">      
            <label class="checkbox-inline">Address Line 2</label>
            <input type="checkbox" id="inlineCheckbox2" value="option2" onclick="displayColumn()" checked>
          </div>
          <div class="w-100"></div>
          <div class="col">      
            <label class="checkbox-inline">City</label>
            <input type="checkbox" id="inlineCheckbox3" value="option3" onclick="displayColumn()" checked>
          </div>
          <div class="col">      
            <label class="checkbox-inline">County</label>
            <input type="checkbox" id="inlineCheckbox4" value="option4" onclick="displayColumn()" checked>
          </div>

          <div class="w-100"></div>
          <div class="col">      
            <label class="checkbox-inline">Postcode</label>
            <input type="checkbox" id="inlineCheckbox5" value="option5" onclick="displayColumn()" checked>
          </div>
        </div>
      </div>
  </div>
</div>
</main>

<script>
var modal = document.getElementById("myModal");
let settingsBtn = document.getElementById("settingsBtn");
var span = document.getElementsByClassName("close")[0];


settingsBtn.onclick = function(event) {
    /// Prevent the default form submission action
    event.preventDefault();
    modal.style.display = "block";
  }


  /// When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }


  /// When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }


/**
 * Display or hide columns based on the checkboxes checked.
 */
function displayColumn(){

  var checkBox1 = document.getElementById("inlineCheckbox1");
  var checkBox2 = document.getElementById("inlineCheckbox2");
  var checkBox3 = document.getElementById("inlineCheckbox3");
  var checkBox4 = document.getElementById("inlineCheckbox4");
  var checkBox5 = document.getElementById("inlineCheckbox5");

  var addressLine1 = document.querySelectorAll(".address-line-1-label");
  var addressLine2 = document.querySelectorAll(".address-line-2-label");
  var city = document.querySelectorAll(".city-label");
  var county = document.querySelectorAll(".county-label");
  var postcode = document.querySelectorAll(".postcode-label");

  /// Check if checkbox 1 is checked
  if (checkBox1.checked) {
    for (var i = 0; i < addressLine1.length; i++) {
      addressLine1[i].style.display = "table-cell";    ///< Display each element in the addressLine1 array as a table cell.

    }
  } else {
    for (var i = 0; i < addressLine1.length; i++) {
      addressLine1[i].style.display = "none";   ///< Hide each element in the addressLine1 array.
    }
  }

  if (checkBox2.checked) {
    for (var i = 0; i < addressLine2.length; i++) {
      addressLine2[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < addressLine2.length; i++) {
      addressLine2[i].style.display = "none";
    }
  }

  if (checkBox3.checked) {
    for (var i = 0; i < city.length; i++) {
      city[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < city.length; i++) {
      city[i].style.display = "none";
    }
  }

  if (checkBox4.checked) {
    for (var i = 0; i < postcode.length; i++) {
      county[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < county.length; i++) {
      county[i].style.display = "none";
    }
  }

  if (checkBox5.checked) {
    for (var i = 0; i < postcode.length; i++) {
      postcode[i].style.display = "table-cell";
    }
  } else {
    for (var i = 0; i < postcode.length; i++) {
      postcode[i].style.display = "none";
    }
  }
}

displayColumn();

/**
 * Unchecks all checkboxes with the class "cb" on the document when the function is called.
 */
function cbChange(obj) {
    var cbs = document.getElementsByClassName("cb");
    for (var i = 0; i < cbs.length; i++) {
        cbs[i].checked = false;
    }
    obj.checked = true;
    displayButtons("block");
}

/**
 * Function to display buttons based on the type provided.
 */
function displayButtons(type){

  if(type == "block"){
    removeBtn.style.display="block";
  } else {
    removeBtn.style.display="none";

  }
}

displayButtons("none");

  
</script>
<?php

Components::pageFooter(); ///< Render page footer

?>