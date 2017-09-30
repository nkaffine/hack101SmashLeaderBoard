<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 3:15 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    $array = array();
    try {
        if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
            throw new Exception("Failed to connect to database");
        }
        if(count($_GET)){
            $group_id = validNumbers($_GET['group_id'], 10);
        }
        if(!isset($group_id)){
            throw new Exception("No group id passed");
        }
        $query = "select tag, character_name, user_id, character_id from groupCharacters left join users using ".
            "(user_id) left join characters using (character_id) where group_id = {$group_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Error occurred when getting characters");
        }
        $users = array();
        while($row = @ mysqli_fetch_array($result)){
            $user = array();
            $user['tag'] = $row['tag'];
            $user['character'] = $row['character_name'];
            $user['id'] = $row['user_id'];
            $user['character_id'] = $row['character_id'];
            array_push($users, $user);
        }
        $array['results'] = $users;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>