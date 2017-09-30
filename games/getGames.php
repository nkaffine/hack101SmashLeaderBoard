<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 1:53 PM
 */
    require_once('../db.php');
    require_once('../libraries/utils.php');
    $array = array();
    try {
        if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
            throw new Exception("Failed to connect to the database");
        }
        if(count($_GET)){
            $group_id = validNumbers($_GET['group_id'], 10);
        }
        if(!isset($group_id)){
            throw new Exception("Group Id was not passed");
        }
        $query = "select win.tag as wtag, win.character_name as wcname, lose.tag as ltag, lose.character_name as ".
            "lcname, stocks, group_name from games ".
            "left join groups using (group_id) left join (select user_id as wuser_id, character_id as wcharacter_id, ".
            "tag, character_name from groupCharacters left join users using(user_id) left join characters using ".
            "(character_id)) as win using (wuser_id, wcharacter_id) left join (select user_id as luser_id, ".
            "character_id as lcharacter_id, tag, character_name from groupCharacters left join users using(user_id) ".
            "left join characters using (character_id)) as lose using (luser_id, lcharacter_id)";
        if(($result = @ mysqli_query($connection, $query))==FALSE){
            throw new Exception("There was an issue getting the games for the group");
        }
        $games = array();
        while($row = @ mysqli_fetch_array($result)){
            $game = array();
            $game['winner_tag'] = $row['wtag'];
            $game['winner_character'] = $row['wcname'];
            $game['loser_tag'] = $row['ltag'];
            $game['loser_character'] = $row['lcname'];
            $game['stocks'] = $row['stocks'];
            $game['group_name'] = $row['group_name'];
            array_push($games, $game);
        }
        $array['results'] = $games;
        $array['error'] = null;
    } catch (Exception $exception) {
        $array['results'] = 0;
        $array['error'] = $exception->getMessage();
    }
    echo json_encode($array);
?>