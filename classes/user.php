<?php

require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");


/**
 * 
 * @brief This class is responsible for actions related to user information..
 * 
 * These include:
 * - User registration validation
 * - User registration (creation of new user record)
 * - Assigning appropiate user role upon registration or login
 * - Updating appropiate user and assigning them user ID
 * - COOKIES - Website won't forget you when you leave it and come back.
 * 
 */

class User{

    /**
     * Validates entered details and logs user in.
     */


    public static function login(){

        /// Check if fields are empty
        if(Utils::postValuesAreEmpty(["username", "password"])){
            return "<p class'error'>ERROR: Not all form inputs filled </p>";
        }

        $conn = Connection::connect(); ///< Connect to database

        $errors = ""; ///< String that will contain error messages later to be returned


        /**
         * 
         * Checks if user exists
         * 
         */

        $stmt = $conn->prepare(SQL::$getUser);
        $stmt->execute([$_POST["username"]]);
        $user = $stmt->fetch();

        $conn = null; ///< Close the connection

        /// If user doesn't exist
        if (empty($user)){
           return "<p class='alert alert-danger'>ERROR: User does not exist</p>";
        }

        /// If password doesn't match the password from the database
        if(!password_verify($_POST["password"], $user["password"])){
            return "<p class='alert alert-danger'>ERROR: Incorrect password</p>";
        }

        /**
         * 
         * Return errors
         * 
         * Seems like I'm not actually assigning errors. This will be investigated in future update
         * 
         */
        if($errors){
            return $errors; 
        }

        $conn = Connection::connect();

        /**
         * 
         * Get email of user with specific username
         * 
         * This will be reworked in future update, as I think fetch will be much better instead of fetchAll
         * This wil also be moved to sql class in future updates.
         * 
         */

        $sql_login = "SELECT email FROM users WHERE username = ?";
        $stmt_login = $conn->prepare($sql_login);
        $stmt_login->bindValue(1, $_POST["username"]);
        $stmt_login->execute();
        $login_result = $stmt_login->fetchAll();

        $login_email = $login_result[0]['email'];


        $profileId = User::checkIfUserExists($_POST["username"], $login_email); ///< Assigns correct user profileId which is used to point to the right profile page
            

        /**
         * Setting some session variables so that the website remembers the user.
         */

        $_SESSION["loggedIn"] = true;
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["profileId"] = $profileId;
        $_SESSION["username"] = $_POST["username"];
        $_SESSION["user_role"] = $user["user_role"];

        /**
         * 
         * Updates user_id field in a table.
         * 
         * The table is picked depending on email address
         * It checks if email address exists in a table, if it does, it updates that table.
         * 
         * Possible Issues:
         *  - If same email address exists in multiple tables, it might select wrong table
         * 
         */
        
        if($profileId){
            User::updateRecord($_POST["username"], $_SESSION["user_id"], $login_email);
            }

        $_SESSION["successMessage"] = "Login Successful!";
        header("Location: " . Utils::$projectFilePath . "/success.php"); ///< This redirects user to another page.

        return "";
        
    }

    /**
     * Validates fields and creates new user if validation is successful.
     */

     public static function register() {
        /**
         * Check if the specified POST values are empty.
         *
         */
        if (Utils::postValuesAreEmpty(["username", "email", "passwordOne", "passwordTwo"])) {
            return "<p class='alert alert-danger'>ERROR: Not all form inputs filled</p>";
        }
    
        $errors = "";
        $username = $_POST["username"];
        $email = $_POST["email"];
        $passwordOne = $_POST["passwordOne"];
        $passwordTwo = $_POST["passwordTwo"];
    
        /// Checks if username length is valid
        if (strlen($username) < 4 || strlen($username) > 32) {
            $errors .= "<p class='alert alert-danger'>ERROR: Username must be between 4 and 32 characters long</p>";
        }
    
        $filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL); ///< Filters a variable with a specified filter
        /// If email isn't valid
        if (!$filteredEmail) {
            $errors .= "<p class='alert alert-danger'>ERROR: Email address is invalid</p>";
        }
    
