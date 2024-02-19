<?php

require_once("classes/connection.php");
require_once("classes/sql.php");
require_once("classes/utils.php");

class User{
    public static function login(){
        if(Utils::postValuesAreEmpty(["username", "password"])){
            return "<p class'error'>ERROR: Not all form inputs filled </p>";
        }

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getUser);
        $stmt->execute([$_POST["username"]]);
        $user = $stmt->fetch();

        $conn = null;

        if (empty($user)){
            return "<p class='error'>ERROR: User does not exist</p>";
        }

        if(!password_verify($_POST["password"], $user["password"])){
            return "<p class='error'>ERROR: Incorrect password</p>";
        }

        $_SESSION["loggedIn"] = true;
        $_SESSION["user_id"] = $user["user_id"];
        $_SESSION["loggedIn"] = $_POST["username"];
        $_SESSION["user_role"] = $user["user_role"];

        return "";
    }

    public static function register(){
        if(Utils::postValuesAreEmpty(["username", "email", "passwordOne", "passwordTwo"])){
            return "<p class='error'>ERROR: Not all form inputs filled</p>";
        }
        
        $errors = "";
        $username = $_POST["username"];
        $email = $_POST["email"];
        $passwordOne = $_POST["passwordOne"];
        $passwordTwo = $_POST["passwordTwo"];

        if(strlen($username) < 4 || strlen($username) > 32){
            $errors .= "<p class='error'>ERROR: Username must be between 4 and 32 characters long </p>";
        }

        $filteredEmail = filter_var($email, FILTER_VALIDATE_EMAIL);

        if(!$filteredEmail){
            $errors .= "<p class='error'>ERROR: Email address is invalid</p>";
        }

        if ($passwordOne !== $passwordTwo){
            $errors .= "<p class='error'>ERROR: Passwords do not match</p>";
        } else if (strlen($passwordOne) < 12){
            $errors .= "<p class='error'>ERROR: Password must be at least 12 characters long</p>";
        }

        if($errors){
            return $errors;
        }
    
        // Connect to the database
        $conn = Connection::connect();
    
        // Check if the user already exists
        $stmt = $conn->prepare(SQL::$getUser);
        $stmt->execute([$username]);
        $user = $stmt->fetch();
    
        // If the user already exists, return an error message
        if(!empty($user)){
            return "<p class='error'>ERROR: User already exists</p>";
        }
    
        // If the user does not exist, proceed with registration
        // Hash the password
        $hashedPassword = password_hash($passwordOne, PASSWORD_BCRYPT);
    
        // Insert the new user into the database
        $stmt = $conn->prepare(SQL::$createUser);
        $stmt->execute([$username, $email, $hashedPassword]);
        
        // Get the inserted user ID
        $insertedId = $conn->lastInsertId();
    
        // Update record in other tables if necessary
        User::updateRecord($insertedId, $email);
    
        // Set session variables
        $_SESSION["loggedIn"] = true;
        $_SESSION["user_id"] = $insertedId;
        $_SESSION["username"] = $username;
        $_SESSION["user_role"] = "Member";
        $_SESSION["justRegistered"] = true;
    
        // Close database connection
        $conn = null;
    
        return "";
    }

    public static function checkIfUserExists($filteredEmail){
        $conn = Connection::connect();
    
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
    
        // Check if the email exists in any of the tables
        if (!empty($result_players) || !empty($result_members) || !empty($result_juniors)) {
            // Close database connections and return true if the email exists
            $conn = null;
            return true;
        } else {
            // Close database connections and return false if the email doesn't exist
            $conn = null;
            return false;
        }
    }

    public static function updateRecord($userId, $filteredEmail) {  
        // Establish database connection
        $conn = Connection::connect();
    
        // Determine which table the email address corresponds to
        $tableName = '';
    
        // Prepare SQL statements
        $sql_players = "SELECT * FROM players WHERE email_address = :email";
        $stmt_players = $conn->prepare($sql_players);
        $stmt_players->bindParam(':email', $filteredEmail);
        $stmt_players->execute();
        $result_players = $stmt_players->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result_players)) {
            $tableName = 'players';
        }

        $sql_juniors = "SELECT * FROM juniors WHERE email_address = :email";
        $stmt_juniors = $conn->prepare($sql_juniors);
        $stmt_juniors->bindParam(':email', $filteredEmail);
        $stmt_juniors->execute();
        $result_juniors = $stmt_juniors->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result_juniors)) {
            $tableName = 'juniors';
        }

        $sql_members = "SELECT * FROM members WHERE email_address = :email";
        $stmt_membersmt = $conn->prepare($sql_members);
        $stmt_membersmt->bindParam(':email', $filteredEmail);
        $stmt_membersmt->execute();
        $result_members = $stmt_membersmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result_members)) {
            $tableName = 'members';
        }
    
        // Similarly, check for members and juniors tables
    
        // Update the record in the corresponding table
        if (!empty($tableName)) {
            $sql_update = "UPDATE $tableName SET user_id = :user_id WHERE email_address = :email";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bindParam(':user_id', $userId);
            $stmt_update->bindParam(':email', $filteredEmail);
            $stmt_update->execute();
            $stmt_update->closeCursor(); // Close cursor to release the connection
        } else {
            // Handle the case where the email address does not exist in any table
            echo "Email address does not exist in any table.";
        }
    
        // Close database connection
        $conn = null;
    }
    
}