<?php
/// This must come first when we need access to the current session
session_start();

require ("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require ("classes/utils.php");
require ("classes/connection.php");
require ("classes/sql.php");
require ("classes/doctor.php");



/**
 * Check if the user is logged in; if not, redirect to login page
 */

if (!isset($_SESSION["loggedIn"])) {

  header("Location: " . Utils::$projectFilePath . "/login.php");

} else {

  /// Redirect to logout page if user role is neither Admin nor Coach

  if (($_SESSION["user_role"] != "Admin") && ($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }

  Components::blankPageHeader("Delete doctor", ["style"], ["mobile-nav"]); ///< Doesn't render anything it's just for keeping stylesheets on, etc.

  /**
   * Redirects the user back to the doctor-list.php page if the "id" parameter is not set in the GET request or is not numeric.
   */
  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/address-list.php");
  }



  $doctor = Doctor::getDoctor($_GET["id"]);  ///< Get details of doctor
  $doctorId = $doctor['doctor_id']; ///< Get ID of that doctor

  $pageTitle = "Doctor Deletion";


  /**
   * Try to delete an doctor by its ID. If successful, redirect to the doctor list page.
   * If doctor is used elsewhere, error will be thrown.
   *
   * @param int $doctorId The ID of the doctor to delete
   */

  try {
    Doctor::deleteDoctor($doctorId);
    header("Location: " . Utils::$projectFilePath . "/doctor-list.php");

  } catch (PDOException $e) {
    echo "<div class='alert alert-danger my-3'>
    <p>Error: Cannot delete doctor, because it is present in another table!</p>
          <a href='doctor-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
          </div>";
  }
}


?>