<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 3:04 PM
 */
    require_once('db.php');
    require_once('libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error("Failed to connect to database");
    }
    $user_id = loginCheck();
    if(count($_GET)){
        $group_id = validNumbers($_GET['id'], 10);
    }
    if(!isset($group_id)){
        error("Not all required parameters were set");
    }
    $query = "select tag, character_name, user_id, character_id from groupCharacters left join users using ".
        "(user_id) left join characters using (character_id) where group_id = {$group_id}";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
       error("Error occurred when getting characters");
    }
    $html = "";
    while($row = @ mysqli_fetch_array($result)){
        $html = $html . "<option value='".$row['user_id']."_".$row['character_id']
            ."'>". $row['character_name']." (" .$row['tag'].")</option>";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <!--Stuff for selectors-->
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
            <meta charset="UTF-8">
            <title>New Group</title>
            <link rel="stylesheet" href="stylesheets/main.css">
            <script src="scripts/main.js"></script>
            <script src="scripts/getMembers.js"></script>
            <script>
                $(document).ready(function(){
                    $("#newGame").click(function(){
                        var stocks = document.getElementById('stocks').value;
                        var winner = document.getElementById('winner').value;
                        winner = winner.split("_");
                        console.log(winner);
                        var wid = winner[0];
                        var wcid = winner[1];
                        var loser = document.getElementById('loser').value;
                        loser = loser.split("_");
                        var lid = loser[0];
                        var lcid = loser[1];
                        var link = "games/newGame.php?wuid="+encodeURIComponent(wid)+"&wcid="+ encodeURIComponent(wcid) +
                                "&luid=" + encodeURIComponent(lid) + "&lcid=" + encodeURIComponent(lcid) + "&stocks=" +
                                encodeURIComponent(stocks) + "&group_id=" + findGetParameter("id");
                        $.getJSON(link, function(data){
                            if(data.results == 0){
                                window.location = "error.php?message=" + encodeURIComponent(data.error);
                            } else {
                                window.location = "group.php?id=" + encodeURIComponent(findGetParameter("id"));
                            }
                        })
                    })
                });
            </script>
        </head>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid" style="background-color:lightyellow">
                <div class="navbar-header">
                    <a class="navbar-brand" href="home.php" style="color:red">Smash Leaderboard</a>
                </div>
                <ul class="nav navbar-nav">
                    <li><a href="home.php" style="color:yellowgreen">Home</a></li>
                    <li><a href="#" style="color:orangered">Player 1</a></li>
                    <li><a href="#" style="color:deepskyblue">Player 2</a></li>
                    <li><a href="#" style="color:darkgoldenrod">Player 3</a></li>
                </ul>
            </div>
        </nav>
        <div class="container col-lg-6 col-lg-offset-3" style="background-color:lightyellow;">
            <h1>New Game</h1>
            <label for="stocks">Stocks Remaining</label>
            <select class="form-control selectpicker" id="stocks">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
            </select>
            <h2>Winner</h2>
            <select class="form-control selectpicker" id="winner"><?php echo $html?></select>
            <h2>Loser</h2>
            <select class="form-control selectpicker" id="loser"><?php echo $html?></select>
            <button id="newGame" class="btn btn-primary btn-md">Submit</button>
        </div>
    </body>
</html>

