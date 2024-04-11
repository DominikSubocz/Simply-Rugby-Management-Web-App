<?php

/// This must come first when we need access to the current session
session_start();

/**
 * Included for the postValuesAreEmpty() and
 * escape() functions and the project file path.
 */
require("classes/utils.php");
$_SESSION = [];

session_destroy(); ///< Destroys all data registered to a session

header("Location: " . Utils::$projectFilePath . "/login.php"); /// Redirect to login page