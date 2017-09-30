<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 11:47 AM
 */
    require_once('db.php');
    require_once('libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error("Connection to database failed");
    }
    $user_id = loginCheck();
    $query = "select group_name, group_id from groupMembers left join groups using (group_id) where user_id = ".
        "{$user_id}";
    if(($result = @ mysqli_query($connection, $query))==FALSE){
        error("Error occurred trying to get groups");
    }
    $list = "<table class='table table-striped col-lg-12'>
                <thead>
                    <th>Group Name</th>
                </thead>
                <tbody>";
    while($row = @ mysqli_fetch_array($result)){
        $id = $row['group_id'];
        $name = $row['group_name'];
        $list = $list . "<tr><td><a href='group.php?id=" . $id."'>{$name}</a></td></tr>";
    }
    $list = $list. "</tbody></table>";
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
        <title>Home</title>
        <link rel="stylesheet" href="stylesheets/main.css">
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
        <div class="container col-lg-6 col-lg-offset-3" style="padding-left:0;">
            <a href="createGroup.php" class="btn btn-info" role="button">Create New Group</a>
        </div>
        <div class="container mainTable col-lg-6 col-lg-offset-3" style="margin-bottom: 5%;">
            <?php echo $list ?>
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