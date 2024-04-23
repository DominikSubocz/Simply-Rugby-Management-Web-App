<?php

/// This must come first when we need access to the current session
session_start();
require ("classes/components.php");
require ("classes/connection.php");
require ("classes/sql.php");
require ("classes/events.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require ("classes/utils.php");

Components::pageHeader("Timetable", ["style"], ["mobile-nav"]); ///< Render page header

/**
 * Check if the update button was clicked.
 * If clicked redirect to the update page for each checked item in the 'check_list'.
 * The update page URL is constructed using the project file path and the checked item.
 *
 * @param array $_POST The associative array containing POST data.
 */
if (isset($_POST['updateSubmit'])) {
  if (!empty($_POST['check_list'])) {
    foreach ($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/update-$check");
    }
  }
}
/**
 * Check if the add button was clicked.
 * Redirect to the 'add-event.php' page if clicked
 */
if (isset($_POST['addSubmit'])) {
  header("Location: " . Utils::$projectFilePath . "/add-event.php");

}

/**
 * Check if the delete button was clicked.
 * and redirect to the delete page for each checked item.
 * 
 * The update page URL is constructed using the project file path and the checked item.
 *
 * @param array $_POST The associative array containing POST data.
 */
if (isset($_POST['removeSubmit'])) {
  if (!empty($_POST['check_list'])) {
    foreach ($_POST['check_list'] as $check) {
      header("Location: " . Utils::$projectFilePath . "/delete-$check");
    }
  }
}

?>


<main class="content-wrapper contact-content">

  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="bg-dark text-white d-flex p-2">
      <input class="btn btn-primary mx-2 my-2" type="submit" id="addBtn" name="addSubmit" value="Add Event">
      <input class="btn btn-secondary mx-2 my-2" type="submit" id="updateBtn" name="updateSubmit" value="Update Event">
      <input class="btn btn-danger mx-2 my-2" type="submit" id="removeBtn" name="removeSubmit" value="Remove Event">
      <input type="hidden" id="hidden-role-field" name="hidden-role-field" value="<?php echo $_SESSION["user_role"]; ?>">
      <input type="button" id="settingsBtn" class="btn btn-info ms-auto my-2" value="Settings">
    </div>
    <table class="table" id="customDataTable">
      <thead>
        <tr>
          <th>#</th>
          <th class="name-label">Name</th>
          <th class="type-label">Type</th>
          <th class="start-date-label">Start Date.</th>
          <th class="end-date-label">End Date</th>
          <th class="location-label">Location</th>
        </tr>
      </thead>
      <tbody>


        <?php


        $events = Events::getAllEvents(); ///< Get all events
        Components::allEvents($events); ///< Render row for each event
        
        ?>

      </tbody>
    </table>
  </form>

  <div id="myModal" class="modal">
    <div class="modal-content column-settings-content  w-50">
      <span class="close">&times;</span>
      <h3>Column Settings</h3>

      <div class="container">
        <div class="row">
          <div class="col">
            <label class="checkbox-inline">Name</label>
            <input type="checkbox" id="inlineCheckbox1" value="option1" onclick="displayColumn()" checked>
          </div>
          <div class="col">
            <label class="checkbox-inline">Type</label>
            <input type="checkbox" id="inlineCheckbox2" value="option2" onclick="displayColumn()" checked>
          </div>
          <div class="w-100"></div>
          <div class="col">
            <label class="checkbox-inline">Start Date</label>
            <input type="checkbox" id="inlineCheckbox3" value="option3" onclick="displayColumn()" checked>
          </div>
          <div class="col">
            <label class="checkbox-inline">End Date</label>
            <input type="checkbox" id="inlineCheckbox4" value="option4" onclick="displayColumn()" checked>
          </div>

          <div class="w-100"></div>
          <div class="col">
            <label class="checkbox-inline">Location</label>
            <input type="checkbox" id="inlineCheckbox5" value="option5" onclick="displayColumn()" checked>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
<script>

  let updateBtn = document.getElementById("updateBtn");
  let addBtn = document.getElementById("addBtn");
  let removeBtn = document.getElementById("removeBtn");
  var role = document.getElementById("hidden-role-field");
  let settingsBtn = document.getElementById("settingsBtn");
  var modal = document.getElementById("myModal");
  var span = document.getElementsByClassName("close")[0];



  settingsBtn.onclick = function (event) {
    /// Prevent the default form submission action
    event.preventDefault();
    modal.style.display = "block";
  }

    /// When the user clicks on <span> (x), close the modal
    span.onclick = function () {
    modal.style.display = "none";
  }


  /// When the user clicks anywhere outside of the modal, close it
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  /**
   * Selects one checkbox while hiding others and displays buttons
   */

  function cbChange(obj) {
    var cbs = document.getElementsByClassName("cb");
    for (var i = 0; i < cbs.length; i++) {
      cbs[i].checked = false;
    }
    obj.checked = true;
    displayButtons("block");
  }

  if ((role.value != "Coach") && (role.value != "Admin")) {
    addBtn.style.display = "none";
  }

    /**
   * Display or hide columns based on the checkboxes checked.
   */
  function displayColumn() {
    var checkBox1 = document.getElementById("inlineCheckbox1");
    var checkBox2 = document.getElementById("inlineCheckbox2");
    var checkBox3 = document.getElementById("inlineCheckbox3");
    var checkBox4 = document.getElementById("inlineCheckbox4");
    var checkBox5 = document.getElementById("inlineCheckbox5");

    var name = document.querySelectorAll(".name-label");
    var type = document.querySelectorAll(".type-label");
    var start = document.querySelectorAll(".start-date-label");
    var end = document.querySelectorAll(".end-date-label");
    var location = document.querySelectorAll(".location-label");

    /// Check if checkbox 1 is checked
    if (checkBox1.checked) {
      for (var i = 0; i < name.length; i++) {
        name[i].style.display = "table-cell"; ///< Display each element in the name array as a table cell.
      }
    } else {
      for (var i = 0; i < name.length; i++) {
        name[i].style.display = "none"; ///< Hide each element in the name array.
      }
    }

    if (checkBox2.checked) {
      for (var i = 0; i < type.length; i++) {
        type[i].style.display = "table-cell"; ///< Display each element in the name array as a table cell.
      }
    } else {
      for (var i = 0; i < type.length; i++) {
        type[i].style.display = "none"; 
      }
    }

    if (checkBox3.checked) {
      for (var i = 0; i < start.length; i++) {
        start[i].style.display = "table-cell"; 
      }
    } else {
      for (var i = 0; i < start.length; i++) {
        start[i].style.display = "none"; 
      }
    }

    if (checkBox4.checked) {
      for (var i = 0; i < end.length; i++) {
        end[i].style.display = "table-cell"; 
      }
    } else {
      for (var i = 0; i < end.length; i++) {
        end[i].style.display = "none"; 
      }
    }

    if (checkBox5.checked) {
      for (var i = 0; i < location.length; i++) {
        location[i].style.display = "table-cell"; 
      }
    } else {
      for (var i = 0; i < location.length; i++) {
        location[i].style.display = "none"; 
      }
    }
  }

  /**
   * Display buttons based on the type provided.
   */

  function displayButtons(type) {
    if (type == "block") {
      updateBtn.style.display = "block";
      removeBtn.style.display = "block";
    } else {
      removeBtn.style.display = "none";
      updateBtn.style.display = "none";

    }
  }

  displayButtons("none");

  displayButtons("none");

</script>