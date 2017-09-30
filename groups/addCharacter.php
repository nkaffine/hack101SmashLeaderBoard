<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 1:15 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    $array = array();
    try {
        if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
            throw new Exception("Failed to connect to the database");
        }
        try {
            $user_id = apiLoginCheck();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        if(count($_GET)){
            $group_id = validNumbers($_GET['group_id'], 10);
            $character_id = validNumbers($_GET['character_id'], 10);
        }
        if(empty($group_id) || empty($character_id)){
            throw new Exception("Not all required arguments were passed");
        }
        //Check if the character exists
        $query = "select character_name from characters where character_id = {$character_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("There was an issue verifying the character");
        }
        if(mysqli_num_rows($result) == 0){
            throw new Exception("Character does not exits");
        }
        //Check to see if the user is a member of the group
        $query = "select user_id from groupMembers where group_id = {$group_id} and user_id = {$user_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("There was an issue verifying you are a member of that group");
        }
        if(mysqli_num_rows($result) == 0){
            throw new Exception("You do not belong to that group");
        }
        //Insert the character and user to the group
        $query = "insert ignore into groupCharacters (user_id, group_id, character_id) values ({$user_id}, {$group_id}, ".
            "{$character_id})";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Failed to insert character into group");
        }
        $array['results'] = 1;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>