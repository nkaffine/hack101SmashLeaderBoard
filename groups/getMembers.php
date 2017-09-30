<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 12:47 PM
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
            throw new Exception("Group Id was not provided");
        }
        $query = "select tag from groupMembers left join users using (user_id) where group_id = {$group_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Failed to get group members");
        }
        $users = array();
        while ($row = @ mysqli_fetch_array($result)){
            array_push($users, $row['tag']);
        }
        $array['results'] = $users;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>