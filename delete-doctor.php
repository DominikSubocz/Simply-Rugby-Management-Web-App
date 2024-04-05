<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/doctor.php");

session_start();

Components::blankPageHeader("Delete doctor", ["style"], ["mobile-nav"]);

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/address-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $doctor = Doctor::getDoctor($_GET["id"]);
  $doctorId = $doctor['doctor_id'];

  $pageTitle = "Doctor Deleted Successfuly";


try{
  Doctor::deleteDoctor($doctorId);
  header("Location: " . Utils::$projectFilePath . "/doctor-list.php");

}
 catch(PDOException $e) {
  echo "<div class='alert alert-danger my-3'>
  <p>Error: Cannot delete doctor, because it is present in another table!</p>
        <a href='doctor-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
        </div>";
}
?>