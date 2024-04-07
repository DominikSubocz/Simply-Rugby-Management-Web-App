<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/address.php");


session_start();

if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
  header("Location: " . Utils::$projectFilePath . "/logout.php");
}

Components::blankPageHeader("Delete player", ["style"], ["mobile-nav"]);

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/address-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $address = Address::getAddress($_GET["id"]);
  $addressId = $address['address_id'];

  $pageTitle = "Address Deletion";


try{
  Address::deleteAddress($addressId);
  header("Location: " . Utils::$projectFilePath . "/member-list.php");

}
 catch(PDOException $e) {
  echo "<div class='alert alert-danger my-3'>
  <p>Error: Cannot delete address, because it is used in another table!</p>
        <a href='address-list.php'><i class='fa fa-chevron-left' aria-hidden='true'></i> Click here to go back.</a>
        </div>";
}
?>

