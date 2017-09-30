<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 2:19 PM
 */
    require_once('db.php');
    require_once('libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error("Failed to connect to database");
    }
    $user_id = loginCheck();
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
            <script>
                function myFunction() {
                    document.getElementById('newgame').style.visibility = "visible";
                }
                $(document).ready(function(){
                    $("#addGroup").click(function(){
                        var link = "groups/createGroup.php?group_name=" +
                            encodeURIComponent(document.getElementById('groupName').value);
                        $.getJSON(link, function(data){
                            if(data.results = 1){
                                window.location = "home.php";
                            } else {
                                window.location = "error.php?message=" + encodeURIComponent(data.error);
                            }

                        });
                    });
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
                    <li class="active"><a href="home.php" style="color:yellowgreen">Home</a></li>
                    <li><a href="#" style="color:orangered">Player 1</a></li>
                    <li><a href="#" style="color:deepskyblue">Player 2</a></li>
                    <li><a href="#" style="color:darkgoldenrod">Player 3</a></li>
                </ul>
            </div>
        </nav>
        <div class="col-lg-6 col-lg-offset-3">
            <input class="form-control" id="groupName" value="" type="text" maxlength="50">
            <button id='addGroup' type="button" class="btn btn-primary btn-lg">Enter New Game</button>
        </div>
        <div class="container" style="background-color:lightyellow; visibility: hidden" id="newgame">
            <h2>Player 1</h2>
            <form>
                <div class="form-group">
                    <label for="usr">Name</label>
                    <input type="text" class="form-control" id="usr">
                </div>
                <div class="form-group">
                    <label for="sel1">Stocks</label>
                    <select class="form-control" id="sel1">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel1">Character</label>
                    <select class="form-control" id="sel2">
                        <option>Mario</option>
                        <option>Luigi</option>
                        <option>Yoshi</option>
                        <option>Donkey Kong</option>
                        <option>Link</option>
                        <option>Samus</option>
                        <option>Kirby</option>
                        <option>Fox</option>
                        <option>Pikachu</option>
                        <option>Jigglypuff</option>
                        <option>Captain Falcon</option>
                        <option>Ness</option>
                        <option>Peach</option>
                        <option>Bowser</option>
                        <option>Dr. Mario</option>
                        <option>Zelda</option>
                        <option>Sheik</option>
                        <option>Ganondorf</option>
                        <option>Young Link</option>
                        <option>Falco</option>
                        <option>Mewtwo</option>
                        <option>Pichu</option>
                        <option>Ice Climbers</option>
                        <option>Mr. Game & Watch</option>
                        <option>Marth</option>
                        <option>Roy</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel1">Result</label>
                    <select class="form-control" id="sel3">
                        <option>Win</option>
                        <option>Loss</option>
                    </select>
                </div>
                <h2>Player 2</h2>
                <div class="form-group">
                    <label for="usr">Name</label>
                    <input type="text" class="form-control" id="usr1">
                </div>
                <div class="form-group">
                    <label for="sel1">Stocks</label>
                    <select class="form-control" id="sel4">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel1">Character</label>
                    <select class="form-control" id="sel5">
                        <option>Mario</option>
                        <option>Luigi</option>
                        <option>Yoshi</option>
                        <option>Donkey Kong</option>
                        <option>Link</option>
                        <option>Samus</option>
                        <option>Kirby</option>
                        <option>Fox</option>
                        <option>Pikachu</option>
                        <option>Jigglypuff</option>
                        <option>Captain Falcon</option>
                        <option>Ness</option>
                        <option>Peach</option>
                        <option>Bowser</option>
                        <option>Dr. Mario</option>
                        <option>Zelda</option>
                        <option>Sheik</option>
                        <option>Ganondorf</option>
                        <option>Young Link</option>
                        <option>Falco</option>
                        <option>Mewtwo</option>
                        <option>Pichu</option>
                        <option>Ice Climbers</option>
                        <option>Mr. Game & Watch</option>
                        <option>Marth</option>
                        <option>Roy</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="sel1">Result</label>
                    <select class="form-control" id="sel6">
                        <option>Win</option>
                        <option>Loss</option>
                    </select>
                </div>
            </form>
            <button type="button" class="btn btn-primary btn-md">Submit</button>
        </div>
    </body>
</html>
