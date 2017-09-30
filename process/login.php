<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 11:32 AM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        showerror($connection);
    }
    if(count($_POST)){
        $username = validInputSizeAlpha($_POST['tag'], 10);
        $type = validNumbers($_POST['type'], 1);
        $password = validInputSizeAlpha($_POST['password'], 10);
    }
    if(empty($username) || empty($password)) {
        error("You need to supply a username and password");
    }
    $tag = str_replace(" ", "", strtolower($username));
    if($type == 1) {
        $query = "select tag from users where tag = '{$tag}'";
        if (($result = @ mysqli_query($connection, $query)) == FALSE) {
            showerror($connection);
        }
        if (mysqli_num_rows($result) == 0) {
            // The facebook id is not affiliated with a user account so input the user's information
            // Get the next user_id that is open
            $query = "select max(user_id) from users";
            if (($result = @ mysqli_query($connection, $query)) == FALSE) {
                showerror($connection);
            }
            $row = mysqli_fetch_array($result);
            $newId = $row['max(user_id)'] + 1;

            // Insert the user's information into the database with the new user_id
            $query = "insert into users (user_id, tag, password) values ({$newId}, '{$tag}', sha1('{$password}'))";
            if (($result = mysqli_query($connection, $query)) == FALSE) {
                showerror($connection);
            }
            if (mysqli_affected_rows($connection) == -1) {
                error("The user was not successfully created");
            }
        } else {
            error("Someone already has that username");
        }
    } else if ($type == 0) {
        $query = "select sha1('{$password}') = password as same, user_id from users where tag = '{$tag}'";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            error("Query Failed");
        }
        if(notUnique($result)){
            error("Username or Password were not correct");
        }
        $row = @ mysqli_fetch_array($result);
        if($row['same'] == 0){
            error("Username or Password were not correct");
        }
        $newId = $row['user_id'];
    } else {
        error("Something unexpected happened");
    }
    // Starts the session of the user and redirects them to the home page.
    session_start();
    $_SESSION['id'] = $newId;
    $cookie_name = "users";
    $cookie_value = $newId;
    setcookie($cookie_name, $cookie_value, time() + (10 * 365 * 24 * 60 * 60), "/"); // 86400 = 1 day
    header("Location: ../home.php");
    exit;
?>