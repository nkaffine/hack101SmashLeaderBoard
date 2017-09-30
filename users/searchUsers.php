<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 12:55 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    $array = array();
    try {
        if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
            throw new Exception("Failed to connect to the databasename");
        }
        if(count($_GET)){
            $search_term = validInputSizeAlpha($_GET['q'], 50);
        }
        if(!isset($search_term)){
            throw new Exception("Search term was not passed");
        }
        $query = "select tag, user_id from users where tag like '%{$search_term}%'";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Error in preforming user query");
        }
        $users = array();
        while($row = @ mysqli_fetch_array($result)){
            $user = array();
            $user['tag'] = $row['tag'];
            $user['id'] = $row['user_id'];
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