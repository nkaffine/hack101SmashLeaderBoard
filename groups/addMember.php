<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 1:01 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    $array = array();
    try {
        if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
            throw new Exception("Failed to connect to database");
        }
        try {
            $user_id = apiLoginCheck();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        if(count($_GET)){
            $group_id = validNumbers($_GET['group_id'], 10);
            $newUserId = validNumbers($_GET['user_id'], 10);
        }
        if(empty($group_id) || empty($newUserId)){
            throw new Exception("No user or group was passed");
        }
        //Check to see if the current user is the owner of the group passed
        $query = "select (owner_id = {$user_id}) as same from groups where group_id = {$group_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Permission denied: not owner of group");
        }
        $query = "insert ignore into groupMembers (user_id, group_id) values ({$newUserId}, {$group_id})";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Failed to insert member into group");
        }
        if(mysqli_affected_rows($connection) == -1){
            throw new Exception("Failed to insert member into group");
        }
        $array['results'] = 1;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>