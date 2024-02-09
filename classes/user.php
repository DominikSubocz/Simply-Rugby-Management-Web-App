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

        $conn = Connection::connect();

        $stmt = $conn->prepare(SQL::$getUser);
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if(!empty($user)){
            return "<p class='error'>ERROR: User already exists</p>";
        }

        $hashedPassword = password_hash($_POST["passwordOne"], PASSWORD_BCRYPT);

        $stmt = $conn->prepare(SQL::$createUser);
        $stmt ->execute([$username, $filteredEmail, $hashedPassword]);

        $insertedId = $conn->lastInsertId();

        $conn = null;

        return "";
    }
}