        /// If passwords don't match
        if ($passwordOne !== $passwordTwo) {
            $errors .= "<p class='alert alert-danger'>ERROR: Passwords do not match</p>";
        } elseif (strlen($passwordOne) < 12) {
            $errors .= "<p class='alert alert-danger'>ERROR: Password must be at least 12 characters long</p>";
        }
    
        /// Return errors - if there are any
        if ($errors) {
            return $errors;
        }
    
        $conn = Connection::connect();
    
        /**
         * Checks if user exists and outputs result.
         */

        ///  Prepare SQL querry to check if user exists
        $stmt = $conn->prepare(SQL::$getUser);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
    
        /// If user doesn't exists output error
        if (!empty($user)) {
            return "<p class='alert alert-danger'>ERROR: User already exists</p>";
        }
    
        $hashedPassword = password_hash($passwordOne, PASSWORD_BCRYPT); ///< Password encryption
    
        $role = "Member"; /// Default role
    
        /**
         * Update user role to admin or coach if username contains words "admin" or "coach"
         */
        if (stripos($username, "admin") !== false) {
            $role = "Admin";
        } elseif (stripos($username, "coach") !== false) {
            $role = "Coach";
        }

    
        $stmt = $conn->prepare(SQL::$createUser);
        $stmt->execute([$username, $email, $hashedPassword, $role]);
    
        $insertedId = $conn->lastInsertId(); ///< Id of just created user
    
        $profileId = User::checkIfUserExists($username, $filteredEmail); /// Returns appropiate profileId, points to the right profile page.

