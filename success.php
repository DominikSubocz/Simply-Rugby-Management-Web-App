<?php
/// This must come first when we need access to the current session
session_start();
require("classes/components.php");
/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");
$message = "Success!"; 

Components::blankPageHeader("Success", ["style"], ["mobile-nav"]); ///< Doesn't render anything, it's just to load css styles and scripts



/**
 * Check if the user is logged in; if not, redirect to login page
 */
if(!isset($_SESSION["loggedIn"])){
  header("Location: " . Utils::$projectFilePath . "/login.php");

}

$profileId = $_SESSION["profileId"]; ///< Get link to profile page

/**
 * Checks if a success message is stored in the session. 
 */
if (isset($_SESSION["successMessage"])) {
    $message = $_SESSION["successMessage"]; ///< Get success message
    unset($_SESSION["successMessage"]); /// Remove the session variable
} else {

    if(isset($_SESSION["loggedIn"])){
      if($_SESSION["user_role"] === "Admin"){
        header("Location: " . Utils::$projectFilePath . "/index.php");
        $message = "Success message not found."; /// Default message
      } else {
        header("Location: " . Utils::$projectFilePath . "/$profileId");
        $message = "Success message not found."; /// Default message
      }

      if(isset($_SESSION["newMember"])){
        header("Location: " . Utils::$projectFilePath . "/logout.php");
        unset($_SESSION["newMember"]); ///< Unset the newMember 
      }
    }


}
?>

<div class="success-content">
    <img src="images/tick.gif" alt="Animated green tick" class="animated-tick-icon">
    <h2><?php echo $message; ?></h2>
    <p>You will be redirected in 5 seconds <p>
</div>

<script>
  /// Refresh the page after 5 seconds
  setTimeout(function() {
      location.reload();
  }, 5000);
</script>
