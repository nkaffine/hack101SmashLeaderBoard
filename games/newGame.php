<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 1:32 PM
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
            // The winners user id
            $wuid = validNumbers($_GET['wuid'], 10);
            // The winners character id
            $wcid = validNumbers($_GET['wcid'], 10);
            // The losers user id
            $luid = validNumbers($_GET['luid'], 10);
            // The losers character id
            $lcid = validNumbers($_GET['lcid'], 10);
            // The number of stocks the winner had left (1-4)
            $stocks = validNumbers($_GET['stocks'], 1);
            $group_id = validNumbers($_GET['group_id'], 10);
        }
        if(empty($wuid) || empty($wcid) || empty($luid) || empty($lcid) || empty($stocks) || empty($group_id)){
            throw new Exception("Not all required arguments were passed");
        }
        //Check to see if the winner character is a character in the group
        $query = "select user_id from groupCharacters where user_id = {$wuid} and character_id = {$wcid} and group_id ".
            "= {$group_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Could not verify winner is in group");
        }
        if(mysqli_num_rows($result) == 0){
            throw new Exception("Winner is not part of group");
        }
        //Check to see if the loser character is in the group
        $query = "select user_id from groupCharacters where user_id = {$luid} and character_id = {$lcid} and group_id ".
            "= {$group_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Could not verify loser is in group");
        }
        if(mysqli_num_rows($result) == 0){
            throw new Exception("Loser is not part of group");
        }
        //Make sure the number of stocks is valid
        if($stocks < 1 || $stocks > 4){
            throw new Exception("Stocks must be from 1 to 4");
        }
        //Get the game id
        $query = "select max(game_id) from games where group_id = {$group_id}";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Failed to get the new game id");
        }
        $row = @ mysqli_fetch_array($result);
        $game_id = $row['max(game_id)'] + 1;
        //Insert the game in
        $query = "insert into games (wuser_id, wcharacter_id, luser_id, lcharacter_id, stocks, group_id, game_id) ".
            "values ($wuid, $wcid, $luid, $lcid, $stocks, $group_id, $game_id)";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("Failed to insert game");
        }
        if(mysqli_affected_rows($connection) == -1){
            throw new Exception("Failed to insert game");
        }
        $array['results'] = 1;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>