        if(($profileId) && ($role !== "Admin")){

            $_SESSION["loggedIn"] = true;  ///< Login state
            $_SESSION["user_id"] = $insertedId;
            $_SESSION["profileId"] = $profileId;
            $_SESSION["username"] = $username;
            $_SESSION["user_role"] = $role; 
            $_SESSION["justRegistered"] = true; ///< Variable used to determine if user has just registered
        
            /// Close database connection
            $conn = null; ///< Close the connection
        
            /// Set success message and redirect
            $_SESSION["successMessage"] = "Registration Successful!";
            header("Location: " . Utils::$projectFilePath . "/success.php");
            exit(); /// Terminate script execution after redirect

        } else if ($role !== "Admin"){
            $_SESSION["loggedIn"] = true; 
            $_SESSION["user_id"] = $insertedId;
            $_SESSION["username"] = $username; 
            $_SESSION["user_role"] = "Member"; 
            $_SESSION["justRegistered"] = true; 
            $_SESSION["newMember"] = true; ///< Variable used to determine if member can access add-member.php to fill their info
            header("Location: " . Utils::$projectFilePath . "/add-member.php"); 
        } else {
            $_SESSION["loggedIn"] = true; 
            $_SESSION["user_id"] = $insertedId;
            $_SESSION["username"] = $username; 
            $_SESSION["user_role"] = $role; 
            $_SESSION["justRegistered"] = true; 
            header("Location: " . Utils::$projectFilePath .  "/success.php");
        }
    

    }



   /**
    * Check if a user exists in the database based on the provided details.
    */
   public static function checkIfUserExists($username, $filteredEmail){

    $conn = Connection::connect(); ///< Connect to the database


    /**
     * Check if user exists and return appropiate profile link
     */
    $sql_coaches = "SELECT * FROM simplyrugby.coaches WHERE email_address = ?";
    $stmt_coaches = $conn->prepare($sql_coaches);
    $stmt_coaches->bindValue(1, $filteredEmail);
    $stmt_coaches->execute();
    $result_coaches = $stmt_coaches->fetchAll();

    $sql_players = "SELECT * FROM players WHERE email_address = ?";
    $stmt_players = $conn->prepare($sql_players);
    $stmt_players->bindValue(1, $filteredEmail);
    $stmt_players->execute();
    $result_players = $stmt_players->fetchAll();

    $sql_juniors = "SELECT * FROM juniors WHERE email_address = ?";
    $stmt_juniors = $conn->prepare($sql_juniors);
    $stmt_juniors->bindValue(1, $filteredEmail);
    $stmt_juniors->execute();
    $result_juniors = $stmt_juniors->fetchAll();

    $sql_members = "SELECT * FROM members WHERE email_address = ?";
    $stmt_members = $conn->prepare($sql_members);
    $stmt_members->bindValue(1, $filteredEmail);
    $stmt_members->execute();
    $result_members = $stmt_members->fetchAll();

    if (!empty($result_coaches) && strpos($username, 'coach') !== false) {
        $coachId = $result_coaches[0]['coach_id'];
        $profileId = "coach-page.php?id=";
        return $profileId . $coachId; 
    }
    
    if (!empty($result_players) && strpos($username, 'coach') === false) {
        $playerId = $result_players[0]['player_id'];
        $profileId = "player.php?id=";
        return $profileId . $playerId; 
    }
    
    if (!empty($result_juniors) && strpos($username, 'coach') === false) {
        $juniorId = $result_juniors[0]['junior_id'];
        $profileId = "junior-page.php?id=";
        return $profileId . $juniorId; 
    }
    
    if (!empty($result_members) && strpos($username, 'coach') === false) {
        $memberId = $result_members[0]['member_id'];
        $profileId = "member-page.php?id=";
        return $profileId . $memberId; 
    }

    /// If user not found, close db connection and return false
    $conn = null; ///< Close the connection
    return 0;
}

    public static function updateRecord($username, $insertedId, $filteredEmail) {  
        $conn = Connection::connect();
    
        $tableName = ''; ///< Empty by default, it will be set after if satement checks
    
        /**
         * Checks if email address is used in any of the member tables (Coaches, Players, Juniors & Members).
         */
        $sql_coaches = "SELECT * FROM coaches WHERE email_address = :email";
        $stmt_coaches = $conn->prepare($sql_coaches);
        $stmt_coaches->bindParam(':email', $filteredEmail);
        $stmt_coaches->execute();
        $result_coaches = $stmt_coaches->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result_coaches) && strpos($username, 'coach') !== false) {
            $tableName = 'coaches';
        }
    
        $sql_players = "SELECT * FROM players WHERE email_address = :email";
        $stmt_players = $conn->prepare($sql_players);
        $stmt_players->bindParam(':email', $filteredEmail);
        $stmt_players->execute();
        $result_players = $stmt_players->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result_players) && strpos($username, 'coach') === false) {
            $tableName = 'players';
        }
    
        $sql_juniors = "SELECT * FROM juniors WHERE email_address = :email";
        $stmt_juniors = $conn->prepare($sql_juniors);
        $stmt_juniors->bindParam(':email', $filteredEmail);
        $stmt_juniors->execute();
        $result_juniors = $stmt_juniors->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result_juniors) && strpos($username, 'coach') === false) {
            $tableName = 'juniors';
        }
    
        $sql_members = "SELECT * FROM members WHERE email_address = :email";
        $stmt_members = $conn->prepare($sql_members);
        $stmt_members->bindParam(':email', $filteredEmail);
        $stmt_members->execute();
        $result_members = $stmt_members->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result_members) && strpos($username, 'coach') === false) {
            $tableName = 'members';
        }

        /**
         * Update user_id in the specific table for specific user.
         */
    
        if (!empty($tableName)) {
            $sql = sprintf(SQL::$assignUserId, $tableName);
            $stmt_update = $conn->prepare($sql);
            $stmt_update->bindParam(1, $insertedId);
            $stmt_update->bindParam(2, $filteredEmail);
            $stmt_update->execute();
            $stmt_update->closeCursor(); 
        } else {
            echo "Email address does not exist in any table.";
        }
    
        $conn = null; ///< Close the connection
    }

    
}