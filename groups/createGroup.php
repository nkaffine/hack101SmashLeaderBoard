<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 11:59 AM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    $array = array();
    try {
        if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
            throw new Exception("Connection to Database Failed");
        }
        try {
            $user_id = apiLoginCheck();
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        if(count($_GET)){
            $group_name = validInputSizeAlpha($_GET['group_name'], 50);
        }
        if(!isset($group_name)){
            throw new Exception("Group Name not Provided");
        }
        $query = "select max(group_id) from groups";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Query Failed");
        }
        $row = @ mysqli_fetch_array($result);
        $group_id = $row['max(group_id)'] + 1;
        mysqli_begin_transaction($connection);
        $query = "insert into groups (group_id, owner_id, group_name) values ({$group_id}, ".
            "{$user_id}, '{$group_name}')";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Group Failed to be created");
        }
        if(mysqli_affected_rows($connection) == -1){
            throw new Exception("Group Failed to be created");
        }
        $query = "insert into groupMembers (user_id, group_id) values ({$user_id}, {$group_id})";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Group Failed to be created");
        }
        if(mysqli_affected_rows($connection) == -1){
            throw new Exception("Group Failed to be created");
        }
        mysqli_commit($connection);
        $array['results'] = 1;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>