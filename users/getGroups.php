<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 2:37 PM
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
        $query = "select group_name, group_id from groupMembers left join groups using (group_id) where user_id = ".
            "{$user_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Error occurred trying to get groups");
        }
        $groups = array();
        while ($row = @ mysqli_fetch_array($result)){
            $group = array();
            $group['name'] = $row['group_name'];
            $group['id'] = $row['group_id'];
            array_push($groups, $group);
        }
        $array['results'] = $groups;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>