<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/address.php");

session_start();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: " . Utils::$projectFilePath . "/address-list.php");
  }
  
  if(!isset($_SESSION["loggedIn"])){
  
    header("Location: " . Utils::$projectFilePath . "/login.php");
  
  }

  $address = Address::getAddress($_GET["id"]);
  $addressId = $address['address_id'];

  $pageTitle = "Address Deleted Successfuly";


Address::deleteAddress($addressId);

header("Location: " . Utils::$projectFilePath . "/address-list.php");
?>

