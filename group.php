<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 2:51 PM
 */
    require_once('db.php');
    require_once('libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error("Failed to connect to the database");
    }
    $user_id = loginCheck();
    if(count($_GET)){
        $group_id = validNumbers($_GET['id'], 10);
    }
    if(!isset($group_id)){
        error("Not all required parameters were passed");
    }
    $query = "select group_name from groups where group_id = {$group_id}";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        debug($query);
        error("Error occurred when getting group information");
    }
    if(notUnique($result)){
        error("Something went wrong, expected unique value but did not get one");
    }
    $row = @mysqli_fetch_array($result);
    $name = $row['group_name'];
?>
<!DOCTYPE html>
<html lang="en">
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
        <title><?php echo $name?></title>
        <link rel="stylesheet" href="stylesheets/main.css">
        <script src="scripts/main.js"></script>
        <script>
            $(document).ready(function(){
               $("#groupName").css('margin-top', $("#groupName").css('margin-bottom'));
               var margins = 2 * parseInt($("#groupName").css('margin-top'));
               var nameHeight = $("#groupName").outerHeight();
               var btnHeight = $("#newGame").outerHeight();
               $("#newGame").css('margin-top', (nameHeight + margins - btnHeight)/2);
               $("#newGame").click(function(){
                  window.location = "newGame.php?id=" + findGetParameter("id");
               });
            });
        </script>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid" style="background-color:lightyellow">
                <div class="navbar-header">
                    <a class="navbar-brand" href="home.php style="color:red">Smash Leaderboard</a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="home.php" style="color:yellowgreen">Home</a></li>
                    <li><a href="#" style="color:orangered">Player 1</a></li>
                    <li><a href="#" style="color:deepskyblue">Player 2</a></li>
                    <li><a href="#" style="color:darkgoldenrod">Player 3</a></li>
                </ul>
            </div>
        </nav>
        <div class="panel panel-default col-lg-6 col-lg-offset-3">
            <h1 class='col-lg-6'id="groupName"><?php echo $name?></h1>
            <div class="col-lg-6">
                <button id="newGame" class="btn btn-primary pull-right">New Game</button>
            </div>
        </div>
        <div class="container mainTable col-lg-6 col-lg-offset-3">
            <h2>Leaderboard</h2>
            <p>Make your way up to the top!</p>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Rank</th>
                    <th>Username</th>
                    <th>Score</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>user1</td>
                    <td>20</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>user2</td>
                    <td>19</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>user3</td>
                    <td>18</td>
                </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
