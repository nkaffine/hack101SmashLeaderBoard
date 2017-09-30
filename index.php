<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 9/30/17
 * Time: 11:17 AM
 */
    require_once('db.php');
    require_once('libraries/utils.php');
    if(!($connection = @ mysqli_connect($DB_hostname, $DB_username, $DB_password, $DB_databasename))){
        error("Failed to connect to database");
    }
    if(isset($_COOKIE['users'])){
        header("Location: /home.php");
        exit;
    }
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Smash</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <!--Stuff for selectors-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        <script src="scripts/main.js"></script>
        <link rel="stylesheet" href="main.css">
        <script>
            $(document).ready(function(){
                $("#loginBtn").click(function(){
                    var name = document.getElementById('username').value;
                    validString(name, 0);
                });
                $("#signUpBtn").click(function(){
                    var name = document.getElementById('username').value;
                    validString(name, 1);
                });
            });
        </script>
    </head>
    <body>
        <div class="col-xs-10 col-xs-offset-1" id="error" style="margin-top: 8%;"></div>
        <div class="box col-xs-10 col-xs-offset-1" style="margin-top: 2%;">
            <form id="tagForm" action="process/login.php" method="post">
                <label for="username">Enter Your Gamer Tag</label>
                <input id='username' class='form-control input-lg' type="text" name="tag" value="" placeholder="username (no spaces or capitals)">
                <label for="password">Enter Your Password</label>
                <input type="password" name="password" class="form-control input-lg" value="">
                <input id='type' type="hidden" name="type" value="">
                <button id="signUpBtn" type="button" class="col-xs-6 btn btn-default btn-lg">Sign Up</button>
                <button id='loginBtn' type="button" class="col-xs-6 btn btn-primary btn-lg">Log In</button>
            </form>
        </div>
    </body>
</html>