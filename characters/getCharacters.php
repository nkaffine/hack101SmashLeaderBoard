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
        $query = "select character_id, character_name from characters";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Failed to get characters");
        }
        $characters = array();
        while($row = @ mysqli_fetch_array($result)){
            $character = array();
            $character['name'] = $row['character_name'];
            $character['id'] = $row['character_id'];
            array_push($characters, $character);
        }
        $array['results'] = $characters;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>