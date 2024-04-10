<?php

require("classes/components.php");
require("classes/utils.php");
require("classes/connection.php");
require("classes/sql.php");
require("classes/address.php");


session_start();

/**
 * Check if the user is logged in by verifying the presence of the 'loggedIn' key in the session.
 * If the user is not logged in, redirect to the login page.
 * 
 * If the user is logged in check priveledge level, and proceed.
 */
if(!isset($_SESSION["loggedIn"])){
  
  header("Location: " . Utils::$projectFilePath . "/login.php");
 
} else {
  /**
   * Check if the user role is not Admin or Coach, then redirect to logout page.
   */

  if(($_SESSION["user_role"] != "Admin") &&($_SESSION["user_role"] != "Coach")) {
    header("Location: " . Utils::$projectFilePath . "/logout.php");
  }
  
  Components::blankPageHeader("Delete player", ["style"], ["mobile-nav"]); ///< Doesn't render anything it's just for keeping stylesheets on, etc.
  
  /**
   * Redirects the user to the address-list.php page if the "id" parameter is not set in the GET request or is not numeric.
   */
  if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
      header("Location: " . Utils::$projectFilePath . "/address-list.php");
  }
  
  $address = Address::getAddress($_GET["id"]); ///< Get details of address
  $addressId = $address['address_id']; ///< Get ID of that address
  
  $pageTitle = "Address Deletion";
  
  
  /**
   * Try to delete an address by its ID. If successful, redirect to the address list page.
   * If an exception of type PDOException is caught, display an error message and a link to go back to the address list page.
   *
   * @param int $addressId The ID of the address to delete
   */
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
}


?>

